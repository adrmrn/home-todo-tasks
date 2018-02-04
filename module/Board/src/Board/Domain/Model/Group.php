<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 29.01.18
 * Time: 21:09
 */

namespace Board\Domain\Model;


use Board\Domain\Model\Membership\Membership;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Group
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|\Board\Domain\Model\Membership\Membership[]
     */
    private $memberships;

    /**
     * Group constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->id          = Uuid::uuid4();
        $this->name        = $name;
        $this->memberships = new ArrayCollection();
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function addMembership(Membership $membership): void
    {
        $this->memberships->add($membership);
    }
}