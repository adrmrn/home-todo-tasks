<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 15.02.18
 * Time: 21:43
 */

namespace Board\Application\Service;

use Board\Application\Event\Publisher\EventPublisher;
use Board\Application\Persistence\Service\GroupBoardManagerPermissionServiceInterface;
use Board\Domain\Model\Group;
use Board\Domain\Model\Membership\Membership;
use Board\Domain\Model\Membership\Role;
use Board\Infrastructure\Repository\Mock\InMemoryBoardRepositoryMock;
use Board\Infrastructure\Repository\Mock\InMemoryGroupRepositoryMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Shared\Application\Event\Publisher\Adapter\Mock\InMemoryEventPublisherAdapterMock;

class BoardCreatorServiceTest extends TestCase
{
    /**
     * @var \Board\Application\Persistence\Repository\BoardRepositoryInterface|InMemoryBoardRepositoryMock
     */
    private $boardRepository;
    /**
     * @var \Board\Application\Service\BoardCreatorService
     */
    private $boardCreatorService;
    /**
     * @var \Board\Application\Persistence\Repository\GroupRepositoryInterface|InMemoryGroupRepositoryMock
     */
    private $groupRepository;
    /**
     * @var \Board\Application\Persistence\Service\GroupBoardManagerPermissionServiceInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $boardManagerPermissionService;
    /**
     * @var \Shared\Application\Event\Publisher\Adapter\EventPublisherAdapterInterface|InMemoryEventPublisherAdapterMock
     */
    private static $inMemoryEventPublisherAdapterMock;

    public static function setUpBeforeClass()
    {
        static::$inMemoryEventPublisherAdapterMock = new InMemoryEventPublisherAdapterMock();
        EventPublisher::initialize(static::$inMemoryEventPublisherAdapterMock);
    }

    public function setUp()
    {
        $this->boardRepository               = new InMemoryBoardRepositoryMock();
        $this->groupRepository               = new InMemoryGroupRepositoryMock();
        $this->boardManagerPermissionService = $this->getMockBuilder(GroupBoardManagerPermissionServiceInterface::class)
                                                    ->disableOriginalConstructor()
                                                    ->getMock();

        $this->boardCreatorService = new BoardCreatorService(
            $this->groupRepository,
            $this->boardRepository,
            $this->boardManagerPermissionService
        );
    }

    public static function tearDownAfterClass()
    {
        EventPublisher::destroy();
    }

    public function testCreateNewBoard()
    {
        $group  = new Group('Group test');
        $userId = Uuid::uuid4();
        $this->groupRepository->store($group);
        $this->boardManagerPermissionService->expects($this->once())
                                            ->method('canUserCreateNewBoardInGroup')
                                            ->willReturn(TRUE);

        $this->boardCreatorService->createBoard($group->id(), 'Board name', $userId);
        $publishedEvent = static::$inMemoryEventPublisherAdapterMock->lastPublishedEvent();

        $this->assertSame('board_created', $publishedEvent->name());
        $this->assertSame('board', $publishedEvent->domain());
        $this->assertInstanceOf(UuidInterface::class, $publishedEvent->entityId());
        $this->assertSame('Board name', $publishedEvent->data()['name']);
        $this->assertSame('Group test', $publishedEvent->data()['group']['name']);
        $this->assertSame($group->id()->toString(), $publishedEvent->data()['group']['id']);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionCode    403
     * @expectedExceptionMessage User can not add new Board to Group
     */
    public function testUserCanNotCreateNewBoard()
    {
        $group  = new Group('Group test');
        $userId = Uuid::uuid4();
        $this->groupRepository->store($group);
        $this->boardManagerPermissionService->expects($this->once())
                                            ->method('canUserCreateNewBoardInGroup')
                                            ->willReturn(FALSE);

        $this->boardCreatorService->createBoard($group->id(), 'Board name', $userId);
    }
}