<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 11.02.18
 * Time: 21:05
 */

namespace Shared\Application\Persistence\DataSource;


use Ramsey\Uuid\UuidInterface;
use Shared\Application\Persistence\Model\BoardViewInterface;
use Shared\Application\Persistence\Specification\MongoDBSpecificationInterface;

interface BoardDataSourceInterface
{
    /**
     * @param \Ramsey\Uuid\UuidInterface $boardId
     *
     * @return \Shared\Application\Persistence\Model\BoardViewInterface
     */
    public function fetchById(UuidInterface $boardId): BoardViewInterface;

    /**
     * @param \Shared\Application\Persistence\Specification\MongoDBSpecificationInterface $specification
     *
     * @return BoardViewInterface[]
     */
    public function fetchBySpecification(MongoDBSpecificationInterface $specification): array;

    /**
     * @param \Shared\Application\Persistence\Specification\MongoDBSpecificationInterface $specification
     *
     * @return int
     */
    public function countBySpecification(MongoDBSpecificationInterface $specification): int;
}