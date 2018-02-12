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
use Shared\Application\Persistence\Specification\MongoDBSpecificationInterface;

interface UserDataSourceInterface
{
    /**
     * @param \Ramsey\Uuid\UuidInterface $userId
     *
     * @return \Shared\Application\Persistence\Model\UserViewInterface
     */
    public function fetchById(UuidInterface $userId): UserViewInterface;

    /**
     * @param \Shared\Application\Persistence\Specification\MongoDBSpecificationInterface $specification
     *
     * @return UserViewInterface[]
     */
    public function fetchBySpecification(MongoDBSpecificationInterface $specification): array;

    /**
     * @param \Shared\Application\Persistence\Specification\MongoDBSpecificationInterface $specification
     *
     * @return int
     */
    public function countBySpecification(MongoDBSpecificationInterface $specification): int;

    /**
     * @param \Ramsey\Uuid\UuidInterface $userId
     *
     * @return bool
     */
    public function exists(UuidInterface $userId): bool;
}