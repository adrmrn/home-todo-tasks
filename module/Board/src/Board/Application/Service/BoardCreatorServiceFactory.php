<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 11.02.18
 * Time: 15:07
 */

namespace Board\Application\Service;


use Board\Application\Persistence\Repository\BoardRepositoryInterface;
use Board\Application\Persistence\Repository\GroupRepositoryInterface;
use Board\Domain\Service\GroupBoardManagerPermissionService;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class BoardCreatorServiceFactory implements FactoryInterface
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
        return new BoardCreatorService(
            $container->get(GroupRepositoryInterface::class),
            $container->get(BoardRepositoryInterface::class),
            $container->get(GroupBoardManagerPermissionService::class)
        );
    }
}