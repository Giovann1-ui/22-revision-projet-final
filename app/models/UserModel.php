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
        $stmt = $this->db->prepare("SELECT nom, mot_de_passe FROM membres WHERE nom = :username");
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
}
?>