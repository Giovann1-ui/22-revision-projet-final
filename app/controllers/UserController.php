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
        $user = $usermodel->get_User_by_id($id);
        Flight::render('user', ['user' => $user]);
    }

    public function createUser(){
        $usermodel = new UserModel(Flight::db());
        $nom = Flight::request()->data->nom ?? '';
        $mot_de_passe = Flight::request()->data->mot_de_passe ?? '';
        $usermodel->createUser(['nom' => $nom, 'mot_de_passe' => $mot_de_passe]);
        Flight::redirect('/dashboard');
    }

    public function login(){
        $usermodel = new UserModel(Flight::db());
        $nom = Flight::request()->data->nom ?? '';
        $mot_de_passe = Flight::request()->data->mot_de_passe ?? '';
        
        $user = $usermodel->login($nom, $mot_de_passe);
        
        if ($user) {
            // Connexion réussie - créer une session
            Flight::redirect('/dashboard');
        } else {
            // Échec de la connexion
            Flight::render('login', ['error' => 'Nom ou mot de passe incorrect']);
        }
    }

    public function findOrCreate($nom)
    {
        $usermodel = new UserModel(Flight::db());
        
        // Vérifier si l'utilisateur existe
        $user = $usermodel->findByUsername($nom);
        
        if ($user) {
            // L'utilisateur existe déjà
            return $user;
        }
        
        // L'utilisateur n'existe pas, on le crée
        $newUserId = $usermodel->createUser(['nom' => $nom, 'mot_de_passe' => 'password123']);
        
        // Récupérer les données du nouvel utilisateur créé
        return $usermodel->get_User_by_id($newUserId);
    }

    /**
     * Initialise un utilisateur temporaire en session (pour le développement)
     * À appeler au démarrage de l'application
     */
    public function initUserTemp(){
        // Démarrer la session si ce n'est pas déjà fait
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Si aucun utilisateur n'est en session, on charge l'utilisateur par défaut
        if (!isset($_SESSION['user'])) {
            $usermodel = new UserModel(Flight::db());
            $user = $usermodel->get_User_by_id(3); // Utilisateur avec id = 1
            
            if ($user) {
                $_SESSION['user'] = $user;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nom'] = $user['nom'];
            }
        }
    }
    
    /**
     * Récupère l'utilisateur actuellement connecté
     */
    public function getCurrentUser(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return $_SESSION['user'] ?? null;
    }
    
    /**
     * Déconnecte l'utilisateur (vide la session)
     */
    public function logout(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        session_destroy();
        Flight::redirect('/');
    }
}
?>