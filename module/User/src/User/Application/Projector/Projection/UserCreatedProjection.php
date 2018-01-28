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
use User\Application\EventManager\ApplicationEventName;

class UserCreatedProjection extends AbstractProjection
{
    /**
     * @param \Shared\Application\Event\Event $event
     *
     * @return void
     */
    public function project(Event $event)
    {
        // save user
        $this->client()->save('user', [
            'id'    => $event->data()['id'],
            'name'  => $event->data()['name'],
            'email' => $event->data()['email'],
        ]);

        // save credentials
        $this->client()->save('credentials', [
            'user_id'  => $event->data()['id'],
            'email'    => $event->data()['email'],
            'password' => $event->data()['password'],
        ]);

        $this->getEventManager()->trigger(
            ApplicationEventName::USER_VIEW_CREATED,
            $event->domain(),
            [
                'id' => $event->data()['id'],
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
        return $event->name() === EventName::USER_CREATED;
    }
}