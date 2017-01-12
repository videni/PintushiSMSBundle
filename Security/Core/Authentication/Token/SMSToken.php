<?php


namespace Pintushi\Bundle\SMSBundle\Security\Core\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * @author Vidy Videni<videni@foxmail.com>
 */
class SMSToken extends AbstractToken
{
    protected  $phoneNumber;

    protected  $verificationCode;
    /**
     * Constructor.
     *
     * @param string|object            $phoneNumber        .
     * @param string                   $verificationCode
     * @param RoleInterface[]|string[] $roles       An array of roles
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($phoneNumber, $verificationCode, array $roles = array())
    {
        parent::__construct($roles);

        $this->phoneNumber=$phoneNumber;
        $this->verificationCode = $verificationCode;

        parent::setAuthenticated(count($roles) > 0);
    }

    public function getCredentials()
    {
        return '';
    }

    /**
     * @return array|\Symfony\Component\Security\Core\Role\RoleInterface[]
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param array|\Symfony\Component\Security\Core\Role\RoleInterface[] $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return mixed
     */
    public function getVerificationCode()
    {
        return $this->verificationCode;
    }

    /**
     * @param mixed $verificationCode
     */
    public function setVerificationCode($verificationCode)
    {
        $this->verificationCode = $verificationCode;
    }
}
