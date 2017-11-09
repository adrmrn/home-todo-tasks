<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 09.11.17
 * Time: 09:55
 */

namespace Shared\Infrastructure\Dao;


use Zend\Db\Adapter\AdapterInterface;

interface DaoInterface
{
    public function adapter(): AdapterInterface;
}