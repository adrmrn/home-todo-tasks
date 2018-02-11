<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 11.02.18
 * Time: 15:38
 */

namespace Board\Application\Command\CreateBoard;


use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Shared\Application\CommandQuery\CommandInterface;

class CreateBoardCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $groupId;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $creatorId;

    /**
     * CreateBoardCommand constructor.
     *
     * @param string $groupId
     * @param string $name
     * @param string $creatorId
     */
    public function __construct(string $groupId, string $name, string $creatorId)
    {
        $this->groupId   = $groupId;
        $this->name      = $name;
        $this->creatorId = $creatorId;
    }

    public function groupId(): UuidInterface
    {
        return Uuid::fromString($this->groupId);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function creatorId(): UuidInterface
    {
        return Uuid::fromString($this->creatorId);
    }
}