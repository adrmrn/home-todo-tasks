<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 05.12.17
 * Time: 20:06
 */

namespace User\Application\Event\Listener;


use Ramsey\Uuid\Uuid;
use Shared\Application\Event\Event;
use Shared\Application\Event\Subscriber\EventSubscriberAggregateInterface;
use User\Application\Event\EventName;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

class EventListenerAggregate extends AbstractListenerAggregate implements ListenerAggregateInterface
{
    /**
     * @var \Shared\Application\Event\Subscriber\EventSubscriberAggregateInterface
     */
    private $eventSubscriberAggregate;

    /**
     * EventListenerAggregate constructor.
     *
     * @param \Shared\Application\Event\Subscriber\EventSubscriberAggregateInterface $eventSubscriberAggregate
     */
    public function __construct(EventSubscriberAggregateInterface $eventSubscriberAggregate)
    {
        $this->eventSubscriberAggregate = $eventSubscriberAggregate;
    }

    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     * @param int                   $priority
     *
     * @return void
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->getSharedManager()->attach(
            '*',
            EventName::USER_CREATED,
            [$this, 'onEvent'],
            $priority
        );
        $this->listeners[] = $events->getSharedManager()->attach(
            '*',
            EventName::USER_RENAMED,
            [$this, 'onEvent'],
            $priority
        );
    }

    public function onEvent(EventInterface $event): void
    {
        $e = new Event(
            $event->getTarget(),
            $event->getName(),
            Uuid::fromString($event->getParam('entity_id')),
            $event->getParam('data'),
            new \DateTimeImmutable($event->getParam('occurred_at'))
        );

        $this->eventSubscriberAggregate->handle($e);
    }
}