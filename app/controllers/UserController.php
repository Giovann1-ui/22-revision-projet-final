<?php
namespace app\controllers;

use app\models\UserModel;
use app\models\AdminModel;
use Flight;

class UserController
{
    public function processLogin()
    {
        $adminModel = new AdminModel(Flight::db());
        $userModel = new UserModel(Flight::db());

        $nom = Flight::request()->data->nom ?? '';
        $motDePasse = Flight::request()->data->motDePasse ?? '';

        $admin = $adminModel->findByUsername($nom);
        if ($admin) {
            if ($admin && $admin['mot_de_passe'] === $motDePasse) {
                session_start();
                $_SESSION['admin'] = [
                    'id' => $admin['id'],
                    'nom' => $admin['nom']
                ];
                session_regenerate_id(true);
                Flight::redirect('/categories');
                return;
            }
        } else {
            $user = $userModel->authenticate($nom, $motDePasse);
            if ($user) {
                session_start();
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'nom' => $user['nom'],
                    'carac' => $user['carac']
                ];
                session_regenerate_id(true);
                Flight::redirect('/client');
                return;
            }
        }
        Flight::render('login', ['error' => 'Nom ou mot de passe incorrect']);
    }

    public function processRegister()
    {
        $usermodel = new UserModel(Flight::db());
        $nom = trim(Flight::request()->data->nom ?? '');
        $motDePasse = Flight::request()->data->motDePasse ?? '';

        $newId = $usermodel->createUser(['nom' => $nom, 'mot_de_passe' => $motDePasse]);

        session_start();
        $_SESSION['user'] = [
            'id' => $newId,
            'nom' => $nom,
            'carac' => 'user'
        ];
        session_regenerate_id(true);

        Flight::redirect('/login');
    }

    public function logout()
    {
        session_start();
        unset($_SESSION['user']);
        session_regenerate_id(true);
        Flight::redirect('/login');
    }

    public function showLogin()
    {
        Flight::render('login');
    }

    public function showRegister()
    {
        Flight::render('register');
    }
}
?>