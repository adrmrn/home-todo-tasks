<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 11.02.18
 * Time: 21:39
 */

namespace Board\Application\Query\FetchBoardById;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Shared\Application\Persistence\DataSource\BoardDataSourceInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class FetchBoardByIdQueryHandlerFactory implements FactoryInterface
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
        return new FetchBoardByIdQueryHandler(
            $container->get(BoardDataSourceInterface::class)
        );
    }
}