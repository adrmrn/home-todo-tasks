<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 31.12.17
 * Time: 17:27
 */

namespace Shared\Infrastructure\RabbitMQ;


use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Shared\Application\Persistence\RabbitMQ\RabbitMQMessagingInterface;

abstract class AbstractRabbitMQMessaging implements RabbitMQMessagingInterface
{
    /**
     * @var \PhpAmqpLib\Connection\AMQPStreamConnection
     */
    private $connection;
    /**
     * @var \PhpAmqpLib\Channel\AMQPChannel
     */
    private $channel;

    /**
     * AbstractRabbitMqMessaging constructor.
     *
     * @param \PhpAmqpLib\Connection\AMQPStreamConnection $connection
     */
    public function __construct(AMQPStreamConnection $connection)
    {
        $this->connection = $connection;
        $this->channel    = $this->connection->channel();
    }

    public function channel(): AMQPChannel
    {
        return $this->channel;
    }

    public function close(): void
    {
        $this->channel()->close();
        $this->connection->close();
    }
}