<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 13.01.18
 * Time: 18:03
 */

namespace Shared\Application\Projector\Projection;


use Shared\Application\Persistence\MongoDB\MongoDBClientInterface;

abstract class AbstractProjection implements ProjectionInterface
{
    /**
     * @var \Shared\Application\Persistence\MongoDB\MongoDBClientInterface
     */
    private $mongoDBClient;

    /**
     * AbstractProjection constructor.
     *
     * @param \Shared\Application\Persistence\MongoDB\MongoDBClientInterface $mongoDBClient
     */
    public function __construct(MongoDBClientInterface $mongoDBClient)
    {
        $this->mongoDBClient = $mongoDBClient;
    }

    /**
     * @return \Shared\Application\Persistence\MongoDB\MongoDBClientInterface
     */
    protected function client(): MongoDBClientInterface
    {
        return $this->mongoDBClient;
    }
}