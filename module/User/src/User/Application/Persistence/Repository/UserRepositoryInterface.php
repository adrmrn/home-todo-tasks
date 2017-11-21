<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 19.11.17
 * Time: 14:00
 */

namespace User\Application\Persistence\Repository;


use Shared\Application\ValueObject\Email;
use User\Application\Model\User;

interface UserRepositoryInterface
{
    /**
     * @param \User\Application\Model\User $user
     *
     * @return mixed
     */
    public function store(User $user);

    /**
     * @param \Shared\Application\ValueObject\Email $email
     *
     * @return bool
     */
    public function checkEmailIsUnique(Email $email): bool;
}