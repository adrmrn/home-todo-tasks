<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 04.12.17
 * Time: 15:40
 */

namespace User\Infrastructure\RabbitMQ;


use Shared\Infrastructure\RabbitMQ\AbstractRabbitMQMessageConsumer;

class RabbitMQMessageConsumer extends AbstractRabbitMQMessageConsumer
{
    protected function domain(): string
    {
        return 'user';
    }
}