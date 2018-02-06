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
     * @var \Board\Application\Persistence\GroupRepositoryInterface|InMemoryGroupRepositoryMock
     */
    private $groupRepository;
    /**
     * @var \Board\Application\Service\GroupCreatorService
     */
    private $groupCreatorService;
    /**
     * @var \Shared\Application\Event\Publisher\Adapter\EventPublisherAdapterInterface|InMemoryEventPublisherAdapterMock
     */
    private $inMemoryEventPublisherAdapterMock;

    public function setUp()
    {
        $this->inMemoryEventPublisherAdapterMock = new InMemoryEventPublisherAdapterMock();
        EventPublisher::initialize($this->inMemoryEventPublisherAdapterMock);

        $this->groupRepository     = new InMemoryGroupRepositoryMock();
        $this->groupCreatorService = new GroupCreatorService($this->groupRepository);
    }

    public function testCreateNewGroup()
    {
        $creatorId = Uuid::uuid4();
        $this->groupCreatorService->createGroup('Test Group Name', $creatorId);
        $publishedEvent = $this->inMemoryEventPublisherAdapterMock->lastPublishedEvent();

        $this->assertSame('group_created', $publishedEvent->name());
        $this->assertSame('board', $publishedEvent->domain());
        $this->assertInstanceOf(UuidInterface::class, $publishedEvent->entityId());
        $this->assertSame([
            'user_id' => $creatorId->toString(),
            'role'    => 'admin',
        ], $publishedEvent->data()['memberships'][0]);
    }
}
