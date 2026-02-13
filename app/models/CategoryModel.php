<?php
namespace app\models;

use PDO;

class CategoryModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM Categories ORDER BY nom ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Categories WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data)
    {
        $stmt = $this->db->prepare("INSERT INTO Categories (nom) VALUES (:nom)");
        $stmt->bindValue(':nom', $data['nom'], PDO::PARAM_STR);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM Categories WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getUserCount()
    {
        $stmt = $this->db->prepare("SELECT COUNT(id) as count FROM Membres");
        $stmt->execute();
        $result = $stmt->fetch();
        return isset($result['count']) ? $result['count'] : 0;
    }

    public function getExchangeCount()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM Propositions WHERE id_statut_proposition = (SELECT id FROM Statut_proposition WHERE id = 2)");
        $stmt->execute();
        $result = $stmt->fetch();
        return isset($result['count']) ? $result['count'] : 0;
    }
}
?>