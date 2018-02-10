<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 30.12.17
 * Time: 19:32
 */

namespace Shared\Application\Event\Publisher;


use Ramsey\Uuid\UuidInterface;
use Shared\Application\Event\Publisher\Adapter\EventPublisherAdapterInterface;

interface EventPublisherAggregateInterface
{
    /**
     * @param \Shared\Application\Event\Publisher\Adapter\EventPublisherAdapterInterface[] ...$publishers
     *
     * @return void
     */
    public static function initialize(EventPublisherAdapterInterface ...$publishers): void;

    /**
     * @param string                     $eventName
     * @param \Ramsey\Uuid\UuidInterface $entityId
     * @param array                      $data
     *
     * @return void
     */
    public static function publish(string $eventName, UuidInterface $entityId, array $data = []): void;

    /**
     * @return void
     */
    public static function destroy(): void;
}