<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 04.12.17
 * Time: 01:07
 */

namespace Cli;

use Cli\Controller\UserEventConsumerController;
use Cli\Controller\UserEventConsumerControllerFactory;

return [
    'controllers'     => [
        'factories' => [
            UserEventConsumerController::class => UserEventConsumerControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [],
    ],
    'console'         => [
        'router' => [
            'routes' => [
                'user event consumer' => [
                    'options' => [
                        'route'    => 'user event consumer',
                        'defaults' => [
                            'controller' => UserEventConsumerController::class,
                            'action'     => 'consumeEvents',
                        ],
                    ],
                ],
            ],
        ],
    ],
];