<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 08.02.18
 * Time: 22:20
 */

namespace Board\Domain\Service;


use Board\Application\Persistence\Service\GroupMembershipManagerPermissionServiceInterface;
use Board\Domain\Model\Group;
use Board\Domain\Model\Membership\Role;
use Ramsey\Uuid\UuidInterface;

class GroupMembershipManagerPermissionService implements GroupMembershipManagerPermissionServiceInterface
{
    public function canUserAddNewMembershipToGroup(UuidInterface $userId, Group $group): bool
    {
        if (FALSE === $group->hasMembership($userId)) {
            return FALSE;
        }

        $membership = $group->membership($userId);
        return TRUE === $membership->role()->is(Role::ADMIN);
    }
}