<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 12.02.18
 * Time: 18:53
 */

namespace Board\Application\Query\FetchBoardsBySpecification;


use Board\Application\Paginator\BoardCollectionAdapter;
use Board\Infrastructure\DataSource\Specification\BoardSpecification;
use Shared\Application\CommandQuery\CommandQueryInterface;
use Shared\Application\CommandQuery\Handler\QueryHandlerInterface;
use Shared\Application\Persistence\DataSource\BoardDataSourceInterface;

class FetchBoardsBySpecificationQueryHandler implements QueryHandlerInterface
{
    /**
     * @var \Shared\Application\Persistence\DataSource\BoardDataSourceInterface
     */
    private $boardDataSource;

    /**
     * FetchBoardsBySpecificationQueryHandler constructor.
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
        /** @var FetchBoardsBySpecificationQuery $commandQuery */
        $specification = new BoardSpecification($commandQuery->params());

        return new BoardCollectionAdapter(
            $this->boardDataSource,
            $specification
        );
    }
}