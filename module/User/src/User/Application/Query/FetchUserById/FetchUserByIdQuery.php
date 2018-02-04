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
        if (FALSE === Uuid::isValid($userId)) {
            throw new \RuntimeException('User ID is invalid', 422);
        }

        $this->userId = $userId;
    }

    public function userId(): UuidInterface
    {
        return Uuid::fromString($this->userId);
    }
}