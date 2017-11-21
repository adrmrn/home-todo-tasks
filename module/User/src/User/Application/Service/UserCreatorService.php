<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 16.11.17
 * Time: 21:34
 */

namespace User\Application\Service;


use Shared\Application\ValueObject\Email;
use User\Application\Model\Credentials\Credentials;
use User\Application\Model\User;
use User\Application\Persistence\Repository\UserRepositoryInterface;
use User\Application\Utility\PasswordHasher;

class UserCreatorService
{
    /**
     * @var \User\Application\Persistence\Repository\UserRepositoryInterface
     */
    private $userRepository;

    /**
     * UserCreatorService constructor.
     *
     * @param \User\Application\Persistence\Repository\UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     */
    public function createUser(string $name, string $email, string $password)
    {
        $email = new Email($email);

        if (FALSE === $this->userRepository->checkEmailIsUnique($email)) {
            throw new \RuntimeException('Email taken', 409);
        }

        $hashedPassword = PasswordHasher::hash($password);

        $user = new User(
            $name,
            new Credentials(
                $email,
                $hashedPassword
            )
        );

        $this->userRepository->store($user);

        // TODO: send event
    }
}