<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 23.11.17
 * Time: 22:02
 */

namespace User\Application\Command\ChangeUserName;


use Shared\Application\CommandQuery\Handler\CommandHandlerInterface;
use Shared\Application\CommandQuery\CommandQueryInterface;
use User\Application\Service\UserEditorService;

class ChangeUserNameCommandHandler implements CommandHandlerInterface
{
    /**
     * @var \User\Application\Service\UserEditorService
     */
    private $userEditorService;

    /**
     * ChangeUserNameCommandHandler constructor.
     *
     * @param \User\Application\Service\UserEditorService $userEditorService
     */
    public function __construct(UserEditorService $userEditorService)
    {
        $this->userEditorService = $userEditorService;
    }

    /**
     * @param \Shared\Application\CommandQuery\CommandQueryInterface $commandQuery
     */
    public function handle(CommandQueryInterface $commandQuery): void
    {
        /** @var ChangeUserNameCommand $commandQuery */
        $this->userEditorService->changeUserName(
            $commandQuery->userId(),
            $commandQuery->name()
        );
    }
}