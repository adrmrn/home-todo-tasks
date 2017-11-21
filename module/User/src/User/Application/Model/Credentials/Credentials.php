<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 21.11.17
 * Time: 22:13
 */

namespace User\Application\Model\Credentials;


use Shared\Application\ValueObject\Email;

class Credentials
{
    /**
     * @var \Shared\Application\ValueObject\Email
     */
    private $email;
    /**
     * @var \User\Application\Model\Credentials\HashedPassword
     */
    private $hashedPassword;

    /**
     * Credentials constructor.
     *
     * @param \Shared\Application\ValueObject\Email              $email
     * @param \User\Application\Model\Credentials\HashedPassword $hashedPassword
     */
    public function __construct(Email $email, HashedPassword $hashedPassword)
    {
        $this->email          = $email;
        $this->hashedPassword = $hashedPassword;
    }

    /**
     * @return \Shared\Application\ValueObject\Email
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * @return \User\Application\Model\Credentials\HashedPassword
     */
    public function hashedPassword(): HashedPassword
    {
        return $this->hashedPassword;
    }
}