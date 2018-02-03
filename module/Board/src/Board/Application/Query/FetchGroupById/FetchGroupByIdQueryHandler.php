<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 03.02.18
 * Time: 11:13
 */

namespace Board\Application\Query\FetchGroupById;


use Shared\Application\CommandQuery\CommandQueryHandler;
use Shared\Application\CommandQuery\CommandQueryInterface;
use Shared\Application\Persistence\DataSource\GroupDataSourceInterface;

class FetchGroupByIdQueryHandler implements CommandQueryHandler
{
    /**
     * @var \Shared\Application\Persistence\DataSource\GroupDataSourceInterface
     */
    private $groupDataSource;

    /**
     * FetchGroupByIdQueryHandler constructor.
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
        /** @var FetchGroupByIdQuery $commandQuery */
        return $this->groupDataSource->fetchById($commandQuery->groupId());
    }
}