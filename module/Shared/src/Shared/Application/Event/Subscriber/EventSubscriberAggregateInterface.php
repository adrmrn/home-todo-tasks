<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 14.01.18
 * Time: 19:12
 */

namespace Shared\Application\Event\Subscriber;


use Shared\Application\Event\Event;

interface EventSubscriberAggregateInterface
{
    /**
     * @param \Shared\Application\Event\Event $event
     *
     * @return void
     */
    public function handle(Event $event): void;
}