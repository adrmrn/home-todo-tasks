<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 11.01.18
 * Time: 21:58
 */

namespace Shared\Infrastructure\RabbitMQ;


use PhpAmqpLib\Connection\AMQPStreamConnection;
use Shared\Application\Persistence\RabbitMQ\RabbitMQMessageConsumerInterface;

abstract class AbstractRabbitMQMessageConsumer extends AbstractRabbitMQMessaging implements RabbitMQMessageConsumerInterface
{
    /**
     * AbstractRabbitMQMessageConsumer constructor.
     *
     * @param \PhpAmqpLib\Connection\AMQPStreamConnection $connection
     */
    public function __construct(AMQPStreamConnection $connection)
    {
        parent::__construct($connection);

        // Exchange
        $this->channel()->exchange_declare('events', 'fanout', FALSE, TRUE, FALSE);

        // Queue
        $this->channel()->queue_declare(sprintf('%s.events', $this->domain()), FALSE, TRUE, FALSE, FALSE);
        $this->channel()->queue_bind(sprintf('%s.events', $this->domain()), 'events');
    }

    /**
     * @return void
     */
    public function listen()
    {
        $channel = $this->channel();

        $callback = function ($msg) {
            echo ' [x] ', $msg->body, "\n";
        };
        $channel->basic_consume(sprintf('%s.events', $this->domain()), '', FALSE, TRUE, FALSE, FALSE, $callback);

        while (count($channel->callbacks)) {
            $channel->wait();
        }

        $this->close();
    }

    /**
     * @return string
     */
    abstract protected function domain(): string;
}