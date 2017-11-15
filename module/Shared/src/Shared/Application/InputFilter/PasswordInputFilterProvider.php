<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 14.11.17
 * Time: 20:59
 */

namespace Shared\Application\InputFilter;


use Zend\InputFilter\InputProviderInterface;
use Zend\Validator\StringLength;

class PasswordInputFilterProvider implements InputProviderInterface
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
     * PasswordInputFilterProvider constructor.
     *
     * @param string $inputName
     * @param bool   $isRequired
     */
    public function __construct(string $inputName, bool $isRequired = TRUE)
    {
        $this->inputName  = $inputName;
        $this->isRequired = $isRequired;
    }

    /**
     * Should return an array specification compatible with
     * {@link Zend\InputFilter\Factory::createInput()}.
     *
     * @return array
     */
    public function getInputSpecification()
    {
        // TODO: improve validation logic for password if needed

        return [
            'name'       => $this->inputName,
            'required'   => $this->isRequired,
            'filters'    => [],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'min' => 8
                    ]
                ],
            ],
        ];
    }
}