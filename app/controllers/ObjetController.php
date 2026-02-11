<?php
namespace app\controllers;

use app\models\ObjetModel;
use app\models\CategorieModel;
use Flight;

class ObjetController {

    /**
     * Affiche tous les objets avec leurs propriétaires
     */
    public function allObjets(){
        $objetModel = new ObjetModel(Flight::db());
        $objets = $objetModel->get_All_Objects();
        Flight::render('objets', ['objets' => $objets]);
    }

    /**
     * Affiche un objet spécifique par son ID
     */
    public function objet($id){
        $objetModel = new ObjetModel(Flight::db());
        $objet = $objetModel->get_Object_by_id($id);
        Flight::render('objet', ['objet' => $objet]);
    }

    /**
     * Affiche tous les objets d'un membre spécifique
     */
    public function objetsByMembre($id_membre){
        $objetModel = new ObjetModel(Flight::db());
        $objets = $objetModel->get_Objects_by_membre($id_membre);
        Flight::render('mes-objets', ['objets' => $objets]);
    }

    /**
     * Affiche le formulaire pour ajouter un objet
     */
    public function showAddObjetForm(){
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            Flight::redirect('/login');
            return;
        }

        try {
            $categorieModel = new CategorieModel(Flight::db());
            $categories = $categorieModel->get_All_Categories();
        } catch (\Exception $e) {
            $categories = [];
        }
        
        Flight::render('ajouterObjet', ['categories' => $categories]);
    }

    /**
     * Crée un nouvel objet
     */
    public function createObjet(){
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            Flight::redirect('/login');
            return;
        }

        $objetModel = new ObjetModel(Flight::db());
        
        $nom = Flight::request()->data->nom ?? '';
        $description = Flight::request()->data->description ?? '';
        $prix_estimatif = Flight::request()->data->prix_estimatif ?? 0;
        $id_categorie = Flight::request()->data->id_categorie ?? 0;
        
        // Validation
        if (empty($nom) || empty($description) || $prix_estimatif <= 0 || $id_categorie <= 0) {
            $categorieModel = new CategorieModel(Flight::db());
            $categories = $categorieModel->get_All_Categories();
            Flight::render('ajouterObjet', [
                'categories' => $categories,
                'error' => 'Tous les champs sont requis et doivent être valides'
            ]);
            return;
        }
        
        $data = [
            'nom' => $nom,
            'description' => $description,
            'prix_estimatif' => $prix_estimatif,
            'id_categorie' => $id_categorie,
            'id_membre' => $_SESSION['user_id']
        ];
        
        $objetModel->createObject($data);
        Flight::redirect('/profile');
    }

    /**
     * Met à jour un objet existant
     */
    public function updateObjet($id){
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            Flight::json(['success' => false, 'message' => 'Non connecté'], 401);
            return;
        }

        $objetModel = new ObjetModel(Flight::db());
        
        // Vérifier que l'objet appartient à l'utilisateur
        $objet = $objetModel->get_Object_by_id($id);
        if (!$objet || $objet['id_membre'] != $_SESSION['user_id']) {
            Flight::json(['success' => false, 'message' => 'Objet non trouvé ou accès refusé'], 403);
            return;
        }
        
        $nom = Flight::request()->data->nom ?? '';
        $description = Flight::request()->data->description ?? '';
        $prix_estimatif = Flight::request()->data->prix_estimatif ?? 0;
        $id_categorie = Flight::request()->data->id_categorie ?? 1;
        
        $data = [
            'nom' => $nom,
            'description' => $description,
            'prix_estimatif' => $prix_estimatif,
            'id_categorie' => $id_categorie
        ];
        
        $objetModel->updateObject($id, $data);
        Flight::json(['success' => true, 'message' => 'Objet mis à jour']);
    }

    /**
     * Supprime un objet
     */
    public function deleteObjet($id){
        // Logger pour debug
        error_log("DELETE request received for object ID: " . $id);
        error_log("Session user_id: " . ($_SESSION['user_id'] ?? 'not set'));
        
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            error_log("User not logged in");
            Flight::json(['success' => false, 'message' => 'Non connecté'], 401);
            return;
        }

        $objetModel = new ObjetModel(Flight::db());
        
        // Vérifier que l'objet appartient à l'utilisateur
        $objet = $objetModel->get_Object_by_id($id);
        
        if (!$objet) {
            error_log("Object not found: ID " . $id);
            Flight::json(['success' => false, 'message' => 'Objet non trouvé'], 404);
            return;
        }
        
        error_log("Object found, owner: " . $objet['id_membre'] . ", current user: " . $_SESSION['user_id']);
        
        if ($objet['id_membre'] != $_SESSION['user_id']) {
            error_log("Access denied: object owner mismatch");
            Flight::json(['success' => false, 'message' => 'Accès refusé'], 403);
            return;
        }
        
        // Supprimer l'objet
        $deleted = $objetModel->deleteObject($id);
        
        error_log("Delete operation result: " . ($deleted ? 'success' : 'failed'));
        
        if ($deleted) {
            Flight::json(['success' => true, 'message' => 'Objet supprimé avec succès']);
        } else {
            Flight::json(['success' => false, 'message' => 'Erreur lors de la suppression'], 500);
        }
    }

    /**
     * Affiche les objets des autres utilisateurs (pas ceux du membre connecté)
     */
    public function objetsAutresUtilisateurs($id_membre){
        $objetModel = new ObjetModel(Flight::db());
        $objets = $objetModel->get_Objects_not_from_membre($id_membre);
        Flight::render('objets-echange', ['objets' => $objets]);
    }
}
?>
