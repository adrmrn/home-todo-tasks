<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 01.02.18
 * Time: 23:26
 */

namespace Board\Application\Projector\Projection;


use Board\Application\Event\EventName;
use Board\Application\EventManager\ApplicationEventName;
use Shared\Application\Event\Event;
use Shared\Application\Projector\Projection\AbstractProjection;

class BoardCreatedProjection extends AbstractProjection
{
    /**
     * @param \Shared\Application\Event\Event $event
     *
     * @return void
     */
    public function project(Event $event)
    {
        // TODO: get full data about user in membership

        // save group
        $this->client()->save('group', [
            'id'          => $event->data()['id'],
            'name'        => $event->data()['name'],
            'memberships' => $event->data()['memberships'],
        ]);

        $this->getEventManager()->trigger(
            ApplicationEventName::GROUP_VIEW_CREATED,
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
        return $event->name() === EventName::GROUP_CREATED;
    }
}