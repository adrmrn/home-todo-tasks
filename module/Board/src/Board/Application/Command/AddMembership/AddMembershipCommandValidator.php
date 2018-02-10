<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 07.02.18
 * Time: 21:01
 */

namespace Board\Application\Command\AddMembership;


use Board\Application\InputFilter\MembershipRoleInputFilterProvider;
use Shared\Application\InputFilter\AbstractCommandValidator;
use Shared\Application\InputFilter\Provider\UuidInputFilterProvider;

class AddMembershipCommandValidator extends AbstractCommandValidator
{
    /**
     * @return void
     */
    public function init()
    {
        $this->addInput(new UuidInputFilterProvider('id'));
        $this->addInput(new UuidInputFilterProvider('user_id'));
        $this->addInput(new MembershipRoleInputFilterProvider('role'));
        $this->addInput(new UuidInputFilterProvider('creator_id'));
    }
}