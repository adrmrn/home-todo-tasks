<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 21.11.17
 * Time: 22:44
 */

namespace Shared\Application\Utility;


use Shared\Application\ValueObject\HashedPassword;

class PasswordHasher
{
    public static function hash(string $password): HashedPassword
    {
        return new HashedPassword(password_hash($password, PASSWORD_BCRYPT));
    }

    public static function verify(string $password, HashedPassword $hash): bool
    {
        return password_verify($password, $hash->toString());
    }
}