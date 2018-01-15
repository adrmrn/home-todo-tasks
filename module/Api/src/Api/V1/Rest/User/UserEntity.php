<?php

namespace Api\V1\Rest\User;

use User\Application\Model\UserView;

class UserEntity extends \ArrayObject
{
    /**
     * @var \User\Application\Model\UserView
     */
    private $user;

    /**
     * UserEntity constructor.
     *
     * @param \User\Application\Model\UserView $user
     */
    public function __construct(UserView $user)
    {
        $this->user = $user;
    }

    /**
     * @return array
     */
    public function getArrayCopy(): array
    {
        return [
            'id'    => $this->user->id(),
            'name'  => $this->user->name(),
            'email' => $this->user->email(),
        ];
    }
}
