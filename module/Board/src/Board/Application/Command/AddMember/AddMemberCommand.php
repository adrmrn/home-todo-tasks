<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 07.02.18
 * Time: 21:00
 */

namespace Board\Application\Command\AddMember;


use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Shared\Application\CommandQuery\CommandInterface;

class AddMemberCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $groupId;
    /**
     * @var string
     */
    private $userId;
    /**
     * @var string
     */
    private $role;
    /**
     * @var string
     */
    private $creatorId;

    /**
     * AddMemberCommand constructor.
     *
     * @param string $groupId
     * @param string $userId
     * @param string $role
     * @param string $creatorId
     */
    public function __construct(string $groupId, string $userId, string $role, string $creatorId)
    {
        $this->groupId   = $groupId;
        $this->userId    = $userId;
        $this->role      = $role;
        $this->creatorId = $creatorId;
    }

    public function groupId(): UuidInterface
    {
        return Uuid::fromString($this->groupId);
    }

    public function userId(): UuidInterface
    {
        return Uuid::fromString($this->userId);
    }

    public function role(): string
    {
        return $this->role;
    }

    public function creatorId(): UuidInterface
    {
        return Uuid::fromString($this->creatorId);
    }
}