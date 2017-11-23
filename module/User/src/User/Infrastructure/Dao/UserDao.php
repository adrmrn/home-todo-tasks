<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 19.11.17
 * Time: 13:44
 */

namespace User\Infrastructure\Dao;


use Ramsey\Uuid\UuidInterface;
use Shared\Application\ValueObject\Email;
use Shared\Infrastructure\Dao\AbstractDao;
use User\Application\Model\User;

class UserDao extends AbstractDao
{
    /**
     * @return string
     */
    protected function tableName(): string
    {
        return 'user';
    }

    /**
     * @param \User\Application\Model\User $user
     */
    public function store(User $user)
    {
        $set   = [
            'name'          => $user->name(),
            'email'         => $user->credentials()->email()->toString(),
            'password_hash' => $user->credentials()->hashedPassword()->toString(),
        ];
        $where = [
            'id' => $user->id()->toString(),
        ];

        $result = $this->tableGateway()->update($set, $where);

        if ($result === 0) {
            $this->tableGateway()->insert(array_merge($set, $where));
        }
    }

    /**
     * @param \Ramsey\Uuid\UuidInterface $id
     *
     * @return array
     */
    public function fetchById(UuidInterface $id): array
    {
        $result = $this->tableGateway()->select(['id' => $id->toString()]);

        return iterator_to_array($result);
    }

    /**
     * @param \Shared\Application\ValueObject\Email $email
     *
     * @return array
     */
    public function fetchByEmail(Email $email): array
    {
        $result = $this->tableGateway()->select(['email' => $email->toString()]);

        return iterator_to_array($result);
    }
}