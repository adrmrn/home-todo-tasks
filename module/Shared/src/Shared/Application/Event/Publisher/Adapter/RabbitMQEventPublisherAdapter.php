<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 31.12.17
 * Time: 12:03
 */

namespace Shared\Application\Event\Publisher\Adapter;


use Shared\Application\Event\Event;
use Shared\Application\Persistence\RabbitMQ\RabbitMQMessageProducerInterface;

class RabbitMQEventPublisherAdapter implements EventPublisherAdapterInterface
{
    /**
     * @var \Shared\Infrastructure\RabbitMQ\RabbitMQMessageProducer
     */
    private $messageProducer;

    /**
     * RabbitMQEventPublisherAdapter constructor.
     *
     * @param \Shared\Application\Persistence\RabbitMQ\RabbitMQMessageProducerInterface $messageProducer
     */
    public function __construct(RabbitMQMessageProducerInterface $messageProducer)
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