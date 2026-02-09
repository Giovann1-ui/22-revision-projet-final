<?php
namespace app\controllers;

use app\models\UserModel;
use Flight;

class UserController {

    public function allUsers(){
        $usermodel = new UserModel(Flight::db());
        $users = $usermodel->get_All_Users();
        Flight::render('login', ['users' => $users]);
    }

    public function user($id){
        $usermodel = new UserModel(Flight::db());
        $user = $usermodel->get_User($id);
        Flight::render('user', ['user' => $user]);
    }

    public function createUser(){
        $usermodel = new UserModel(Flight::db());
        $username = Flight::request()->data->username ?? '';
        $usermodel->createUser(['username' => $username]);
        Flight::redirect('/dashboard');
    }

    public function findOrCreate($username)
    {
        $usermodel = new UserModel(Flight::db());
        
        // Vérifier si l'utilisateur existe
        $user = $usermodel->findByUsername($username);
        
        if ($user) {
            // L'utilisateur existe déjà
            return $user;
        }
        
        // L'utilisateur n'existe pas, on le crée
        $newUserId = $usermodel->createUser(['username' => $username]);
        
        // Récupérer les données du nouvel utilisateur créé
        return $usermodel->get_User($newUserId);
    }
}
?>