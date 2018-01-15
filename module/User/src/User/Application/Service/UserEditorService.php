<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 23.11.17
 * Time: 22:11
 */

namespace User\Application\Service;


use Ramsey\Uuid\UuidInterface;
use User\Application\Event\Publisher\EventPublisher;
use User\Application\Event\EventName;
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
     * @param \Ramsey\Uuid\UuidInterface $userId
     * @param string                     $newName
     */
    public function changeUserName(UuidInterface $userId, string $newName)
    {
        $user = $this->userRepository->fetchById($userId);

        $user->rename($newName);

        $this->userRepository->store($user);

        EventPublisher::publish(
            EventName::USER_RENAMED,
            $user->id(),
            [
                'id'   => $user->id()->toString(),
                'name' => $user->name(),
            ]
        );
    }
}