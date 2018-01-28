<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 27.01.18
 * Time: 23:05
 */

namespace Shared\Application\Persistence\Model;


interface CredentialsViewInterface
{
    /**
     * @return string
     */
    public function userId(): string;

    /**
     * @return string
     */
    public function email(): string;

    /**
     * @return string
     */
    public function password(): string;
}