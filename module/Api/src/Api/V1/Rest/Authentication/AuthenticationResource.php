<?php

namespace Api\V1\Rest\Authentication;

use Auth\Application\Command\AuthenticateUser\AuthenticateUserCommand;
use Auth\Application\EventManager\ApplicationEventName;
use League\Tactician\CommandBus;
use Shared\Application\Service\CommandQueryService;
use Zend\EventManager\EventInterface;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class AuthenticationResource extends AbstractResourceListener
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
     * AuthenticationResource constructor.
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

        $token = NULL;
        $this->attachTokenHandler($token);

        $command = $this->commandQueryService->prepareCommandQuery(
            AuthenticateUserCommand::class,
            [
                'email'    => $data['email'] ?? '',
                'password' => $data['password'] ?? '',
            ]
        );
        $this->commandBus->handle($command);

        return new AuthenticationEntity($token);
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

    /**
     * @param $token
     *
     * @return mixed
     */
    private function attachTokenHandler(&$token)
    {
        /** @var \Zend\EventManager\SharedEventManagerInterface $eventManager */
        $eventManager = $this->getEvent()->getTarget()->getEventManager()->getSharedManager();
        $eventManager->attach(
            '*',
            ApplicationEventName::TOKEN_VIEW_CREATED,
            function (EventInterface $event) use (&$token) {
                $token = $event->getParam('token');
            }
        );

        return $token;
    }
}
