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
use User\Application\Model\Credentials\Credentials;

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
     * @var \User\Application\Model\Credentials\Credentials
     */
    private $credentials;

    /**
     * User constructor.
     *
     * @param string                                          $name
     * @param \User\Application\Model\Credentials\Credentials $credentials
     * @param \Ramsey\Uuid\UuidInterface|NULL                 $id
     */
    public function __construct(string $name, Credentials $credentials, UuidInterface $id = NULL)
    {
        $this->id          = (NULL !== $id) ? $id : Uuid::uuid4();
        $this->name        = $name;
        $this->credentials = $credentials;
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
     * @return \User\Application\Model\Credentials\Credentials
     */
    public function credentials(): Credentials
    {
        return $this->credentials;
    }
}