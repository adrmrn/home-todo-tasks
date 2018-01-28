<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 23.01.18
 * Time: 21:30
 */

namespace Auth\Application\Service\Token;

use Auth\Application\ValueObject\JWTToken;
use Emarref\Jwt\Exception\VerificationException;
use Emarref\Jwt\Jwt;
use Emarref\Jwt\Token;
use Emarref\Jwt\Claim;
use Emarref\Jwt\Algorithm;
use Emarref\Jwt\Encryption;
use Emarref\Jwt\Verification;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class JWTTokenService implements JWTTokenGeneratorInterface, JWTTokenVerifierInterface
{
    /**
     * @var string
     */
    private $issuer;
    /**
     * @var string
     */
    private $secret;

    /**
     * JWTTokenService constructor.
     *
     * @param string $issuer
     * @param string $secret
     */
    public function __construct(string $issuer, string $secret)
    {
        $this->issuer = $issuer;
        $this->secret = $secret;
    }

    /**
     * @param \Ramsey\Uuid\UuidInterface $userId
     *
     * @return \Auth\Application\ValueObject\JWTToken
     */
    public function generateToken(UuidInterface $userId): JWTToken
    {
        $token = new Token();
        $token->addClaim(new Claim\Issuer($this->issuer));
        $token->addClaim(new Claim\IssuedAt(new \DateTime()));
        $token->addClaim(new Claim\PrivateClaim('data', [
            'user_id' => $userId->toString(),
        ]));

        $jwt = new Jwt();

        $algorithm       = new Algorithm\Hs256($this->secret);
        $encryption      = Encryption\Factory::create($algorithm);
        $serializedToken = $jwt->serialize($token, $encryption);

        return new JWTToken(
            $serializedToken,
            $userId,
            (new \DateTime())->setTimestamp($token->getPayload()->findClaimByName('iat')->getValue()),
            $token->getPayload()->findClaimByName('data')->getValue()
        );
    }

    /**
     * @param string $token
     *
     * @return bool
     */
    public function isTokenVerified(string $token): bool
    {
        $jwt   = new Jwt();
        $token = $jwt->deserialize($token);

        $algorithm  = new Algorithm\Hs256($this->secret);
        $encryption = Encryption\Factory::create($algorithm);
        $context    = new Verification\Context($encryption);
        $context->setIssuer($this->issuer);

        try {
            $jwt->verify($token, $context);
        } catch (VerificationException $e) {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * @param string $serializedToken
     *
     * @return \Auth\Application\ValueObject\JWTToken
     */
    public function deserializeToken(string $serializedToken): JWTToken
    {
        $jwt   = new Jwt();
        $token = $jwt->deserialize($serializedToken);

        return new JWTToken(
            $serializedToken,
            Uuid::fromString($token->getPayload()->findClaimByName('data')->getValue()['user_id']),
            (new \DateTime())->setTimestamp($token->getPayload()->findClaimByName('iat')->getValue()),
            $token->getPayload()->findClaimByName('data')->getValue()
        );
    }
}