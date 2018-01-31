<?php
namespace Api\V1\Rest\Group;

use League\Tactician\CommandBus;
use Shared\Application\Service\CommandQueryService;
use Shared\Application\Service\JsonPatchResolver;

class GroupResourceFactory
{
    public function __invoke($services)
    {
        return new GroupResource(
            $services->get(CommandQueryService::class),
            $services->get(CommandBus::class),
            $services->get(JsonPatchResolver::class)
        );
    }
}
