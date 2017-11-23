<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 09.11.17
 * Time: 09:25
 */

use Shared\Application\Service\CommandQueryService;
use Shared\Application\Service\CommandQueryServiceFactory;
use Shared\Application\Service\JsonPatchResolver;
use Shared\Application\Service\JsonPatchResolverFactory;
use Shared\Infrastructure\Dao\DaoAbstractFactory;

return [
    'service_manager' => [
        'abstract_factories' => [
            DaoAbstractFactory::class,
        ],
        'invokables'         => [

        ],
        'factories'          => [
            CommandQueryService::class => CommandQueryServiceFactory::class,
            JsonPatchResolver::class   => JsonPatchResolverFactory::class,
        ],
    ],
];