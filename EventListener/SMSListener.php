<?php

namespace Pintushi\Bundle\SMSBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Pintushi\Bundle\SMSBundle\PintushiSMSEvents;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * @author Vidy Videni<videni@foxmail.com>
 */
class SMSListener implements EventSubscriberInterface
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return array(
            PintushiSMSEvents::SMS_VERIFICATION_CODE_PRE_SEND => 'preSend',
            PintushiSMSEvents::SMS_VERIFICATION_CODE_POST_SEND => 'postSend',
        );
    }

    public function postSend(GenericEvent $event)
    {
    }

    public function preSend(GenericEvent $event)
    {
    }
}
