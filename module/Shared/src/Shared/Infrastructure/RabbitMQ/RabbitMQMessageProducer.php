<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 11.01.18
 * Time: 21:09
 */

namespace Shared\Infrastructure\RabbitMQ;


use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Shared\Application\Event\Event;
use Shared\Application\Persistence\RabbitMQ\RabbitMQMessageProducerInterface;

class RabbitMQMessageProducer extends AbstractRabbitMQMessaging implements RabbitMQMessageProducerInterface
{
    /**
     * AbstractRabbitMQPublisher constructor.
     *
     * @param \PhpAmqpLib\Connection\AMQPStreamConnection $connection
     */
    public function __construct(AMQPStreamConnection $connection)
    {
        parent::__construct($connection);

        // Exchange
        $this->channel()->exchange_declare('events', 'fanout', FALSE, TRUE, FALSE);
    }

    public function send(Event $event): void
    {
        $channel = $this->channel();

        $msg = new AMQPMessage(
            json_encode([
                'domain' => $event->domain(),
                'data'   => $event->jsonSerialize(),
            ])
        );

        $channel->basic_publish($msg, 'events');

        $this->close();
    }
}