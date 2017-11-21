<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 20.11.17
 * Time: 22:26
 */

namespace User\Application\Model\Credentials;


class HashedPassword
{
    /**
     * @var string
     */
    private $passwordHash;

    /**
     * PasswordHash constructor.
     *
     * @param string $passwordHash
     */
    public function __construct(string $passwordHash)
    {
        // Password hashed by password_hash() with PASSWORD_BCRYPT algorithm,
        // always contains 60 characters
        if (strlen($passwordHash) !== 60) {
            throw new \InvalidArgumentException('Password seems to be invalid.', 422);
        }

        $this->passwordHash = $passwordHash;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->passwordHash;
    }
}