<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 28.01.18
 * Time: 16:49
 */

namespace Auth\Application\Projector\Projection;


use Auth\Application\Event\EventName;
use Auth\Application\EventManager\ApplicationEventName;
use Shared\Application\Event\Event;
use Shared\Application\Projector\Projection\AbstractProjection;

class TokenCreatedProjection extends AbstractProjection
{
    /**
     * @param \Shared\Application\Event\Event $event
     *
     * @return void
     */
    public function project(Event $event)
    {
        $this->client()->save('token', [
            'user_id'   => $event->data()['user_id'],
            'token'     => $event->data()['token'],
            'issued_at' => $event->data()['issued_at'],
            'data'      => $event->data()['data'],
        ]);

        $this->getEventManager()->trigger(
            ApplicationEventName::TOKEN_VIEW_CREATED,
            $event->domain(),
            [
                'token' => $event->data()['token'],
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
        return $event->name() === EventName::TOKEN_CREATED;
    }
}