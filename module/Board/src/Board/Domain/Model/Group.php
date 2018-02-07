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

    public function removeMembership(UuidInterface $userId): void
    {
        $this->memberships->removeElement(
            $this->membership($userId)
        );
    }

    /**
     * @return Membership[]
     */
    public function memberships(): array
    {
        return $this->memberships->toArray();
    }

    public function membership(UuidInterface $userId): Membership
    {
        foreach ($this->memberships as $key => $membership) {
            if ($membership->id()->equals($userId)) {
                return $membership;
            }
        }

        throw new \DomainException(sprintf('Membership does not exist with user_id: %s', $userId->toString()), 404);
    }

    public function hasMembership(UuidInterface $userId): bool
    {
        foreach ($this->memberships as $key => $membership) {
            if ($membership->id()->equals($userId)) {
                return TRUE;
            }
        }

        return FALSE;
    }
}