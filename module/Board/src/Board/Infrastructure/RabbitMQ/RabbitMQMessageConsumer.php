<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 04.02.18
 * Time: 14:32
 */

namespace Board\Infrastructure\RabbitMQ;


use Shared\Infrastructure\RabbitMQ\AbstractRabbitMQMessageConsumer;

class RabbitMQMessageConsumer extends AbstractRabbitMQMessageConsumer
{
    protected function domain(): string
    {
        return 'board';
    }
}