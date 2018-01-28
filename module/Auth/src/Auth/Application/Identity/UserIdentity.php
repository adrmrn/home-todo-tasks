<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 28.01.18
 * Time: 15:47
 */

namespace Auth\Application\Identity;


use Zend\Permissions\Rbac\AbstractRole;
use ZF\MvcAuth\Identity\IdentityInterface;

class UserIdentity extends AbstractRole implements IdentityInterface
{
    /**
     * @var string
     */
    private $userId;

    /**
     * UserIdentity constructor.
     *
     * @param string $userId
     */
    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getAuthenticationIdentity()
    {
        return $this->userId;
    }

    /**
     * Returns the string identifier of the Role
     *
     * @return string
     */
    public function getRoleId()
    {
        return $this->userId;
    }
}