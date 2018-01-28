<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 09.11.17
 * Time: 15:24
 */

namespace User;

use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Shared\Application\Persistence\DataSource\CredentialsDataSourceInterface;
use User\Application\Command\ChangeUserName\ChangeUserNameCommand;
use User\Application\Command\ChangeUserName\ChangeUserNameCommandHandler;
use User\Application\Command\ChangeUserName\ChangeUserNameCommandHandlerFactory;
use User\Application\Command\ChangeUserName\ChangeUserNameCommandInputFilter;
use User\Application\Command\CreateUser\CreateUserCommand;
use User\Application\Command\CreateUser\CreateUserCommandHandler;
use User\Application\Command\CreateUser\CreateUserCommandHandlerFactory;
use User\Application\Command\CreateUser\CreateUserCommandInputFilter;
use User\Application\Event\Listener\EventListenerAggregateFactory;
use Shared\Application\Persistence\DataSource\UserDataSourceInterface;
use User\Application\Query\FetchUserById\FetchUserByIdQuery;
use User\Application\Query\FetchUserById\FetchUserByIdQueryHandler;
use User\Application\Query\FetchUserById\FetchUserByIdQueryHandlerFactory;
use User\Infrastructure\DataSource\CredentialsDataSourceFactory;
use User\Infrastructure\DataSource\UserDataSourceFactory;
use User\Infrastructure\RabbitMQ\RabbitMQMessageConsumer;
use User\Infrastructure\RabbitMQ\RabbitMQMessageConsumerFactory;
use User\Application\Event\Listener\EventListenerAggregate;
use User\Application\Persistence\Repository\UserRepositoryInterface;
use User\Application\Service\UserCreatorService;
use User\Application\Service\UserCreatorServiceFactory;
use User\Application\Service\UserEditorService;
use User\Application\Service\UserEditorServiceFactory;
use User\Infrastructure\Repository\DoctrineUserRepositoryFactory;

return [
    'service_manager' => [
        'factories'  => [
            // Command
            CreateUserCommandHandler::class       => CreateUserCommandHandlerFactory::class,
            ChangeUserNameCommandHandler::class   => ChangeUserNameCommandHandlerFactory::class,

            // Query
            FetchUserByIdQueryHandler::class      => FetchUserByIdQueryHandlerFactory::class,

            // Service
            UserCreatorService::class             => UserCreatorServiceFactory::class,
            UserEditorService::class              => UserEditorServiceFactory::class,

            // Repository
            UserRepositoryInterface::class        => DoctrineUserRepositoryFactory::class,

            // Event
            EventListenerAggregate::class         => EventListenerAggregateFactory::class,
            RabbitMQMessageConsumer::class        => RabbitMQMessageConsumerFactory::class,

            // DataSource
            UserDataSourceInterface::class        => UserDataSourceFactory::class,
            CredentialsDataSourceInterface::class => CredentialsDataSourceFactory::class,
        ],
        'invokables' => [
        ],
    ],
    'tactician'       => [
        'handler-map'     => [
            CreateUserCommand::class     => CreateUserCommandHandler::class,
            ChangeUserNameCommand::class => ChangeUserNameCommandHandler::class,
            FetchUserByIdQuery::class    => FetchUserByIdQueryHandler::class,
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
    'doctrine'        => [
        'driver' => [
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            __NAMESPACE__ . '_driver' => [
                'class' => SimplifiedXmlDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/User/Infrastructure/Doctrine/Mapping'             => 'User\Application\Model',
                    __DIR__ . '/../src/User/Infrastructure/Doctrine/Mapping/Credentials' => 'User\Application\Model\Credentials',
                ],
            ],

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default'             => [
                'drivers' => [
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    __NAMESPACE__ . '\Application\Model' => __NAMESPACE__ . '_driver',
                ],
            ],
        ],
    ],
];