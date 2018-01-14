<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 13.01.18
 * Time: 17:14
 */

namespace User\Application\Event\Listener;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Shared\Application\Event\Subscriber\EventSubscriberAggregate;
use Shared\Application\Projector\ProjectorEventSubscriber;
use User\Application\Projector\Projection\UserCreatedProjection;
use User\Application\Projector\Projection\UserRenamedProjection;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class EventListenerAggregateFactory implements FactoryInterface
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
        return new EventListenerAggregate(
            new EventSubscriberAggregate(
                new ProjectorEventSubscriber(
                    $container->get(UserCreatedProjection::class),
                    $container->get(UserRenamedProjection::class)
                )
            )
        );
    }
}