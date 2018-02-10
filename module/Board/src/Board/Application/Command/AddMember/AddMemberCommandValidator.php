<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 07.02.18
 * Time: 21:01
 */

namespace Board\Application\Command\AddMember;


use Board\Application\InputFilter\MembershipRoleInputFilterProvider;
use Shared\Application\InputFilter\UuidInputFilterProvider;
use Zend\InputFilter\InputFilter;

class AddMemberCommandValidator extends InputFilter
{
    /**
     * @return void
     */
    public function init()
    {
        $groupId   = $this->getFactory()->createInput(new UuidInputFilterProvider('id'));
        $userId    = $this->getFactory()->createInput(new UuidInputFilterProvider('user_id'));
        $role      = $this->getFactory()->createInput(new MembershipRoleInputFilterProvider('role'));
        $creatorId = $this->getFactory()->createInput(new UuidInputFilterProvider('creator_id'));

        $this->add($groupId)->add($userId)->add($role)->add($creatorId);
    }
}