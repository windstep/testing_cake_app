<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;


Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    // Register scoped middleware for in scopes.
    $routes->registerMiddleware('csrf', new CsrfProtectionMiddleware([
        'httpOnly' => true,
    ]));
    $routes->applyMiddleware('csrf');

    $routes->get('/', ['controller' => 'Tasks', 'action' => 'index'], 'tasks.index');
    $routes->get('/:id', ['controller' => 'Tasks', 'action' => 'view'], 'tasks.view')->setPass(['id'])->setPatterns(['id' => '[0-9]+']);
    $routes->connect('/:id/edit', ['controller' => 'Tasks', 'action' => 'edit'])->setPass(['id'])->setPatterns(['id' => '[0-9]+']);
    $routes->delete('/:id', ['controller' => 'Tasks', 'action' => 'delete'])->setPass(['id'])->setPatterns(['id' => '[0-9]+']);
    $routes->connect('/new', ['controller' => 'Tasks', 'action' => 'create']);

    $routes->connect('/login', ['controller' => 'Auth', 'action' => 'login']);
    $routes->connect('/logout', ['controller' => 'Auth', 'action' => 'logout']);

    $routes->fallbacks(DashedRoute::class);
});
