<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 03.02.18
 * Time: 11:40
 */

namespace Shared\Application\Persistence\DataSource;


use Ramsey\Uuid\UuidInterface;
use Shared\Application\Persistence\Model\GroupViewInterface;

interface GroupDataSourceInterface
{
    /**
     * @param \Ramsey\Uuid\UuidInterface $groupId
     *
     * @return \Shared\Application\Persistence\Model\GroupViewInterface
     */
    public function fetchById(UuidInterface $groupId): GroupViewInterface;
}