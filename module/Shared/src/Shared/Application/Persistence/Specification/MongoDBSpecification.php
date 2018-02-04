<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 03.02.18
 * Time: 22:41
 */

namespace Shared\Application\Persistence\Specification;


interface MongoDBSpecification
{
    /**
     * @return array
     */
    public function filtersToClauses(): array;

    /**
     * @return array
     */
    public function optionsToClauses(): array;
}