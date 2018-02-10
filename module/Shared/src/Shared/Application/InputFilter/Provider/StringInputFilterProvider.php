<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 14.11.17
 * Time: 20:49
 */

namespace Shared\Application\InputFilter\Provider;


use Zend\Filter\StringTrim;
use Zend\InputFilter\InputProviderInterface;
use Zend\Validator\StringLength;

class StringInputFilterProvider implements InputProviderInterface
{
    /**
     * @var string
     */
    private $inputName;
    /**
     * @var bool
     */
    private $isRequired;
    /**
     * @var array
     */
    private $minMax;

    /**
     * StringInputFilterProvider constructor.
     *
     * @param string $inputName
     * @param bool   $isRequired
     * @param array  $minMax
     */
    public function __construct(string $inputName, bool $isRequired = TRUE, array $minMax = [])
    {
        $this->inputName  = $inputName;
        $this->isRequired = $isRequired;
        $this->minMax     = $minMax;
    }

    /**
     * Should return an array specification compatible with
     * {@link Zend\InputFilter\Factory::createInput()}.
     *
     * @return array
     */
    public function getInputSpecification()
    {
        return [
            'name'       => $this->inputName,
            'required'   => $this->isRequired,
            'filters'    => [
                [
                    'name' => StringTrim::class,
                ],
            ],
            'validators' => [
                [
                    'name'    => StringLength::class,
                    'options' => $this->minMax,
                ],
            ],
        ];
    }
}