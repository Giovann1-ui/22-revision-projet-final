<?php
namespace app\controllers;

use app\models\UserModel;
use app\models\ObjetModel;
use app\models\CategorieModel;
use Flight;

class HomeController
{
    /**
     * Affiche la page d'accueil avec les objets des autres utilisateurs
     * Supporte la recherche par mot-clé et filtre par catégorie
     */
    public function index()
    {
        $objets = [];
        $categories = [];
        
        // Récupérer les paramètres de recherche
        $keyword = Flight::request()->query['keyword'] ?? '';
        $id_categorie = Flight::request()->query['categorie'] ?? '';
        
        try {
            $objetModel = new ObjetModel(Flight::db());
            $categorieModel = new CategorieModel(Flight::db());
            
            // Charger les catégories pour le select
            $categories = $categorieModel->get_All_Categories();
            
            $id_membre = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
            
            // Si on a des critères de recherche, utiliser searchObjects
            if (!empty($keyword) || !empty($id_categorie)) {
                $objets = $objetModel->searchObjects($keyword, $id_categorie ?: null, $id_membre);
            } else {
                // Sinon, comportement par défaut
                if ($id_membre !== null) {
                    $objets = $objetModel->get_Objects_not_from_membre($id_membre);
                } else {
                    $objets = $objetModel->get_All_Objects();
                }
            }
        } catch (\Exception $e) {
            $objets = [];
        }
        
        Flight::render('accueil', [
            'objets' => $objets,
            'categories' => $categories,
            'keyword' => $keyword,
            'selected_categorie' => $id_categorie,
        ]);
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