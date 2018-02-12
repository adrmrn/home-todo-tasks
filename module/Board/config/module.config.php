<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 29.01.18
 * Time: 19:21
 */

namespace Board;

use Board\Application\Command\AddMembership\AddMembershipCommand;
use Board\Application\Command\AddMembership\AddMembershipCommandHandler;
use Board\Application\Command\AddMembership\AddMembershipCommandHandlerFactory;
use Board\Application\Command\AddMembership\AddMembershipCommandValidator;
use Board\Application\Command\CreateBoard\CreateBoardCommand;
use Board\Application\Command\CreateBoard\CreateBoardCommandHandler;
use Board\Application\Command\CreateBoard\CreateBoardCommandHandlerFactory;
use Board\Application\Command\CreateBoard\CreateBoardCommandValidator;
use Board\Application\Event\Listener\EventListenerAggregate;
use Board\Application\Event\Listener\EventListenerAggregateFactory;
use Board\Application\Persistence\Repository\BoardRepositoryInterface;
use Board\Application\Persistence\Repository\GroupRepositoryInterface;
use Board\Application\Projector\Projection\GroupCreatedProjection;
use Board\Application\Projector\Projection\GroupCreatedProjectionFactory;
use Board\Application\Projector\Projection\GroupMembershipAddedProjection;
use Board\Application\Projector\Projection\GroupMembershipAddedProjectionFactory;
use Board\Application\Query\FetchBoardById\FetchBoardByIdQuery;
use Board\Application\Query\FetchBoardById\FetchBoardByIdQueryHandler;
use Board\Application\Query\FetchBoardById\FetchBoardByIdQueryHandlerFactory;
use Board\Application\Query\FetchBoardsBySpecification\FetchBoardsBySpecificationQuery;
use Board\Application\Query\FetchBoardsBySpecification\FetchBoardsBySpecificationQueryHandler;
use Board\Application\Query\FetchBoardsBySpecification\FetchBoardsBySpecificationQueryHandlerFactory;
use Board\Application\Query\FetchGroupById\FetchGroupByIdQuery;
use Board\Application\Query\FetchGroupById\FetchGroupByIdQueryHandler;
use Board\Application\Query\FetchGroupById\FetchGroupByIdQueryHandlerFactory;
use Board\Application\Query\FetchGroupsBySpecification\FetchGroupsBySpecificationQuery;
use Board\Application\Query\FetchGroupsBySpecification\FetchGroupsBySpecificationQueryHandler;
use Board\Application\Query\FetchGroupsBySpecification\FetchGroupsBySpecificationQueryHandlerFactory;
use Board\Application\Service\BoardCreatorService;
use Board\Application\Service\BoardCreatorServiceFactory;
use Board\Application\Service\GroupMembershipManagerService;
use Board\Application\Service\GroupMembershipManagerServiceFactory;
use Board\Domain\Service\GroupBoardManagerPermissionService;
use Board\Domain\Service\GroupMembershipManagerPermissionService;
use Board\Infrastructure\DataSource\BoardDataSourceFactory;
use Board\Infrastructure\DataSource\GroupDataSourceFactory;
use Board\Infrastructure\RabbitMQ\RabbitMQMessageConsumer;
use Board\Infrastructure\RabbitMQ\RabbitMQMessageConsumerFactory;
use Board\Infrastructure\Repository\DoctrineBoardRepositoryFactory;
use Board\Infrastructure\Repository\DoctrineGroupRepositoryFactory;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Board\Application\Command\CreateGroup\CreateGroupCommand;
use Board\Application\Command\CreateGroup\CreateGroupCommandHandler;
use Board\Application\Command\CreateGroup\CreateGroupCommandHandlerFactory;
use Board\Application\Command\CreateGroup\CreateGroupCommandValidator;
use Board\Application\Service\GroupCreatorService;
use Board\Application\Service\GroupCreatorServiceFactory;
use Shared\Application\Persistence\DataSource\BoardDataSourceInterface;
use Shared\Application\Persistence\DataSource\GroupDataSourceInterface;

return [
    'service_manager' => [
        'factories'          => [
            // Command
            CreateGroupCommandHandler::class              => CreateGroupCommandHandlerFactory::class,
            AddMembershipCommandHandler::class            => AddMembershipCommandHandlerFactory::class,
            CreateBoardCommandHandler::class              => CreateBoardCommandHandlerFactory::class,

            // Query
            FetchGroupByIdQueryHandler::class             => FetchGroupByIdQueryHandlerFactory::class,
            FetchGroupsBySpecificationQueryHandler::class => FetchGroupsBySpecificationQueryHandlerFactory::class,
            FetchBoardByIdQueryHandler::class             => FetchBoardByIdQueryHandlerFactory::class,
            FetchBoardsBySpecificationQueryHandler::class => FetchBoardsBySpecificationQueryHandlerFactory::class,

            // Service
            GroupCreatorService::class                    => GroupCreatorServiceFactory::class,
            GroupMembershipManagerService::class          => GroupMembershipManagerServiceFactory::class,
            BoardCreatorService::class                    => BoardCreatorServiceFactory::class,

            // Repository
            GroupRepositoryInterface::class               => DoctrineGroupRepositoryFactory::class,
            BoardRepositoryInterface::class               => DoctrineBoardRepositoryFactory::class,

            // Event
            EventListenerAggregate::class                 => EventListenerAggregateFactory::class,
            RabbitMQMessageConsumer::class                => RabbitMQMessageConsumerFactory::class,

            // Projector
            GroupCreatedProjection::class                 => GroupCreatedProjectionFactory::class,
            GroupMembershipAddedProjection::class         => GroupMembershipAddedProjectionFactory::class,

            // DataSource
            GroupDataSourceInterface::class               => GroupDataSourceFactory::class,
            BoardDataSourceInterface::class               => BoardDataSourceFactory::class,
        ],
        'abstract_factories' => [
        ],
        'invokables'         => [
            GroupMembershipManagerPermissionService::class,
            GroupBoardManagerPermissionService::class,
        ],
    ],
    'tactician'       => [
        'handler-map'     => [
            // Command
            CreateGroupCommand::class              => CreateGroupCommandHandler::class,
            AddMembershipCommand::class            => AddMembershipCommandHandler::class,
            CreateBoardCommand::class              => CreateBoardCommandHandler::class,

            // Query
            FetchGroupByIdQuery::class             => FetchGroupByIdQueryHandler::class,
            FetchGroupsBySpecificationQuery::class => FetchGroupsBySpecificationQueryHandler::class,
            FetchBoardByIdQuery::class             => FetchBoardByIdQueryHandler::class,
            FetchBoardsBySpecificationQuery::class => FetchBoardsBySpecificationQueryHandler::class,
        ],
        'inputfilter-map' => [
            CreateGroupCommand::class   => CreateGroupCommandValidator::class,
            AddMembershipCommand::class => AddMembershipCommandValidator::class,
            CreateBoardCommand::class   => CreateBoardCommandValidator::class,
        ],
    ],
    'input_filters'   => [
        'invokables' => [
            CreateGroupCommandValidator::class,
            AddMembershipCommandValidator::class,
            CreateBoardCommandValidator::class,
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