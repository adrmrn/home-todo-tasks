<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 31.12.17
 * Time: 12:03
 */

namespace User\Application\Event\Publisher\Adapter;


use Shared\Application\Event\Event;
use Shared\Application\Event\Publisher\Adapter\EventPublisherAdapterInterface;
use Shared\Infrastructure\RabbitMQ\RabbitMQMessageProducer;

class RabbitMQEventPublisherAdapter implements EventPublisherAdapterInterface
{
    /**
     * @var \Shared\Infrastructure\RabbitMQ\RabbitMQMessageProducer
     */
    private $messageProducer;

    /**
     * RabbitMQEventPublisherAdapter constructor.
     *
     * @param \Shared\Infrastructure\RabbitMQ\RabbitMQMessageProducer $messageProducer
     */
    public function __construct(RabbitMQMessageProducer $messageProducer)
    {
        $this->messageProducer = $messageProducer;
    }

    /**
     * @param \Shared\Application\Event\Event $event
     *
     * @return void
     */
    public function publish(Event $event)
    {
        $this->messageProducer->send($event);
    }
}