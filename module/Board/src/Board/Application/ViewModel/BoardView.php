<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 11.02.18
 * Time: 21:08
 */

namespace Board\Application\ViewModel;


use Shared\Application\Persistence\Model\BoardViewInterface;

class BoardView implements BoardViewInterface
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
    private $group;
    /**
     * @var array
     */
    private $tasks;

    /**
     * BoardView constructor.
     *
     * @param string $id
     * @param string $name
     * @param array  $group
     * @param array  $tasks
     */
    private function __construct(string $id, string $name, array $group, array $tasks)
    {
        $this->id    = $id;
        $this->name  = $name;
        $this->group = $group;
        $this->tasks = $tasks;
    }

    public static function fromArray(array $data): self
    {
        return new static(
            $data['id'],
            $data['name'],
            $data['group'],
            [] // tasks will be here
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

    public function group(): array
    {
        return $this->group;
    }

    public function tasks(): array
    {
        return $this->tasks;
    }
}