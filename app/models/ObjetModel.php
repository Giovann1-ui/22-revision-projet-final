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

    public function get_image_objet_by_id($id_objet)
    {
        $stmt = $this->db->prepare("SELECT url FROM Images WHERE id_objet = :id_objet");
        $stmt->bindValue(':id_objet', (int) $id_objet, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_All_Objects()
    {
        $stmt = $this->db->prepare("SELECT O.*, M.nom as nom_membre, C.nom as nom_categorie,
                                     GROUP_CONCAT(I.url) as images
                                     FROM Objets O 
                                     JOIN Membres M ON O.id_membre = M.id 
                                     JOIN Categories C ON O.id_categorie = C.id
                                     LEFT JOIN Images I ON O.id = I.id_objet
                                     GROUP BY O.id");
        $stmt->execute();
        $objets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($objets as &$objet) {
            $objet['images'] = $objet['images'] ? explode(',', $objet['images']) : [];
        }
        return $objets;
    }

    /**
     * Récupère un objet par son ID avec les informations du membre et de la catégorie
     */
    public function get_Object_by_id($id)
    {
        $stmt = $this->db->prepare("SELECT O.*, M.nom as nom_membre, C.nom as nom_categorie,
                                     GROUP_CONCAT(I.url) as images
                                     FROM Objets O 
                                     JOIN Membres M ON O.id_membre = M.id 
                                     JOIN Categories C ON O.id_categorie = C.id 
                                     LEFT JOIN Images I ON O.id = I.id_objet
                                     WHERE O.id = :id
                                     GROUP BY O.id");
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $stmt->execute();
        $objet = $stmt->fetch(PDO::FETCH_ASSOC);
        $objet['images'] = $this->get_image_objet_by_id($id);
        return $objet;
    }

    /**
     * Récupère tous les objets d'un membre spécifique
     */
    public function get_Objects_by_membre($id_membre)
    {
        $stmt = $this->db->prepare("SELECT O.*, M.nom as nom_membre, C.nom as nom_categorie,
                                     GROUP_CONCAT(I.url) as images
                                     FROM Objets O 
                                     JOIN Membres M ON O.id_membre = M.id
                                     JOIN Categories C ON O.id_categorie = C.id 
                                     LEFT JOIN Images I ON O.id = I.id_objet
                                     WHERE O.id_membre = :id_membre
                                     GROUP BY O.id");
        $stmt->bindValue(':id_membre', (int) $id_membre, PDO::PARAM_INT);
        $stmt->execute();
        $objets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($objets as &$objet) {
            $images = $objet['images'] ? explode(',', $objet['images']) : [];
            // Transformer en tableau d'objets avec propriété 'url'
            $objet['images'] = array_map(function ($url) {
                return ['url' => $url];
            }, $images);
        }
        return $objets;
    }

    /**
     * Récupère tous les objets sauf ceux d'un membre spécifique
     */
    public function get_Objects_not_from_membre($id_membre)
    {
        $stmt = $this->db->prepare("SELECT O.*, M.nom as nom_membre, C.nom as nom_categorie,
                                     GROUP_CONCAT(I.url) as images
                                     FROM Objets O 
                                     JOIN Membres M ON O.id_membre = M.id 
                                     JOIN Categories C ON O.id_categorie = C.id 
                                     LEFT JOIN Images I ON O.id = I.id_objet
                                     WHERE O.id_membre != :id_membre
                                     GROUP BY O.id");
        $stmt->bindValue(':id_membre', (int) $id_membre, PDO::PARAM_INT);
        $stmt->execute();
        $objets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($objets as &$objet) {
            $objet['images'] = $objet['images'] ? explode(',', $objet['images']) : [];
        }
        return $objets;
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
     * Supprime un objet
     */
    public function deleteObject($id)
    {
        $stmt = $this->db->prepare("DELETE FROM Objets WHERE id = :id");
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount();
    }


    public function addImageObject($idObjet, $url)
    {
        $stmt = $this->db->prepare("INSERT INTO Images (url, id_objet) VALUES (:url, :id_objet)");
        $stmt->bindValue(':url', $url, PDO::PARAM_STR);
        $stmt->bindValue(':id_objet', (int) $idObjet, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function uploadImageToApp($image)
    {
        $uploadDir = '/assets/images/';
        $maxSize = 2 * 1024 * 1024; // 2 Mo
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        // Vérifie si un fichier est soumis
        if ($image != NULL) {
            $file = $image;
            if ($file['error'] !== UPLOAD_ERR_OK) {
                // die('Erreur lors de l’upload : ' . $file['error']);
                return NULL;
            }
            // Vérifie la taille
            if ($file['size'] > $maxSize) {
                die('Le fichier est trop volumineux.');
            }
            // Vérifie le type MIME avec `finfo`
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);
            if (!in_array($mime, $allowedMimeTypes)) {
                die('Type de fichier non autorisé : ' . $mime);
            }
            // renommer le fichier
            $originalName = pathinfo($file['name'], PATHINFO_FILENAME);
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $newName = $originalName . '_' . uniqid() . '.' . $extension;
            // Déplace le fichier
            if (move_uploaded_file($file['tmp_name'], $uploadDir . $newName)) {
                echo "Fichier uploadé avec succès : " . $newName;


                return $newName;
            } else {
                echo "Échec du déplacement du fichier.";
            }
        } else {
            echo "Aucun fichier reçu.";
            return NULL;
        }
    }
}
?>