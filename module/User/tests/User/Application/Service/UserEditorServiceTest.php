<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 15.02.18
 * Time: 22:57
 */

namespace User\Application\Service;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;
use Shared\Application\Event\Publisher\Adapter\Mock\InMemoryEventPublisherAdapterMock;
use Shared\Application\Utility\PasswordHasher;
use Shared\Application\ValueObject\Email;
use Shared\Application\ValueObject\HashedPassword;
use User\Application\Event\Publisher\EventPublisher;
use User\Application\Model\Credentials\Credentials;
use User\Application\Model\User;
use User\Infrastructure\Repository\Mock\InMemoryUserRepositoryMock;

class UserEditorServiceTest extends TestCase
{
    /**
     * @var \User\Application\Persistence\Repository\UserRepositoryInterface|InMemoryUserRepositoryMock
     */
    private $userRepository;
    /**
     * @var \User\Application\Service\UserEditorService
     */
    private $userEditorService;
    /**
     * @var User
     */
    private $user;
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
        $this->userRepository    = new InMemoryUserRepositoryMock();
        $this->userEditorService = new UserEditorService($this->userRepository);

        $this->user = new User(
            'John Doe',
            new Credentials(
                new Email('johndoe@o2.pl'),
                PasswordHasher::hash('pass123')
            )
        );
        $this->userRepository->store($this->user);
    }

    public static function tearDownAfterClass()
    {
        EventPublisher::destroy();
    }

    public function testChangeUserName()
    {
        $this->userEditorService->changeUserName($this->user->id(), 'Jane Doe');
        $publishedEvent = static::$inMemoryEventPublisherAdapterMock->lastPublishedEvent();

        $this->assertSame('user_renamed', $publishedEvent->name());
        $this->assertSame('user', $publishedEvent->domain());
        $this->assertSame($this->user->id(), $publishedEvent->entityId());
        $this->assertSame('Jane Doe', $publishedEvent->data()['name']);
    }
}
