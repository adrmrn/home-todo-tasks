<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 12.02.18
 * Time: 18:59
 */

namespace Board\Application\Paginator;


use Board\Infrastructure\DataSource\Specification\BoardSpecification;
use Shared\Application\Persistence\DataSource\BoardDataSourceInterface;
use Zend\Paginator\Adapter\AdapterInterface;

class BoardCollectionAdapter implements AdapterInterface
{
    /**
     * @var \Shared\Application\Persistence\DataSource\BoardDataSourceInterface
     */
    private $boardDataSource;
    /**
     * @var \Board\Infrastructure\DataSource\Specification\BoardSpecification
     */
    private $specification;

    /**
     * BoardCollectionAdapter constructor.
     *
     * @param \Shared\Application\Persistence\DataSource\BoardDataSourceInterface $boardDataSource
     * @param \Board\Infrastructure\DataSource\Specification\BoardSpecification   $specification
     */
    public function __construct(BoardDataSourceInterface $boardDataSource, BoardSpecification $specification)
    {
        $this->boardDataSource = $boardDataSource;
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

        return $this->boardDataSource->fetchBySpecification($specification);
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
        return $this->boardDataSource->countBySpecification($this->specification);
    }
}