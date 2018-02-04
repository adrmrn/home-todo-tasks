<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 04.02.18
 * Time: 11:55
 */

namespace User\Application\Query\FetchUsersBySpecification;


use Shared\Application\CommandQuery\QueryInterface;

class FetchUsersBySpecificationQuery implements QueryInterface
{
    /**
     * @var array
     */
    private $params;

    /**
     * FetchUsersBySpecificationQuery constructor.
     *
     * @param array $params
     */
    public function __construct($params = [])
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function params(): array
    {
        return $this->params;
    }
}