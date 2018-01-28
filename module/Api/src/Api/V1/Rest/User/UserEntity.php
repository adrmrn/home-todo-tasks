<?php

namespace Api\V1\Rest\User;

use User\Application\ViewModel\UserView;

class UserEntity extends \ArrayObject
{
    /**
     * @var \User\Application\ViewModel\UserView
     */
    private $user;

    /**
     * UserEntity constructor.
     *
     * @param \User\Application\ViewModel\UserView $user
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
