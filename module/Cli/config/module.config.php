<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 04.12.17
 * Time: 01:07
 */

use Cli\Controller\UserEventReceiverController;
use Cli\Controller\UserEventReceiverControllerFactory;

return [
    'controllers'     => [
        'factories' => [
            UserEventReceiverController::class => UserEventReceiverControllerFactory::class
            // InvokableFactory::class
        ],
    ],
    'service_manager' => [
        'factories' => [],
    ],
    'console'         => [
        'router' => [
            'routes' => [
                'user event receiver' => [
                    'options' => [
                        'route'    => 'user event receiver',
                        'defaults' => [
                            'controller' => UserEventReceiverController::class,
                            'action'     => 'receiveEvent',
                        ],
                    ],
                ],
            ],
        ],
    ],
];