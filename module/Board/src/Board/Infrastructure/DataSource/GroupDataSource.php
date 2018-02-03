<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 03.02.18
 * Time: 11:39
 */

namespace Board\Infrastructure\DataSource;


use Board\Application\ViewModel\GroupView;
use Ramsey\Uuid\UuidInterface;
use Shared\Application\Persistence\DataSource\GroupDataSourceInterface;
use Shared\Application\Persistence\Model\GroupViewInterface;
use Shared\Application\Persistence\MongoDB\MongoDBClientInterface;

class GroupDataSource implements GroupDataSourceInterface
{
    /**
     * @var \Shared\Application\Persistence\MongoDB\MongoDBClientInterface
     */
    private $mongoDBClient;

    /**
     * GroupDataSource constructor.
     *
     * @param \Shared\Application\Persistence\MongoDB\MongoDBClientInterface $mongoDBClient
     */
    public function __construct(MongoDBClientInterface $mongoDBClient)
    {
        $this->mongoDBClient = $mongoDBClient;
    }

    /**
     * @param \Ramsey\Uuid\UuidInterface $groupId
     *
     * @return \Shared\Application\Persistence\Model\GroupViewInterface
     */
    public function fetchById(UuidInterface $groupId): GroupViewInterface
    {
        $result = $this->mongoDBClient->findOne('group', ['id' => $groupId->toString()]);

        if (TRUE === empty($result)) {
            throw new \RuntimeException('Group not found', 404);
        }

        return GroupView::fromArray($this->prepareRawArray($result));
    }

    /**
     * @param array $data
     *
     * @return array
     */
    private function prepareRawArray(array $data): array
    {
        $memberships = [];

        /** @var \MongoDB\Model\BSONDocument $membership */
        foreach ($data['memberships']->getArrayCopy() as $membership) {
            /** @var \MongoDB\Model\BSONDocument $user */
            $user = $membership->getArrayCopy()['user'];

            $memberships[] = [
                'user' => $user->getArrayCopy(),
                'role' => $membership->getArrayCopy()['role'],
            ];
        }

        return [
            'id'          => $data['id'],
            'name'        => $data['name'],
            'memberships' => $memberships,
        ];
    }
}