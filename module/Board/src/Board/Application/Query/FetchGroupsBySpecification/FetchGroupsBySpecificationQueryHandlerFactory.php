<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 03.02.18
 * Time: 16:52
 */

namespace Board\Application\Query\FetchGroupsBySpecification;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Shared\Application\Persistence\DataSource\GroupDataSourceInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class FetchGroupsBySpecificationQueryHandlerFactory implements FactoryInterface
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
        return new FetchGroupsBySpecificationQueryHandler(
            $container->get(GroupDataSourceInterface::class)
        );
    }
}