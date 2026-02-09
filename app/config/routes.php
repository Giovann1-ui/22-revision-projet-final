<?php

use app\controllers\ApiExampleController;
use app\controllers\ConversationController;
use app\controllers\MessageController;
use app\controllers\UserController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

$router->group('', function (Router $router) use ($app) {

    $router->get('/', function () use ($app) {
        $app->render('login');
    });

    // Route de connexion/inscription
    $router->post('/register', function () use ($app) {
        // Récupérer le username depuis POST
        $username = $app->request()->data->username ?? '';

        if (empty($username)) {
            $app->render('login', ['error' => 'Veuillez entrer un pseudo.']);
            return;
        }

        // Créer une instance du contrôleur
        $userController = new UserController();
        $user = $userController->findOrCreate($username);

        if ($user) {
            // Démarrer la session et sauvegarder les infos
            $_SESSION['user_id'] = $user['id_membre'];
            $_SESSION['username'] = $user['username'];

            // Rediriger vers le dashboard
            $app->redirect('/dashboard');
        } else {
            $app->render('login', ['error' => 'Erreur lors de la création du compte.']);
        }
    });

    $router->group('/register', function () use ($router): void {
        $router->get('/create', [UserController::class, 'create']);
    });

    $router->get('/dashboard', function () use ($app) {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            $app->redirect('/');
            return;
        }
        $app->render('index');
    });

    $router->get('/messages', function () use ($app, $router) {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            $app->redirect('/');
            return;
        }
        
        $messageController = new MessageController();
        $messageController->getLastConversations($_SESSION['username']);
    });

    $router->get('/hello-world/@name', function ($name) {
        echo '<h1>Hello world! Oh hey ' . $name . '!</h1>';
    });

    $router->group('/api', function () use ($router) {
        $router->get('/users', [ApiExampleController::class, 'getUsers']);
        $router->get('/users/@id:[0-9]', [ApiExampleController::class, 'getUser']);
        $router->post('/users/@id:[0-9]', [ApiExampleController::class, 'updateUser']);
    });

}, [SecurityHeadersMiddleware::class]);