<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 03.02.18
 * Time: 22:21
 */

namespace Board\Infrastructure\DataSource\Specification;


use MongoDB\BSON\Regex;
use Shared\Application\Persistence\Specification\MongoDBSpecification;
use Shared\Application\Persistence\Specification\PaginatorAwareInterface;

class GroupSpecification implements MongoDBSpecification, PaginatorAwareInterface
{
    /**
     * @var array
     */
    private $filters = [];
    /**
     * @var array
     */
    private $options = [];

    /**
     * GroupSpecification constructor.
     *
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $this->prepareFilters($params);
        $this->prepareOptions($params);
    }

    /**
     * @param array $params
     */
    private function prepareFilters(array $params)
    {
        if (TRUE === isset($params['name'])) {
            $this->filters['name'] = new Regex($params['name'], 'i');
        }
    }

    /**
     * @param array $params
     */
    private function prepareOptions(array $params)
    {
        if (TRUE === isset($params['sort_by'])) {
            $sortDirection = 1;

            if (TRUE === isset($params['sort_direction'])) {
                $sortDirection = $params['sort_direction'] === 'desc' ? -1 : 1;
            }

            $this->options['sort'] = [
                $params['sort_by'] => $sortDirection,
            ];
        }
    }

    /**
     * @return array
     */
    public function filtersToClauses(): array
    {
        return $this->filters;
    }

    /**
     * @return array
     */
    public function optionsToClauses(): array
    {
        return $this->options;
    }

    /**
     * @param int $offset
     */
    public function setOffset(int $offset)
    {
        $this->options['skip'] = $offset;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit)
    {
        $this->options['limit'] = $limit;
    }
}