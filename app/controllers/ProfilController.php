<?php
namespace app\controllers;

use app\models\UserModel;
use app\models\ObjetModel;
use Flight;

class ProfilController
{
    /**
     * Affiche le profil de l'utilisateur connecté
     */
    public function monProfil()
    {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            Flight::redirect('/login');
            return;
        }

        $userModel = new UserModel(Flight::db());
        $objetModel = new ObjetModel(Flight::db());

        // Récupérer les informations de l'utilisateur
        $user = $userModel->get_User_by_id($_SESSION['user_id']);

        // Récupérer les objets de l'utilisateur
        $objets = $objetModel->get_Objects_by_membre($_SESSION['user_id']);

        // Compter les statistiques
        $stats = [
            'total_objets' => count($objets),
            'valeur_totale' => array_sum(array_column($objets, 'prix_estimatif')),
        ];

        Flight::render('myprofil', [
            'user' => $user,
            'objets' => $objets,
            'stats' => $stats
        ]);
    }

    /**
     * Met à jour les informations du profil
     */
    public function updateProfil()
    {
        if (!isset($_SESSION['user_id'])) {
            Flight::json(['success' => false, 'message' => 'Non connecté'], 401);
            return;
        }

        $userModel = new UserModel(Flight::db());
        $nom = Flight::request()->data->nom ?? '';

        if (empty($nom)) {
            Flight::json(['success' => false, 'message' => 'Le nom est requis'], 400);
            return;
        }

        // Vérifier si le nom est déjà pris par un autre utilisateur
        $existingUser = $userModel->findByUsername($nom);
        if ($existingUser && $existingUser['id'] != $_SESSION['user_id']) {
            Flight::json(['success' => false, 'message' => 'Ce nom est déjà utilisé'], 400);
            return;
        }

        // Mettre à jour l'utilisateur
        $userModel->updateUser($_SESSION['user_id'], ['nom' => $nom]);

        // Mettre à jour la session
        $_SESSION['user_nom'] = $nom;

        Flight::json(['success' => true, 'message' => 'Profil mis à jour']);
    }
}