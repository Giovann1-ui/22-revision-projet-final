<?php

use app\controllers\ApiExampleController;
use app\controllers\HomeController;
use app\controllers\UserController;
use app\controllers\ProfilController;
use app\controllers\ObjetController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function(Router $router) use ($app) {

	// Page d'accueil
	$router->get('/', [ HomeController::class, 'index' ]);

	// Authentification
	$router->get('/login', [ UserController::class, 'allUsers' ]);
	$router->post('/register', [ UserController::class, 'createUser' ]);
	$router->get('/logout', [ HomeController::class, 'logout' ]);

	// Profil
	$router->get('/profile', [ ProfilController::class, 'monProfil' ]);
	$router->post('/profile/update', [ ProfilController::class, 'updateProfil' ]);

	// Gestion des objets
	$router->get('/mes-objets/ajouter', [ ObjetController::class, 'showAddObjetForm' ]);
	$router->post('/mes-objets/ajouter', [ ObjetController::class, 'createObjet' ]);
	$router->delete('/mes-objets/supprimer/@id:[0-9]+', [ ObjetController::class, 'deleteObjet' ]);

	// Example route
	$router->get('/hello-world/@name', function($name) {
		echo '<h1>Hello world! Oh hey '.$name.'!</h1>';
	});

	$router->group('/api', function() use ($router) {
		$router->get('/users', [ ApiExampleController::class, 'getUsers' ]);
		$router->get('/users/@id:[0-9]', [ ApiExampleController::class, 'getUser' ]);
		$router->post('/users/@id:[0-9]', [ ApiExampleController::class, 'updateUser' ]);
	});
	
}, [ SecurityHeadersMiddleware::class ]);