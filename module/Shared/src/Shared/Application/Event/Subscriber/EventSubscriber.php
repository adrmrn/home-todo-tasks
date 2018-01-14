<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 14.01.18
 * Time: 18:41
 */

namespace Shared\Application\Event\Subscriber;


use Shared\Application\Event\Event;

interface EventSubscriber
{
    /**
     * @param \Shared\Application\Event\Event $event
     *
     * @return void
     */
    public function handle(Event $event);

    /**
     * @param \Shared\Application\Event\Event $event
     *
     * @return bool
     */
    public function isSubscribedTo(Event $event): bool;
}