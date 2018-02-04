<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 24.01.18
 * Time: 21:36
 */

namespace Auth\Application\Command\AuthenticateUser;


use Shared\Application\CommandQuery\CommandInterface;

class AuthenticateUserCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $password;

    /**
     * AuthenticateUserCommand constructor.
     *
     * @param string $email
     * @param string $password
     */
    public function __construct(string $email, string $password)
    {
        $this->email    = $email;
        $this->password = $password;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }
}