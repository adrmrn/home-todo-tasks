<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 24.01.18
 * Time: 21:36
 */

namespace Auth\Application\Command\AuthenticateUser;


use Auth\Application\Service\UserAuthenticationService;
use Shared\Application\CommandQuery\Handler\CommandHandlerInterface;
use Shared\Application\CommandQuery\CommandQueryInterface;

class AuthenticateUserCommandHandler implements CommandHandlerInterface
{
    /**
     * @var \Auth\Application\Service\UserAuthenticationService
     */
    private $userAuthenticationService;

    /**
     * AuthenticateUserCommandHandler constructor.
     *
     * @param \Auth\Application\Service\UserAuthenticationService $userAuthenticationService
     */
    public function __construct(UserAuthenticationService $userAuthenticationService)
    {
        $this->userAuthenticationService = $userAuthenticationService;
    }

    /**
     * @param \Shared\Application\CommandQuery\CommandQueryInterface $commandQuery
     */
    public function handle(CommandQueryInterface $commandQuery): void
    {
        /** @var AuthenticateUserCommand $commandQuery */
        $this->userAuthenticationService->authenticate(
            $commandQuery->email(),
            $commandQuery->password()
        );
    }
}