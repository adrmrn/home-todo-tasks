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
     * @var \Shared\Application\ValueObject\Email
     */
    private $email;

    /**
     * User constructor.
     *
     * @param string                                $name
     * @param \Shared\Application\ValueObject\Email $email
     * @param \Ramsey\Uuid\UuidInterface            $id
     */
    public function __construct(string $name, Email $email, UuidInterface $id = NULL)
    {
        $this->id    = (NULL !== $id) ? $id : Uuid::uuid4();
        $this->name  = $name;
        $this->email = $email;
    }
}