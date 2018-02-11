<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 11.02.18
 * Time: 21:04
 */

namespace Board\Infrastructure\DataSource;


use Board\Application\ViewModel\BoardView;
use Ramsey\Uuid\UuidInterface;
use Shared\Application\Persistence\DataSource\BoardDataSourceInterface;
use Shared\Application\Persistence\Model\BoardViewInterface;
use Shared\Application\Persistence\MongoDB\MongoDBClientInterface;

class BoardDataSource implements BoardDataSourceInterface
{
    /**
     * @var \Shared\Application\Persistence\MongoDB\MongoDBClientInterface
     */
    private $mongoDBClient;

    /**
     * BoardDataSource constructor.
     *
     * @param \Shared\Application\Persistence\MongoDB\MongoDBClientInterface $mongoDBClient
     */
    public function __construct(MongoDBClientInterface $mongoDBClient)
    {
        $this->mongoDBClient = $mongoDBClient;
    }

    public function fetchById(UuidInterface $boardId): BoardViewInterface
    {
        $result = $this->mongoDBClient->findOne('board', ['id' => $boardId->toString()]);

        if (TRUE === empty($result)) {
            throw new \RuntimeException('Board not found', 404);
        }

        return BoardView::fromArray($this->prepareRawArray($result));
    }

    private function prepareRawArray(array $data): array
    {
        $tasks = [];

//        /** @var \MongoDB\Model\BSONDocument $task */
//        foreach ($data['tasks']->getArrayCopy() as $task) {
//            $tasks[] = [];
//        }

        return [
            'id'    => $data['id'],
            'name'  => $data['name'],
            'group' => $data['group']->getArrayCopy(),
            'tasks' => $tasks,
        ];
    }
}