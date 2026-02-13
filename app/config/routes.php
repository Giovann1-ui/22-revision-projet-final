<?php

use app\controllers\AdminController;
use app\controllers\UserController;
use app\controllers\CategoryController;
use app\controllers\ApiExampleController;
use app\controllers\HomeController;
use app\controllers\ProfilController;
use app\controllers\ObjetController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

Flight::route('GET /', [UserController::class, 'showLogin']);

Flight::route('POST /', [UserController::class, 'processLogin']);

Flight::route('POST /login', [UserController::class, 'processLogin']);

Flight::route('GET /register', [UserController::class, 'showRegister']);

// Page d'accueil
	$router->get('/accueil', [ HomeController::class, 'index' ]);

	// Profil
	$router->get('/profile', [ ProfilController::class, 'monProfil' ]);
	$router->post('/profile/update', [ ProfilController::class, 'updateProfil' ]);

	// Gestion des objets
	$router->get('/mes-objets/ajouter', [ ObjetController::class, 'showAddObjetForm' ]);
	$router->post('/mes-objets/ajouter', [ ObjetController::class, 'createObjet' ]);
	$router->delete('/mes-objets/supprimer/@id', [ ObjetController::class, 'deleteObjet' ]);
	// Route POST alternative pour la suppression (fallback si DELETE ne marche pas)
	$router->post('/mes-objets/supprimer/@id', [ ObjetController::class, 'deleteObjet' ]);

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