<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 08.02.18
 * Time: 21:46
 */

namespace Board\Application\InputFilter\Validator;


use Board\Domain\Model\Membership\Role;
use Zend\Validator\Callback;

class MembershipRoleValidator extends Callback
{
    public function __construct()
    {
        $callback = function ($value) {
            try {
                Role::get($value);
            } catch (\Exception $exception) {
                return FALSE;
            }

            return TRUE;
        };

        parent::__construct($callback);

        $this->setMessage('Role is invalid');
    }
}