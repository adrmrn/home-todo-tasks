<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 06.02.18
 * Time: 20:46
 */

namespace Board\Application\Service;

use Board\Application\Event\Publisher\EventPublisher;
use Board\Infrastructure\Repository\Mock\InMemoryGroupRepositoryMock;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Shared\Application\Event\Publisher\Adapter\Mock\InMemoryEventPublisherAdapterMock;

class GroupCreatorServiceTest extends TestCase
{
    /**
     * @var \Board\Application\Persistence\Repository\GroupRepositoryInterface|InMemoryGroupRepositoryMock
     */
    private $groupRepository;
    /**
     * @var \Board\Application\Service\GroupCreatorService
     */
    private $groupCreatorService;
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
        $this->groupRepository     = new InMemoryGroupRepositoryMock();
        $this->groupCreatorService = new GroupCreatorService($this->groupRepository);
    }

    public static function tearDownAfterClass()
    {
        EventPublisher::destroy();
    }

    public function testCreateNewGroup()
    {
        $creatorId = Uuid::uuid4();
        $this->groupCreatorService->createGroup('Test Group Name', $creatorId);
        $publishedEvent = static::$inMemoryEventPublisherAdapterMock->lastPublishedEvent();

        $this->assertSame('group_created', $publishedEvent->name());
        $this->assertSame('board', $publishedEvent->domain());
        $this->assertInstanceOf(UuidInterface::class, $publishedEvent->entityId());
        $this->assertSame('Test Group Name', $publishedEvent->data()['name']);
        $this->assertSame([
            'user_id' => $creatorId->toString(),
            'role'    => 'admin',
        ], $publishedEvent->data()['memberships'][0]);
    }
}
