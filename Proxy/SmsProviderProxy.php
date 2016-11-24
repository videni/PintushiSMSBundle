<?php

namespace Pintushi\Bundle\SMSBundle\Proxy;

use ProxyManager\Configuration;
use ProxyManager\Factory\LazyLoadingValueHolderFactory;
use ProxyManager\GeneratorStrategy\EvaluatingGeneratorStrategy;
use YunZhiXun\Provider;

/**
 * @author Vidy Videni<videni@foxmail.com>
 */
class SmsProviderProxy
{

    /**
     * @param array $config
     * @return \ProxyManager\Proxy\VirtualProxyInterface
     */
    public static function create(array $config)
    {
        $proxyFonfig = new Configuration();
        $proxyFonfig->setGeneratorStrategy(new EvaluatingGeneratorStrategy());

        $factory = new LazyLoadingValueHolderFactory($proxyFonfig);

        $providerProxy = $factory->createProxy(
            Provider::class,
            function (& $wrappedObject, $proxy, $method, $parameters, & $initializer) use ($config) {
                $wrappedObject = new Provider([
                    'accountSid' => $config['account_id'],
                    'authToken' => $config['auth_token'],
                    'appId' => $config['app_id'],
                ]);
                $initializer = null; // turning off further lazy initialization
            }
        );

        return $providerProxy;
    }
}