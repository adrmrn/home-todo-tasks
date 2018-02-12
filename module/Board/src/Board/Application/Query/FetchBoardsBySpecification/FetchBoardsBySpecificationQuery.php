<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 12.02.18
 * Time: 18:53
 */

namespace Board\Application\Query\FetchBoardsBySpecification;


use Shared\Application\CommandQuery\QueryInterface;

class FetchBoardsBySpecificationQuery implements QueryInterface
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