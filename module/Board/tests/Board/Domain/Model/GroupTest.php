<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 07.02.18
 * Time: 18:37
 */

namespace Board\Domain\Model;

use Board\Domain\Model\Membership\Membership;
use Board\Domain\Model\Membership\Role;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class GroupTest extends TestCase
{
    public function testCreateNewGroup()
    {
        $group = new Group('Lorem ipsum');

        $this->assertInstanceOf(UuidInterface::class, $group->id());
        $this->assertSame('Lorem ipsum', $group->name());
        $this->assertSame([], $group->memberships());
    }

    public function testManageGroupMemberships()
    {
        $group = new Group('Lorem ipsum memberships');

        $userId     = Uuid::uuid4();
        $membership = new Membership($group, $userId, Role::get(Role::ADMIN));
        $group->addMembership($membership);

        $this->assertCount(1, $group->memberships());
        $this->assertSame($membership, $group->memberships()[0]);
        $this->assertSame($membership, $group->membership($userId));
        $this->assertTrue($group->hasMembership($userId));

        $group->removeMembership($userId);

        $this->assertCount(0, $group->memberships());
        $this->assertFalse($group->hasMembership($userId));
    }

    public function testRemoveExpectedMembership()
    {
        $group = new Group('XOXOXO');

        for ($i = 0; $i < 5; $i++) {
            $membership = new Membership($group, Uuid::uuid4(), Role::get(Role::MEMBER));
            $group->addMembership($membership);
        }

        $this->assertCount(5, $group->memberships());

        $membership = $group->memberships()[2];
        $group->removeMembership($membership->id());

        $this->assertCount(4, $group->memberships());
        $this->assertFalse($group->hasMembership($membership->id()));
    }

    /**
     * @expectedException \DomainException
     * @expectedExceptionCode 404
     */
    public function testMembershipDoesNotExist()
    {
        $group = new Group('Empty group');
        $group->membership(Uuid::uuid4());
    }

    /**
     * @expectedException \DomainException
     * @expectedExceptionCode 404
     */
    public function testMembershipDoesNotExistWhileRemoving()
    {
        $group = new Group('Empty group');
        $group->removeMembership(Uuid::uuid4());
    }
}