<?php

namespace Pintushi\Bundle\SMSBundle\Security\Core\Authentication\Provider;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\AuthenticationServiceException;
use Pintushi\Bundle\SMSBundle\Verification\PhoneNumberVerificationInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Pintushi\Bundle\SMSBundle\Security\Core\Authentication\Token\SMSToken;
use Pintushi\Bundle\SMSBundle\Security\Core\Exception\PhoneNumberFormatException;


/**
 * @author Vidy Videni<videni@foxmail.com>
 */
class SMSAuthProvider implements AuthenticationProviderInterface
{

    /**
     * @var UserProviderInterface
     */
    private $userProvider;

    /**
     * @var UserCheckerInterface
     */
    private $userChecker;

    /**
     * @var PhoneNumberVerificationInterface
     */
    private $phoneNumberVerification;

    /**
     * @param UserProviderInterface $userProvider User provider
     * @param UserCheckerInterface $userChecker User checker
     */
    public function __construct(UserProviderInterface $userProvider, PhoneNumberVerificationInterface $phoneNumberVerification, UserCheckerInterface $userChecker)
    {
        $this->userProvider = $userProvider;
        $this->userChecker = $userChecker;
        $this->phoneNumberVerification = $phoneNumberVerification;
    }

    /**
     * {@inheritDoc}
     */
    public function supports(TokenInterface $token)
    {

        return $token instanceof SMSToken;
    }

    /**
     * {@inheritDoc}
     */
    public function authenticate(TokenInterface $token)
    {
        /* @var SMSToken $token */
        $user = $this->userProvider->loadUserByUsername($token->getPhoneNumber());

        if (!$user instanceof UserInterface) {
            throw new AuthenticationServiceException('loadUserByUsername() must return a UserInterface.');
        }

        try {
            $this->userChecker->checkPreAuth($user);

            if (!$this->phoneNumberVerification->validate($token->getPhoneNumber(), $token->getVerificationCode())) {
                throw  new  BadCredentialsException();
            }

            $this->userChecker->checkPostAuth($user);
        } catch (BadCredentialsException $e) {
            throw $e;
        }

        $token = new SMSToken($token->getPhoneNumber(), $token->getVerificationCode(), $user->getRoles());
        $token->setUser($user);
        $token->setAuthenticated(true);

        $this->userChecker->checkPostAuth($user);

        return $token;
    }
}
