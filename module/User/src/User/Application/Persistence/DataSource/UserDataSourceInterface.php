<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 14.01.18
 * Time: 22:21
 */

namespace User\Application\Persistence\DataSource;


use Ramsey\Uuid\UuidInterface;
use User\Application\Model\UserView;

interface UserDataSourceInterface
{
    /**
     * @param \Ramsey\Uuid\UuidInterface $userId
     *
     * @return \User\Application\Model\UserView
     */
    public function fetchById(UuidInterface $userId): UserView;
}