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

    public function createUser($data)
    {
        $stmt = $this->db->prepare("INSERT INTO Membres (nom, mot_de_passe) VALUES (:nom, :mot_de_passe)");
        $stmt->bindValue(':nom', $data['nom'], PDO::PARAM_STR);
        $stmt->bindValue(':mot_de_passe', $data['mot_de_passe'], PDO::PARAM_STR);
        $stmt->execute();

        return $this->db->lastInsertId();
    }


    public function findByUsername($nom)
    {
        $stmt = $this->db->prepare("SELECT * FROM Membres WHERE nom = :nom");
        $stmt->bindValue(':nom', $nom, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function get_All_Users()
    {
        $stmt = $this->db->prepare("SELECT * FROM Membres");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllUsersNotSelf($selfId)
    {
        $stmt = $this->db->prepare("SELECT * FROM Membres WHERE id != :selfId");
        $stmt->bindValue(':selfId', (int) $selfId, PDO::PARAM_INT); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_User_by_id($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Membres WHERE id = :id");
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function login($nom, $mot_de_passe)
    {
        $stmt = $this->db->prepare("SELECT * FROM Membres WHERE nom = :nom AND mot_de_passe = :mot_de_passe");
        $stmt->bindValue(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindValue(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>