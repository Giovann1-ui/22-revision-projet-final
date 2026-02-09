<?php

use app\controllers\UserController;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

$router->group('', function(Router $router) {

	$router->post('/login' , [UserController::class, 'processLogin']);
	
}, [ SecurityHeadersMiddleware::class ]);