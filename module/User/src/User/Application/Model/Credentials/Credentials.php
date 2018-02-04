<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 21.11.17
 * Time: 22:13
 */

namespace User\Application\Model\Credentials;


use Shared\Application\ValueObject\Email;
use Shared\Application\ValueObject\HashedPassword;

class Credentials
{
    /**
     * @var \Shared\Application\ValueObject\Email
     */
    private $email;
    /**
     * @var \Shared\Application\ValueObject\HashedPassword
     */
    private $hashedPassword;

    /**
     * Credentials constructor.
     *
     * @param \Shared\Application\ValueObject\Email          $email
     * @param \Shared\Application\ValueObject\HashedPassword $hashedPassword
     */
    public function __construct(Email $email, HashedPassword $hashedPassword)
    {
        $this->email          = $email;
        $this->hashedPassword = $hashedPassword;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function hashedPassword(): HashedPassword
    {
        return $this->hashedPassword;
    }
}