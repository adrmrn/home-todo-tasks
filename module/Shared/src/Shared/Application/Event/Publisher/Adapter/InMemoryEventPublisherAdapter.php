<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 30.12.17
 * Time: 15:08
 */

namespace Shared\Application\Event\Publisher\Adapter;


use Shared\Application\Event\Event;
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
            $event->jsonSerialize()
        );
    }
}