<?php

namespace Api\V1\Rest\Board;

use Shared\Application\Persistence\Model\BoardViewInterface;

class BoardEntity extends \ArrayObject
{
    /**
     * @var \Shared\Application\Persistence\Model\GroupViewInterface
     */
    private $board;

    /**
     * BoardEntity constructor.
     *
     * @param \Shared\Application\Persistence\Model\BoardViewInterface $board
     */
    public function __construct(BoardViewInterface $board)
    {
        $this->board = $board;
    }

    public function getArrayCopy(): array
    {
        return [
            'id'    => $this->board->id(),
            'name'  => $this->board->name(),
            'group' => $this->board->group(),
            'tasks' => $this->board->tasks(),
        ];
    }
}