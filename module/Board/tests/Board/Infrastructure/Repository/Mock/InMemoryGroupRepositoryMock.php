<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 06.02.18
 * Time: 20:50
 */

namespace Board\Infrastructure\Repository\Mock;


use Board\Application\Persistence\Repository\GroupRepositoryInterface;
use Board\Domain\Model\Group;
use Ramsey\Uuid\UuidInterface;

class InMemoryGroupRepositoryMock implements GroupRepositoryInterface
{
    /**
     * @var Group[]
     */
    private $storage = [];

    /**
     * InMemoryGroupRepositoryMock constructor.
     *
     * @param \Board\Domain\Model\Group[] ...$groups
     */
    public function __construct(Group ...$groups)
    {
        foreach ($groups as $group) {
            $this->store($group);
        }
    }

    public function store(Group $group): void
    {
        $this->storage[$group->id()->toString()] = $group;
    }

    public function fetchById(UuidInterface $id): Group
    {
        if (FALSE === isset($this->storage[$id->toString()])) {
            throw new \RuntimeException('Group not found', 404);
        }

        return $this->storage[$id->toString()];
    }
}