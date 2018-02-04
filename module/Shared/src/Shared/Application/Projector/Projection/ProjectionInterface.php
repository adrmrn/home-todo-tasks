<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 13.01.18
 * Time: 16:07
 */

namespace Shared\Application\Projector\Projection;


use Shared\Application\Event\Event;

interface ProjectionInterface
{
    /**
     * @param \Shared\Application\Event\Event $event
     *
     * @return void
     */
    public function project(Event $event): void;

    /**
     * @param \Shared\Application\Event\Event $event
     *
     * @return bool
     */
    public function isSubscribedTo(Event $event): bool;
}