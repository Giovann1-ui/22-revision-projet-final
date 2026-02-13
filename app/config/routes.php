<?php

use app\controllers\AdminController;
use app\controllers\UserController;
use app\controllers\CategoryController;

Flight::route('GET /', [UserController::class, 'showLogin']);

Flight::route('POST /', [UserController::class, 'processLogin']);

Flight::route('POST /login', [UserController::class, 'processLogin']);

Flight::route('GET /register', [UserController::class, 'showRegister']);

Flight::route('POST /register', [UserController::class, 'processRegister']);

Flight::route('POST /logout', function() {
    session_start();
    unset($_SESSION['user']);
    unset($_SESSION['admin']);
    session_regenerate_id(true);
    Flight::redirect('/');
});

Flight::route('GET /client', function() {
    echo "client a ajouter";
});

Flight::group('/admin', function(flight\net\Router $router) {
    $router->post('/login', [AdminController::class, 'processLogin']);
    $router->get('/register', [AdminController::class, 'showRegister']);
    $router->post('/register', [AdminController::class, 'processRegister']);
    $router->post('/logout', function() {
        session_start();
        unset($_SESSION['admin']);
        session_regenerate_id(true);
        Flight::redirect('/admin/login');
    });
});

Flight::group('/categories', function(flight\net\Router $router) {
    $router->get('', [CategoryController::class, 'index']);
    $router->get('/create', [CategoryController::class, 'create']);
    $router->post('/store', [CategoryController::class, 'store']);
    $router->post('/delete', [CategoryController::class, 'delete']);
});