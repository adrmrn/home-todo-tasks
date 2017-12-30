<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 05.12.17
 * Time: 20:06
 */

namespace User\Application\EventManager;


use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

class EventListenerAggregate extends AbstractListenerAggregate implements ListenerAggregateInterface
{
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
            [$this, 'onUserCreated'],
            $priority
        );
        $this->listeners[] = $events->getSharedManager()->attach(
            '*',
            EventName::USER_UPDATED,
            [$this, 'onUserUpdated'],
            $priority
        );
    }

    public function onUserCreated(EventInterface $event)
    {
        //TODO: implement handler for create user projection
    }

    public function onUserUpdated(EventInterface $event)
    {
        //TODO: implement handler for update user projection
    }
}