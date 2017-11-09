<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 09.11.17
 * Time: 09:56
 */

namespace Shared\Infrastructure\Dao;


use Zend\Db\Adapter\AdapterInterface;

abstract class AbstractDao implements DaoInterface
{
    /**
     * @var \Zend\Db\Adapter\AdapterInterface
     */
    private $adapter;

    /**
     * AbstractDao constructor.
     *
     * @param \Zend\Db\Adapter\AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return \Zend\Db\Adapter\AdapterInterface
     */
    public function adapter(): AdapterInterface
    {
        return $this->adapter;
    }
}