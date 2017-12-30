<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 30.12.17
 * Time: 15:08
 */

namespace User\Application\Event\Publisher\Adapter;


use Shared\Application\Event\Event;
use Shared\Application\Event\Publisher\Adapter\EventPublisherAdapterInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;

class InMemoryEventPublisherAdapter implements EventPublisherAdapterInterface, EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    /**
     * @param \Shared\Application\Event\Event $event
     */
    public function publish(Event $event)
    {
        $this->getEventManager()->trigger(
            $event->name(),
            $event->domain(),
            $event->data()
        );
    }
}