<?php

namespace Pintushi\Bundle\SMSBundle\Verification;

use Doctrine\Common\Cache\Cache;
use Huying\Sms\Message;
use Huying\Sms\MessageStatus;
use Huying\Sms\ProviderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @author Vidy Videni<videni@foxmail.com>
 */
class PhoneNumberVerification implements PhoneNumberVerificationInterface
{
    const  VERIFICATION_KEY = 'phone_number_verification';

    /**
     * @var  ProviderInterface
     */
    protected $provider;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var string
     */
    private $templateId;

    /**
     * @var int
     */
    private $second;

    /**
     * @param ProviderInterface $provider
     * @param Cache $cache
     * @param ValidatorInterface $validator
     * @param string $templateId
     * @param int $second
     */
    public function __construct(ProviderInterface $provider, Cache $cache, ValidatorInterface $validator,$templateId, $second=30)
    {
        $this->provider = $provider;
        $this->cache = $cache;
        $this->validator = $validator;
        $this->templateId = $templateId;
        $this->second=$second;
    }

    /**
     * @param $phone
     * @return array
     */
    public function send($phone)
    {
        if (!$this->canSendAgain($phone)) {
            return array(
                'status' => MessageStatus::STATUS_FAILED,
                'message' => sprintf('发送短信操作太频繁,请%s秒后再试.',$this->second) ,
            );
        }

        $code = $this->generateCode();

        $this->cache->save($this->getKey($phone), array(
            'token' => $code,
            'sent_at' => time(),
        ), 300);  //5 min

        try{
            $message = Message::create()
                ->setRecipient($phone)
                ->setTemplateId($this->templateId)
                ->setData([
                    $code
                ])->using($this->provider)
                ->send();
        }catch (\InvalidArgumentException $exception){
            return [
                'status'=>MessageStatus::STATUS_FAILED,
                'message'=> '请配置短信参数'
            ];
        }

        return [
            'status' => $message->getStatus(),
            'messsage' => $message->getStatus() == MessageStatus::STATUS_SENT ? '发送成功' : $message->getError()->getMessage()
        ];
    }


    protected function generateCode()
    {
        return (string)mt_rand(100000, 999999);
    }

    /**
     * @param $phone
     * @return string
     */
    protected function getKey($phone)
    {
        return self::VERIFICATION_KEY . $phone;
    }

    /**
     * @param string $phone
     * @param string $code
     * @return bool
     */
    public function validate($phone, $code)
    {
        $data = $this->cache->fetch($this->getKey($phone));

        if (!$data || !isset($data['token'])) {
            return false;
        }

        $status = $this->compare($code, $data['token']);

        if ($status) {
            $this->cache->delete($this->getKey($phone));
        }

        return $status;
    }

    /**
     * Run a match comparison on the provided code and the expected code.
     *
     * @param $code
     * @param $expectedCode
     *
     * @return bool
     */
    protected function compare($code, $expectedCode)
    {
        return $expectedCode !== null && is_string($expectedCode) && $code == $expectedCode;
    }

    /**
     * @param $phone
     *
     * @return bool
     */
    protected function canSendAgain($phone)
    {
        if ($this->cache->contains($this->getKey($phone))) {
            $data = $this->cache->fetch($this->getKey($phone));

            if (!$data || !isset($data['sent_at'])) {
                return true;
            }
            return time() >= $data['sent_at'] + $this->second;
        }

        return true;
    }
}
