<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 13.01.18
 * Time: 12:07
 */

namespace Shared\Application\Persistence\RabbitMQ;


use PhpAmqpLib\Channel\AMQPChannel;

interface RabbitMQMessagingInterface
{
    /**
     * @return \PhpAmqpLib\Channel\AMQPChannel
     */
    public function channel(): AMQPChannel;

    /**
     * @return void
     */
    public function close(): void;
}