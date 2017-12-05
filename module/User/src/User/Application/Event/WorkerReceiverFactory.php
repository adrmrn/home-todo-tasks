<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 04.12.17
 * Time: 15:40
 */

namespace User\Application\Event;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class WorkerReceiverFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     *
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL)
    {
        if (FALSE === isset($container->get('config')['rabbitmq'])) {
            throw new \RuntimeException('Config for RabbitMQ is not provided.', 501);
        }

        $config = $container->get('config')['rabbitmq'];

        $connection = new AMQPStreamConnection(
            $config['hostname'],
            $config['port'],
            $config['username'],
            $config['password']
        );

        return new WorkerReceiver(
            $connection
        );
    }
}