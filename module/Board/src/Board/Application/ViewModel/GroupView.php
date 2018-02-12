<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 03.02.18
 * Time: 11:27
 */

namespace Board\Application\ViewModel;


use Shared\Application\Persistence\Model\GroupViewInterface;

class GroupView implements GroupViewInterface
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
     * @var array
     */
    private $memberships;
    /**
     * @var array
     */
    private $boards;

    /**
     * GroupView constructor.
     *
     * @param string $id
     * @param string $name
     * @param array  $memberships
     * @param array  $boards
     */
    private function __construct(string $id, string $name, array $memberships, array $boards)
    {
        $this->id          = $id;
        $this->name        = $name;
        $this->memberships = $memberships;
        $this->boards      = $boards;
    }

    public static function fromArray(array $data): self
    {
        return new static(
            $data['id'],
            $data['name'],
            $data['memberships'],
            $data['boards']
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

    public function memberships(): array
    {
        return $this->memberships;
    }

    public function boards(): array
    {
        return $this->boards;
    }
}