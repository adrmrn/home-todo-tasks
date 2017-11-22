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
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionCode 422
     * @expectedExceptionMessage Email is invalid.
     */
    public function testCreateInvalidEmail()
    {
        new Email('i_am_sure_this_is_wrong_email_address');
    }
}
