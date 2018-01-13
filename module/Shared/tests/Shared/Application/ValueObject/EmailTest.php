<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 22.11.17
 * Time: 16:53
 */

namespace Shared\Application\ValueObject;

use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testCreateEmail()
    {
        $email = new Email('test@o2.pl');

        $this->assertEquals('test@o2.pl', $email->toString());
        $this->assertEquals('test@o2.pl', $email); // test __toString() magic method
        $this->assertEquals('test', $email->localPart());
        $this->assertEquals('o2.pl', $email->domain());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionCode 422
     * @expectedExceptionMessage Email is invalid.
     */
    public function testCreateInvalidEmail()
    {
        new Email('invalid_email_address');
    }
}
