<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 14.01.18
 * Time: 22:10
 */

namespace User\Application\ViewModel;


use Shared\Application\Persistence\Model\UserViewInterface;

class UserView implements UserViewInterface
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $email;

    /**
     * UserView constructor.
     *
     * @param string $id
     * @param string $name
     * @param string $email
     */
    private function __construct(string $id, string $name, string $email)
    {
        $this->id    = $id;
        $this->name  = $name;
        $this->email = $email;
    }

    public static function fromArray(array $data): self
    {
        return new static(
            $data['id'],
            $data['name'],
            $data['email']
        );
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }
}