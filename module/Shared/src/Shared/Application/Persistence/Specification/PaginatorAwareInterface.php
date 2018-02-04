<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 04.02.18
 * Time: 11:03
 */

namespace Shared\Application\Persistence\Specification;


interface PaginatorAwareInterface
{
    /**
     * @param int $offset
     *
     * @return void
     */
    public function setOffset(int $offset): void;

    /**
     * @param int $limit
     *
     * @return void
     */
    public function setLimit(int $limit): void;
}