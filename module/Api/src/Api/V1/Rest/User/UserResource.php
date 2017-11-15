<?php

namespace Api\V1\Rest\User;

use League\Tactician\CommandBus;
use Shared\Application\Service\CommandQueryService;
use User\Application\Command\CreateUser\CreateUserCommand;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class UserResource extends AbstractResourceListener
{
    /**
     * @var \League\Tactician\CommandBus
     */
    private $commandBus;
    /**
     * @var \Shared\Application\Service\CommandQueryService
     */
    private $commandQueryService;

    /**
     * UserResource constructor.
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
     * Create a resource
     *
     * @param  mixed $data
     *
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $data = (array)$data;

        $command = $this->commandQueryService->prepareCommandQuery(
            CreateUserCommand::class,
            [
                'name'     => $data['name'] ?? '',
                'password' => $data['password'] ?? '',
                'email'    => $data['email'] ?? '',
            ]
        );
        $this->commandBus->handle($command);

        return ['user' => 'ok'];
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     *
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     *
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     *
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return new ApiProblem(405, 'The GET method has not been defined for individual resources');
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     *
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return new ApiProblem(405, 'The GET method has not been defined for collections');
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     *
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     *
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     *
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     *
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }
}
