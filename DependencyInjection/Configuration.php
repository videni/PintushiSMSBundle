<?php

namespace Pintushi\Bundle\SMSBundle\DependencyInjection;

use Pintushi\Bundle\ConfigBundle\DependencyInjection\SettingsBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Vidy Videni<videni@foxmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('pintushi_sms');

        SettingsBuilder::append($rootNode, [
            'account_id' => array(
                'value' => '56',
            ),
            'auth_token' => array(
                'value' => '98',
            ),
            'phone_verification_template_id' => array(
                'value' => 'werwe',
            ),
            'app_id' => array(
                'value' => 'waefwf',
            ),
        ]);

        return $treeBuilder;
    }
}
