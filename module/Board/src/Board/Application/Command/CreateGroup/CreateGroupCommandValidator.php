<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 29.01.18
 * Time: 19:36
 */

namespace Board\Application\Command\CreateGroup;


use Shared\Application\InputFilter\AbstractCommandValidator;
use Shared\Application\InputFilter\Provider\StringInputFilterProvider;
use Shared\Application\InputFilter\Provider\UuidInputFilterProvider;

class CreateGroupCommandValidator extends AbstractCommandValidator
{
    /**
     * @return void
     */
    public function init()
    {
        $this->addInput(new StringInputFilterProvider('name'));
        $this->addInput(new UuidInputFilterProvider('creator_id'));
    }
}