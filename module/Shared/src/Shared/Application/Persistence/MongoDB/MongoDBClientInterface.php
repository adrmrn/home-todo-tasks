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
     * @param array  $filter
     * @param array  $data
     *
     * @return void
     */
    public function update(string $collectionName, array $filter, array $data);

    /**
     * @param string $collectionName
     * @param array  $filter
     *
     * @return array
     */
    public function findOne(string $collectionName, array $filter): array;

    /**
     * @param string $collectionName
     * @param array  $filter
     * @param array  $options
     *
     * @return array
     */
    public function find(string $collectionName, array $filter, array $options = []): array;

    /**
     * @param string $collectionName
     * @param array  $filter
     * @param array  $options
     *
     * @return int
     */
    public function count(string $collectionName, array $filter, array $options = []): int;
}