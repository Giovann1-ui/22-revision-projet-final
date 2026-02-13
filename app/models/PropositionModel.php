<?php
namespace app\models;

use PDO;

class PropositionModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Récupère les propositions reçues par un membre
     */
    public function getPropositionsRecues($id_membre)
    {
        $stmt = $this->db->prepare("
            SELECT P.*, 
                   S.nom as statut,
                   O1.nom as objet1_nom, O1.description as objet1_desc, O1.prix_estimatif as objet1_prix,
                   C1.nom as objet1_categorie,
                   O2.nom as objet2_nom, O2.description as objet2_desc, O2.prix_estimatif as objet2_prix,
                   C2.nom as objet2_categorie,
                   M.nom as proposant_nom
            FROM Propositions P
            JOIN Statut_Proposition S ON P.id_statut_proposition = S.id
            JOIN Objets O1 ON P.id_objet_demande = O1.id
            JOIN Objets O2 ON P.id_objet_propose = O2.id
            JOIN Categories C1 ON O1.id_categorie = C1.id
            JOIN Categories C2 ON O2.id_categorie = C2.id
            JOIN Membres M ON P.id_membre_proposeur = M.id
            INNER JOIN (
                SELECT id_objet_propose, id_objet_demande, id_membre_proposeur, id_membre_receveur, 
                       MAX(date_proposition) as derniere_date
                FROM Propositions
                WHERE id_membre_receveur = :id_membre
                GROUP BY id_objet_propose, id_objet_demande, id_membre_proposeur, id_membre_receveur
            ) AS derniere_prop ON P.id_objet_propose = derniere_prop.id_objet_propose 
                                  AND P.id_objet_demande = derniere_prop.id_objet_demande
                                  AND P.id_membre_proposeur = derniere_prop.id_membre_proposeur
                                  AND P.id_membre_receveur = derniere_prop.id_membre_receveur
                                  AND P.date_proposition = derniere_prop.derniere_date
            WHERE P.id_membre_receveur = :id_membre
            ORDER BY P.date_proposition DESC
        ");
        $stmt->bindValue(':id_membre', $id_membre, PDO::PARAM_INT);
        $stmt->execute();
        $propositions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Ajouter les images pour chaque objet
        foreach ($propositions as &$prop) {
            $prop['objet_propose_images'] = $this->getImagesObjet($prop['id_objet_propose']);
            $prop['objet_demande_images'] = $this->getImagesObjet($prop['id_objet_demande']);
        }

        return $propositions;
    }

    /**
     * Récupère les propositions envoyées par un membre
     */
    public function getPropositionsEnvoyees($id_membre)
    {
        $stmt = $this->db->prepare("
            SELECT P.*, 
                   S.nom as statut,
                   O1.nom as objet1_nom, O1.prix_estimatif as objet1_prix,
                   C1.nom as objet1_categorie,
                   O2.nom as objet2_nom, O2.prix_estimatif as objet2_prix,
                   C2.nom as objet2_categorie,
                   M.nom as destinataire_nom
            FROM Propositions P
            JOIN Statut_Proposition S ON P.id_statut_proposition = S.id
            JOIN Objets O1 ON P.id_objet_demande = O1.id
            JOIN Objets O2 ON P.id_objet_propose = O2.id
            JOIN Categories C1 ON O1.id_categorie = C1.id
            JOIN Categories C2 ON O2.id_categorie = C2.id
            JOIN Membres M ON P.id_membre_receveur = M.id
            INNER JOIN (
                SELECT id_objet_propose, id_objet_demande, id_membre_proposeur, id_membre_receveur, 
                       MAX(date_proposition) as derniere_date
                FROM Propositions
                WHERE id_membre_proposeur = :id_membre
                GROUP BY id_objet_propose, id_objet_demande, id_membre_proposeur, id_membre_receveur
            ) AS derniere_prop ON P.id_objet_propose = derniere_prop.id_objet_propose 
                                  AND P.id_objet_demande = derniere_prop.id_objet_demande
                                  AND P.id_membre_proposeur = derniere_prop.id_membre_proposeur
                                  AND P.id_membre_receveur = derniere_prop.id_membre_receveur
                                  AND P.date_proposition = derniere_prop.derniere_date
            WHERE P.id_membre_proposeur = :id_membre
            ORDER BY P.date_proposition DESC
        ");
        $stmt->bindValue(':id_membre', $id_membre, PDO::PARAM_INT);
        $stmt->execute();
        $propositions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($propositions as &$prop) {
            $prop['objet_propose_images'] = $this->getImagesObjet($prop['id_objet_propose']);
            $prop['objet_demande_images'] = $this->getImagesObjet($prop['id_objet_demande']);
        }

        return $propositions;
    }

    // public function echangerObjet($id_proposition)
    // {
    //     // ! Récupérer les données de la proposition
    //     $stmt = $this->db->prepare("SELECT * FROM Propositions WHERE id = :id");
    //     $stmt->bindValue(':id', $id_proposition, PDO::PARAM_INT);
    //     $stmt->execute();
    //     $proposition = $stmt->fetch(PDO::FETCH_ASSOC);

    //     // ! update des objets pour échanger les propriétaires
    //     $stmt1 = $this->db->prepare("UPDATE Objets SET id_membre = :id_membre WHERE id = :id_objet_propose");
    //     $stmt2 = $this->db->prepare("UPDATE Objets SET id_membre = :id_membre WHERE id = :id_objet_demande");

    //     $stmt1->bindValue(':id_membre', $proposition['id_membre_proposeur'], PDO::PARAM_INT);
    //     $stmt1->bindValue(':id_objet_propose', $proposition['id_objet_propose'], PDO::PARAM_INT);

    //     $stmt2->bindValue(':id_membre', $proposition['id_membre_receveur'], PDO::PARAM_INT);
    //     $stmt2->bindValue(':id_objet_demande', $proposition['id_objet_demande'], PDO::PARAM_INT);

    //     $stmt1->execute();
    //     $stmt2->execute();

    // }

    public function echangerObjet($id_proposition)
{
    // 1. Récupérer les données
    $stmt = $this->db->prepare("SELECT * FROM Propositions WHERE id = :id");
    $stmt->bindValue(':id', $id_proposition, PDO::PARAM_INT);
    $stmt->execute();
    $proposition = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$proposition) return false;

    // 2. Préparer les échanges (Logique inversée)
    // L'objet proposé va chez le receveur
    $stmt1 = $this->db->prepare("UPDATE Objets SET id_membre = :id_receveur WHERE id = :id_objet_propose");
    // L'objet demandé va chez le proposeur
    $stmt2 = $this->db->prepare("UPDATE Objets SET id_membre = :id_proposeur WHERE id = :id_objet_demande");

    $stmt1->bindValue(':id_receveur', $proposition['id_membre_receveur'], PDO::PARAM_INT);
    $stmt1->bindValue(':id_objet_propose', $proposition['id_objet_propose'], PDO::PARAM_INT);

    $stmt2->bindValue(':id_proposeur', $proposition['id_membre_proposeur'], PDO::PARAM_INT);
    $stmt2->bindValue(':id_objet_demande', $proposition['id_objet_demande'], PDO::PARAM_INT);

    $stmt1->execute();
    $stmt2->execute();
    
    // 3. Optionnel : Marquer la proposition comme "terminée"
    // $this->marquerCommeTerminee($id_proposition);
}

    /**
     * Accepte une proposition
     */
    public function accepterProposition($id_proposition)
    {
        // Récupérer l'ID du statut "acceptée"
        $stmt = $this->db->prepare("SELECT id FROM Statut_Proposition WHERE nom = 'Acceptée'");
        $stmt->execute();
        $statut = $stmt->fetch(PDO::FETCH_ASSOC);

        // ! On prend les donnnes de la proposition actuelle

        $stmt = $this->db->prepare("SELECT * FROM Propositions WHERE id = :id");
        $stmt->bindValue(':id', $id_proposition, PDO::PARAM_INT);
        $stmt->execute();
        $proposition = $stmt->fetch(PDO::FETCH_ASSOC);

        // ! on fait un isert au lieu de update pour garder une trace de la proposition acceptée
        $stmt = $this->db->prepare("INSERT INTO Propositions (id_objet_propose, id_objet_demande, id_membre_proposeur, id_membre_receveur, id_statut_proposition)
                                     VALUES (:id_objet_propose, :id_objet_demande, :id_membre_proposeur, :id_membre_receveur, (SELECT id FROM Statut_Proposition WHERE nom = 'Acceptée'))");
        $stmt->bindValue(':id_objet_propose', $proposition['id_objet_propose'], PDO::PARAM_INT);
        $stmt->bindValue(':id_objet_demande', $proposition['id_objet_demande'], PDO::PARAM_INT);
        $stmt->bindValue(':id_membre_proposeur', $proposition['id_membre_proposeur'], PDO::PARAM_INT);
        $stmt->bindValue(':id_membre_receveur', $proposition['id_membre_receveur'], PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Refuse une proposition
     */
    public function refuserProposition($id_proposition)
    {
        $stmt = $this->db->prepare("SELECT id FROM Statut_Proposition WHERE nom = 'Refusée'");
        $stmt->execute();
        $statut = $stmt->fetch(PDO::FETCH_ASSOC);

        // ! On prend les donnnes de la proposition actuelle

        $stmt = $this->db->prepare("SELECT * FROM Propositions WHERE id = :id");
        $stmt->bindValue(':id', $id_proposition, PDO::PARAM_INT);
        $stmt->execute();
        $proposition = $stmt->fetch(PDO::FETCH_ASSOC);

        // ! on fait un isert au lieu de update pour garder une trace de la proposition refusée
        $stmt = $this->db->prepare("INSERT INTO Propositions (id_objet_propose, id_objet_demande, id_membre_proposeur, id_membre_receveur, id_statut_proposition)
                                        VALUES (:id_objet_propose, :id_objet_demande, :id_membre_proposeur, :id_membre_receveur, (SELECT id FROM Statut_Proposition WHERE nom = 'Refusée'))");
        $stmt->bindValue(':id_objet_propose', $proposition['id_objet_propose'], PDO::PARAM_INT);
        $stmt->bindValue(':id_objet_demande', $proposition['id_objet_demande'], PDO::PARAM_INT);
        $stmt->bindValue(':id_membre_proposeur', $proposition['id_membre_proposeur'], PDO::PARAM_INT);
        $stmt->bindValue(':id_membre_receveur', $proposition['id_membre_receveur'], PDO::PARAM_INT);
        $stmt->execute();

        return true;
    }

    /**
     * Annule (supprime) une proposition
     */
    public function annulerProposition($id_proposition)
    {
        // ! On prend les donnnes de la proposition actuelle

        $stmt = $this->db->prepare("SELECT * FROM Propositions WHERE id = :id");
        $stmt->bindValue(':id', $id_proposition, PDO::PARAM_INT);
        $stmt->execute();
        $proposition = $stmt->fetch(PDO::FETCH_ASSOC);

        // ! on fait un isert au lieu de delete pour garder une trace de la proposition annulée
        $stmt = $this->db->prepare("INSERT INTO Propositions (id_objet_propose, id_objet_demande, id_membre_proposeur, id_membre_receveur, id_statut_proposition)
                                     VALUES (:id_objet_propose, :id_objet_demande, :id_membre_proposeur, :id_membre_receveur, (SELECT id FROM Statut_Proposition WHERE nom = 'Annulée'))");
        $stmt->bindValue(':id_objet_propose', $proposition['id_objet_propose'], PDO::PARAM_INT);
        $stmt->bindValue(':id_objet_demande', $proposition['id_objet_demande'], PDO::PARAM_INT);
        $stmt->bindValue(':id_membre_proposeur', $proposition['id_membre_proposeur'], PDO::PARAM_INT);
        $stmt->bindValue(':id_membre_receveur', $proposition['id_membre_receveur'], PDO::PARAM_INT);
        $stmt->execute();

        return true;
    }

    /**
     * Récupère les images d'un objet
     */
    private function getImagesObjet($id_objet)
    {
        $stmt = $this->db->prepare("SELECT url FROM Images WHERE id_objet = :id_objet");
        $stmt->bindValue(':id_objet', $id_objet, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crée une nouvelle proposition
     */
    public function creerProposition($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO Propositions (id_objet_propose, id_objet_demande, id_membre_proposeur, id_membre_receveur, id_statut_proposition)
            VALUES (:objet1, :objet2, :prop1, :prop2, 1)
        ");
        $stmt->bindValue(':objet1', $data['id_objet_propose'], PDO::PARAM_INT);
        $stmt->bindValue(':objet2', $data['id_objet_demande'], PDO::PARAM_INT);
        $stmt->bindValue(':prop1', $data['id_membre_proposeur'], PDO::PARAM_INT);
        $stmt->bindValue(':prop2', $data['id_membre_receveur'], PDO::PARAM_INT);

        return $stmt->execute();
    }
}