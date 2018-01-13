<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 13.01.18
 * Time: 12:12
 */

namespace Shared\Application\Persistence\RabbitMQ;


interface RabbitMQMessageConsumerInterface
{
    /**
     * @return void
     */
    public function listen();
}