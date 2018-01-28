<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 25.01.18
 * Time: 21:28
 */

namespace Auth\Application\Service\Token;


use Auth\Application\ValueObject\JWTToken;
use Ramsey\Uuid\UuidInterface;

interface JWTTokenGeneratorInterface
{
    /**
     * @param \Ramsey\Uuid\UuidInterface $userId
     *
     * @return \Auth\Application\ValueObject\JWTToken
     */
    public function generateToken(UuidInterface $userId): JWTToken;
}