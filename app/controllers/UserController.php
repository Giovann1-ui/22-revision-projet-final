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
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'nom' => $user['nom']
                ];
                // Ajouter les clés individuelles utilisées par les autres contrôleurs
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nom'] = $user['nom'];
                session_regenerate_id(true);
                Flight::redirect('/accueil');
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

        $_SESSION['user'] = [
            'id' => $newId,
            'nom' => $nom
        ];
        $_SESSION['user_id'] = $newId;
        $_SESSION['user_nom'] = $nom;
        session_regenerate_id(true);

        Flight::redirect('/login');
    }

    public function logout()
    {
        unset($_SESSION['user']);
        unset($_SESSION['user_id']);
        unset($_SESSION['user_nom']);
        unset($_SESSION['admin']);
        session_regenerate_id(true);
        Flight::redirect('/');
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