<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 09.11.17
 * Time: 15:44
 */

namespace User\Application\Model;


use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Shared\Application\ValueObject\Email;

class User
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
     * @var \User\Application\Model\Identity
     */
    private $identity;

    /**
     * User constructor.
     *
     * @param string                           $name
     * @param \User\Application\Model\Identity $identity
     * @param \Ramsey\Uuid\UuidInterface|NULL  $id
     */
    public function __construct(string $name, Identity $identity, UuidInterface $id = NULL)
    {
        $this->id       = (NULL !== $id) ? $id : Uuid::uuid4();
        $this->name     = $name;
        $this->identity = $identity;
    }
}