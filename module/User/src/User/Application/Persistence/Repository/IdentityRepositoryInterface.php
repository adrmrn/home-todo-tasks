<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 19.11.17
 * Time: 14:05
 */

namespace User\Application\Persistence\Repository;


interface IdentityRepositoryInterface
{
    public function exists(string $email): bool;
}