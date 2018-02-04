<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 03.02.18
 * Time: 23:17
 */

namespace Board\Application\Paginator;


use Board\Infrastructure\DataSource\Specification\GroupSpecification;
use Shared\Application\Persistence\DataSource\GroupDataSourceInterface;
use Zend\Paginator\Adapter\AdapterInterface;

class GroupCollectionAdapter implements AdapterInterface
{
    /**
     * @var \Shared\Application\Persistence\DataSource\GroupDataSourceInterface
     */
    private $groupDataSource;
    /**
     * @var \Board\Infrastructure\DataSource\Specification\GroupSpecification
     */
    private $specification;

    /**
     * GroupCollectionAdapter constructor.
     *
     * @param \Shared\Application\Persistence\DataSource\GroupDataSourceInterface $groupDataSource
     * @param \Board\Infrastructure\DataSource\Specification\GroupSpecification   $specification
     */
    public function __construct(GroupDataSourceInterface $groupDataSource, GroupSpecification $specification)
    {
        $this->groupDataSource = $groupDataSource;
        $this->specification   = $specification;
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

        return $this->groupDataSource->fetchBySpecification($specification);
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
        return $this->groupDataSource->countBySpecification($this->specification);
    }
}