<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 28.01.18
 * Time: 14:03
 */

namespace User\Infrastructure\DataSource;


use Shared\Application\Persistence\DataSource\CredentialsDataSourceInterface;
use Shared\Application\Persistence\Model\CredentialsViewInterface;
use Shared\Application\Persistence\MongoDB\MongoDBClientInterface;
use Shared\Application\ValueObject\Email;
use User\Application\ViewModel\Credentials\CredentialsView;

class CredentialsDataSource implements CredentialsDataSourceInterface
{
    /**
     * @var \Shared\Application\Persistence\MongoDB\MongoDBClientInterface
     */
    private $mongoDBClient;

    /**
     * CredentialsDataSource constructor.
     *
     * @param \Shared\Application\Persistence\MongoDB\MongoDBClientInterface $mongoDBClient
     */
    public function __construct(MongoDBClientInterface $mongoDBClient)
    {
        $this->mongoDBClient = $mongoDBClient;
    }

    /**
     * @param \Shared\Application\ValueObject\Email $email
     *
     * @return \Shared\Application\Persistence\Model\CredentialsViewInterface
     */
    public function fetchByEmail(Email $email): CredentialsViewInterface
    {
        $result = $this->mongoDBClient->findOne('credentials', ['email' => $email->toString()]);

        if (TRUE === empty($result)) {
            throw new \RuntimeException('Credentials not found', 404);
        }

        return CredentialsView::fromArray($result);
    }
}