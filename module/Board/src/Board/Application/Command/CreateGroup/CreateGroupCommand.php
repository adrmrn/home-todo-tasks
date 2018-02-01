<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 29.01.18
 * Time: 19:36
 */

namespace Board\Application\Command\CreateGroup;


use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Shared\Application\CommandQuery\CommandInterface;

class CreateGroupCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $creatorId;

    /**
     * CreateGroupCommand constructor.
     *
     * @param string $name
     * @param string $creatorId
     */
    public function __construct(string $name, string $creatorId)
    {
        $this->name      = $name;
        $this->creatorId = $creatorId;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return \Ramsey\Uuid\UuidInterface
     */
    public function creatorId(): UuidInterface
    {
        return Uuid::fromString($this->creatorId);
    }
}