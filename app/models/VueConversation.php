<?php
namespace app\models;

use Flight;
use PDO;

class VueConversation
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getLastConversations($username)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM v_last_conversations WHERE destinataire = :username
        ");
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}