<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 04.02.18
 * Time: 12:01
 */

namespace User\Infrastructure\DataSource\Specification;


use MongoDB\BSON\Regex;
use Shared\Application\Persistence\Specification\MongoDBSpecification;
use Shared\Application\Persistence\Specification\PaginatorAwareInterface;

class UserSpecification implements MongoDBSpecification, PaginatorAwareInterface
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
     * UserSpecification constructor.
     *
     * @param array $params
     */
    public function __construct($params = [])
    {
        $this->prepareFilters($params);
        $this->prepareOptions($params);
    }

    private function prepareFilters(array $params): void
    {
        if (TRUE === isset($params['name'])) {
            $this->filters['name'] = new Regex($params['name'], 'i');
        }

        if (TRUE === isset($params['email'])) {
            $this->filters['email'] = new Regex($params['email'], 'i');
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

    /**
     * @param int $offset
     *
     * @return void
     */
    public function setOffset(int $offset): void
    {
        $this->options['skip'] = $offset;
    }

    /**
     * @param int $limit
     *
     * @return void
     */
    public function setLimit(int $limit): void
    {
        $this->options['limit'] = $limit;
    }
}