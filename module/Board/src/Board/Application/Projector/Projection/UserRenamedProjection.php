<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 04.02.18
 * Time: 14:34
 */

namespace Board\Application\Projector\Projection;


use Shared\Application\Event\Event;
use Shared\Application\Projector\Projection\AbstractProjection;

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
            'group',
            [
                'memberships.user.id' => $event->data()['id'],
            ],
            [
                'memberships.$.user.name' => $event->data()['name'],
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
        return $event->name() === 'user_renamed';
    }
}