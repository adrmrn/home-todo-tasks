<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 29.01.18
 * Time: 21:15
 */

namespace Board\Domain\Model\Member;


use MabeEnum\Enum;

class Role extends Enum
{
    const ADMIN  = 'admin';
    const MEMBER = 'member';
}