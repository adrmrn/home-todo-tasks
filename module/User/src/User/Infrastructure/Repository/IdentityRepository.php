<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 19.11.17
 * Time: 14:04
 */

namespace User\Infrastructure\Repository;


use User\Application\Persistence\Repository\IdentityRepositoryInterface;

class IdentityRepository implements IdentityRepositoryInterface
{
    public function exists(string $email): bool
    {
        // TODO: Implement exists() method.
    }
}