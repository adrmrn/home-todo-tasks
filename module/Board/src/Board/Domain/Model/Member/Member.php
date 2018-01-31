<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 29.01.18
 * Time: 21:15
 */

namespace Board\Domain\Model\Member;


use Ramsey\Uuid\UuidInterface;

class Member
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     */
    private $id;
    /**
     * @var \Board\Domain\Model\Member\Role
     */
    private $role;

    /**
     * Member constructor.
     *
     * @param \Ramsey\Uuid\UuidInterface      $id
     * @param \Board\Domain\Model\Member\Role $role
     */
    public function __construct(UuidInterface $id, Role $role)
    {
        $this->id   = $id;
        $this->role = $role;
    }

    /**
     * @return \Ramsey\Uuid\UuidInterface
     */
    public function id(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return \Board\Domain\Model\Member\Role
     */
    public function role(): Role
    {
        return $this->role;
    }
}