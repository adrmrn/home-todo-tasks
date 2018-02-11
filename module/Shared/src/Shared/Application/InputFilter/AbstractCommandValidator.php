<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 10.02.18
 * Time: 17:42
 */

namespace Shared\Application\InputFilter;


use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputProviderInterface;

abstract class AbstractCommandValidator extends InputFilter
{
    public function addInput(InputProviderInterface $inputProvider): void
    {
        $input = $this->getFactory()->createInput($inputProvider);

        $this->add($input);
    }
}