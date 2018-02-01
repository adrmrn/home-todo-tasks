<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 01.02.18
 * Time: 23:22
 */

namespace Board\Application\Event;


use MabeEnum\Enum;

class EventName extends Enum
{
    const GROUP_CREATED = 'group_created';
}