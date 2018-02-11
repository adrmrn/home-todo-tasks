<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 31.01.18
 * Time: 23:01
 */

namespace Board\Application\EventManager;


use MabeEnum\Enum;

class ApplicationEventName extends Enum
{
    const GROUP_VIEW_CREATED = 'group_view_created';
    const BOARD_VIEW_CREATED = 'board_view_created';
}