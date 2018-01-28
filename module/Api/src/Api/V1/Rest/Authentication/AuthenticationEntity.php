<?php

namespace Api\V1\Rest\Authentication;

class AuthenticationEntity extends \ArrayObject
{
    /**
     * @var string
     */
    private $token;

    /**
     * AuthenticationEntity constructor.
     *
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function getArrayCopy()
    {
        return [
            'token' => $this->token,
        ];
    }
}
