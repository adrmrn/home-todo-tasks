<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 09.11.17
 * Time: 15:24
 */

use User\Application\Command\ChangeUserName\ChangeUserNameCommand;
use User\Application\Command\ChangeUserName\ChangeUserNameCommandHandler;
use User\Application\Command\ChangeUserName\ChangeUserNameCommandHandlerFactory;
use User\Application\Command\ChangeUserName\ChangeUserNameCommandInputFilter;
use User\Application\Command\CreateUser\CreateUserCommand;
use User\Application\Command\CreateUser\CreateUserCommandHandler;
use User\Application\Command\CreateUser\CreateUserCommandHandlerFactory;
use User\Application\Command\CreateUser\CreateUserCommandInputFilter;
use User\Application\Event\WorkerReceiver;
use User\Application\Event\WorkerReceiverFactory;
use User\Application\Persistence\Repository\UserRepositoryInterface;
use User\Application\Service\UserCreatorService;
use User\Application\Service\UserCreatorServiceFactory;
use User\Application\Service\UserEditorService;
use User\Application\Service\UserEditorServiceFactory;
use User\Infrastructure\Repository\UserRepositoryFactory;

return [
    'service_manager' => [
        'factories' => [
            // Command
            CreateUserCommandHandler::class     => CreateUserCommandHandlerFactory::class,
            ChangeUserNameCommandHandler::class => ChangeUserNameCommandHandlerFactory::class,

            // Service
            UserCreatorService::class           => UserCreatorServiceFactory::class,
            UserEditorService::class            => UserEditorServiceFactory::class,

            // Repository
            UserRepositoryInterface::class      => UserRepositoryFactory::class,

            WorkerReceiver::class => WorkerReceiverFactory::class,
        ],
    ],
    'tactician'       => [
        'handler-map'     => [
            CreateUserCommand::class     => CreateUserCommandHandler::class,
            ChangeUserNameCommand::class => ChangeUserNameCommandHandler::class,
        ],
        'inputfilter-map' => [
            CreateUserCommand::class     => CreateUserCommandInputFilter::class,
            ChangeUserNameCommand::class => ChangeUserNameCommandInputFilter::class,
        ],
    ],
    'input_filters'   => [
        'invokables' => [
            CreateUserCommandInputFilter::class,
            ChangeUserNameCommandInputFilter::class,
        ],
        'factories'  => [],
    ],
];