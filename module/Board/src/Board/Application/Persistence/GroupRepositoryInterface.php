<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 31.01.18
 * Time: 22:59
 */

namespace Board\Application\Persistence;


use Board\Domain\Model\Group;
use Ramsey\Uuid\UuidInterface;

interface GroupRepositoryInterface
{
    /**
     * @param \Board\Domain\Model\Group $group
     *
     * @return void
     */
    public function store(Group $group);

    /**
     * @param \Ramsey\Uuid\UuidInterface $id
     *
     * @return \Board\Domain\Model\Group
     */
    public function fetchById(UuidInterface $id): Group;
}