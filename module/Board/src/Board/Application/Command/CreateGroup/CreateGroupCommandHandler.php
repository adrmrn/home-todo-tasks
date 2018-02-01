<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 29.01.18
 * Time: 19:36
 */

namespace Board\Application\Command\CreateGroup;


use Board\Application\Service\GroupCreatorService;
use Shared\Application\CommandQuery\CommandQueryHandler;
use Shared\Application\CommandQuery\CommandQueryInterface;

class CreateGroupCommandHandler implements CommandQueryHandler
{
    /**
     * @var \Board\Application\Service\GroupCreatorService
     */
    private $groupCreatorService;

    /**
     * CreateGroupCommandHandler constructor.
     *
     * @param \Board\Application\Service\GroupCreatorService $groupCreatorService
     */
    public function __construct(GroupCreatorService $groupCreatorService)
    {
        $this->groupCreatorService = $groupCreatorService;
    }

    /**
     * @param \Shared\Application\CommandQuery\CommandQueryInterface $commandQuery
     *
     * @return mixed
     */
    public function handle(CommandQueryInterface $commandQuery)
    {
        /** @var CreateGroupCommand $commandQuery */
        $this->groupCreatorService->createGroup(
            $commandQuery->name(),
            $commandQuery->creatorId()
        );
    }
}