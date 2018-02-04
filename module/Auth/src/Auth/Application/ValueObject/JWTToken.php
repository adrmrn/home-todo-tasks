<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 24.01.18
 * Time: 23:17
 */

namespace Auth\Application\ValueObject;


use Ramsey\Uuid\UuidInterface;

class JWTToken
{
    /**
     * @var string
     */
    private $token;
    /**
     * @var \Ramsey\Uuid\UuidInterface
     */
    private $userId;
    /**
     * @var \DateTime
     */
    private $issuedAt;
    /**
     * @var array
     */
    private $data;

    /**
     * JWTToken constructor.
     *
     * @param \Ramsey\Uuid\UuidInterface $userId
     * @param string                     $token
     * @param \DateTime                  $issuedAt
     * @param array                      $data
     *
     * @internal param string $serializedToken
     */
    public function __construct(string $token, UuidInterface $userId, \DateTime $issuedAt, array $data = [])
    {
        $this->token    = $token;
        $this->userId   = $userId;
        $this->issuedAt = $issuedAt;
        $this->data     = $data;
    }

    public function token(): string
    {
        return $this->token;
    }

    public function userId(): UuidInterface
    {
        return $this->userId;
    }

    public function issuedAt(): \DateTime
    {
        return $this->issuedAt;
    }

    public function data(): array
    {
        return $this->data;
    }
}