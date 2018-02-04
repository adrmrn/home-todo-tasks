<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 23.11.17
 * Time: 22:02
 */

namespace User\Application\Command\ChangeUserName;


use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Shared\Application\CommandQuery\CommandInterface;

class ChangeUserNameCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $userId;
    /**
     * @var string
     */
    private $name;

    /**
     * ChangeUserNameCommand constructor.
     *
     * @param string $userId
     * @param string $name
     */
    public function __construct(string $userId, string $name)
    {
        $this->userId = $userId;
        $this->name   = $name;
    }

    public function userId(): UuidInterface
    {
        return Uuid::fromString($this->userId);
    }

    public function name(): string
    {
        return $this->name;
    }
}