<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 19.11.17
 * Time: 13:57
 */

namespace User\Infrastructure\Repository;


use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Shared\Application\ValueObject\Email;
use User\Application\Model\Credentials\Credentials;
use User\Application\Model\Credentials\HashedPassword;
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
     * @param \Ramsey\Uuid\UuidInterface $id
     *
     * @return \User\Application\Model\User
     */
    public function fetchById(UuidInterface $id): User
    {
        $result = $this->userDao->fetchById($id);

        if (count($result) === 0) {
            throw new \RuntimeException('User not found.', 404);
        }

        return $this->processRawData($result)[0];
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

    /**
     * @param array $rawData
     *
     * @return User[]
     */
    private function processRawData(array $rawData): array
    {
        $users = [];

        foreach ($rawData as $userRawData) {
            $users[] = new User(
                $userRawData['name'],
                new Credentials(
                    new Email($userRawData['email']),
                    new HashedPassword($userRawData['password_hash'])
                ),
                Uuid::fromString($userRawData['id'])
            );
        }

        return $users;
    }
}