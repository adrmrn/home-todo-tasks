<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 11.02.18
 * Time: 15:38
 */

namespace Board\Application\Command\CreateBoard;


use Board\Application\Service\BoardCreatorService;
use Shared\Application\CommandQuery\CommandQueryInterface;
use Shared\Application\CommandQuery\Handler\CommandHandlerInterface;

class CreateBoardCommandHandler implements CommandHandlerInterface
{
    /**
     * @var \Board\Application\Service\BoardCreatorService
     */
    private $boardCreatorService;

    /**
     * CreateBoardCommandHandler constructor.
     *
     * @param \Board\Application\Service\BoardCreatorService $boardCreatorService
     */
    public function __construct(BoardCreatorService $boardCreatorService)
    {
        $this->boardCreatorService = $boardCreatorService;
    }

    /**
     * @param \Shared\Application\CommandQuery\CommandQueryInterface $commandQuery
     */
    public function handle(CommandQueryInterface $commandQuery): void
    {
        /** @var CreateBoardCommand $commandQuery */
        $this->boardCreatorService->createBoard(
            $commandQuery->groupId(),
            $commandQuery->name(),
            $commandQuery->creatorId()
        );
    }
}