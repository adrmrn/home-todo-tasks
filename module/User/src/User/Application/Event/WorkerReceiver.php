<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 04.12.17
 * Time: 15:40
 */

namespace User\Application\Event;


use PhpAmqpLib\Connection\AMQPStreamConnection;

class WorkerReceiver
{
    /**
     * @var \PhpAmqpLib\Connection\AMQPStreamConnection
     */
    private $connection;

    /**
     * WorkerReceiver constructor.
     *
     * @param \PhpAmqpLib\Connection\AMQPStreamConnection $connection
     */
    public function __construct(AMQPStreamConnection $connection)
    {
        $this->connection = $connection;
    }

    public function listen()
    {
        $channel = $this->connection->channel();

        $channel->exchange_declare('events', 'fanout', false, false, false);
        $channel->queue_declare('user.events', false, true, false, false);
        $channel->queue_bind('user.events', 'events');

        $callback = function($msg){
            echo ' [x] ', $msg->body, "\n";
        };

        $channel->basic_consume('user.events', '', false, true, false, false, $callback);

        while(count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
        $this->connection->close();
    }
}