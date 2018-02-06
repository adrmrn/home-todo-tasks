<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 06.02.18
 * Time: 20:50
 */

namespace Board\Infrastructure\Repository\Mock;


use Board\Application\Persistence\GroupRepositoryInterface;
use Board\Domain\Model\Group;
use Ramsey\Uuid\UuidInterface;

class InMemoryGroupRepositoryMock implements GroupRepositoryInterface
{
    /**
     * @var Group[]
     */
    private $storage = [];

    public function store(Group $group): void
    {
        $this->storage[] = $group;
    }

    public function fetchById(UuidInterface $id): Group
    {
        foreach ($this->storage as $group) {
            if ($group->id()->compareTo($id)) {
                return $group;
            }
        }

        throw new \RuntimeException('Group not found', 404);
    }
}