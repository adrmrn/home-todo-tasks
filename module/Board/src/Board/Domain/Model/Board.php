<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 11.02.18
 * Time: 14:34
 */

namespace Board\Domain\Model;


use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Board
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var \Board\Domain\Model\Group
     */
    private $group;

    /**
     * Board constructor.
     *
     * @param \Board\Domain\Model\Group $group
     * @param string                    $name
     */
    public function __construct(Group $group, string $name)
    {
        $this->id    = Uuid::uuid4();
        $this->name  = $name;
        $this->group = $group;
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function group(): Group
    {
        return $this->group;
    }
}