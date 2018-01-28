<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 23.01.18
 * Time: 21:31
 */

namespace Auth\Application\Service\Token;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class JWTTokenServiceFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     *
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL)
    {
        if (FALSE === isset(
                $container->get('config')['auth'],
                $container->get('config')['auth']['issuer'],
                $container->get('config')['auth']['secret']
            )) {
            throw new \RuntimeException('Config for JWT is not provided.', 501);
        }

        $config = $container->get('config')['auth'];

        return new JWTTokenService(
            $config['issuer'],
            $config['secret']
        );
    }
}