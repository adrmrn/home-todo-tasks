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
     */
    public function __construct(string $name, Credentials $credentials)
    {
        $this->id          = Uuid::uuid4();
        $this->name        = $name;
        $this->credentials = $credentials;
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function credentials(): Credentials
    {
        return $this->credentials;
    }

    public function rename(string $newName): void
    {
        $this->name = $newName;
    }
}