<?php
// in src/Middleware/UnauthorizedHandler/FlashRedirectHandler.php

namespace App\Middleware;

use Authorization\Exception\Exception;
use Authorization\Middleware\UnauthorizedHandler\RedirectHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class FlashRedirectHandler extends RedirectHandler
{
    public function handle(
        Exception $exception,
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $options = []
    ): ResponseInterface
    {
        $result = parent::handle($exception, $request, $response, $options);

        $message = __('You cannot access this page');

        /** @var \Cake\Http\Session $session */
        $session = $request->getAttribute('session');

        $messages = (array)$session->read('Flash.flash', []);
        $messages[] = [
            'message' => $message,
            'key' => 'flash',
            'element' => 'flash/error',
            'params' => [],
        ];
        $session->write('Flash.flash', $messages);

        return $result;
    }
}
