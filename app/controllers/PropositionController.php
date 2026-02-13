<?php
namespace app\controllers;

use app\models\ObjetModel;
use app\models\PropositionModel;
use Flight;

class PropositionController
{
    public function choisirObjet($id_objet)
    {
        if (!isset($_SESSION['user_id'])) {
            Flight::redirect('/login');
            return;
        }

        $objetModel = new ObjetModel(Flight::db());
        $objet_demande = $objetModel->get_Object_by_id($id_objet);
        $mes_objets = $objetModel->get_Objects_by_membre($_SESSION['user_id']);
        
        Flight::render('liste-objets-echangeable', [
            'objet_demande' => $objet_demande,
            'mes_objets' => $mes_objets
        ]);
    }

    public function creerProposition()
    {
        if (!isset($_SESSION['user_id'])) {
            Flight::json(['success' => false, 'message' => 'Non connecté'], 401);
            return;
        }

        $id_objet_demande = Flight::request()->data->id_objet_demande ?? 0;
        $id_objet_propose = Flight::request()->data->id_objet_propose ?? 0;
        $id_membre_receveur = Flight::request()->data->id_membre_receveur ?? 0;

        if ($id_objet_demande <= 0 || $id_objet_propose <= 0) {
            Flight::json(['success' => false, 'message' => 'Données invalides'], 400);
            return;
        }
        
        $propositionModel = new PropositionModel(Flight::db());
        $result = $propositionModel->creerProposition([
            'id_objet_demande' => $id_objet_demande,
            'id_objet_propose' => $id_objet_propose,
            'id_membre_receveur' => $id_membre_receveur,
            'id_membre_proposeur' => $_SESSION['user_id']
        ]);

        if ($result) {
            Flight::redirect('/propositions?success=1');
        } else {
            Flight::redirect('/propositions?error=1');
        }
    }

    public function mesPropositions()
    {
        if (!isset($_SESSION['user_id'])) {
            Flight::redirect('/login');
            return;
        }

        $propositionModel = new PropositionModel(Flight::db());
        
        $propositions_recues = $propositionModel->getPropositionsRecues($_SESSION['user_id']);
        $propositions_envoyees = $propositionModel->getPropositionsEnvoyees($_SESSION['user_id']);

        Flight::render('propositions', [
            'propositions_recues' => $propositions_recues,
            'propositions_envoyees' => $propositions_envoyees
        ]);
    }

    public function accepterProposition($id)
    {
        if (!isset($_SESSION['user_id'])) {
            Flight::json(['success' => false, 'message' => 'Non connecté'], 401);
            return;
        }

        $propositionModel = new PropositionModel(Flight::db());
        $propositionModel->accepterProposition($id);
        $propositionModel->echangerObjet($id);

        Flight::redirect('/propositions?success=1');
    }

    public function refuserProposition($id)
    {
        if (!isset($_SESSION['user_id'])) {
            Flight::json(['success' => false, 'message' => 'Non connecté'], 401);
            return;
        }

        $propositionModel = new PropositionModel(Flight::db());
        $result = $propositionModel->refuserProposition($id);

        Flight::redirect('/propositions?success=2');
    }

    public function annulerProposition($id)
    {
        if (!isset($_SESSION['user_id'])) {
            Flight::json(['success' => false, 'message' => 'Non connecté'], 401);
            return;
        }

        $propositionModel = new PropositionModel(Flight::db());
        $result = $propositionModel->annulerProposition($id);

        Flight::redirect('/propositions?success=3');
    }
}