<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 11.02.18
 * Time: 21:04
 */

namespace Board\Infrastructure\DataSource;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Shared\Application\Persistence\MongoDB\MongoDBClientInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class BoardDataSourceFactory implements FactoryInterface
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
        return new BoardDataSource(
            $container->get(MongoDBClientInterface::class)
        );
    }
}