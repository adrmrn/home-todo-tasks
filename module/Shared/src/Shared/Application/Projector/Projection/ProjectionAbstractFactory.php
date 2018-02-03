<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 13.01.18
 * Time: 18:01
 */

namespace Shared\Application\Projector\Projection;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Shared\Application\Persistence\MongoDB\MongoDBClientInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;

class ProjectionAbstractFactory implements AbstractFactoryInterface
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
        if (FALSE === $reflectionClass->implementsInterface(ProjectionInterface::class)) {
            return FALSE;
        }

        return FALSE === $this->isFactoryDefinedForClass($container, $requestedName);
    }

    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param                                       $requestedName
     *
     * @return bool
     */
    private function isFactoryDefinedForClass(ContainerInterface $container, $requestedName): bool
    {
        return TRUE === array_key_exists($requestedName, $container->get('config')['service_manager']['factories']);
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
            $container->get(MongoDBClientInterface::class)
        );
    }
}