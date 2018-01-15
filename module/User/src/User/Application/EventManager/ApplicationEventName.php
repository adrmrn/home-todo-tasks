<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 14.01.18
 * Time: 23:19
 */

namespace User\Application\EventManager;


use MabeEnum\Enum;

class ApplicationEventName extends Enum
{
    const USER_VIEW_CREATED = 'user_view_created';
}