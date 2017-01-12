<?php

namespace Pintushi\Bundle\SMSBundle\Security;

use Sylius\Bundle\UserBundle\Provider\AbstractUserProvider;

/**
 * @author Vidy Videni<videni@foxmail.com>
 */
class SMSUserProvider extends AbstractUserProvider
{
    public function findUser($phoneNumber)
    {
        if (!preg_match('/^\d{11}$/', $phoneNumber)) {
            return null;
        }

        return $this->userRepository->findOneByPhoneNumber($phoneNumber);
    }
}
