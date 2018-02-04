<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 21.01.18
 * Time: 14:55
 */

namespace Shared\Application\EventManager;


use Shared\Application\Event\Event;
use Shared\Application\Event\Subscriber\EventSubscriber;
use Shared\Application\Persistence\Repository\EventStoreRepositoryInterface;

class EventStoreEventSubscriber implements EventSubscriber
{
    /**
     * @var \Shared\Application\Persistence\Repository\EventStoreRepositoryInterface
     */
    private $eventStoreRepository;

    /**
     * EventStoreEventSubscriber constructor.
     *
     * @param \Shared\Application\Persistence\Repository\EventStoreRepositoryInterface $eventStoreRepository
     */
    public function __construct(EventStoreRepositoryInterface $eventStoreRepository)
    {
        $this->eventStoreRepository = $eventStoreRepository;
    }

    public function handle(Event $event): void
    {
        $this->eventStoreRepository->store($event);
    }

    public function isSubscribedTo(Event $event): bool
    {
        return TRUE;
    }
}