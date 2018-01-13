<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 12.01.18
 * Time: 22:06
 */

namespace User\Infrastructure\Repository;


use Doctrine\ORM\EntityManager;
use Ramsey\Uuid\UuidInterface;
use Shared\Application\ValueObject\Email;
use User\Application\Model\User;
use User\Application\Persistence\Repository\UserRepositoryInterface;

class DoctrineUserRepository implements UserRepositoryInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;
    private $repository;

    /**
     * DoctrineUserRepository constructor.
     *
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository    = $entityManager->getRepository(User::class);
    }

    /**
     * @param \User\Application\Model\User $user
     *
     * @return void
     */
    public function store(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * @param \Ramsey\Uuid\UuidInterface $id
     *
     * @return \User\Application\Model\User
     */
    public function fetchById(UuidInterface $id): User
    {
        $user = $this->repository->find($id);

        if ($user === NULL) {
            throw new \RuntimeException('User not found', 404);
        }

        /** @var User $user */
        return $user;
    }

    /**
     * @param \Shared\Application\ValueObject\Email $email
     *
     * @return bool
     */
    public function checkEmailIsUnique(Email $email): bool
    {
        $user = $this->repository->findOneBy([
            'credentials.email.value' => $email->toString()
        ]);

        return NULL === $user;
    }
}