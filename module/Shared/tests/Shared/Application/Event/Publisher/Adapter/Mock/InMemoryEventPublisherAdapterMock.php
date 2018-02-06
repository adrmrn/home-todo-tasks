<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 06.02.18
 * Time: 21:01
 */

namespace Shared\Application\Event\Publisher\Adapter\Mock;


use Shared\Application\Event\Event;
use Shared\Application\Event\Publisher\Adapter\EventPublisherAdapterInterface;

class InMemoryEventPublisherAdapterMock implements EventPublisherAdapterInterface
{
    /**
     * @var Event[]
     */
    private $storage = [];

    /**
     * @param \Shared\Application\Event\Event $event
     *
     * @return void
     */
    public function publish(Event $event): void
    {
        $this->storage[] = $event;
    }

    public function lastPublishedEvent(): Event
    {
        return end($this->storage);
    }
}