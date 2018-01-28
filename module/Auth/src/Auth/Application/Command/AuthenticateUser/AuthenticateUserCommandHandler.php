<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 24.01.18
 * Time: 21:36
 */

namespace Auth\Application\Command\AuthenticateUser;


use Auth\Application\Service\UserAuthenticationService;
use Shared\Application\CommandQuery\CommandQueryHandler;
use Shared\Application\CommandQuery\CommandQueryInterface;

class AuthenticateUserCommandHandler implements CommandQueryHandler
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
     *
     * @return void
     */
    public function handle(CommandQueryInterface $commandQuery)
    {
        /** @var AuthenticateUserCommand $commandQuery */
        $this->userAuthenticationService->authenticate(
            $commandQuery->email(),
            $commandQuery->password()
        );
    }
}