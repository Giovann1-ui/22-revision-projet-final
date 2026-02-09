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
            // Authentification réussie
            session_start();
            $_SESSION['user_id'] = $user['id']; // Si vous avez un champ id
            $_SESSION['nom'] = $user['nom'];

            // Récupérer le type si nécessaire
            $userType = $usermodel->getType($nom);
            $_SESSION['user_type'] = $userType;

            Flight::redirect('/dashboard');
        } else {
            // Échec de l'authentification
            Flight::render('login', ['error' => 'Nom ou mot de passe incorrect']);
        }
    }
}
?>