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
use Shared\Application\Persistence\Specification\MongoDBSpecificationInterface;

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

    /**
     * @param \Shared\Application\Persistence\Specification\MongoDBSpecificationInterface $specification
     *
     * @return BoardViewInterface[]
     */
    public function fetchBySpecification(MongoDBSpecificationInterface $specification): array
    {
        $results = $this->mongoDBClient->find(
            'board',
            $specification->filtersToClauses(),
            $specification->optionsToClauses()
        );

        $boards = [];
        /** @var \MongoDB\Model\BSONDocument $row */
        foreach ($results as $row) {
            $boards[] = BoardView::fromArray(
                $this->prepareRawArray($row->getArrayCopy())
            );
        }

        return $boards;
    }

    public function countBySpecification(MongoDBSpecificationInterface $specification): int
    {
        return $this->mongoDBClient->count(
            'board',
            $specification->filtersToClauses(),
            $specification->optionsToClauses()
        );
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