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
use Ramsey\Uuid\Uuid;
use Shared\Application\Event\Event;
use Shared\Application\Persistence\DataSource\UserDataSourceInterface;
use Shared\Application\Persistence\MongoDB\MongoDBClientInterface;
use Shared\Application\Projector\Projection\AbstractProjection;

class GroupCreatedProjection extends AbstractProjection
{
    /**
     * @var \Shared\Application\Persistence\DataSource\UserDataSourceInterface
     */
    private $userDataSource;

    /**
     * BoardCreatedProjection constructor.
     *
     * @param \Shared\Application\Persistence\MongoDB\MongoDBClientInterface     $mongoDBClient
     * @param \Shared\Application\Persistence\DataSource\UserDataSourceInterface $userDataSource
     */
    public function __construct(MongoDBClientInterface $mongoDBClient, UserDataSourceInterface $userDataSource)
    {
        parent::__construct($mongoDBClient);

        $this->userDataSource = $userDataSource;
    }

    public function project(Event $event): void
    {
        $userId = $event->data()['memberships'][0]['user_id'];
        $user   = $this->userDataSource->fetchById(Uuid::fromString($userId));

        $membership = [
            'user' => [
                'id'   => $user->id(),
                'name' => $user->name(),
            ],
            'role' => $event->data()['memberships'][0]['role'],
        ];

        $this->client()->save('group', [
            'id'          => $event->data()['id'],
            'name'        => $event->data()['name'],
            'memberships' => [$membership],
            'boards'      => [],
        ]);

        $this->getEventManager()->trigger(
            ApplicationEventName::GROUP_VIEW_CREATED,
            $event->domain(),
            [
                'id' => $event->data()['id'],
            ]
        );
    }

    public function isSubscribedTo(Event $event): bool
    {
        return $event->name() === EventName::GROUP_CREATED;
    }
}