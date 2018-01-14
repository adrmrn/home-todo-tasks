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

    /**
     * @param string $collectionName
     * @param array  $where
     * @param array  $data
     *
     * @return void
     */
    public function update(string $collectionName, array $where, array $data);
}