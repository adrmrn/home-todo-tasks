<?php

namespace Api\V1\Rest\Group;

use Shared\Application\Persistence\Model\GroupViewInterface;
use Zend\Filter\Callback;
use Zend\Paginator\Paginator;

class GroupCollection extends Paginator
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
                function (array $groups) {
                    return array_map(function (GroupViewInterface $group) {
                        return new GroupEntity($group);
                    }, $groups);
                }
            )
        );
    }
}