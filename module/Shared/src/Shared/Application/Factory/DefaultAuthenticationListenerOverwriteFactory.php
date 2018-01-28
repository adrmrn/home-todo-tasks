<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 22.01.18
 * Time: 21:44
 */

namespace Shared\Application\Factory;


use Interop\Container\ContainerInterface;
use Auth\Application\Adapter\AuthenticationJWTAdapter;
use ZF\MvcAuth\Factory\DefaultAuthenticationListenerFactory;

class DefaultAuthenticationListenerOverwriteFactory extends DefaultAuthenticationListenerFactory
{
    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     * @param array|NULL                            $options
     *
     * @return \ZF\MvcAuth\Authentication\DefaultAuthenticationListener
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL)
    {
        $listener = parent::__invoke($container, $requestedName, $options);

        $jwtAdapter = $container->get(AuthenticationJWTAdapter::class);
        if ($jwtAdapter) {
            $listener->attach($jwtAdapter);
        }

        return $listener;
    }
}