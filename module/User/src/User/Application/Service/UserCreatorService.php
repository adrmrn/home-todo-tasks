<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 16.11.17
 * Time: 21:34
 */

namespace User\Application\Service;


class UserCreatorService
{
    /**
     * @var \User\Application\Service\IdentityCreatorService
     */
    private $identityCreatorService;

    /**
     * UserCreatorService constructor.
     *
     * @param \User\Application\Service\IdentityCreatorService $identityCreatorService
     */
    public function __construct(IdentityCreatorService $identityCreatorService)
    {
        $this->identityCreatorService = $identityCreatorService;
    }

    public function createUser(string $name, string $email, string $password)
    {
        $identity = $this->identityCreatorService->createIdentity($email, $password);

        // create identity - identityService->createIdentity($email, $password)
        // create user
        // save user
    }
}