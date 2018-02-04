<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 03.02.18
 * Time: 11:12
 */

namespace Board\Application\Query\FetchGroupById;


use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Shared\Application\CommandQuery\QueryInterface;

class FetchGroupByIdQuery implements QueryInterface
{
    /**
     * @var string
     */
    private $groupId;

    /**
     * FetchGroupByIdQuery constructor.
     *
     * @param string $groupId
     */
    public function __construct(string $groupId)
    {
        if (FALSE === Uuid::isValid($groupId)) {
            throw new \RuntimeException('Group ID is invalid', 422);
        }

        $this->groupId = $groupId;
    }

    public function groupId(): UuidInterface
    {
        return Uuid::fromString($this->groupId);
    }
}