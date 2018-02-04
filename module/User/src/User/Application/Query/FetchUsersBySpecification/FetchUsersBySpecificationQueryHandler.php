<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 04.02.18
 * Time: 11:56
 */

namespace User\Application\Query\FetchUsersBySpecification;


use Shared\Application\CommandQuery\CommandQueryInterface;
use Shared\Application\CommandQuery\Handler\QueryHandlerInterface;
use Shared\Application\Persistence\DataSource\UserDataSourceInterface;
use User\Application\Paginator\UserCollectionAdapter;
use User\Infrastructure\DataSource\Specification\UserSpecification;

class FetchUsersBySpecificationQueryHandler implements QueryHandlerInterface
{
    /**
     * @var \Shared\Application\Persistence\DataSource\UserDataSourceInterface
     */
    private $userDataSource;

    /**
     * FetchUsersBySpecificationQueryHandler constructor.
     *
     * @param \Shared\Application\Persistence\DataSource\UserDataSourceInterface $userDataSource
     */
    public function __construct(UserDataSourceInterface $userDataSource)
    {
        $this->userDataSource = $userDataSource;
    }

    /**
     * @param \Shared\Application\CommandQuery\CommandQueryInterface $commandQuery
     *
     * @return mixed
     */
    public function handle(CommandQueryInterface $commandQuery)
    {
        /** @var FetchUsersBySpecificationQuery $commandQuery */
        $specification = new UserSpecification($commandQuery->params());

        return new UserCollectionAdapter(
            $this->userDataSource,
            $specification
        );
    }
}