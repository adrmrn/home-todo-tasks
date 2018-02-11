<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 11.02.18
 * Time: 14:45
 */

namespace Board\Application\Persistence\Repository;


use Board\Domain\Model\Board;
use Ramsey\Uuid\UuidInterface;

interface BoardRepositoryInterface
{
    /**
     * @param \Board\Domain\Model\Board $board
     *
     * @return void
     */
    public function store(Board $board): void;

    /**
     * @param \Ramsey\Uuid\UuidInterface $id
     *
     * @return \Board\Domain\Model\Board
     */
    public function fetchById(UuidInterface $id): Board;
}