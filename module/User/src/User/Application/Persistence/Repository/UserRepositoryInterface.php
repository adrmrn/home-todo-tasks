<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 19.11.17
 * Time: 14:00
 */

namespace User\Application\Persistence\Repository;


use Ramsey\Uuid\UuidInterface;
use Shared\Application\ValueObject\Email;
use User\Application\Model\User;

interface UserRepositoryInterface
{
    /**
     * @param \User\Application\Model\User $user
     *
     * @return void
     */
    public function store(User $user): void;

    /**
     * @param \Ramsey\Uuid\UuidInterface $id
     *
     * @return \User\Application\Model\User
     */
    public function fetchById(UuidInterface $id): User;

    /**
     * @param \Shared\Application\ValueObject\Email $email
     *
     * @return \User\Application\Model\User
     */
    public function fetchByEmail(Email $email): User;

    /**
     * @param \Shared\Application\ValueObject\Email $email
     *
     * @return bool
     */
    public function checkEmailIsUnique(Email $email): bool;
}