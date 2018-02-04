<?php

namespace Api\V1\Rest\Group;

use Board\Application\Command\CreateGroup\CreateGroupCommand;
use Board\Application\EventManager\ApplicationEventName;
use Board\Application\Query\FetchGroupById\FetchGroupByIdQuery;
use Board\Application\Query\FetchGroupsBySpecification\FetchGroupsBySpecificationQuery;
use League\Tactician\CommandBus;
use Shared\Application\Service\CommandQueryService;
use Shared\Application\Service\JsonPatchResolver;
use Zend\EventManager\EventInterface;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class GroupResource extends AbstractResourceListener
{
    /**
     * @var \Shared\Application\Service\CommandQueryService
     */
    private $commandQueryService;
    /**
     * @var \League\Tactician\CommandBus
     */
    private $commandBus;
    /**
     * @var \Shared\Application\Service\JsonPatchResolver
     */
    private $jsonPatchResolver;

    /**
     * GroupResource constructor.
     *
     * @param \Shared\Application\Service\CommandQueryService $commandQueryService
     * @param \League\Tactician\CommandBus                    $commandBus
     * @param \Shared\Application\Service\JsonPatchResolver   $jsonPatchResolver
     */
    public function __construct(CommandQueryService $commandQueryService, CommandBus $commandBus,
                                JsonPatchResolver $jsonPatchResolver)
    {
        $this->commandQueryService = $commandQueryService;
        $this->commandBus          = $commandBus;
        $this->jsonPatchResolver   = $jsonPatchResolver;
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

        $entityId = NULL;
        $this->attachIdHandler($entityId);

        $command = $this->commandQueryService->prepareCommandQuery(
            CreateGroupCommand::class,
            [
                'name'       => $data['name'] ?? '',
                'creator_id' => $this->getIdentity()->getAuthenticationIdentity(),
            ]
        );
        $this->commandBus->handle($command);

        return $this->fetch($entityId);
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
        $query = $this->commandQueryService->prepareCommandQuery(
            FetchGroupByIdQuery::class,
            [
                'id' => (string)$id,
            ]
        );
        $user  = $this->commandBus->handle($query);

        return new GroupEntity($user);
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
        $query  = $this->commandQueryService->prepareCommandQuery(
            FetchGroupsBySpecificationQuery::class,
            [
                'params' => (array)$params,
            ]
        );
        $groups = $this->commandBus->handle($query);

        return new GroupCollection($groups);
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

    /**
     * @param $id
     *
     * @return mixed
     */
    private function attachIdHandler(&$id)
    {
        /** @var \Zend\EventManager\SharedEventManagerInterface $eventManager */
        $eventManager = $this->getEvent()->getTarget()->getEventManager()->getSharedManager();
        $eventManager->attach(
            '*',
            ApplicationEventName::GROUP_VIEW_CREATED,
            function (EventInterface $event) use (&$id) {
                $id = $event->getParam('id');
            }
        );

        return $id;
    }
}
