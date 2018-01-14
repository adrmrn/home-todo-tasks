<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 13.01.18
 * Time: 17:46
 */

namespace User\Application\Projector\Projection;


use Shared\Application\Event\Event;
use Shared\Application\Projector\Projection\AbstractProjection;
use User\Application\Event\EventName;

class UserRenamedProjection extends AbstractProjection
{
    /**
     * @param \Shared\Application\Event\Event $event
     *
     * @return void
     */
    public function project(Event $event)
    {
        $this->client()->update(
            'user',
            [
                'id' => $event->data()['id'],
            ],
            [
                'name' => $event->data()['name'],
            ]
        );
    }

    /**
     * @param \Shared\Application\Event\Event $event
     *
     * @return bool
     */
    public function isSubscribedTo(Event $event): bool
    {
        return $event->name() === EventName::USER_RENAMED;
    }
}