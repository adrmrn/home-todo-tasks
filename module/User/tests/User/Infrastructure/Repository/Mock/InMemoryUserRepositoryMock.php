<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 15.02.18
 * Time: 22:17
 */

namespace User\Infrastructure\Repository\Mock;


use Ramsey\Uuid\UuidInterface;
use Shared\Application\ValueObject\Email;
use User\Application\Model\User;
use User\Application\Persistence\Repository\UserRepositoryInterface;

class InMemoryUserRepositoryMock implements UserRepositoryInterface
{
    /**
     * @var User[]
     */
    private $storage = [];

    /**
     * InMemoryUserRepositoryMock constructor.
     *
     * @param \User\Application\Model\User[] ...$users
     */
    public function __construct(User ...$users)
    {
        foreach ($users as $user) {
            $this->store($user);
        }
    }

    /**
     * @param \User\Application\Model\User $user
     *
     * @return void
     */
    public function store(User $user): void
    {
        $this->storage[$user->id()->toString()] = $user;
    }

    /**
     * @param \Ramsey\Uuid\UuidInterface $id
     *
     * @return \User\Application\Model\User
     */
    public function fetchById(UuidInterface $id): User
    {
        if (FALSE === isset($this->storage[$id->toString()])) {
            throw new \RuntimeException('User not found', 404);
        }

        return $this->storage[$id->toString()];
    }

    /**
     * @param \Shared\Application\ValueObject\Email $email
     *
     * @return \User\Application\Model\User
     */
    public function fetchByEmail(Email $email): User
    {
        /** @var User $user */
        foreach ($this->storage as $user) {
            if ($user->credentials()->email()->toString() === $email->toString()) {
                return $user;
            }
        }

        throw new \RuntimeException('User not found', 404);
    }

    /**
     * @param \Shared\Application\ValueObject\Email $email
     *
     * @return bool
     */
    public function checkEmailIsUnique(Email $email): bool
    {
        try {
            $this->fetchByEmail($email);
        } catch (\RuntimeException $exception) {
            return TRUE;
        }

        return FALSE;
    }
}