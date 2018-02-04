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
    private $value;

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

        $this->value = $email;
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function localPart(): string
    {
        $emailParts = explode('@', $this->value, 2);

        return $emailParts[0];
    }

    public function domain(): string
    {
        $emailParts = explode('@', $this->value, 2);

        return $emailParts[1];
    }

    public static function fromString(string $email): self
    {
        return new self($email);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}