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
            $_SESSION['user_id'] = $user['id']; 
            $_SESSION['nom'] = $user['nom'];

            $userType = $usermodel->getType($nom);
            $_SESSION['user_type'] = $userType;

            Flight::redirect('/dashboard');
        } else {
            Flight::render('login', ['error' => 'Nom ou mot de passe incorrect']);
        }
    }
}
?>