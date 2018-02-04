<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 10.11.17
 * Time: 13:20
 */

namespace User\Application\Command\CreateUser;


use Shared\Application\InputFilter\EmailInputFilterProvider;
use Shared\Application\InputFilter\PasswordInputFilterProvider;
use Shared\Application\InputFilter\StringInputFilterProvider;
use Zend\InputFilter\InputFilter;

class CreateUserCommandValidator extends InputFilter
{
    /**
     * @return void
     */
    public function init()
    {
        $name     = $this->getFactory()->createInput(new StringInputFilterProvider('name'));
        $email    = $this->getFactory()->createInput(new EmailInputFilterProvider('email'));
        $password = $this->getFactory()->createInput(new PasswordInputFilterProvider('password'));

        $this->add($name)->add($email)->add($password);
    }
}