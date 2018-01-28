<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 24.01.18
 * Time: 21:32
 */

namespace Auth\Application\EventManager;


use MabeEnum\Enum;

class ApplicationEventName extends Enum
{
    const TOKEN_VIEW_CREATED = 'token_view_created';
}