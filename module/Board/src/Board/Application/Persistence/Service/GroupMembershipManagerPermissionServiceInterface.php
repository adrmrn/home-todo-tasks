<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 08.02.18
 * Time: 22:22
 */

namespace Board\Application\Persistence\Service;


use Board\Domain\Model\Group;
use Ramsey\Uuid\UuidInterface;

interface GroupMembershipManagerPermissionServiceInterface
{
    public function canUserAddNewMembershipToGroup(UuidInterface $userId, Group $group): bool;
}