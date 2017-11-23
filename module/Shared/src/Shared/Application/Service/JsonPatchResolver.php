<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 23.11.17
 * Time: 21:12
 */

namespace Shared\Application\Service;


use League\Tactician\CommandBus;

class JsonPatchResolver
{
    /**
     * Based on RFC6902
     *
     * Operation objects MUST have exactly one "op" member, whose value
     * indicates the operation to perform.  Its value MUST be one of "add",
     * "remove", "replace", "move", "copy", or "test"; other values are
     * errors.
     */
    const ALLOWED_OPERATIONS = ['add', 'remove', 'replace', 'move', 'copy', 'test'];
    /**
     * @var array
     */
    private $actionsList = [];
    /**
     * @var \Shared\Application\Service\CommandQueryService
     */
    private $commandQueryService;
    /**
     * @var \League\Tactician\CommandBus
     */
    private $commandBus;

    /**
     * JsonPatchResolver constructor.
     *
     * @param \Shared\Application\Service\CommandQueryService $commandQueryService
     * @param \League\Tactician\CommandBus                    $commandBus
     */
    public function __construct(CommandQueryService $commandQueryService, CommandBus $commandBus)
    {
        $this->commandQueryService = $commandQueryService;
        $this->commandBus          = $commandBus;
    }

    /**
     * @param string $operation
     * @param string $path
     * @param string $commandClassName
     * @param array  $allowedValues
     */
    public function addAction(string $operation, string $path, string $commandClassName, array $allowedValues = [])
    {
        if (FALSE === $this->isActionValid($operation, $path, $commandClassName)) {
            throw new \RuntimeException('Provided action seems to be malformed.', 501);
        }

        $this->actionsList[$path][$operation] = [
            'command' => $commandClassName,
            'value'   => $allowedValues,
        ];
    }

    public function resolveActionsForRequest(array $request, string $entityId)
    {
        if (FALSE === isset($request['actions'])) {
            throw new \RuntimeException('Provided PATCH data seems to be malformed. Provide "actions" array', 501);
        }

        foreach ($request['actions'] as $action) {
            $this->executeAction($action, $entityId);
        }
    }

    private function executeAction(array $actionData, string $entityId)
    {
        if (FALSE === $this->isRequestValid($actionData)) {
            throw new \RuntimeException('Provided PATCH request seems to be invalid. Provide "op", "path" and "value"', 422);
        }

        if (FALSE === $this->hasAction($actionData['op'], $actionData['path'])) {
            throw new \RuntimeException('Action is not configured.', 501);
        }

        $action = $this->actionsList[$actionData['path']][$actionData['op']];

        $actionData['value']['id'] = $entityId;
        $command                   = $this->commandQueryService->prepareCommandQuery(
            $action['command'],
            $this->prepareArgumentsForPatch($action['value'], $actionData['value'])
        );

        $this->commandBus->handle($command);
    }

    /**
     * @param string $operation
     * @param string $path
     * @param string $commandClass
     *
     * @return bool
     */
    private function isActionValid(string $operation, string $path, string $commandClass): bool
    {
        if (TRUE === empty($operation) && TRUE === empty($path)) {
            return FALSE;
        }

        if (FALSE === in_array($operation, self::ALLOWED_OPERATIONS)) {
            return FALSE;
        }

        return TRUE === class_exists($commandClass);
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    private function isRequestValid(array $data): bool
    {
        return (TRUE === isset($data['op'], $data['path'], $data['value']));
    }

    /**
     * @param string $operation
     * @param string $path
     *
     * @return bool
     */
    private function hasAction(string $operation, string $path): bool
    {
        return TRUE === isset($this->actionsList[$path][$operation]);
    }

    /**
     * @param array $allowedValues
     * @param array $rawValues
     *
     * @return array
     */
    private function prepareArgumentsForPatch(array $allowedValues, array $rawValues): array
    {
        $arguments = [];

        foreach ($allowedValues as $allowedValueName) {
            $arguments[$allowedValueName] = $rawValues[$allowedValueName];
        }

        return $arguments;
    }
}