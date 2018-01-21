<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 21.01.18
 * Time: 13:14
 */

namespace Shared\Application\Persistence\Repository;


use Shared\Application\Event\Event;

interface EventStoreRepositoryInterface
{
    /**
     * @param \Shared\Application\Event\Event $event
     *
     * @return void
     */
    public function store(Event $event);
}