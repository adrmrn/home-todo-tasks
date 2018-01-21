<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 21.01.18
 * Time: 13:10
 */

namespace Shared\Infrastructure\Repository;


use Doctrine\ORM\EntityManager;
use Shared\Application\Event\Event;
use Shared\Application\Persistence\Repository\EventStoreRepositoryInterface;

class DoctrineEventStoreRepository implements EventStoreRepositoryInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;
    private $repository;

    /**
     * DoctrineEventRepository constructor.
     *
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository    = $entityManager->getRepository(Event::class);
    }

    /**
     * @param \Shared\Application\Event\Event $event
     */
    public function store(Event $event)
    {
        $this->entityManager->persist($event);
        $this->entityManager->flush();
    }
}