<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 05.12.17
 * Time: 21:32
 */

namespace User\Application\Event;


use MabeEnum\Enum;

class EventName extends Enum
{
    const USER_CREATED = 'user_created';
    const USER_RENAMED = 'user_renamed';
}