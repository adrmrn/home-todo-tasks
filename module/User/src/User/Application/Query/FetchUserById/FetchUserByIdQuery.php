<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 14.01.18
 * Time: 21:09
 */

namespace User\Application\Query\FetchUserById;


use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Shared\Application\CommandQuery\QueryInterface;

class FetchUserByIdQuery implements QueryInterface
{
    /**
     * @var string
     */
    private $userId;

    /**
     * FetchUserByIdQuery constructor.
     *
     * @param string $userId
     */
    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return \Ramsey\Uuid\UuidInterface
     */
    public function userId(): UuidInterface
    {
        return Uuid::fromString($this->userId);
    }
}