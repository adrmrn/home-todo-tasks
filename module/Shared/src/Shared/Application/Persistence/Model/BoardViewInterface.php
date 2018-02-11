<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 11.02.18
 * Time: 21:07
 */

namespace Shared\Application\Persistence\Model;


interface BoardViewInterface
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
    public function group(): array;

    /**
     * @return array
     */
    public function tasks(): array;
}