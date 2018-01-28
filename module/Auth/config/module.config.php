<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 24.01.18
 * Time: 21:29
 */

namespace Auth;

use Auth\Application\Adapter\AuthenticationJWTAdapter;
use Auth\Application\Adapter\AuthenticationJWTAdapterFactory;
use Auth\Application\Command\AuthenticateUser\AuthenticateUserCommand;
use Auth\Application\Command\AuthenticateUser\AuthenticateUserCommandHandler;
use Auth\Application\Command\AuthenticateUser\AuthenticateUserCommandHandlerFactory;
use Auth\Application\Command\AuthenticateUser\AuthenticateUserCommandInputFilter;
use Auth\Application\Event\Listener\EventListenerAggregate;
use Auth\Application\Event\Listener\EventListenerAggregateFactory;
use Auth\Application\Service\Token\JWTTokenGeneratorInterface;
use Auth\Application\Service\Token\JWTTokenServiceFactory;
use Auth\Application\Service\Token\JWTTokenVerifierInterface;
use Auth\Application\Service\UserAuthenticationService;
use Auth\Application\Service\UserAuthenticationServiceFactory;

return [
    'service_manager' => [
        'factories'  => [
            // Command
            AuthenticateUserCommandHandler::class => AuthenticateUserCommandHandlerFactory::class,

            // Service
            UserAuthenticationService::class      => UserAuthenticationServiceFactory::class,
            JWTTokenGeneratorInterface::class     => JWTTokenServiceFactory::class,
            JWTTokenVerifierInterface::class      => JWTTokenServiceFactory::class,

            // Adapter
            AuthenticationJWTAdapter::class       => AuthenticationJWTAdapterFactory::class,

            // Event
            EventListenerAggregate::class         => EventListenerAggregateFactory::class,
        ],
        'invokables' => [
        ],
    ],
    'tactician'       => [
        'handler-map'     => [
            AuthenticateUserCommand::class => AuthenticateUserCommandHandler::class,
        ],
        'inputfilter-map' => [
            AuthenticateUserCommand::class => AuthenticateUserCommandInputFilter::class,
        ],
    ],
    'input_filters'   => [
        'invokables' => [
            AuthenticateUserCommandInputFilter::class,
        ],
        'factories'  => [],
    ],
    //    'doctrine'        => [
    //        'driver' => [
    //            // defines an annotation driver with two paths, and names it `my_annotation_driver`
    //            __NAMESPACE__ . '_driver' => [
    //                'class' => SimplifiedXmlDriver::class,
    //                'cache' => 'array',
    //                'paths' => [
    //                    __DIR__ . '/../src/User/Infrastructure/Doctrine/Mapping'             => 'User\Application\Model',
    //                    __DIR__ . '/../src/User/Infrastructure/Doctrine/Mapping/Credentials' => 'User\Application\Model\Credentials',
    //                ],
    //            ],
    //
    //            // default metadata driver, aggregates all other drivers into a single one.
    //            // Override `orm_default` only if you know what you're doing
    //            'orm_default'             => [
    //                'drivers' => [
    //                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
    //                    __NAMESPACE__ . '\Application\Model' => __NAMESPACE__ . '_driver',
    //                ],
    //            ],
    //        ],
    //    ],
];