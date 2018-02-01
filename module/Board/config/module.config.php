<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 29.01.18
 * Time: 19:21
 */

namespace Board;

use Board\Application\Persistence\GroupRepositoryInterface;
use Board\Infrastructure\Repository\DoctrineGroupRepositoryFactory;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Board\Application\Command\CreateGroup\CreateGroupCommand;
use Board\Application\Command\CreateGroup\CreateGroupCommandHandler;
use Board\Application\Command\CreateGroup\CreateGroupCommandHandlerFactory;
use Board\Application\Command\CreateGroup\CreateGroupCommandInputFilter;
use Board\Application\Service\GroupCreatorService;
use Board\Application\Service\GroupCreatorServiceFactory;

return [
    'service_manager' => [
        'factories'          => [
            // Command
            CreateGroupCommandHandler::class => CreateGroupCommandHandlerFactory::class,

            // Service
            GroupCreatorService::class       => GroupCreatorServiceFactory::class,

            // Repository
            GroupRepositoryInterface::class  => DoctrineGroupRepositoryFactory::class,
        ],
        'abstract_factories' => [
        ],
        'invokables'         => [
        ],
    ],
    'tactician'       => [
        'handler-map'     => [
            CreateGroupCommand::class => CreateGroupCommandHandler::class,
        ],
        'inputfilter-map' => [
            CreateGroupCommand::class => CreateGroupCommandInputFilter::class,
        ],
    ],
    'input_filters'   => [
        'invokables' => [
            CreateGroupCommandInputFilter::class,
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
                    __DIR__ . '/../src/Board/Infrastructure/Doctrine/Mapping'            => 'Board\Domain\Model',
                    __DIR__ . '/../src/Board/Infrastructure/Doctrine/Mapping/Membership' => 'Board\Domain\Model\Membership',
                ],
            ],

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default'             => [
                'drivers' => [
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    __NAMESPACE__ . '\Domain\Model'            => __NAMESPACE__ . '_driver',
                    __NAMESPACE__ . '\Domain\Model\Membership' => __NAMESPACE__ . '_driver',
                ],
            ],
        ],
        //        'configuration' => [
        //            'orm_default' => [
        //                'types' => [
        //                    'member_role' => MemberRoleType::class,
        //                ],
        //            ],
        //        ],
    ],
];