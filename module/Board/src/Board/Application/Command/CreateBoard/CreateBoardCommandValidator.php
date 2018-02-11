<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 11.02.18
 * Time: 15:38
 */

namespace Board\Application\Command\CreateBoard;


use Shared\Application\InputFilter\AbstractCommandValidator;
use Shared\Application\InputFilter\Provider\StringInputFilterProvider;
use Shared\Application\InputFilter\Provider\UuidInputFilterProvider;

class CreateBoardCommandValidator extends AbstractCommandValidator
{
    /**
     * @return void
     */
    public function init()
    {
        $this->addInput(new UuidInputFilterProvider('group_id'));
        $this->addInput(new StringInputFilterProvider('name'));
        $this->addInput(new UuidInputFilterProvider('creator_id'));
    }
}