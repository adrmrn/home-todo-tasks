<?php

namespace Api\V1\Rest\Group;

use Shared\Application\Persistence\Model\GroupViewInterface;

class GroupEntity extends \ArrayObject
{
    /**
     * @var \Shared\Application\Persistence\Model\GroupViewInterface
     */
    private $group;

    /**
     * GroupEntity constructor.
     *
     * @param \Shared\Application\Persistence\Model\GroupViewInterface $group
     */
    public function __construct(GroupViewInterface $group)
    {
        $this->group = $group;
    }

    /**
     * @return array
     */
    public function getArrayCopy(): array
    {
        return [
            'id'          => $this->group->id(),
            'name'        => $this->group->name(),
            'memberships' => $this->group->memberships(),
        ];
    }
}
