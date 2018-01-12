<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 04.12.17
 * Time: 14:05
 */

namespace Cli\Controller;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use User\Infrastructure\RabbitMQ\RabbitMQMessageConsumer;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class UserEventConsumerControllerFactory implements FactoryInterface
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
        return new UserEventConsumerController(
            $container->get(RabbitMQMessageConsumer::class)
        );
    }
}