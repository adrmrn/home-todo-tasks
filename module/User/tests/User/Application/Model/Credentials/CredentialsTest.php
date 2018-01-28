<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 24.11.17
 * Time: 00:25
 */

namespace User\Application\Model\Credentials;

use PHPUnit\Framework\TestCase;
use Shared\Application\ValueObject\Email;
use Shared\Application\ValueObject\HashedPassword;
use Shared\Application\Utility\PasswordHasher;

class CredentialsTest extends TestCase
{
    public function testCreateCredentials()
    {
        $email = new Email('test@gmail.com');
        $password = PasswordHasher::hash('Qwerty123');

        $credentials = new Credentials($email, $password);

        $this->assertInstanceOf(Email::class, $credentials->email());
        $this->assertInstanceOf(HashedPassword::class, $credentials->hashedPassword());
        $this->assertEquals('test@gmail.com', $credentials->email()->toString());
    }
}
