<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 22.01.18
 * Time: 23:12
 */

namespace Auth\Application\Adapter;


use Auth\Application\Identity\UserIdentity;
use Auth\Application\Service\Token\JWTTokenVerifierInterface;
use Zend\Http\Request;
use Zend\Http\Response;
use ZF\MvcAuth\Authentication\AbstractAdapter;
use ZF\MvcAuth\Identity\IdentityInterface;
use ZF\MvcAuth\MvcAuthEvent;

class AuthenticationJWTAdapter extends AbstractAdapter
{
    /**
     * Authentication types this adapter provides.
     *
     * @var array
     */
    protected $authorizationTokenTypes = ['bearer'];
    /**
     * @var \Auth\Application\Service\Token\JWTTokenVerifierInterface
     */
    private $tokenService;

    /**
     * AuthenticationJWTAdapter constructor.
     *
     * @param \Auth\Application\Service\Token\JWTTokenVerifierInterface $tokenService
     */
    public function __construct(JWTTokenVerifierInterface $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @return array Array of types this adapter can handle.
     */
    public function provides()
    {
        return $this->authorizationTokenTypes;
    }

    /**
     * Attempt to match a requested authentication type
     * against what the adapter provides.
     *
     * @param string $type
     *
     * @return bool
     */
    public function matches($type)
    {
        return in_array($type, $this->authorizationTokenTypes, TRUE);
    }

    /**
     * Perform pre-flight authentication operations.
     *
     * Use case would be for providing authentication challenge headers.
     *
     * @param Request  $request
     * @param Response $response
     *
     * @return void|Response
     */
    public function preAuth(Request $request, Response $response)
    {
        return;
    }

    /**
     * Attempt to authenticate the current request.
     *
     * @param Request      $request
     * @param Response     $response
     * @param MvcAuthEvent $mvcAuthEvent
     *
     * @return false|IdentityInterface False on failure, IdentityInterface
     *     otherwise
     */
    public function authenticate(Request $request, Response $response, MvcAuthEvent $mvcAuthEvent)
    {
        $header = $request->getHeader('Authorization');

        if (!preg_match("/Bearer\s((.*)\.(.*)\.(.*))/", $header->toString(), $matches)) {
            throw new \RuntimeException('Bearer JWT token is invalid', 401);
        }
        $serializedToken = $matches[1];

        if (FALSE === $this->tokenService->isTokenVerified($serializedToken)) {
            return FALSE;
        }

        $token = $this->tokenService->deserializeToken($serializedToken);

        return new UserIdentity(
            $token->userId()->toString()
        );
    }
}