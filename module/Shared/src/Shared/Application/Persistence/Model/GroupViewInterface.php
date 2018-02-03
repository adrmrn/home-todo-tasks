<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 03.02.18
 * Time: 11:29
 */

namespace Shared\Application\Persistence\Model;


interface GroupViewInterface
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
     * @return array
     */
    public function memberships(): array;
}