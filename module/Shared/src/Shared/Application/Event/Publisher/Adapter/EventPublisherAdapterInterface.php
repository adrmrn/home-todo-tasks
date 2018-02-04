<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 29.12.17
 * Time: 21:14
 */

namespace Shared\Application\Event\Publisher\Adapter;


use Shared\Application\Event\Event;

interface EventPublisherAdapterInterface
{
    /**
     * @param \Shared\Application\Event\Event $event
     *
     * @return void
     */
    public function publish(Event $event): void;
}