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
        'factories'  => [
        ],
    ],
];