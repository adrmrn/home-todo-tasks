<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 16.11.17
 * Time: 21:34
 */

namespace User\Application\Service;


use Shared\Application\ValueObject\Email;
use User\Application\Event\Publisher\EventPublisher;
use User\Application\Event\EventName;
use User\Application\Model\Credentials\Credentials;
use User\Application\Model\User;
use User\Application\Persistence\Repository\UserRepositoryInterface;
use Shared\Application\Utility\PasswordHasher;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;

class UserCreatorService implements EventManagerAwareInterface
{
    use EventManagerAwareTrait;

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

    public function createUser(string $name, string $email, string $password): void
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

        EventPublisher::publish(
            EventName::USER_CREATED,
            $user->id(),
            [
                'id'       => $user->id()->toString(),
                'name'     => $user->name(),
                'email'    => $user->credentials()->email()->toString(),
                'password' => $user->credentials()->hashedPassword()->toString(),
            ]
        );
    }
}