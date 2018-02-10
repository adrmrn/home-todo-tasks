<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 10.11.17
 * Time: 13:20
 */

namespace User\Application\Command\CreateUser;


use Shared\Application\InputFilter\AbstractCommandValidator;
use Shared\Application\InputFilter\Provider\EmailInputFilterProvider;
use Shared\Application\InputFilter\Provider\PasswordInputFilterProvider;
use Shared\Application\InputFilter\Provider\StringInputFilterProvider;

class CreateUserCommandValidator extends AbstractCommandValidator
{
    /**
     * @return void
     */
    public function init()
    {
        $this->addInput(new StringInputFilterProvider('name'));
        $this->addInput(new EmailInputFilterProvider('email'));
        $this->addInput(new PasswordInputFilterProvider('password'));
    }
}