<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 16.11.17
 * Time: 23:04
 */

namespace User\Application\Service;


use Shared\Application\ValueObject\Email;
use User\Application\Model\Identity;
use User\Application\Persistence\Repository\IdentityRepositoryInterface;

class IdentityCreatorService
{
    /**
     * @var \User\Application\Persistence\Repository\IdentityRepositoryInterface
     */
    private $identityRepository;

    /**
     * IdentityCreatorService constructor.
     *
     * @param \User\Application\Persistence\Repository\IdentityRepositoryInterface $identityRepository
     */
    public function __construct(IdentityRepositoryInterface $identityRepository)
    {
        $this->identityRepository = $identityRepository;
    }

    public function createIdentity(string $email, string $password): Identity
    {
        if (TRUE === $this->identityRepository->exists($email)) {
            throw new \RuntimeException('Email is taken.', 409);
        }

        $identity = new Identity(
            new Email($email)
        );


    }
}