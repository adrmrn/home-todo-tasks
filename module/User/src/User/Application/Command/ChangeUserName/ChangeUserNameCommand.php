<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 23.11.17
 * Time: 22:02
 */

namespace User\Application\Command\ChangeUserName;


use Shared\Application\CommandQuery\CommandQueryInterface;

class ChangeUserNameCommand implements CommandQueryInterface
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

    /**
     * @return string
     */
    public function userId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }
}