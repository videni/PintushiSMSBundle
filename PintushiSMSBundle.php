<?php

namespace Pintushi\Bundle\SMSBundle;

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
    }
}
