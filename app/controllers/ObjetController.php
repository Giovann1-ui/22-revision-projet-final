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
            // En cas d'erreur, utiliser un tableau vide
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
                'error' => 'Tous les champs sont requis'
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
        
        $objetModel->deleteObject($id);
        Flight::json(['success' => true, 'message' => 'Objet supprimé']);
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
