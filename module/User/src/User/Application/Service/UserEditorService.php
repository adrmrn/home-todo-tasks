<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 23.11.17
 * Time: 22:11
 */

namespace User\Application\Service;


use Ramsey\Uuid\Uuid;
use User\Application\Event\Publisher\EventPublisher;
use User\Application\EventManager\EventName;
use User\Application\Persistence\Repository\UserRepositoryInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;

class UserEditorService implements EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    /**
     * @var \User\Application\Persistence\Repository\UserRepositoryInterface
     */
    private $userRepository;

    /**
     * UserEditorService constructor.
     *
     * @param \User\Application\Persistence\Repository\UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $userId
     * @param string $newName
     *
     * @return void
     */
    public function changeUserName(string $userId, string $newName)
    {
        $user = $this->userRepository->fetchById(Uuid::fromString($userId));

        $user->rename($newName);

        $this->userRepository->store($user);

        EventPublisher::publish(
            EventName::USER_UPDATED,
            $user->id(),
            [
                'user' => $user,
            ]
        );
    }
}