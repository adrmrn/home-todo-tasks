<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 25.01.18
 * Time: 23:57
 */

namespace Auth\Application\Event;


use MabeEnum\Enum;

class EventName extends Enum
{
    const TOKEN_CREATED = 'token_created';
}