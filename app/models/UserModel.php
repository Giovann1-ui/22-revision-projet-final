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
        $stmt = $this->db->prepare("SELECT id, nom, mot_de_passe, carac FROM membres WHERE nom = :username");
        $stmt->bindValue(':username', $nom, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $user['mot_de_passe'] === $motDePasse) {
            return $user;        
        }
        
        return false;
    }

    public function getType($nom) {
        $stmt = $this->db->prepare("SELECT carac FROM membres WHERE nom = :username");
        $stmt->bindValue(':username', $nom, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return $user['carac'];
        }
        
        return null;
    }

    public function findByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM membres WHERE nom = :username");
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($data)
    {
        $stmt = $this->db->prepare("INSERT INTO membres (nom, mot_de_passe, carac) VALUES (:nom, :mot_de_passe, :carac)");
        $stmt->bindValue(':nom', $data['nom'], PDO::PARAM_STR);
        $stmt->bindValue(':mot_de_passe', $data['mot_de_passe'] ?? '', PDO::PARAM_STR);
        $stmt->bindValue(':carac', $data['carac'] ?? 'user', PDO::PARAM_STR);
        $stmt->execute();

        return $this->db->lastInsertId();
    }
}
?>