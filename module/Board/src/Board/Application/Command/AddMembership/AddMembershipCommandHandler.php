<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 07.02.18
 * Time: 21:01
 */

namespace Board\Application\Command\AddMembership;


use Board\Application\Service\GroupMembershipManagerService;
use Shared\Application\CommandQuery\CommandQueryInterface;
use Shared\Application\CommandQuery\Handler\CommandHandlerInterface;

class AddMembershipCommandHandler implements CommandHandlerInterface
{
    /**
     * @var \Board\Application\Service\GroupMembershipManagerService
     */
    private $groupMembershipManagerService;

    /**
     * AddMemberCommandHandler constructor.
     *
     * @param \Board\Application\Service\GroupMembershipManagerService $groupMembershipManagerService
     */
    public function __construct(GroupMembershipManagerService $groupMembershipManagerService)
    {
        $this->groupMembershipManagerService = $groupMembershipManagerService;
    }

    public function handle(CommandQueryInterface $commandQuery): void
    {
        /** @var AddMembershipCommand $commandQuery */
        $this->groupMembershipManagerService->addMembershipToGroup(
            $commandQuery->groupId(),
            $commandQuery->userId(),
            $commandQuery->role(),
            $commandQuery->creatorId()
        );
    }
}