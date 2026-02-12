<?php
namespace app\controllers;

use app\models\UserModel;
use Flight;

class UserController
{
    public function processLogin()
    {
        $usermodel = new UserModel(Flight::db());
        $nom = Flight::request()->data->nom ?? '';
        $motDePasse = Flight::request()->data->motDePasse ?? '';

        $user = $usermodel->authenticate($nom, $motDePasse);

        if ($user) {
            session_start();
            // store a minimal user session
            $_SESSION['user'] = [
                'id' => $user['id'],
                'nom' => $user['nom'],
                'carac' => $user['carac']
            ];

            // regenerate session id to prevent fixation
            session_regenerate_id(true);

            Flight::redirect('/dashboard');
        } else {
            Flight::render('login', ['error' => 'Nom ou mot de passe incorrect']);
        }
    }

    public function showLogin()
    {
        Flight::render('login');
    }

    public function showRegister()
    {
        Flight::render('register');
    }

    public function processRegister()
    {
        $usermodel = new UserModel(Flight::db());
        $nom = trim(Flight::request()->data->nom ?? '');
        $motDePasse = Flight::request()->data->motDePasse ?? '';

        // Basic validation
        if (strlen($nom) < 3) {
            Flight::render('register', ['error' => 'Le nom doit contenir au moins 3 caractères']);
            return;
        }

        // Check if username exists
        if ($usermodel->findByUsername($nom)) {
            Flight::render('register', ['error' => 'Nom déjà utilisé']);
            return;
        }

        // Create user (store password as plain text for now to match existing DB)
        $newId = $usermodel->createUser(['nom' => $nom, 'mot_de_passe' => $motDePasse]);

        // Log the user in
        session_start();
        $_SESSION['user'] = [
            'id' => $newId,
            'nom' => $nom,
            'carac' => 'user'
        ];
        session_regenerate_id(true);

        Flight::redirect('/dashboard');
    }

    public function logout()
    {
        session_start();
        unset($_SESSION['user']);
        session_regenerate_id(true);
        Flight::redirect('/login');
    }
}
?>