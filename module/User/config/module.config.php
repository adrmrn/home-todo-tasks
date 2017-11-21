<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 09.11.17
 * Time: 15:24
 */

use User\Application\Command\CreateUser\CreateUserCommand;
use User\Application\Command\CreateUser\CreateUserCommandHandler;
use User\Application\Command\CreateUser\CreateUserCommandHandlerFactory;
use User\Application\Command\CreateUser\CreateUserCommandInputFilter;
use User\Application\Persistence\Repository\IdentityRepositoryInterface;
use User\Application\Persistence\Repository\UserRepositoryInterface;
use User\Application\Service\IdentityCreatorService;
use User\Application\Service\IdentityCreatorServiceFactory;
use User\Application\Service\UserCreatorService;
use User\Application\Service\UserCreatorServiceFactory;
use User\Infrastructure\Repository\IdentityRepository;
use User\Infrastructure\Repository\UserRepositoryFactory;

return [
    'service_manager' => [
        'factories' => [
            CreateUserCommandHandler::class    => CreateUserCommandHandlerFactory::class,
            UserCreatorService::class          => UserCreatorServiceFactory::class,
            UserRepositoryInterface::class     => UserRepositoryFactory::class,
        ],
    ],
    'tactician'       => [
        'handler-map'     => [
            CreateUserCommand::class => CreateUserCommandHandler::class,
        ],
        'inputfilter-map' => [
            CreateUserCommand::class => CreateUserCommandInputFilter::class,
        ],
    ],
    'input_filters'   => [
        'invokables' => [
            CreateUserCommandInputFilter::class,
        ],
        'factories'  => [],
    ],
];