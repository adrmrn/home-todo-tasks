<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 15.02.18
 * Time: 21:48
 */

namespace Board\Infrastructure\Repository\Mock;


use Board\Application\Persistence\Repository\BoardRepositoryInterface;
use Board\Domain\Model\Board;
use Ramsey\Uuid\UuidInterface;

class InMemoryBoardRepositoryMock implements BoardRepositoryInterface
{
    /**
     * @var Board[]
     */
    private $storage = [];

    /**
     * InMemoryBoardRepositoryMock constructor.
     *
     * @param \Board\Domain\Model\Board[] ...$boards
     */
    public function __construct(Board ...$boards)
    {
        foreach ($boards as $board) {
            $this->store($board);
        }
    }

    /**
     * @param \Board\Domain\Model\Board $board
     *
     * @return void
     */
    public function store(Board $board): void
    {
        $this->storage[$board->id()->toString()] = $board;
    }

    /**
     * @param \Ramsey\Uuid\UuidInterface $id
     *
     * @return \Board\Domain\Model\Board
     */
    public function fetchById(UuidInterface $id): Board
    {
        if (FALSE === isset($this->storage[$id->toString()])) {
            throw new \RuntimeException('Board not found', 404);
        }

        return $this->storage[$id->toString()];
    }
}