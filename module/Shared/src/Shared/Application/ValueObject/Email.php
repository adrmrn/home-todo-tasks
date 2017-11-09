<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 09.11.17
 * Time: 16:00
 */

namespace Shared\Application\ValueObject;


class Email
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $domain;

    /**
     * Email constructor.
     *
     * @param string $email
     */
    public function __construct(string $email)
    {
        if (FALSE === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Email is invalid.', 422);
        }

        $emailParts = explode('@', $email, 2);

        $this->name = $emailParts[0];
        $this->domain = $emailParts[1];
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return sprintf('%s@%s', $this->name, $this->domain);
    }
}