<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 09.11.17
 * Time: 18:29
 */

namespace User\Application\Command\CreateUser;


use Shared\Application\CommandQuery\CommandQueryInterface;

class CreateUserCommand implements CommandQueryInterface
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $password;

    /**
     * CreateUserCommand constructor.
     *
     * @param string $name
     * @param string $email
     * @param string $password
     */
    public function __construct(string $name, string $email, string $password)
    {
        $this->name     = $name;
        $this->email    = $email;
        $this->password = $password;
    }

    /**
     * @return array
     */
    protected function arraySerialize(): array
    {
        return [
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => $this->password,
        ];
    }

    /**
     * @param array $filteredData
     *
     * @return void
     */
    protected function overwriteInputData(array $filteredData)
    {
        foreach ($filteredData as $name => $value) {
            $this->{$name} = $value;
        }
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
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