<?php
namespace app\controllers;

use app\models\UserModel;
use app\models\ObjetModel;
use Flight;

class HomeController
{
    /**
     * Affiche la page d'accueil avec les objets des autres utilisateurs
     */
    public function index()
    {
        // L'utilisateur est déjà chargé en session via bootstrap.php
        $objets = [];
        
        try {
            // Si un utilisateur est connecté, afficher les objets des autres
            if (isset($_SESSION['user_id'])) {
                $objetModel = new ObjetModel(Flight::db());
                $objets = $objetModel->get_Objects_not_from_membre($_SESSION['user_id']);
            } else {
                // Si personne n'est connecté, afficher tous les objets
                $objetModel = new ObjetModel(Flight::db());
                $objets = $objetModel->get_All_Objects();
            }
        } catch (\Exception $e) {
            // En cas d'erreur, on continue avec un tableau vide
            $objets = [];
        }
        
        Flight::render('accueil', ['objets' => $objets]);
    }

    /**
     * Déconnexion de l'utilisateur
     */
    public function logout()
    {
        // Démarrer la session si nécessaire
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Détruire la session
        session_destroy();
        Flight::redirect('/');
    }
}