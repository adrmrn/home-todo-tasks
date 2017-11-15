<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 09.11.17
 * Time: 18:29
 */

namespace User\Application\Command\CreateUser;


class CreateUserCommandHandler
{
    public function handle(CreateUserCommand $createUserCommand)
    {
        return ['user' => 'ok'];
    }
}