<?php 
namespace app\models;
use Flight;
use PDO;

class ObjetModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function get_All_Objects()
    {
        $stmt = $this->db->prepare("SELECT O.*, M.nom as nom_membre, C.nom as nom_categorie 
                                     FROM Objets O 
                                     JOIN Membres M ON O.id_membre = M.id 
                                     JOIN Categories C ON O.id_categorie = C.id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un objet par son ID avec les informations du membre et de la catégorie
     */
    public function get_Object_by_id($id)
    {
        $stmt = $this->db->prepare("SELECT O.*, M.nom as nom_membre, C.nom as nom_categorie 
                                     FROM Objets O 
                                     JOIN Membres M ON O.id_membre = M.id 
                                     JOIN Categories C ON O.id_categorie = C.id 
                                     WHERE O.id = :id");
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tous les objets d'un membre spécifique
     */
    public function get_Objects_by_membre($id_membre)
    {
        $stmt = $this->db->prepare("SELECT O.*, C.nom as nom_categorie 
                                     FROM Objets O 
                                     JOIN Categories C ON O.id_categorie = C.id 
                                     WHERE O.id_membre = :id_membre");
        $stmt->bindValue(':id_membre', (int) $id_membre, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tous les objets sauf ceux d'un membre spécifique
     */
    public function get_Objects_not_from_membre($id_membre)
    {
        $stmt = $this->db->prepare("SELECT O.*, M.nom as nom_membre, C.nom as nom_categorie 
                                     FROM Objets O 
                                     JOIN Membres M ON O.id_membre = M.id 
                                     JOIN Categories C ON O.id_categorie = C.id 
                                     WHERE O.id_membre != :id_membre");
        $stmt->bindValue(':id_membre', (int) $id_membre, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crée un nouvel objet
     */
    public function createObject($data)
    {
        $stmt = $this->db->prepare("INSERT INTO Objets (nom, description, prix_estimatif, id_categorie, id_membre) 
                                     VALUES (:nom, :description, :prix_estimatif, :id_categorie, :id_membre)");
        $stmt->bindValue(':nom', $data['nom'], PDO::PARAM_STR);
        $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR);
        $stmt->bindValue(':prix_estimatif', $data['prix_estimatif'], PDO::PARAM_STR);
        $stmt->bindValue(':id_categorie', (int) $data['id_categorie'], PDO::PARAM_INT);
        $stmt->bindValue(':id_membre', (int) $data['id_membre'], PDO::PARAM_INT);
        $stmt->execute();
        
        return $this->db->lastInsertId();
    }

    /**
     * Met à jour un objet existant
     */
    public function updateObject($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE Objets 
                                     SET nom = :nom, description = :description, 
                                         prix_estimatif = :prix_estimatif, id_categorie = :id_categorie 
                                     WHERE id = :id");
        $stmt->bindValue(':nom', $data['nom'], PDO::PARAM_STR);
        $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR);
        $stmt->bindValue(':prix_estimatif', $data['prix_estimatif'], PDO::PARAM_STR);
        $stmt->bindValue(':id_categorie', (int) $data['id_categorie'], PDO::PARAM_INT);
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->rowCount();
    }

    /**
     * Recherche des objets par mot-clé et/ou catégorie (exclut les objets du membre connecté)
     */
    public function searchObjects($keyword = '', $id_categorie = null, $id_membre_exclude = null)
    {
        $sql = "SELECT O.*, M.nom as nom_membre, C.nom as nom_categorie 
                FROM Objets O 
                JOIN Membres M ON O.id_membre = M.id 
                JOIN Categories C ON O.id_categorie = C.id 
                WHERE 1=1";
        $params = [];

        // Exclure les objets du membre connecté
        if ($id_membre_exclude !== null) {
            $sql .= " AND O.id_membre != :id_membre_exclude";
            $params[':id_membre_exclude'] = (int) $id_membre_exclude;
        }

        // Recherche par mot-clé dans le titre ou la description
        if (!empty($keyword)) {
            $sql .= " AND (O.nom LIKE :keyword OR O.description LIKE :keyword)";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        // Filtre par catégorie
        if (!empty($id_categorie)) {
            $sql .= " AND O.id_categorie = :id_categorie";
            $params[':id_categorie'] = (int) $id_categorie;
        }

        $sql .= " ORDER BY O.date_creation DESC";

        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $value) {
            if (is_int($value)) {
                $stmt->bindValue($key, $value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($key, $value, PDO::PARAM_STR);
            }
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Supprime un objet
     */
    public function deleteObject($id)
    {
        $stmt = $this->db->prepare("DELETE FROM Objets WHERE id = :id");
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->rowCount();
    }



}
?>
