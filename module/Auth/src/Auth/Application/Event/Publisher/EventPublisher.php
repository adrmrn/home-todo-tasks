<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 25.01.18
 * Time: 22:12
 */

namespace Auth\Application\Event\Publisher;


use Ramsey\Uuid\UuidInterface;
use Shared\Application\Event\Event;
use Shared\Application\Event\Publisher\Adapter\EventPublisherAdapterInterface;
use Shared\Application\Event\Publisher\EventPublisherAggregateInterface;

class EventPublisher implements EventPublisherAggregateInterface
{
    const DOMAIN_NAME = 'auth';

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

    /**
     * @return \Auth\Application\Event\Publisher\EventPublisher
     */
    private static function instance(): EventPublisher
    {
        if (NULL === static::$instance) {
            throw new \BadMethodCallException('EventPublisher is not initialized');
        }

        return static::$instance;
    }

    /**
     * @param string                     $eventName
     * @param \Ramsey\Uuid\UuidInterface $entityId
     * @param array                      $data
     */
    public static function publish(string $eventName, UuidInterface $entityId, array $data = [])
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

    /**
     * @param \Shared\Application\Event\Publisher\Adapter\EventPublisherAdapterInterface[] ...$publishers
     */
    public static function initialize(EventPublisherAdapterInterface ...$publishers)
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