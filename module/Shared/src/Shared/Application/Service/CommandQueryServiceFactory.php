<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 10.11.17
 * Time: 14:33
 */

namespace Shared\Application\Service;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\InputFilter\InputFilterPluginManager;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class CommandQueryServiceFactory implements FactoryInterface
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
        $inputFilterMap = $container->get('Config')['tactician']['inputfilter-map'] ?? [];

        return new CommandQueryService(
            $container->get(InputFilterPluginManager::class),
            $inputFilterMap
        );
    }
}