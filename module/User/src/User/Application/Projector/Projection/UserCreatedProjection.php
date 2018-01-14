<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 13.01.18
 * Time: 16:20
 */

namespace User\Application\Projector\Projection;


use Shared\Application\Event\Event;
use Shared\Application\Projector\Projection\AbstractProjection;
use User\Application\Event\EventName;

class UserCreatedProjection extends AbstractProjection
{
    /**
     * @param \Shared\Application\Event\Event $event
     *
     * @return void
     */
    public function project(Event $event)
    {
        $this->client()->save('user', [
            'id'    => $event->data()['id'],
            'name'  => $event->data()['name'],
            'email' => $event->data()['email'],
        ]);
    }

    /**
     * @param \Shared\Application\Event\Event $event
     *
     * @return bool
     */
    public function isSubscribedTo(Event $event): bool
    {
        return $event->name() === EventName::USER_CREATED;
    }
}