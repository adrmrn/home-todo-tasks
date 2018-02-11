<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 11.02.18
 * Time: 15:07
 */

namespace Board\Application\Service;


use Board\Application\Event\EventName;
use Board\Application\Event\Publisher\EventPublisher;
use Board\Application\Persistence\Repository\BoardRepositoryInterface;
use Board\Application\Persistence\Repository\GroupRepositoryInterface;
use Board\Application\Persistence\Service\GroupBoardManagerPermissionServiceInterface;
use Board\Domain\Model\Board;
use Ramsey\Uuid\UuidInterface;

class BoardCreatorService
{
    /**
     * @var \Board\Application\Persistence\Repository\GroupRepositoryInterface
     */
    private $groupRepository;
    /**
     * @var \Board\Application\Persistence\Repository\BoardRepositoryInterface
     */
    private $boardRepository;
    /**
     * @var \Board\Application\Persistence\Service\GroupBoardManagerPermissionServiceInterface
     */
    private $boardManagerPermissionService;

    /**
     * BoardCreatorService constructor.
     *
     * @param \Board\Application\Persistence\Repository\GroupRepositoryInterface                 $groupRepository
     * @param \Board\Application\Persistence\Repository\BoardRepositoryInterface                 $boardRepository
     * @param \Board\Application\Persistence\Service\GroupBoardManagerPermissionServiceInterface $boardManagerPermissionService
     */
    public function __construct(GroupRepositoryInterface $groupRepository, BoardRepositoryInterface $boardRepository,
                                GroupBoardManagerPermissionServiceInterface $boardManagerPermissionService)
    {
        $this->groupRepository               = $groupRepository;
        $this->boardRepository               = $boardRepository;
        $this->boardManagerPermissionService = $boardManagerPermissionService;
    }

    public function createBoard(UuidInterface $groupId, string $name, UuidInterface $creatorId): void
    {
        $group = $this->groupRepository->fetchById($groupId);

        if (FALSE === $this->boardManagerPermissionService->canUserCreateNewBoardInGroup($creatorId, $group)) {
            throw new \RuntimeException('User can not add new Board to Group', 403);
        }

        $board = new Board($group, $name);
        $this->boardRepository->store($board);

        EventPublisher::publish(
            EventName::BOARD_CREATED,
            $board->id(),
            [
                'id'    => $board->id()->toString(),
                'name'  => $board->name(),
                'group' => [
                    'id'   => $board->group()->id()->toString(),
                    'name' => $board->group()->name(),
                ],
            ]
        );
    }
}