<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 14.01.18
 * Time: 16:48
 */

namespace Shared\Application\Event\Subscriber;


use Shared\Application\Event\Event;

class EventSubscriberAggregate implements EventSubscriberAggregateInterface
{
    /**
     * @var \Shared\Application\Event\Subscriber\EventSubscriber[]
     */
    private $eventSubscribers;

    /**
     * EventSubscriberAggregate constructor.
     *
     * @param \Shared\Application\Event\Subscriber\EventSubscriber[] ...$eventSubscribers
     */
    public function __construct(EventSubscriber ...$eventSubscribers)
    {
        $this->eventSubscribers = $eventSubscribers;
    }

    /**
     * @param \Shared\Application\Event\Event $event
     */
    public function handle(Event $event)
    {
        foreach ($this->eventSubscribers as $eventSubscriber) {
            if ($eventSubscriber->isSubscribedTo($event)) {
                $eventSubscriber->handle($event);
            }
        }
    }
}