<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 03.02.18
 * Time: 16:51
 */

namespace Board\Application\Query\FetchGroupsBySpecification;


use Board\Application\Paginator\GroupCollectionAdapter;
use Board\Infrastructure\DataSource\Specification\GroupSpecification;
use Shared\Application\CommandQuery\CommandQueryHandler;
use Shared\Application\CommandQuery\CommandQueryInterface;
use Shared\Application\Persistence\DataSource\GroupDataSourceInterface;

class FetchGroupsBySpecificationQueryHandler implements CommandQueryHandler
{
    /**
     * @var \Shared\Application\Persistence\DataSource\GroupDataSourceInterface
     */
    private $groupDataSource;

    /**
     * FetchGroupsBySpecificationQueryHandler constructor.
     *
     * @param \Shared\Application\Persistence\DataSource\GroupDataSourceInterface $groupDataSource
     */
    public function __construct(GroupDataSourceInterface $groupDataSource)
    {
        $this->groupDataSource = $groupDataSource;
    }

    /**
     * @param \Shared\Application\CommandQuery\CommandQueryInterface $commandQuery
     *
     * @return mixed
     */
    public function handle(CommandQueryInterface $commandQuery)
    {
        /** @var FetchGroupsBySpecificationQuery $commandQuery */
        $specification = new GroupSpecification($commandQuery->params());

        return new GroupCollectionAdapter(
            $this->groupDataSource,
            $specification
        );
    }
}