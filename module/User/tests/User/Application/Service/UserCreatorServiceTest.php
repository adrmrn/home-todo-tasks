<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 15.02.18
 * Time: 22:15
 */

namespace User\Application\Service;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;
use Shared\Application\Event\Publisher\Adapter\Mock\InMemoryEventPublisherAdapterMock;
use User\Application\Event\Publisher\EventPublisher;
use User\Infrastructure\Repository\Mock\InMemoryUserRepositoryMock;

class UserCreatorServiceTest extends TestCase
{
    /**
     * @var \User\Application\Persistence\Repository\UserRepositoryInterface|InMemoryUserRepositoryMock
     */
    private $userRepository;
    /**
     * @var \User\Application\Service\UserCreatorService
     */
    private $userCreatorService;
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
        $this->userRepository     = new InMemoryUserRepositoryMock();
        $this->userCreatorService = new UserCreatorService($this->userRepository);
    }

    public static function tearDownAfterClass()
    {
        EventPublisher::destroy();
    }

    public function testCreateNewUser()
    {
        $this->userCreatorService->createUser('John Doe', 'johndoe@o2.pl', 'pass123');
        $publishedEvent = static::$inMemoryEventPublisherAdapterMock->lastPublishedEvent();

        $this->assertSame('user_created', $publishedEvent->name());
        $this->assertSame('user', $publishedEvent->domain());
        $this->assertInstanceOf(UuidInterface::class, $publishedEvent->entityId());
        $this->assertSame('John Doe', $publishedEvent->data()['name']);
        $this->assertSame('johndoe@o2.pl', $publishedEvent->data()['email']);
        $this->assertSame(60, strlen($publishedEvent->data()['password']));
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionCode    409
     * @expectedExceptionMessage Email taken
     */
    public function testUserEmailTaken()
    {
        $this->userCreatorService->createUser('John Doe', 'emailtaken@o2.pl', 'pass123');
        $this->userCreatorService->createUser('John Doe', 'emailtaken@o2.pl', 'pass123');
    }
}
