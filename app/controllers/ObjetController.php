<?php
namespace app\controllers;

use app\models\ObjetModel;
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
     * Crée un nouvel objet
     */
    public function createObjet(){
        $objetModel = new ObjetModel(Flight::db());
        
        $nom = Flight::request()->data->nom ?? '';
        $description = Flight::request()->data->description ?? '';
        $prix_estimatif = Flight::request()->data->prix_estimatif ?? 0;
        $id_categorie = Flight::request()->data->id_categorie ?? 1;
        $id_membre = Flight::request()->data->id_membre ?? 0;
        
        $data = [
            'nom' => $nom,
            'description' => $description,
            'prix_estimatif' => $prix_estimatif,
            'id_categorie' => $id_categorie,
            'id_membre' => $id_membre
        ];
        
        $objetModel->createObject($data);
        Flight::redirect('/mes-objets/' . $id_membre);
    }

    /**
     * Met à jour un objet existant
     */
    public function updateObjet($id){
        $objetModel = new ObjetModel(Flight::db());
        
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
        $objetModel = new ObjetModel(Flight::db());
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
