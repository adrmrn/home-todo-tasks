<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 16.11.17
 * Time: 21:34
 */

namespace User\Application\Service;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use User\Application\Persistence\Repository\UserRepositoryInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class UserCreatorServiceFactory implements FactoryInterface
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
        return new UserCreatorService(
            $container->get(UserRepositoryInterface::class)
        );
    }
}