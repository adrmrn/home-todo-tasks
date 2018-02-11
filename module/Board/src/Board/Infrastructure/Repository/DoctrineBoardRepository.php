<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 11.02.18
 * Time: 14:45
 */

namespace Board\Infrastructure\Repository;


use Board\Application\Persistence\Repository\BoardRepositoryInterface;
use Board\Domain\Model\Board;
use Doctrine\ORM\EntityManager;
use Ramsey\Uuid\UuidInterface;

class DoctrineBoardRepository implements BoardRepositoryInterface
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
     * DoctrineBoardRepository constructor.
     *
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository    = $entityManager->getRepository(Board::class);
    }

    public function store(Board $board): void
    {
        $this->entityManager->persist($board);
        $this->entityManager->flush();
    }

    public function fetchById(UuidInterface $id): Board
    {
        $board = $this->repository->find($id);

        if ($board === NULL) {
            throw new \RuntimeException('Board not found', 404);
        }

        /** @var Board $board */
        return $board;
    }
}