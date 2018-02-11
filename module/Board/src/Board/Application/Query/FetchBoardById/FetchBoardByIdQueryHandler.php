<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 11.02.18
 * Time: 21:39
 */

namespace Board\Application\Query\FetchBoardById;


use Shared\Application\CommandQuery\CommandQueryInterface;
use Shared\Application\CommandQuery\Handler\QueryHandlerInterface;
use Shared\Application\Persistence\DataSource\BoardDataSourceInterface;

class FetchBoardByIdQueryHandler implements QueryHandlerInterface
{
    /**
     * @var \Shared\Application\Persistence\DataSource\BoardDataSourceInterface
     */
    private $boardDataSource;

    /**
     * FetchBoardByIdQueryHandler constructor.
     *
     * @param \Shared\Application\Persistence\DataSource\BoardDataSourceInterface $boardDataSource
     */
    public function __construct(BoardDataSourceInterface $boardDataSource)
    {
        $this->boardDataSource = $boardDataSource;
    }

    /**
     * @param \Shared\Application\CommandQuery\CommandQueryInterface $commandQuery
     *
     * @return mixed
     */
    public function handle(CommandQueryInterface $commandQuery)
    {
        /** @var FetchBoardByIdQuery $commandQuery */
        return $this->boardDataSource->fetchById($commandQuery->boardId());
    }
}