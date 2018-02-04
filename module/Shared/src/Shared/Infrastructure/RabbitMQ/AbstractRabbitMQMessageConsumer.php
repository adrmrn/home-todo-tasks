<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 11.01.18
 * Time: 21:58
 */

namespace Shared\Infrastructure\RabbitMQ;


use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Ramsey\Uuid\Uuid;
use Shared\Application\Event\Event;
use Shared\Application\Event\Subscriber\EventSubscriberAggregateInterface;
use Shared\Application\Persistence\RabbitMQ\RabbitMQMessageConsumerInterface;

abstract class AbstractRabbitMQMessageConsumer extends AbstractRabbitMQMessaging implements RabbitMQMessageConsumerInterface
{
    /**
     * @var \Shared\Application\Event\Subscriber\EventSubscriberAggregateInterface
     */
    private $eventSubscriberAggregate;

    /**
     * AbstractRabbitMQMessageConsumer constructor.
     *
     * @param \PhpAmqpLib\Connection\AMQPStreamConnection                            $connection
     * @param \Shared\Application\Event\Subscriber\EventSubscriberAggregateInterface $eventSubscriberAggregate
     */
    public function __construct(AMQPStreamConnection $connection,
                                EventSubscriberAggregateInterface $eventSubscriberAggregate)
    {
        parent::__construct($connection);

        $this->eventSubscriberAggregate = $eventSubscriberAggregate;

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

        $channel->basic_consume(sprintf('%s.events', $this->domain()), '', FALSE, TRUE, FALSE, FALSE, [$this, 'handleCallback']);

        while (count($channel->callbacks)) {
            $channel->wait();
        }

        $this->close();
    }

    /**
     * @param $msg
     */
    public function handleCallback(AMQPMessage $msg)
    {
        echo sprintf(" [ %s - DOMAIN HANDLER ] %s \n", strtoupper($this->domain()), $msg->body);

        $msg = json_decode($msg->body, TRUE);

        // build event from body
        $event = new Event(
            $msg['data']['domain'],
            $msg['data']['name'],
            Uuid::fromString($msg['data']['entity_id']),
            $msg['data']['data'],
            new \DateTimeImmutable($msg['data']['occurred_at'])
        );

        $this->eventSubscriberAggregate->handle($event);
    }

    /**
     * @return string
     */
    abstract protected function domain(): string;
}