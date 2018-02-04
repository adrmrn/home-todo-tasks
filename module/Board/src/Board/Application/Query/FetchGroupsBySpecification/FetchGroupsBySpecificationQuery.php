<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 03.02.18
 * Time: 16:51
 */

namespace Board\Application\Query\FetchGroupsBySpecification;


use Shared\Application\CommandQuery\QueryInterface;

class FetchGroupsBySpecificationQuery implements QueryInterface
{
    /**
     * @var array
     */
    private $params;

    /**
     * FetchGroupsBySpecificationQuery constructor.
     *
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $this->params = $params;
    }

    public function params(): array
    {
        return $this->params;
    }
}