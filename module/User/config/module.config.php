<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 09.11.17
 * Time: 15:24
 */

namespace User;

use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use User\Application\Command\ChangeUserName\ChangeUserNameCommand;
use User\Application\Command\ChangeUserName\ChangeUserNameCommandHandler;
use User\Application\Command\ChangeUserName\ChangeUserNameCommandHandlerFactory;
use User\Application\Command\ChangeUserName\ChangeUserNameCommandInputFilter;
use User\Application\Command\CreateUser\CreateUserCommand;
use User\Application\Command\CreateUser\CreateUserCommandHandler;
use User\Application\Command\CreateUser\CreateUserCommandHandlerFactory;
use User\Application\Command\CreateUser\CreateUserCommandInputFilter;
use User\Application\Event\Publisher\Adapter\RabbitMQEventPublisherAdapter;
use User\Application\Event\Publisher\Adapter\RabbitMQEventPublisherAdapterFactory;
use User\Infrastructure\RabbitMQ\RabbitMQMessageConsumer;
use User\Infrastructure\RabbitMQ\RabbitMQMessageConsumerFactory;
use User\Application\EventManager\EventListenerAggregate;
use User\Application\Event\Publisher\Adapter\InMemoryEventPublisherAdapter;
use User\Application\Persistence\Repository\UserRepositoryInterface;
use User\Application\Service\UserCreatorService;
use User\Application\Service\UserCreatorServiceFactory;
use User\Application\Service\UserEditorService;
use User\Application\Service\UserEditorServiceFactory;
use User\Infrastructure\Repository\UserRepositoryFactory;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'factories'  => [
            // Command
            CreateUserCommandHandler::class      => CreateUserCommandHandlerFactory::class,
            ChangeUserNameCommandHandler::class  => ChangeUserNameCommandHandlerFactory::class,

            // Service
            UserCreatorService::class            => UserCreatorServiceFactory::class,
            UserEditorService::class             => UserEditorServiceFactory::class,

            // Repository
            UserRepositoryInterface::class       => UserRepositoryFactory::class,

            // Event
            EventListenerAggregate::class        => InvokableFactory::class,
            RabbitMQEventPublisherAdapter::class => RabbitMQEventPublisherAdapterFactory::class,
            RabbitMQMessageConsumer::class       => RabbitMQMessageConsumerFactory::class,
        ],
        'invokables' => [
            InMemoryEventPublisherAdapter::class,
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
    'doctrine'        => [
        'driver' => [
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            __NAMESPACE__ . '_driver' => [
                'class' => SimplifiedXmlDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/User/Infrastructure/Doctrine/Mapping' => 'User\Infrastructure\Doctrine\Mapping',
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