<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 29.01.18
 * Time: 19:44
 */

namespace Board\Application\Service;


use Board\Application\Persistence\GroupRepositoryInterface;
use Board\Domain\Model\Group;

class GroupCreatorService
{
    /**
     * @var \Board\Application\Persistence\GroupRepositoryInterface
     */
    private $groupRepository;

    /**
     * GroupCreatorService constructor.
     *
     * @param \Board\Application\Persistence\GroupRepositoryInterface $groupRepository
     */
    public function __construct(GroupRepositoryInterface $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    /**
     * @param string $name
     */
    public function createGroup(string $name)
    {
        // TODO: add automatically first member
        $group = new Group($name);

        $this->groupRepository->store($group);

        // TODO: send event
    }
}