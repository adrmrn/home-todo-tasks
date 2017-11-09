<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 09.11.17
 * Time: 18:12
 */

namespace User\Application\Model;


class UserIdentity
{
    /**
     * @var \User\Application\Model\User
     */
    private $user;
    /**
     * @var string
     */
    private $activationCode;
    /**
     * @var bool
     */
    private $isActivated;

    /**
     * UserIdentity constructor.
     *
     * @param \User\Application\Model\User $user
     * @param string                       $activationCode
     * @param bool                         $isActivated
     */
    public function __construct(User $user, string $activationCode, bool $isActivated)
    {
        $this->user           = $user;
        $this->activationCode = $activationCode;
        $this->isActivated    = $isActivated;
    }

    /**
     * @return bool
     */
    public function isActivated(): bool
    {
        return $this->isActivated;
    }

    /**
     * @return void
     */
    public function activate()
    {
        $this->isActivated = TRUE;
    }

    /**
     * @return string
     */
    public function activationCode(): string
    {
        return $this->activationCode;
    }
}