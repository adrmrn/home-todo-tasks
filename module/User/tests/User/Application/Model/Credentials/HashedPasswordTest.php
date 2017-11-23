<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 24.11.17
 * Time: 00:21
 */

namespace User\Application\Model\Credentials;

use PHPUnit\Framework\TestCase;

class HashedPasswordTest extends TestCase
{
    public function testCreateHashedPassword()
    {
        $hashedPassword = new HashedPassword('$2y$10$3ROZUelRQM9VVI79A2TjS.GqVBW2NCfyky1YcTkPWNOs8r.sRyUJm');

        $this->assertEquals(60, strlen($hashedPassword->toString()));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionCode 422
     * @expectedExceptionMessage Password seems to be invalid.
     */
    public function testFailCreateHashedPassword()
    {
        new HashedPassword('43254325sfgsdr345');
    }
}
