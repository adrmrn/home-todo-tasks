<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 02.12.17
 * Time: 20:03
 */

namespace Shared\Infrastructure\MongoDB;


use MongoDB\Client;
use MongoDB\Collection;
use Shared\Application\Persistence\MongoDB\MongoDBClientInterface;

class MongoDBClient implements MongoDBClientInterface
{
    /**
     * @var \MongoDB\Client
     */
    private $client;
    /**
     * @var string
     */
    private $database;

    /**
     * MongoDBClient constructor.
     *
     * @param \MongoDB\Client $client
     * @param string          $database
     */
    public function __construct(Client $client, string $database)
    {
        $this->client   = $client;
        $this->database = $database;
    }

    /**
     * @param string $collectionName
     * @param array  $data
     */
    public function save(string $collectionName, array $data)
    {
        $collection = $this->grabCollection($collectionName);

        $collection->insertOne($data);
    }

    /**
     * @param string $collectionName
     * @param array  $filter
     * @param array  $data
     */
    public function update(string $collectionName, array $filter, array $data)
    {
        $collection = $this->grabCollection($collectionName);

        $collection->updateMany($filter, ['$set' => $data]);
    }

    /**
     * @param string $collectionName
     * @param array  $filter
     *
     * @return array
     */
    public function findOne(string $collectionName, array $filter): array
    {
        $collection = $this->grabCollection($collectionName);

        $result = $collection->findOne($filter);

        if (NULL === $result) {
            return [];
        }

        return $result->getArrayCopy();
    }

    /**
     * @param string $collectionName
     * @param array  $filter
     * @param array  $options
     *
     * @return array
     */
    public function find(string $collectionName, array $filter, array $options = []): array
    {
        $collection = $this->grabCollection($collectionName);

        $result = $collection->find($filter, $options);

        return $result->toArray();
    }

    /**
     * @param string $collectionName
     * @param array  $filter
     * @param array  $options
     *
     * @return int
     */
    public function count(string $collectionName, array $filter, array $options = []): int
    {
        $collection = $this->grabCollection($collectionName);

        return $collection->count($filter, $options);
    }

    /**
     * @param string $collectionName
     *
     * @return \MongoDB\Collection
     */
    private function grabCollection(string $collectionName): Collection
    {
        return $this->client->selectCollection($this->database, $collectionName);
    }

}