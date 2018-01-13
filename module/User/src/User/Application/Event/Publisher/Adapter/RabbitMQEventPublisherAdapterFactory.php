<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 31.12.17
 * Time: 12:33
 */

namespace User\Application\Event\Publisher\Adapter;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Shared\Application\Persistence\RabbitMQ\RabbitMQMessageProducerInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class RabbitMQEventPublisherAdapterFactory implements FactoryInterface
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
        return new RabbitMQEventPublisherAdapter(
            $container->get(RabbitMQMessageProducerInterface::class)
        );
    }
}