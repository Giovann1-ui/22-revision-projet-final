<?php
namespace app\models;

use PDO;

class AdminModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findByUsername(string $username)
    {
        $stmt = $this->db->prepare("SELECT * FROM Admin WHERE nom = :username");
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createAdmin(array $data)
    {
        $stmt = $this->db->prepare("INSERT INTO Admin (nom, mot_de_passe) VALUES (:nom, :mot_de_passe)");
        $stmt->bindValue(':nom', $data['nom'], PDO::PARAM_STR);
        $stmt->bindValue(':mot_de_passe', $data['mot_de_passe'], PDO::PARAM_STR);
        $stmt->execute();
        return $this->db->lastInsertId();
    }
}
?>
