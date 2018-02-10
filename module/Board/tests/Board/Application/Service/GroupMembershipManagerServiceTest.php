<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 10.02.18
 * Time: 14:05
 */

namespace Board\Application\Service;

use Board\Application\Event\Publisher\EventPublisher;
use Board\Domain\Model\Group;
use Board\Domain\Model\Membership\Membership;
use Board\Domain\Model\Membership\Role;
use Board\Domain\Service\GroupMembershipManagerPermissionService;
use Board\Infrastructure\Repository\Mock\InMemoryGroupRepositoryMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Shared\Application\Event\Publisher\Adapter\Mock\InMemoryEventPublisherAdapterMock;
use Shared\Application\Persistence\DataSource\UserDataSourceInterface;

class GroupMembershipManagerServiceTest extends TestCase
{
    /**
     * @var InMemoryGroupRepositoryMock|\Board\Application\Persistence\Repository\GroupRepositoryInterface
     */
    private $groupRepository;
    /**
     * @var \Board\Application\Service\GroupMembershipManagerService
     */
    private $groupMembershipManagerService;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Shared\Application\Persistence\DataSource\UserDataSourceInterface
     */
    private $userDataSource;
    /**
     * @var InMemoryEventPublisherAdapterMock
     */
    private static $inMemoryEventPublisherAdapterMock;

    public static function setUpBeforeClass()
    {
        static::$inMemoryEventPublisherAdapterMock = new InMemoryEventPublisherAdapterMock();
        EventPublisher::initialize(static::$inMemoryEventPublisherAdapterMock);
    }

    public static function tearDownAfterClass()
    {
        EventPublisher::destroy();
    }

    public function setUp()
    {
        $this->groupRepository = new InMemoryGroupRepositoryMock();
        $this->userDataSource  = $this->getMockBuilder(UserDataSourceInterface::class)
                                      ->disableOriginalConstructor()
                                      ->getMock();

        $this->groupMembershipManagerService = new GroupMembershipManagerService(
            $this->groupRepository,
            new GroupMembershipManagerPermissionService(),
            $this->userDataSource
        );
    }

    public function testAddNewMembershipToGroup()
    {
        $adminId = Uuid::uuid4();
        $group   = new Group('Test name');
        $group->addMembership(new Membership($group, $adminId, Role::get(Role::ADMIN)));
        $this->groupRepository->store($group);

        $userId = Uuid::uuid4();
        $this->userDataSource->expects($this->once())->method('exists')->with($userId)->willReturn(TRUE);

        $this->groupMembershipManagerService->addMembershipToGroup($group->id(), $userId, Role::MEMBER, $adminId);

        $updatedGroup = $this->groupRepository->fetchById($group->id());

        $this->assertCount(2, $updatedGroup->memberships());
        $this->assertTrue($updatedGroup->hasMembership($userId));
        $this->assertSame(Role::get(Role::MEMBER), $updatedGroup->membership($userId)->role());

        $publishedEvent = static::$inMemoryEventPublisherAdapterMock->lastPublishedEvent();
        $this->assertSame('group_membership_added', $publishedEvent->name());
        $this->assertSame('board', $publishedEvent->domain());
        $this->assertInstanceOf(UuidInterface::class, $publishedEvent->entityId());
        $this->assertSame([
            'user_id' => $userId->toString(),
            'role'    => 'member',
        ], $publishedEvent->data()['memberships'][0]);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionCode    403
     * @expectedExceptionMessage User can not add new Membership to Group
     */
    public function testMemberCanNotAddNewMembershipToGroup()
    {
        $memberId = Uuid::uuid4();
        $group    = new Group('Test membership');
        $group->addMembership(new Membership($group, $memberId, Role::get(Role::MEMBER)));
        $this->groupRepository->store($group);

        $userId = Uuid::uuid4();
        $this->groupMembershipManagerService->addMembershipToGroup($group->id(), $userId, Role::MEMBER, $memberId);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionCode    404
     * @expectedExceptionMessage User does not found
     */
    public function testUserDoesNotExists()
    {
        $memberId = Uuid::uuid4();
        $group    = new Group('Test membership');
        $group->addMembership(new Membership($group, $memberId, Role::get(Role::ADMIN)));
        $this->groupRepository->store($group);

        $userId = Uuid::uuid4();
        $this->userDataSource->expects($this->once())->method('exists')->with($userId)->willReturn(FALSE);

        $this->groupMembershipManagerService->addMembershipToGroup($group->id(), $userId, Role::MEMBER, $memberId);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionCode    409
     * @expectedExceptionMessage Membership exists
     */
    public function testMembershipExists()
    {
        $memberId = Uuid::uuid4();
        $group    = new Group('Test membership');
        $group->addMembership(new Membership($group, $memberId, Role::get(Role::ADMIN)));
        $this->groupRepository->store($group);

        $userId = Uuid::uuid4();
        $this->userDataSource->expects($this->any())->method('exists')->with($userId)->willReturn(TRUE);

        $this->groupMembershipManagerService->addMembershipToGroup($group->id(), $userId, Role::MEMBER, $memberId);
        $this->groupMembershipManagerService->addMembershipToGroup($group->id(), $userId, Role::MEMBER, $memberId);
    }
}