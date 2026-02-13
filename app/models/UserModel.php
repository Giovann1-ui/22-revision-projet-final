<?php
namespace app\models;

use Flight;
use PDO;

class UserModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function authenticate($nom, $motDePasse)
    {
        $stmt = $this->db->prepare("SELECT id, nom, mot_de_passe FROM Membres WHERE nom = :username");
        $stmt->bindValue(':username', $nom, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $user['mot_de_passe'] === $motDePasse) {
            return $user;        
        }
        
        return false;
    }

    public function createUser(array $data)
    {
        $stmt = $this->db->prepare("INSERT INTO Membres (nom, mot_de_passe) VALUES (:nom, :mot_de_passe)");
        $stmt->bindValue(':nom', $data['nom'], PDO::PARAM_STR);
        $stmt->bindValue(':mot_de_passe', $data['mot_de_passe'], PDO::PARAM_STR);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function get_User_by_id($id)
    {
        $stmt = $this->db->prepare("SELECT id, nom FROM Membres WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>