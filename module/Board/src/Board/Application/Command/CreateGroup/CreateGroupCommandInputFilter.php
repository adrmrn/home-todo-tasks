<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 29.01.18
 * Time: 19:36
 */

namespace Board\Application\Command\CreateGroup;


use Shared\Application\InputFilter\StringInputFilterProvider;
use Shared\Application\InputFilter\UuidInputFilterProvider;
use Zend\InputFilter\InputFilter;

class CreateGroupCommandInputFilter extends InputFilter
{
    /**
     * @return void
     */
    public function init()
    {
        $name      = $this->getFactory()->createInput(new StringInputFilterProvider('name'));
        $creatorId = $this->getFactory()->createInput(new UuidInputFilterProvider('creator_id'));

        $this->add($name)->add($creatorId);
    }
}