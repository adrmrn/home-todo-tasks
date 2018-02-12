<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 11.02.18
 * Time: 15:21
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
    public function project(Event $event): void
    {
        $this->client()->save('board', [
            'id'    => $event->data()['id'],
            'name'  => $event->data()['name'],
            'group' => [
                'id'   => $event->data()['group']['id'],
                'name' => $event->data()['group']['name'],
            ],
            'tasks' => [],
        ]);

        $this->client()->push('group',
            [
                'id' => $event->data()['group']['id'],
            ],
            [
                'boards' => [
                    'id'   => $event->data()['id'],
                    'name' => $event->data()['name'],
                ],
            ]
        );

        $this->getEventManager()->trigger(
            ApplicationEventName::BOARD_VIEW_CREATED,
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
        return $event->name() === EventName::BOARD_CREATED;
    }
}