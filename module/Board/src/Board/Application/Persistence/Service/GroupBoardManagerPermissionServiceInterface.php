<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 11.02.18
 * Time: 15:13
 */

namespace Board\Application\Persistence\Service;


use Board\Domain\Model\Group;
use Ramsey\Uuid\UuidInterface;

interface GroupBoardManagerPermissionServiceInterface
{
    /**
     * @param \Ramsey\Uuid\UuidInterface $userId
     * @param \Board\Domain\Model\Group  $group
     *
     * @return bool
     */
    public function canUserCreateNewBoardInGroup(UuidInterface $userId, Group $group): bool;
}