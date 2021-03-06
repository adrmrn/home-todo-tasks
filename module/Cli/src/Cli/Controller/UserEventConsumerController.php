<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 04.12.17
 * Time: 14:05
 */

namespace Cli\Controller;


use Shared\Application\Persistence\RabbitMQ\RabbitMQMessageConsumerInterface;
use Zend\Console\Request;
use Zend\Mvc\Console\Controller\AbstractConsoleController;

class UserEventConsumerController extends AbstractConsoleController
{
    /**
     * @var \Shared\Application\Persistence\RabbitMQ\RabbitMQMessageConsumerInterface
     */
    private $messageConsumer;

    /**
     * UserEventConsumerController constructor.
     *
     * @param \Shared\Application\Persistence\RabbitMQ\RabbitMQMessageConsumerInterface $messageConsumer
     */
    public function __construct(RabbitMQMessageConsumerInterface $messageConsumer)
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