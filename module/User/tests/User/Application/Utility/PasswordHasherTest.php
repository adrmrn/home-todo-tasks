<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 24.11.17
 * Time: 00:14
 */

namespace User\Application\Utility;

use PHPUnit\Framework\TestCase;
use User\Application\Model\Credentials\HashedPassword;

class PasswordHasherTest extends TestCase
{
    public function testGeneratePasswordHash()
    {
        $hash = PasswordHasher::hash('Qwerty123');

        $this->assertInstanceOf(HashedPassword::class, $hash);
        $this->assertEquals(60, strlen($hash->toString()));
    }

    public function testVerifyPasswordHash()
    {
        $hash = PasswordHasher::hash('Qwerty123');

        $this->assertTrue(PasswordHasher::verify('Qwerty123', $hash));
    }

    public function testFailVerifyPasswordHash()
    {
        $hash = PasswordHasher::hash('Qwerty123');

        $this->assertFalse(PasswordHasher::verify('Test123', $hash));
    }
}
