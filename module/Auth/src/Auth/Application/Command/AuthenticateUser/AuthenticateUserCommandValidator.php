<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 24.01.18
 * Time: 21:38
 */

namespace Auth\Application\Command\AuthenticateUser;


use Shared\Application\InputFilter\EmailInputFilterProvider;
use Shared\Application\InputFilter\PasswordInputFilterProvider;
use Zend\InputFilter\InputFilter;

class AuthenticateUserCommandValidator extends InputFilter
{
    /**
     * @return void
     */
    public function init()
    {
        $email    = $this->getFactory()->createInput(new EmailInputFilterProvider('email'));
        $password = $this->getFactory()->createInput(new PasswordInputFilterProvider('password'));

        $this->add($email)->add($password);
    }
}