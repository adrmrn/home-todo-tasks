<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 14.01.18
 * Time: 21:09
 */

namespace User\Application\Query\FetchUserById;


use Shared\Application\CommandQuery\CommandQueryInterface;
use Shared\Application\CommandQuery\Handler\QueryHandlerInterface;
use Shared\Application\Persistence\DataSource\UserDataSourceInterface;

class FetchUserByIdQueryHandler implements QueryHandlerInterface
{
    /**
     * @var \Shared\Application\Persistence\DataSource\UserDataSourceInterface
     */
    private $userDataSource;

    /**
     * FetchUserByIdQueryHandler constructor.
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
        /** @var FetchUserByIdQuery $commandQuery */
        return $this->userDataSource->fetchById($commandQuery->userId());
    }
}