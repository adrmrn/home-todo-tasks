<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 14.11.17
 * Time: 20:53
 */

namespace Shared\Application\InputFilter\Provider;


use Zend\Filter\StringTrim;
use Zend\InputFilter\InputProviderInterface;
use Zend\Validator\EmailAddress;

class EmailInputFilterProvider implements InputProviderInterface
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
     * EmailInputFilterProvider constructor.
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
                    'name' => EmailAddress::class,
                    'options' => [
                        'useMxCheck'     => TRUE,
                        'useDeepMxCheck' => TRUE,
                    ]
                ],
            ],
        ];
    }
}