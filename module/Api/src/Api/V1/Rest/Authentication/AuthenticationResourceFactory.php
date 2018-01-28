<?php
namespace Api\V1\Rest\Authentication;

use League\Tactician\CommandBus;
use Shared\Application\Service\CommandQueryService;

class AuthenticationResourceFactory
{
    public function __invoke($services)
    {
        return new AuthenticationResource(
            $services->get(CommandQueryService::class),
            $services->get(CommandBus::class)
        );
    }
}