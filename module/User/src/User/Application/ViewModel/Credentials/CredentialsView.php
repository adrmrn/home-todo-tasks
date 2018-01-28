<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 27.01.18
 * Time: 23:05
 */

namespace User\Application\ViewModel\Credentials;


use Shared\Application\Persistence\Model\CredentialsViewInterface;

class CredentialsView implements CredentialsViewInterface
{
    /**
     * @var string
     */
    private $userId;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $password;

    /**
     * CredentialsView constructor.
     *
     * @param string $userId
     * @param string $email
     * @param string $password
     */
    private function __construct(string $userId, string $email, string $password)
    {
        $this->userId   = $userId;
        $this->email    = $email;
        $this->password = $password;
    }

    /**
     * @param array $data
     *
     * @return \User\Application\ViewModel\Credentials\CredentialsView
     */
    public static function fromArray(array $data): self
    {
        return new static(
            $data['user_id'],
            $data['email'],
            $data['password']
        );
    }

    /**
     * @return string
     */
    public function userId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function email(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function password(): string
    {
        return $this->password;
    }
}