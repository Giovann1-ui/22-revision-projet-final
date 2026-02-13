<?php
namespace app\models;

use PDO;

class CategorieModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Récupère toutes les catégories
     */
    public function get_All_Categories()
    {
        $stmt = $this->db->prepare("SELECT * FROM Categories ORDER BY nom ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une catégorie par son ID
     */
    public function get_Category_by_id($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Categories WHERE id = :id");
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>