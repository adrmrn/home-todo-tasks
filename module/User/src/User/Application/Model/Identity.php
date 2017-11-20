<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 09.11.17
 * Time: 18:12
 */

namespace User\Application\Model;


use Shared\Application\ValueObject\Email;

class Identity
{
    /**
     * @var \Shared\Application\ValueObject\Email
     */
    private $email;
    /**
     * @var string
     */
    private $activationCode;
    /**
     * @var bool
     */
    private $isActivated;

    /**
     * Identity constructor.
     *
     * @param \Shared\Application\ValueObject\Email $email
     * @param string                                $activationCode
     * @param bool                                  $isActivated
     */
    public function __construct(Email $email, bool $isActivated = FALSE, string $activationCode = NULL)
    {
        $this->email          = $email;
        $this->isActivated    = $isActivated;
        $this->activationCode = $activationCode ?? bin2hex(random_bytes(32));
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