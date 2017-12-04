<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 02.12.17
 * Time: 20:03
 */

namespace Shared\Infrastructure\MongoDB;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use MongoDB\Client;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class MongoDBClientFactory implements FactoryInterface
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
        if (FALSE === isset($container->get('config')['mongodb'])) {
            throw new \RuntimeException('Config for MongoDB\Client is not provided.', 501);
        }

        $config = $container->get('config')['mongodb'];

        $client = new Client(
            sprintf(
                'mongodb://%s:%s@%s:%s/%s',
                $config['username'],
                $config['password'],
                $config['hostname'],
                $config['port'],
                $config['database']
            )
        );

        return new MongoDBClient(
            $client,
            $config['database']
        );
    }
}