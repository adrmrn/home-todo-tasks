<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 09.11.17
 * Time: 09:25
 */

namespace Shared;

use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Shared\Application\Factory\RabbitMQConnectionFactory;
use Shared\Application\Persistence\MongoDB\MongoDBClientInterface;
use Shared\Application\Persistence\RabbitMQ\RabbitMQMessageProducerInterface;
use Shared\Application\Projector\Projection\ProjectionAbstractFactory;
use Shared\Application\Service\CommandQueryService;
use Shared\Application\Service\CommandQueryServiceFactory;
use Shared\Application\Service\JsonPatchResolver;
use Shared\Application\Service\JsonPatchResolverFactory;
use Shared\Infrastructure\Dao\DaoAbstractFactory;
use Shared\Infrastructure\MongoDB\MongoDBClientFactory;
use Shared\Infrastructure\RabbitMQ\RabbitMQMessageProducerFactory;

return [
    'service_manager' => [
        'abstract_factories' => [
            ProjectionAbstractFactory::class,
        ],
        'invokables'         => [

        ],
        'factories'          => [
            CommandQueryService::class              => CommandQueryServiceFactory::class,
            JsonPatchResolver::class                => JsonPatchResolverFactory::class,

            // Mongo
            MongoDBClientInterface::class           => MongoDBClientFactory::class,

            // RabbitMQ
            AMQPStreamConnection::class             => RabbitMQConnectionFactory::class,
            RabbitMQMessageProducerInterface::class => RabbitMQMessageProducerFactory::class,
        ],
    ],
    'doctrine'        => [
        'driver' => [
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            __NAMESPACE__ . '_driver' => [
                'class' => SimplifiedXmlDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/Shared/Infrastructure/Doctrine/Mapping' => 'Shared\Application\ValueObject',
                ],
            ],

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default'             => [
                'drivers' => [
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    __NAMESPACE__ . '\Application\ValueObject' => __NAMESPACE__ . '_driver',
                ],
            ],
        ],
    ],
];