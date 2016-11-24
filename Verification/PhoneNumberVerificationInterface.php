<?php
namespace Pintushi\Bundle\SMSBundle\Verification;

/**
 * @author Vidy Videni<videni@foxmail.com>
 */
interface PhoneNumberVerificationInterface
{
    /**
     * @param $phone
     * @return array
     */
    public function send($phone);

    /**
     * @param string $phone
     * @param string $code
     * @return bool
     */
    public function validate($phone, $code);
}