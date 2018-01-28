<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 25.01.18
 * Time: 21:30
 */

namespace Auth\Application\Service\Token;


use Auth\Application\ValueObject\JWTToken;

interface JWTTokenVerifierInterface
{
    /**
     * @param string $token
     *
     * @return bool
     */
    public function isTokenVerified(string $token): bool;

    /**
     * @param string $serializedToken
     *
     * @return \Auth\Application\ValueObject\JWTToken
     */
    public function deserializeToken(string $serializedToken): JWTToken;
}