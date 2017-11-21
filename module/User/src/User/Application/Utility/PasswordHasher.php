<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 21.11.17
 * Time: 22:44
 */

namespace User\Application\Utility;


use User\Application\Model\Credentials\HashedPassword;

class PasswordHasher
{
    /**
     * @param string $password
     *
     * @return \User\Application\Model\Credentials\HashedPassword
     */
    public static function hash(string $password): HashedPassword
    {
        return new HashedPassword(password_hash($password, PASSWORD_BCRYPT));
    }

    /**
     * @param string                                             $password
     * @param \User\Application\Model\Credentials\HashedPassword $hash
     *
     * @return bool
     */
    public static function verify(string $password, HashedPassword $hash)
    {
        return password_verify($password, $hash->toString());
    }
}