<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 09.11.17
 * Time: 09:56
 */

namespace Shared\Infrastructure\Dao;


use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\TableGatewayInterface;

abstract class AbstractDao implements DaoInterface
{
    /**
     * @var \Zend\Db\Adapter\AdapterInterface
     */
    private $adapter;
    /**
     * @var \Zend\Db\TableGateway\TableGateway
     */
    private $tableGateway;

    /**
     * AbstractDao constructor.
     *
     * @param \Zend\Db\Adapter\AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter      = $adapter;
        $this->tableGateway = new TableGateway($this->tableName(), $adapter);
    }

    /**
     * @return string
     */
    abstract protected function tableName(): string;

    /**
     * @return \Zend\Db\Adapter\AdapterInterface
     */
    public function adapter(): AdapterInterface
    {
        return $this->adapter;
    }

    /**
     * @return \Zend\Db\TableGateway\TableGatewayInterface
     */
    public function tableGateway(): TableGatewayInterface
    {
        return $this->tableGateway;
    }
}