<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 09.11.17
 * Time: 18:29
 */

namespace User\Application\Command\CreateUser;


use User\Application\Service\UserCreatorService;

class CreateUserCommandHandler
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

    public function handle(CreateUserCommand $createUserCommand)
    {
        $this->userCreatorService->createUser(
            $createUserCommand->name(),
            $createUserCommand->email(),
            $createUserCommand->password()
        );
    }
}