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

return [
    'service_manager' => [
        'factories' => [
            CreateUserCommandHandler::class => CreateUserCommandHandlerFactory::class,
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