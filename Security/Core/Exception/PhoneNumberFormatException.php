<?php

namespace Pintushi\Bundle\SMSBundle\Security\Core\Exception;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * @author Vidy Videni<videni@foxmail.com>
 */
class PhoneNumberFormatException extends AuthenticationException
{
    private $phoneNumber;

    /**
     * {@inheritdoc}
     */
    public function getMessageKey()
    {
        return 'Phone number format  is not correct.';
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize(array(
            $this->phoneNumber,
            parent::serialize(),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($str)
    {
        list($this->phoneNumber, $parentData) = unserialize($str);

        parent::unserialize($parentData);
    }
}
