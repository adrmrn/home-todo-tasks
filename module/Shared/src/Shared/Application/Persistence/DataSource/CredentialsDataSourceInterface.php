<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 27.01.18
 * Time: 22:56
 */

namespace Shared\Application\Persistence\DataSource;


use Shared\Application\Persistence\Model\CredentialsViewInterface;
use Shared\Application\ValueObject\Email;

interface CredentialsDataSourceInterface
{
    /**
     * @param \Shared\Application\ValueObject\Email $email
     *
     * @return \Shared\Application\Persistence\Model\CredentialsViewInterface
     */
    public function fetchByEmail(Email $email): CredentialsViewInterface;
}