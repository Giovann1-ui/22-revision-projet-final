<?php
namespace app\controllers;

use app\models\UserModel;
use Flight;

class HomeController
{
    /**
     * Affiche la page d'accueil
     */
    public function index()
    {
        // L'utilisateur est déjà chargé en session via bootstrap.php
        // On affiche simplement la page d'accueil
        Flight::render('accueil');
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