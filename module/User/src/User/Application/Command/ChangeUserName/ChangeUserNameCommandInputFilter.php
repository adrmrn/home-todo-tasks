<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 23.11.17
 * Time: 22:03
 */

namespace User\Application\Command\ChangeUserName;


use Shared\Application\InputFilter\StringInputFilterProvider;
use Shared\Application\InputFilter\UuidInputFilterProvider;
use Zend\InputFilter\InputFilter;

class ChangeUserNameCommandInputFilter extends InputFilter
{
    /**
     * @return void
     */
    public function init()
    {
        $id   = $this->getFactory()->createInput(new UuidInputFilterProvider('id'));
        $name = $this->getFactory()->createInput(new StringInputFilterProvider('name'));

        $this->add($id)->add($name);
    }
}