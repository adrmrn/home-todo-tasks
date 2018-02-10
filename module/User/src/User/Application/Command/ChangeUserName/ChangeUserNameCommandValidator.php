<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 23.11.17
 * Time: 22:03
 */

namespace User\Application\Command\ChangeUserName;


use Shared\Application\InputFilter\AbstractCommandValidator;
use Shared\Application\InputFilter\Provider\StringInputFilterProvider;
use Shared\Application\InputFilter\Provider\UuidInputFilterProvider;

class ChangeUserNameCommandValidator extends AbstractCommandValidator
{
    /**
     * @return void
     */
    public function init()
    {
        $this->addInput(new UuidInputFilterProvider('id'));
        $this->addInput(new StringInputFilterProvider('name'));
    }
}