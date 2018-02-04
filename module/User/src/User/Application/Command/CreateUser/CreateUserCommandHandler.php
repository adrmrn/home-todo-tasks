<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 09.11.17
 * Time: 18:29
 */

namespace User\Application\Command\CreateUser;


use Shared\Application\CommandQuery\Handler\CommandHandlerInterface;
use Shared\Application\CommandQuery\CommandQueryInterface;
use User\Application\Service\UserCreatorService;

class CreateUserCommandHandler implements CommandHandlerInterface
{
    /**
     * @var \User\Application\Service\UserCreatorService
     */
    private $userCreatorService;

    /**
     * CreateUserCommandHandler constructor.
     *
     * @param \User\Application\Service\UserCreatorService $userCreatorService
     */
    public function __construct(UserCreatorService $userCreatorService)
    {
        $this->userCreatorService = $userCreatorService;
    }

    /**
     * @param \Shared\Application\CommandQuery\CommandQueryInterface $commandQuery
     */
    public function handle(CommandQueryInterface $commandQuery): void
    {
        /** @var CreateUserCommand $commandQuery */
        $this->userCreatorService->createUser(
            $commandQuery->name(),
            $commandQuery->email(),
            $commandQuery->password()
        );
    }
}