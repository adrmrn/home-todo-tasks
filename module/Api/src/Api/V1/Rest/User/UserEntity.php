<?php

namespace Api\V1\Rest\User;

use Shared\Application\Persistence\Model\UserViewInterface;

class UserEntity extends \ArrayObject
{
    /**
     * @var \Shared\Application\Persistence\Model\UserViewInterface
     */
    private $user;

    /**
     * UserEntity constructor.
     *
     * @param \Shared\Application\Persistence\Model\UserViewInterface $user
     */
    public function __construct(UserViewInterface $user)
    {
        $this->user = $user;
    }

    public function getArrayCopy(): array
    {
        return [
            'id'    => $this->user->id(),
            'name'  => $this->user->name(),
            'email' => $this->user->email(),
        ];
    }
}
