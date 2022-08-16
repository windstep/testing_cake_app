<?php
namespace App\Middleware;

use Authentication\Authenticator\UnauthenticatedException;
use Authentication\Authenticator\UnauthorizedException as UnauthorizedExceptionAlias;
use Authorization\Exception\ForbiddenException;
use Cake\Http\Exception\UnauthorizedException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Authorization\Exception\AuthorizationRequiredException;

/**
 * NotEnoughRightsMiddleware middleware
 */
class NotEnoughRightsMiddlewareMiddleware
{
    /**
     * Invoke method.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Message\ResponseInterface $response The response.
     * @param callable $next Callback to invoke the next middleware.
     * @return \Psr\Http\Message\ResponseInterface A response
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {
        try {
            return $next($request, $response);
        } catch (UnauthorizedException | UnauthorizedExceptionAlias | UnauthenticatedException $e) {
            return $response->withHeader('Location', '/login');
        } catch (ForbiddenException $e) {
            return $response->withHeader('Location', '/');
        }
    }
}
