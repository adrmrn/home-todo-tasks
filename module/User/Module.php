<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 09.11.17
 * Time: 15:25
 */

namespace User;


use Shared\Application\Event\Publisher\Adapter\RabbitMQEventPublisherAdapter;
use User\Application\Event\Listener\EventListenerAggregate;
use User\Application\Event\Publisher\EventPublisher;
use Shared\Application\Event\Publisher\Adapter\InMemoryEventPublisherAdapter;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface, BootstrapListenerInterface, AutoloaderProviderInterface
{
    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Listen to the bootstrap event
     *
     * @param EventInterface|\Zend\Mvc\MvcEvent $e
     *
     * @return array
     */
    public function onBootstrap(EventInterface $e)
    {
        $eventManager = $e->getApplication()->getEventManager();

        $aggregate = $e->getApplication()->getServiceManager()->get(EventListenerAggregate::class);
        $aggregate->attach($eventManager);

        EventPublisher::initialize(
            $e->getApplication()->getServiceManager()->get(InMemoryEventPublisherAdapter::class),
            $e->getApplication()->getServiceManager()->get(RabbitMQEventPublisherAdapter::class)
        );

        return [];
    }

    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }
}