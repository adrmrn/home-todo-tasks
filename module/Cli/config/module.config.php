<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 04.12.17
 * Time: 01:07
 */

namespace Cli;

use Cli\Controller\BoardEventConsumerController;
use Cli\Controller\BoardEventConsumerControllerFactory;
use Cli\Controller\UserEventConsumerController;
use Cli\Controller\UserEventConsumerControllerFactory;

return [
    'controllers'     => [
        'factories' => [
            UserEventConsumerController::class  => UserEventConsumerControllerFactory::class,
            BoardEventConsumerController::class => BoardEventConsumerControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [],
    ],
    'console'         => [
        'router' => [
            'routes' => [
                'user event consumer'  => [
                    'options' => [
                        'route'    => 'user event consumer',
                        'defaults' => [
                            'controller' => UserEventConsumerController::class,
                            'action'     => 'consumeEvents',
                        ],
                    ],
                ],
                'board event consumer' => [
                    'options' => [
                        'route'    => 'board event consumer',
                        'defaults' => [
                            'controller' => BoardEventConsumerController::class,
                            'action'     => 'consumeEvents',
                        ],
                    ],
                ],
            ],
        ],
    ],
];