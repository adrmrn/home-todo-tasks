<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 08.02.18
 * Time: 22:19
 */

namespace Board\Application\Service;


use Board\Application\Persistence\Repository\GroupRepositoryInterface;
use Board\Domain\Service\GroupMembershipManagerPermissionService;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Shared\Application\Persistence\DataSource\UserDataSourceInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class GroupMembershipManagerServiceFactory implements FactoryInterface
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
        return new GroupMembershipManagerService(
            $container->get(GroupRepositoryInterface::class),
            $container->get(GroupMembershipManagerPermissionService::class),
            $container->get(UserDataSourceInterface::class)
        );
    }
}