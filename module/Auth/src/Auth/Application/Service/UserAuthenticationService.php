<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 24.01.18
 * Time: 22:19
 */

namespace Auth\Application\Service;


use Auth\Application\Event\EventName;
use Auth\Application\Event\Publisher\EventPublisher;
use Auth\Application\Service\Token\JWTTokenGeneratorInterface;
use Ramsey\Uuid\Uuid;
use Shared\Application\Persistence\DataSource\CredentialsDataSourceInterface;
use Shared\Application\ValueObject\Email;
use Shared\Application\ValueObject\HashedPassword;
use Shared\Application\Utility\PasswordHasher;

class UserAuthenticationService
{
    /**
     * @var \Shared\Application\Persistence\DataSource\CredentialsDataSourceInterface
     */
    private $credentialsDataSource;
    /**
     * @var \Auth\Application\Service\Token\JWTTokenGeneratorInterface
     */
    private $JWTTokenGenerator;

    /**
     * UserAuthenticationService constructor.
     *
     * @param \Shared\Application\Persistence\DataSource\CredentialsDataSourceInterface $credentialsDataSource
     * @param \Auth\Application\Service\Token\JWTTokenGeneratorInterface                $JWTTokenGenerator
     */
    public function __construct(CredentialsDataSourceInterface $credentialsDataSource,
                                JWTTokenGeneratorInterface $JWTTokenGenerator)
    {
        $this->credentialsDataSource = $credentialsDataSource;
        $this->JWTTokenGenerator     = $JWTTokenGenerator;
    }

    /**
     * @param string $email
     * @param string $password
     */
    public function authenticate(string $email, string $password)
    {
        $credentials = $this->credentialsDataSource->fetchByEmail(Email::fromString($email));

        if (FALSE === PasswordHasher::verify($password, HashedPassword::fromString($credentials->password()))) {
            throw new \RuntimeException('Invalid credentials', 401);
        }

        $token = $this->JWTTokenGenerator->generateToken(Uuid::fromString($credentials->userId()));

        EventPublisher::publish(
            EventName::TOKEN_CREATED,
            $token->userId(),
            [
                'user_id'   => $token->userId()->toString(),
                'token'     => $token->token(),
                'issued_at' => $token->issuedAt()->format(DATE_ISO8601),
                'data'      => $token->data(),
            ]
        );
    }
}