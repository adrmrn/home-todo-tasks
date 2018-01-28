<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 27.01.18
 * Time: 23:01
 */

namespace Shared\Application\Persistence\Model;


interface UserViewInterface
{
    /**
     * @return string
     */
    public function id(): string;

    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return string
     */
    public function email(): string;
}