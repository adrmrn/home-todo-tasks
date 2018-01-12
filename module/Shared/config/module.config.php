<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 09.11.17
 * Time: 09:25
 */

namespace Shared;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use Shared\Application\Factory\RabbitMQConnectionFactory;
use Shared\Application\Persistence\MongoDB\MongoDBClientInterface;
use Shared\Application\Service\CommandQueryService;
use Shared\Application\Service\CommandQueryServiceFactory;
use Shared\Application\Service\JsonPatchResolver;
use Shared\Application\Service\JsonPatchResolverFactory;
use Shared\Infrastructure\Dao\DaoAbstractFactory;
use Shared\Infrastructure\MongoDB\MongoDBClientFactory;
use Shared\Infrastructure\RabbitMQ\RabbitMQMessageProducer;
use Shared\Infrastructure\RabbitMQ\RabbitMQMessageProducerFactory;

return [
    'service_manager' => [
        'abstract_factories' => [
            DaoAbstractFactory::class,
        ],
        'invokables'         => [

        ],
        'factories'          => [
            CommandQueryService::class     => CommandQueryServiceFactory::class,
            JsonPatchResolver::class       => JsonPatchResolverFactory::class,

            // Mongo
            MongoDBClientInterface::class  => MongoDBClientFactory::class,

            // RabbitMQ
            AMQPStreamConnection::class    => RabbitMQConnectionFactory::class,
            RabbitMQMessageProducer::class => RabbitMQMessageProducerFactory::class,
        ],
    ],
];