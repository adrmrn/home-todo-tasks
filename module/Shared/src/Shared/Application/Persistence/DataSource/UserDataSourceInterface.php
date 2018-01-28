<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 14.01.18
 * Time: 22:21
 */

namespace Shared\Application\Persistence\DataSource;


use Ramsey\Uuid\UuidInterface;
use Shared\Application\Persistence\Model\UserViewInterface;

interface UserDataSourceInterface
{
    /**
     * @param \Ramsey\Uuid\UuidInterface $userId
     *
     * @return \Shared\Application\Persistence\Model\UserViewInterface
     */
    public function fetchById(UuidInterface $userId): UserViewInterface;
}