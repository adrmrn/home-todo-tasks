<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 14.01.18
 * Time: 22:21
 */

namespace Shared\Application\Persistence\DataSource;


use Ramsey\Uuid\UuidInterface;
use Shared\Application\Persistence\Model\UserViewInterface;
use Shared\Application\Persistence\Specification\MongoDBSpecification;

interface UserDataSourceInterface
{
    /**
     * @param \Ramsey\Uuid\UuidInterface $userId
     *
     * @return \Shared\Application\Persistence\Model\UserViewInterface
     */
    public function fetchById(UuidInterface $userId): UserViewInterface;

    /**
     * @param \Shared\Application\Persistence\Specification\MongoDBSpecification $specification
     *
     * @return array
     */
    public function fetchBySpecification(MongoDBSpecification $specification): array;

    /**
     * @param \Shared\Application\Persistence\Specification\MongoDBSpecification $specification
     *
     * @return int
     */
    public function countBySpecification(MongoDBSpecification $specification): int;

    /**
     * @param \Ramsey\Uuid\UuidInterface $userId
     *
     * @return bool
     */
    public function exists(UuidInterface $userId): bool;
}