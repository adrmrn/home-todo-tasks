<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 29.01.18
 * Time: 21:15
 */

namespace Board\Domain\Model\Membership;


use Board\Domain\Model\Group;
use Ramsey\Uuid\UuidInterface;

class Membership
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     */
    private $userId;
    /**
     * @var \Board\Domain\Model\Membership\Role
     */
    private $role;
    /**
     * @var \Board\Domain\Model\Group
     */
    private $group;

    /**
     * Membership constructor.
     *
     * @param \Board\Domain\Model\Group           $group
     * @param \Ramsey\Uuid\UuidInterface          $userId
     * @param \Board\Domain\Model\Membership\Role $role
     */
    public function __construct(Group $group, UuidInterface $userId, Role $role)
    {
        $this->userId = $userId;
        $this->role   = $role;
        $this->group  = $group;
    }

    public function id(): UuidInterface
    {
        return $this->userId;
    }

    public function role(): Role
    {
        return $this->role;
    }
}