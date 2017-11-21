<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 09.11.17
 * Time: 10:09
 */

namespace Shared\Infrastructure\Dao;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Db\Adapter\AdapterInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;

class DaoAbstractFactory implements AbstractFactoryInterface
{
    /**
     * Can the factory create an instance for the service?
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     *
     * @return bool
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        if (FALSE === class_exists($requestedName)) {
            return FALSE;
        }

        $reflectionClass = new \ReflectionClass($requestedName);

        return $reflectionClass->implementsInterface(DaoInterface::class);
    }

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
        return new $requestedName(
            $container->get(AdapterInterface::class)
        );
    }
}