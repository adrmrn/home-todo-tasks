<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 02.12.17
 * Time: 20:54
 */

namespace Shared\Application\Persistence\MongoDB;


interface MongoDBClientInterface
{
    /**
     * @param string $collectionName
     * @param array  $data
     *
     * @return void
     */
    public function save(string $collectionName, array $data);
}