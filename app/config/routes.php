<?php

use app\controllers\ApiExampleController;
use app\controllers\HomeController;
use app\controllers\UserController;
use app\controllers\ProfilController;
use app\controllers\ObjetController;
use app\controllers\PropositionController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function (Router $router) use ($app) {

	// Page d'accueil
	$router->get('/', [HomeController::class, 'index']);

	// Authentification
	$router->get('/login', [UserController::class, 'allUsers']);
	$router->post('/register', [UserController::class, 'createUser']);
	$router->get('/logout', [HomeController::class, 'logout']);

	// Profil
	$router->get('/profile', [ProfilController::class, 'monProfil']);
	$router->post('/profile/update', [ProfilController::class, 'updateProfil']);

	// Gestion des objets
	$router->group('/mes-objets', function (Router $router) {
		// $router->get('', [ObjetController::class, 'mesObjets']);
		$router->get('/ajouter', [ObjetController::class, 'showAddObjetForm']);
		$router->post('/ajouter', [ObjetController::class, 'createObjet']);
		$router->delete('/supprimer/@id:[0-9]+', [ObjetController::class, 'deleteObjet']);

		$router->get('/edit', [ObjetController::class, 'editObjet']);
		$router->post('/edit', [ObjetController::class, 'updateObjet']);
	});

	$router->group('/objets', function (Router $router) {
		// $router->get('', [ObjetController::class, 'allObjets']);
		$router->get('/@id:[0-9]+', [ObjetController::class, 'objet']);
		$router->get('/membre/@id_membre:[0-9]+', [ObjetController::class, 'objetsByMembre']);
	});

	$router->group('/propositions', function (Router $router) {
		$router->get('/choisir-objet/@id_objet:[0-9]+', [PropositionController::class, 'choisirObjet']);
		$router->post('/creer', [PropositionController::class, 'creerProposition']);
		$router->get('', [PropositionController::class, 'mesPropositions']);
		$router->post('/@id:[0-9]+/accepter', [PropositionController::class, 'accepterProposition']);
		$router->post('/@id:[0-9]+/refuser', [PropositionController::class, 'refuserProposition']);
		$router->post('/@id:[0-9]+/annuler', [PropositionController::class, 'annulerProposition']);
	});

	// Example route
	$router->get('/hello-world/@name', function ($name) {
		echo '<h1>Hello world! Oh hey ' . $name . '!</h1>';
	});

	$router->group('/api', function () use ($router) {
		$router->get('/users', [ApiExampleController::class, 'getUsers']);
		$router->get('/users/@id:[0-9]+', [ApiExampleController::class, 'getUser']);
		$router->post('/users/@id:[0-9]+', [ApiExampleController::class, 'updateUser']);
	});

}, [SecurityHeadersMiddleware::class]);