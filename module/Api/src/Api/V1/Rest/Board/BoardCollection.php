<?php

namespace Api\V1\Rest\Board;

use Shared\Application\Persistence\Model\BoardViewInterface;
use Zend\Filter\Callback;
use Zend\Paginator\Paginator;

class BoardCollection extends Paginator
{
    /**
     * BoardCollection constructor.
     *
     * @param \Zend\Paginator\Adapter\AdapterInterface|\Zend\Paginator\AdapterAggregateInterface $adapter
     */
    public function __construct($adapter)
    {
        parent::__construct($adapter);

        $this->setFilter(
            new Callback(
                function (array $boards) {
                    return array_map(function (BoardViewInterface $board) {
                        return new BoardEntity($board);
                    }, $boards);
                }
            )
        );
    }
}