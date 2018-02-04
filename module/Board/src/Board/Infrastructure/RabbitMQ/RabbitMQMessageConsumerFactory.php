<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 04.02.18
 * Time: 14:32
 */

namespace Board\Infrastructure\RabbitMQ;


use Board\Application\Projector\Projection\UserRenamedProjection;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Shared\Application\Event\Subscriber\EventSubscriberAggregate;
use Shared\Application\Projector\ProjectorEventSubscriber;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class RabbitMQMessageConsumerFactory implements FactoryInterface
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
        return new RabbitMQMessageConsumer(
            $container->get(AMQPStreamConnection::class),
            new EventSubscriberAggregate(
                new ProjectorEventSubscriber(
                    $container->get(UserRenamedProjection::class)
                )
            )
        );
    }
}