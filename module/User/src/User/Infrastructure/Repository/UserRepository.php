<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 19.11.17
 * Time: 13:57
 */

namespace User\Infrastructure\Repository;


use Shared\Application\ValueObject\Email;
use User\Application\Model\User;
use User\Application\Persistence\Repository\UserRepositoryInterface;
use User\Infrastructure\Dao\UserDao;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var \User\Infrastructure\Dao\UserDao
     */
    private $userDao;

    /**
     * UserRepository constructor.
     *
     * @param \User\Infrastructure\Dao\UserDao $userDao
     */
    public function __construct(UserDao $userDao)
    {
        $this->userDao = $userDao;
    }

    /**
     * @param \User\Application\Model\User $user
     *
     * @return void
     */
    public function store(User $user)
    {
        $this->userDao->store($user);
    }

    /**
     * @param \Shared\Application\ValueObject\Email $email
     *
     * @return bool
     */
    public function checkEmailIsUnique(Email $email): bool
    {
        $result = $this->userDao->fetchByEmail($email);

        return count($result) === 0;
    }
}