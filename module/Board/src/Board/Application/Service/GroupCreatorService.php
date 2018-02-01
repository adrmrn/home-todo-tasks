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
use Board\Domain\Model\Membership\Membership;
use Board\Domain\Model\Membership\Role as MembershipRole;
use Ramsey\Uuid\UuidInterface;

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
     * @param string                     $name
     * @param \Ramsey\Uuid\UuidInterface $creatorId
     */
    public function createGroup(string $name, UuidInterface $creatorId)
    {
        $group = new Group($name);

        $membership = new Membership($group, $creatorId, MembershipRole::get(MembershipRole::ADMIN));
        $group->addMembership($membership);

        $this->groupRepository->store($group);

        // TODO: send event
    }
}