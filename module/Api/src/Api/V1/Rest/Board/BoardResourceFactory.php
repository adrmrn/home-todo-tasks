<?php
namespace Api\V1\Rest\Board;

use League\Tactician\CommandBus;
use Shared\Application\Service\CommandQueryService;

class BoardResourceFactory
{
    public function __invoke($services)
    {
        return new BoardResource(
            $services->get(CommandQueryService::class),
            $services->get(CommandBus::class)
        );
    }
}