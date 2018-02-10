<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 09.02.18
 * Time: 17:42
 */

namespace Board\Domain\Service;

use Board\Domain\Model\Group;
use Board\Domain\Model\Membership\Membership;
use Board\Domain\Model\Membership\Role;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GroupMembershipManagerPermissionServiceTest extends TestCase
{
    /**
     * @var \Board\Application\Persistence\Service\GroupMembershipManagerPermissionServiceInterface
     */
    private $permissionService;

    public function setUp()
    {
        $this->permissionService = new GroupMembershipManagerPermissionService();
    }

    public function testPersonIsGroupAdminAndCanAddNewMember()
    {
        $group  = new Group('Test membership permission');
        $userId = Uuid::uuid4();
        $group->addMembership(new Membership($group, $userId, Role::get(Role::ADMIN)));

        $result = $this->permissionService->canUserAddNewMembershipToGroup($userId, $group);

        $this->assertTrue($result);
    }

    public function testPersonIsGroupMemberAndCanNotAddNewMember()
    {
        $group  = new Group('Test membership permission');
        $userId = Uuid::uuid4();
        $group->addMembership(new Membership($group, $userId, Role::get(Role::MEMBER)));

        $result = $this->permissionService->canUserAddNewMembershipToGroup($userId, $group);

        $this->assertFalse($result);
    }
}