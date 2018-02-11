<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 11.02.18
 * Time: 21:39
 */

namespace Board\Application\Query\FetchBoardById;


use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Shared\Application\CommandQuery\QueryInterface;

class FetchBoardByIdQuery implements QueryInterface
{
    /**
     * @var string
     */
    private $boardId;

    /**
     * FetchBoardByIdQuery constructor.
     *
     * @param string $boardId
     */
    public function __construct(string $boardId)
    {
        if (FALSE === Uuid::isValid($boardId)) {
            throw new \RuntimeException('Board ID is invalid', 422);
        }

        $this->boardId = $boardId;
    }

    public function boardId(): UuidInterface
    {
        return Uuid::fromString($this->boardId);
    }
}