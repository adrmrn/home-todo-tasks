<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 04.02.18
 * Time: 13:11
 */

namespace User\Application\Paginator;


use Shared\Application\Persistence\DataSource\UserDataSourceInterface;
use User\Infrastructure\DataSource\Specification\UserSpecification;
use Zend\Paginator\Adapter\AdapterInterface;

class UserCollectionAdapter implements AdapterInterface
{
    /**
     * @var \Shared\Application\Persistence\DataSource\UserDataSourceInterface
     */
    private $userDataSource;
    /**
     * @var \User\Infrastructure\DataSource\Specification\UserSpecification
     */
    private $specification;

    /**
     * UserCollectionAdapter constructor.
     *
     * @param \Shared\Application\Persistence\DataSource\UserDataSourceInterface $userDataSource
     * @param \User\Infrastructure\DataSource\Specification\UserSpecification    $specification
     */
    public function __construct(UserDataSourceInterface $userDataSource, UserSpecification $specification)
    {
        $this->userDataSource = $userDataSource;
        $this->specification  = $specification;
    }

    /**
     * Returns a collection of items for a page.
     *
     * @param  int $offset           Page offset
     * @param  int $itemCountPerPage Number of items per page
     *
     * @return array
     */
    public function getItems($offset, $itemCountPerPage)
    {
        $specification = clone $this->specification;

        $specification->setOffset($offset);
        $specification->setLimit($itemCountPerPage);

        return $this->userDataSource->fetchBySpecification($specification);
    }

    /**
     * Count elements of an object
     * @link  http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return $this->userDataSource->countBySpecification($this->specification);
    }
}