<?php

namespace Pintushi\Bundle\SMSBundle\Validator;

use Pintushi\Bundle\SMSBundle\Verification\PhoneNumberVerificationInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;

/**
 * SMS validator.
 */
class SMSValidator
{
    /**
     * @var PhoneNumberVerificationInterface
     */
    protected $phoneNumberVerification;

    public function __construct(PhoneNumberVerificationInterface $phoneNumberVerification)
    {
        $this->phoneNumberVerification = $phoneNumberVerification;
    }

    /**
     * @param FormEvent $event
     */
    public function validate(FormEvent $event)
    {
        $form = $event->getForm();

        $phone = $form->get('phoneNumber')->getData();
        if (empty($phone))
            return;

        $verificationCodeForm = $form->get('verificationCode');
        $code = $verificationCodeForm->getData();

//        if (!$this->phoneNumberVerification->validate($phone, $code)) {
//            $formError = new FormError('请输入正确的验证码');
//            $verificationCodeForm->addError($formError);
//        }
    }
}
