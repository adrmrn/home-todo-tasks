<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 11.02.18
 * Time: 15:12
 */

namespace Board\Domain\Service;


use Board\Application\Persistence\Service\GroupBoardManagerPermissionServiceInterface;
use Board\Domain\Model\Group;
use Board\Domain\Model\Membership\Role;
use Ramsey\Uuid\UuidInterface;

class GroupBoardManagerPermissionService implements GroupBoardManagerPermissionServiceInterface
{
    public function canUserCreateNewBoardInGroup(UuidInterface $userId, Group $group): bool
    {
        if (FALSE === $group->hasMembership($userId)) {
            return FALSE;
        }

        return $group->membership($userId)->role()->is(Role::ADMIN);
    }
}