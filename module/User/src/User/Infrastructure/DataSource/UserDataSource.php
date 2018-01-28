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

    /**
     * @param \Ramsey\Uuid\UuidInterface $userId
     *
     * @return \Shared\Application\Persistence\Model\UserViewInterface
     */
    public function fetchById(UuidInterface $userId): UserViewInterface
    {
        $result = $this->mongoDBClient->findOne('user', ['id' => $userId->toString()]);

        if (TRUE === empty($result)) {
            throw new \RuntimeException('User not found', 404);
        }

        return UserView::fromArray($result);
    }
}