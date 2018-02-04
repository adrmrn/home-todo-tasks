<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 13.01.18
 * Time: 12:12
 */

namespace Shared\Application\Persistence\RabbitMQ;


use PhpAmqpLib\Message\AMQPMessage;

interface RabbitMQMessageConsumerInterface
{
    /**
     * @return void
     */
    public function listen(): void;

    /**
     * @param \PhpAmqpLib\Message\AMQPMessage $message
     */
    public function handleCallback(AMQPMessage $message): void;
}