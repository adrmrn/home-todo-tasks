<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 05.12.17
 * Time: 21:32
 */

namespace User\Application\EventManager;


use MabeEnum\Enum;

class EventName extends Enum
{
    const USER_CREATED = 'user_created';
    const USER_UPDATED = 'user_updated';
}