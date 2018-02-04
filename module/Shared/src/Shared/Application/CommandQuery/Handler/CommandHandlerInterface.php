<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 04.02.18
 * Time: 18:54
 */

namespace Shared\Application\CommandQuery\Handler;


use Shared\Application\CommandQuery\CommandQueryInterface;

interface CommandHandlerInterface extends CommandQueryHandlerInterface
{
    /**
     * @param \Shared\Application\CommandQuery\CommandQueryInterface $commandQuery
     */
    public function handle(CommandQueryInterface $commandQuery): void;
}