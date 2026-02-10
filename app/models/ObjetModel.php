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
        $stmt = $this->db->prepare("SELECT * FROM Objets J JOIN Membres M ON J.id_membre = M.id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



}
?>
