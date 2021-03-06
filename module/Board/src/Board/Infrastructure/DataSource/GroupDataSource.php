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
use Shared\Application\Persistence\Specification\MongoDBSpecificationInterface;

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

    public function fetchById(UuidInterface $groupId): GroupViewInterface
    {
        $result = $this->mongoDBClient->findOne('group', ['id' => $groupId->toString()]);

        if (TRUE === empty($result)) {
            throw new \RuntimeException('Group not found', 404);
        }

        return GroupView::fromArray($this->prepareRawArray($result));
    }

    /**
     * @param \Shared\Application\Persistence\Specification\MongoDBSpecificationInterface $specification
     *
     * @return GroupViewInterface[]
     */
    public function fetchBySpecification(MongoDBSpecificationInterface $specification): array
    {
        $results = $this->mongoDBClient->find(
            'group',
            $specification->filtersToClauses(),
            $specification->optionsToClauses()
        );

        $groups = [];
        /** @var \MongoDB\Model\BSONDocument $row */
        foreach ($results as $row) {
            $groups[] = GroupView::fromArray(
                $this->prepareRawArray($row->getArrayCopy())
            );
        }

        return $groups;
    }

    public function countBySpecification(MongoDBSpecificationInterface $specification): int
    {
        return $this->mongoDBClient->count(
            'group',
            $specification->filtersToClauses(),
            $specification->optionsToClauses()
        );
    }

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