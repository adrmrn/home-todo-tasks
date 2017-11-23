<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 23.11.17
 * Time: 22:03
 */

namespace Shared\Application\CommandQuery;


interface CommandQueryHandler
{
    /**
     * @param \Shared\Application\CommandQuery\CommandQueryInterface $commandQuery
     *
     * @return void
     */
    public function handle(CommandQueryInterface $commandQuery);
}