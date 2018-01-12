<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 04.12.17
 * Time: 14:05
 */

namespace Cli\Controller;


use User\Infrastructure\RabbitMQ\RabbitMQMessageConsumer;
use Zend\Console\Request;
use Zend\Mvc\Console\Controller\AbstractConsoleController;

class UserEventConsumerController extends AbstractConsoleController
{
    /**
     * @var \User\Infrastructure\RabbitMQ\RabbitMQMessageConsumer
     */
    private $messageConsumer;

    /**
     * UserEventConsumerController constructor.
     *
     * @param \User\Infrastructure\RabbitMQ\RabbitMQMessageConsumer $messageConsumer
     */
    public function __construct(RabbitMQMessageConsumer $messageConsumer)
    {
        $this->messageConsumer = $messageConsumer;
    }

    public function consumeEventsAction()
    {
        $request = $this->getRequest();

        // Make sure that we are running in a console and the user has not tricked our
        // application into running this action from a public web server.
        if (!$request instanceof Request) {
            throw new \RuntimeException('You can only run consumer from a console!', 501);
        }

        $this->messageConsumer->listen();
    }
}