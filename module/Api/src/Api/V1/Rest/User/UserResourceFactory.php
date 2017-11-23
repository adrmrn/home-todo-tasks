<?php
namespace Api\V1\Rest\User;

use League\Tactician\CommandBus;
use Shared\Application\Service\CommandQueryService;
use Shared\Application\Service\JsonPatchResolver;

class UserResourceFactory
{
    public function __invoke($services)
    {
        return new UserResource(
            $services->get(CommandQueryService::class),
            $services->get(CommandBus::class),
            $services->get(JsonPatchResolver::class)
        );
    }
}
