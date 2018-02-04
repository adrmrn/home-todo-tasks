<?php

namespace Api\V1\Rest\User;

use Shared\Application\Persistence\Model\UserViewInterface;
use Zend\Filter\Callback;
use Zend\Paginator\Paginator;

class UserCollection extends Paginator
{
    /**
     * GroupCollection constructor.
     *
     * @param \Zend\Paginator\Adapter\AdapterInterface|\Zend\Paginator\AdapterAggregateInterface $adapter
     */
    public function __construct($adapter)
    {
        parent::__construct($adapter);

        $this->setFilter(
            new Callback(
                function (array $users) {
                    return array_map(function (UserViewInterface $user) {
                        return new UserEntity($user);
                    }, $users);
                }
            )
        );
    }
}