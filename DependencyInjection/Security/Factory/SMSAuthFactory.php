<?php

namespace Pintushi\Bundle\SMSBundle\DependencyInjection\Security\Factory;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\AbstractFactory;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

/**
 * SMSAuthFactory
 */
class SMSAuthFactory extends AbstractFactory
{
    public function __construct()
    {
        $this->addOption('phone_number_parameter', 'phoneNumber');
        $this->addOption('verification_code_parameter', 'verificationCode');
        $this->addOption('csrf_parameter', '_csrf_token');
        $this->addOption('intention', 'authenticate');
        $this->addOption('post_only', true);
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
        parent::addConfiguration($node);

        $builder = $node->children();
        $builder
            ->scalarNode('login_path')->cannotBeEmpty()->isRequired()->end()
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'sms';
    }

    /**
     * {@inheritDoc}
     */
    public function getPosition()
    {
        return 'form';
    }

    /**
     * {@inheritDoc}
     */
    protected function createAuthProvider(ContainerBuilder $container, $id, $config, $userProviderId)
    {
        $providerId = 'pintushi_sms.authentication.provider.'.$id;

        $container
            ->setDefinition($providerId, new DefinitionDecorator('pintushi_sms.security.authentication.provider'))
            ->addArgument(new Reference($userProviderId))
            ->addArgument(new Reference('pintushi.phone_number_verification'))
            ->addArgument(new Reference('security.user_checker'))
        ;

        return $providerId;
    }

    /**
     * {@inheritDoc}
     */
    protected function createEntryPoint($container, $id, $config, $defaultEntryPoint)
    {
        $entryPointId = 'security.authentication.form_entry_point.'.$id;
        $container
            ->setDefinition($entryPointId, new DefinitionDecorator('security.authentication.form_entry_point'))
            ->addArgument(new Reference('security.http_utils'))
            ->addArgument($config['login_path'])
            ->addArgument($config['use_forward'])
        ;

        return $entryPointId;
    }

    /**
     * {@inheritDoc}
     */
    protected function createListener($container, $id, $config, $userProvider)
    {
        $listenerId = parent::createListener($container, $id, $config, $userProvider);

        $container
            ->getDefinition($listenerId)
            ->addArgument(isset($config['csrf_provider']) ? new Reference($config['csrf_provider']) : null)
        ;

        return $listenerId;
    }

    /**
     * {@inheritDoc}
     */
    protected function getListenerId()
    {
        return 'pintushi_sms.security.authentication.listener';
    }
}
