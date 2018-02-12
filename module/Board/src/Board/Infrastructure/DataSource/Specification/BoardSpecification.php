<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 12.02.18
 * Time: 18:57
 */

namespace Board\Infrastructure\DataSource\Specification;


use MongoDB\BSON\Regex;
use Shared\Application\Persistence\Specification\MongoDBSpecificationInterface;
use Shared\Application\Persistence\Specification\PaginatorAwareInterface;

class BoardSpecification implements MongoDBSpecificationInterface, PaginatorAwareInterface
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

    private function prepareFilters(array $params): void
    {
        if (TRUE === isset($params['name'])) {
            $this->filters['name'] = new Regex($params['name'], 'i');
        }
    }

    private function prepareOptions(array $params): void
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

    public function filtersToClauses(): array
    {
        return $this->filters;
    }

    public function optionsToClauses(): array
    {
        return $this->options;
    }

    public function setOffset(int $offset): void
    {
        $this->options['skip'] = $offset;
    }

    public function setLimit(int $limit): void
    {
        $this->options['limit'] = $limit;
    }
}