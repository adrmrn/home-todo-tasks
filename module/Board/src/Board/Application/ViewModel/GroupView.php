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
     * GroupView constructor.
     *
     * @param string $id
     * @param string $name
     * @param array  $memberships
     */
    private function __construct(string $id, string $name, array $memberships)
    {
        $this->id          = $id;
        $this->name        = $name;
        $this->memberships = $memberships;
    }

    /**
     * @param array $data
     *
     * @return \Board\Application\ViewModel\GroupView
     */
    public static function fromArray(array $data): self
    {
        return new static(
            $data['id'],
            $data['name'],
            $data['memberships']
        );
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function memberships(): array
    {
        return $this->memberships;
    }
}