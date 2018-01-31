<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 29.01.18
 * Time: 21:09
 */

namespace Board\Domain\Model;


use Board\Domain\Model\Member\Member;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Group
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
     * @var Member[]
     */
    private $members;

    /**
     * Group constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->id      = Uuid::uuid4();
        $this->name    = $name;
        $this->members = new ArrayCollection();
    }

    /**
     * @return \Ramsey\Uuid\UuidInterface
     */
    public function id(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return Member[]
     */
    public function members(): ArrayCollection
    {
        return $this->members;
    }
}