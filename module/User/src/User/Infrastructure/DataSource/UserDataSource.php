<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 14.01.18
 * Time: 22:08
 */

namespace User\Infrastructure\DataSource;


use Ramsey\Uuid\UuidInterface;
use Shared\Application\Persistence\Model\UserViewInterface;
use Shared\Application\Persistence\MongoDB\MongoDBClientInterface;
use Shared\Application\Persistence\Specification\MongoDBSpecificationInterface;
use User\Application\ViewModel\UserView;
use Shared\Application\Persistence\DataSource\UserDataSourceInterface;

class UserDataSource implements UserDataSourceInterface
{
    /**
     * @var \Shared\Application\Persistence\MongoDB\MongoDBClientInterface
     */
    private $mongoDBClient;

    /**
     * UserDataSource constructor.
     *
     * @param \Shared\Application\Persistence\MongoDB\MongoDBClientInterface $mongoDBClient
     */
    public function __construct(MongoDBClientInterface $mongoDBClient)
    {
        $this->mongoDBClient = $mongoDBClient;
    }

    public function fetchById(UuidInterface $userId): UserViewInterface
    {
        if (FALSE === $this->exists($userId)) {
            throw new \RuntimeException('User not found', 404);
        }

        $result = $this->mongoDBClient->findOne('user', ['id' => $userId->toString()]);

        return UserView::fromArray($result);
    }

    /**
     * @param \Shared\Application\Persistence\Specification\MongoDBSpecificationInterface $specification
     *
     * @return UserViewInterface[]
     */
    public function fetchBySpecification(MongoDBSpecificationInterface $specification): array
    {
        $results = $this->mongoDBClient->find(
            'user',
            $specification->filtersToClauses(),
            $specification->optionsToClauses()
        );

        $users = [];
        /** @var \MongoDB\Model\BSONDocument $row */
        foreach ($results as $row) {
            $users[] = UserView::fromArray($row->getArrayCopy());
        }

        return $users;
    }

    public function countBySpecification(MongoDBSpecificationInterface $specification): int
    {
        return $this->mongoDBClient->count(
            'user',
            $specification->filtersToClauses(),
            $specification->optionsToClauses()
        );
    }

    public function exists(UuidInterface $userId): bool
    {
        $result = $this->mongoDBClient->findOne('user', ['id' => $userId->toString()]);

        return FALSE === empty($result);
    }
}