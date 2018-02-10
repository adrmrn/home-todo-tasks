<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 07.02.18
 * Time: 22:29
 */

namespace Board\Application\InputFilter;


use Board\Application\InputFilter\Validator\MembershipRoleValidator;
use Zend\Filter\StringTrim;
use Zend\InputFilter\InputProviderInterface;

class MembershipRoleInputFilterProvider implements InputProviderInterface
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
     * MembershipRoleInputFilterProvider constructor.
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
                    'name' => MembershipRoleValidator::class,
                ],
            ],
        ];
    }
}