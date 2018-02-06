<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 31.01.18
 * Time: 22:49
 */

namespace Board\Infrastructure\Repository;


use Board\Application\Persistence\GroupRepositoryInterface;
use Board\Domain\Model\Group;
use Doctrine\ORM\EntityManager;
use Ramsey\Uuid\UuidInterface;

class DoctrineGroupRepository implements GroupRepositoryInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;
    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository
     */
    private $repository;

    /**
     * DoctrineGroupRepository constructor.
     *
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository    = $entityManager->getRepository(Group::class);
    }

    public function store(Group $group): void
    {
        $this->entityManager->persist($group);
        $this->entityManager->flush();
    }

    public function fetchById(UuidInterface $id): Group
    {
        $group = $this->repository->find($id);

        if ($group === NULL) {
            throw new \RuntimeException('Group not found', 404);
        }

        /** @var Group $group */
        return $group;
    }
}