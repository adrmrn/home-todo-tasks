<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 08.02.18
 * Time: 22:19
 */

namespace Board\Application\Service;


use Board\Application\Event\EventName;
use Board\Application\Event\Publisher\EventPublisher;
use Board\Application\Persistence\Repository\GroupRepositoryInterface;
use Board\Application\Persistence\Service\GroupMembershipManagerPermissionServiceInterface;
use Board\Domain\Model\Membership\Membership;
use Board\Domain\Model\Membership\Role as MembershipRole;
use Ramsey\Uuid\UuidInterface;
use Shared\Application\Persistence\DataSource\UserDataSourceInterface;

class GroupMembershipManagerService
{
    /**
     * @var \Board\Application\Persistence\Repository\GroupRepositoryInterface
     */
    private $groupRepository;
    /**
     * @var \Board\Application\Persistence\Service\GroupMembershipManagerPermissionServiceInterface
     */
    private $membershipManagerPermissionService;
    /**
     * @var \Shared\Application\Persistence\DataSource\UserDataSourceInterface
     */
    private $userDataSource;

    /**
     * GroupMembershipManagerService constructor.
     *
     * @param \Board\Application\Persistence\Repository\GroupRepositoryInterface                      $groupRepository
     * @param \Board\Application\Persistence\Service\GroupMembershipManagerPermissionServiceInterface $membershipManagerPermissionService
     * @param \Shared\Application\Persistence\DataSource\UserDataSourceInterface                      $userDataSource
     */
    public function __construct(GroupRepositoryInterface $groupRepository,
                                GroupMembershipManagerPermissionServiceInterface $membershipManagerPermissionService,
                                UserDataSourceInterface $userDataSource)
    {
        $this->groupRepository                    = $groupRepository;
        $this->membershipManagerPermissionService = $membershipManagerPermissionService;
        $this->userDataSource                     = $userDataSource;
    }

    public function addMembershipToGroup(UuidInterface $groupId, UuidInterface $userId, string $role,
                                         UuidInterface $creatorId): void
    {
        $group = $this->groupRepository->fetchById($groupId);

        if (FALSE === $this->membershipManagerPermissionService->canUserAddNewMembershipToGroup($creatorId, $group)) {
            throw new \RuntimeException('User can not add new Membership to Group', 403);
        }

        if (FALSE === $this->userDataSource->exists($userId)) {
            throw new \RuntimeException('User does not found', 404);
        }

        if (TRUE === $group->hasMembership($userId)) {
            throw new \RuntimeException('Membership exists', 409);
        }

        $membership = new Membership(
            $group,
            $userId,
            MembershipRole::get($role)
        );
        $group->addMembership($membership);

        $this->groupRepository->store($group);

        EventPublisher::publish(
            EventName::GROUP_MEMBERSHIP_ADDED,
            $group->id(),
            [
                'id'          => $group->id()->toString(),
                'memberships' => [
                    [
                        'user_id' => $membership->id()->toString(),
                        'role'    => $membership->role()->getValue(),
                    ],
                ],
            ]
        );
    }
}