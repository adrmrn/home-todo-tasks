<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 13.01.18
 * Time: 12:13
 */

namespace Shared\Application\Persistence\RabbitMQ;


use Shared\Application\Event\Event;

interface RabbitMQMessageProducerInterface
{
    /**
     * @param \Shared\Application\Event\Event $event
     *
     * @return void
     */
    public function send(Event $event): void;
}