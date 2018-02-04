<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 01.02.18
 * Time: 23:18
 */

namespace Board\Application\Event\Publisher;


use Ramsey\Uuid\UuidInterface;
use Shared\Application\Event\Event;
use Shared\Application\Event\Publisher\Adapter\EventPublisherAdapterInterface;
use Shared\Application\Event\Publisher\EventPublisherAggregateInterface;

class EventPublisher implements EventPublisherAggregateInterface
{
    const DOMAIN_NAME = 'board';

    private static $instance = null;
    /**
     * @var \Shared\Application\Event\Publisher\Adapter\EventPublisherAdapterInterface[]
     */
    private $publishers = [];

    /**
     * EventPublisher constructor.
     *
     * @param \Shared\Application\Event\Publisher\Adapter\EventPublisherAdapterInterface[] ...$publishers
     */
    private function __construct(EventPublisherAdapterInterface ...$publishers) {
        $this->publishers = $publishers;
    }

    private static function instance(): EventPublisher
    {
        if (NULL === static::$instance) {
            throw new \BadMethodCallException('EventPublisher is not initialized');
        }

        return static::$instance;
    }

    public static function publish(string $eventName, UuidInterface $entityId, array $data = []): void
    {
        $event = new Event(
            static::DOMAIN_NAME,
            $eventName,
            $entityId,
            $data
        );

        foreach (static::instance()->publishers as $publisher) {
            $publisher->publish($event);
        }
    }

    public static function initialize(EventPublisherAdapterInterface ...$publishers): void
    {
        if (NULL !== static::$instance) {
            throw new \LogicException('EventPublisher can be initialized once');
        }

        static::$instance = new static(...$publishers);
    }

    public function __clone()
    {
        throw new \BadMethodCallException('Clone is not supported');
    }
}