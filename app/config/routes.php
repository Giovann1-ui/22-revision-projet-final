<?php

use app\controllers\UserController;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

$router->get('/', function() {
    Flight::redirect('/login');
});
$router->group('', function(Router $router) {
    $router->get('/login', [UserController::class, 'showLogin']);
    $router->post('/login', [UserController::class, 'processLogin']);
    $router->get('/register', [UserController::class, 'showRegister']);
    $router->post('/register', [UserController::class, 'processRegister']);
    $router->get('/logout', [UserController::class, 'logout']);
});

// Admin routes
$router->group('/admin', function(Router $router) {
    $router->get('/login', ['app\controllers\AdminController', 'showLogin']);
    $router->post('/login', ['app\controllers\AdminController', 'processLogin']);
    $router->get('/register', ['app\controllers\AdminController', 'showRegister']);
    $router->post('/register', ['app\controllers\AdminController', 'processRegister']);
    $router->get('/logout', ['app\controllers\AdminController', 'logout']);
});

// Category management (admin)
$router->group('', function(Router $router) {
    $router->get('/categories', ['app\controllers\CategoryController', 'index']);
    $router->get('/categories/create', ['app\controllers\CategoryController', 'create']);
    $router->post('/categories', ['app\controllers\CategoryController', 'store']);
    $router->post('/categories/delete', ['app\controllers\CategoryController', 'delete']);
});