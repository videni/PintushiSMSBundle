<?php

namespace Pintushi\Bundle\SMSBundle;

use Pintushi\Bundle\SMSBundle\DependencyInjection\Security\Factory\SMSAuthFactory;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Vidy Videni<videni@foxmail.com>
 */
class PintushiSMSBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new SMSAuthFactory());
    }
}
