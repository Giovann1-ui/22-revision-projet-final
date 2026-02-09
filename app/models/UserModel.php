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
    
    /**
     * Crée un nouvel utilisateur dans la base de données
     * @param array $data Les données de l'utilisateur (pseudo)
     * @return int L'ID du nouvel utilisateur créé
     */
    public function createUser($data)
    {
        $stmt = $this->db->prepare("INSERT INTO Membres (username) VALUES (:username)");
        $stmt->bindValue(':username', $data['username'], PDO::PARAM_STR);
        $stmt->execute();

        return $this->db->lastInsertId();
    }

    /**
     * Trouve un utilisateur par son pseudo
     * @param string $pseudo Le pseudo de l'utilisateur
     * @return array|false Les données de l'utilisateur ou false si non trouvé
     */
    public function findByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM Membres WHERE username = :username");
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Vérifie si un utilisateur existe, sinon le crée
     * Retourne l'utilisateur dans tous les cas
     * @param string $pseudo Le pseudo de l'utilisateur
     * @return array Les données de l'utilisateur (existant ou nouveau)
     */
    // public function findOrCreate($pseudo)
    // {
    //     // Vérifier si l'utilisateur existe
    //     $user = $this->findByUsername($pseudo);
        
    //     if ($user) {
    //         // L'utilisateur existe déjà
    //         return $user;
    //     }
        
    //     // L'utilisateur n'existe pas, on le crée
    //     $newUserId = $this->createUser(['pseudo' => $pseudo]);
        
    //     // Récupérer les données du nouvel utilisateur créé
    //     return $this->get_User($newUserId);
    // }

    /**
     * Récupère tous les utilisateurs
     * @return array Liste de tous les utilisateurs
     */
    public function get_All_Users()
    {
        $stmt = $this->db->prepare("SELECT * FROM Membres");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllUsersNotSelf($selfId)
    {
        $stmt = $this->db->prepare("SELECT * FROM Membres WHERE id_membre != :selfId");
        $stmt->bindValue(':selfId', (int) $selfId, PDO::PARAM_INT); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un utilisateur par son ID
     * @param int $id L'ID de l'utilisateur
     * @return array|false Les données de l'utilisateur ou false si non trouvé
     */
    public function get_User($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Membres WHERE id_membre = :id");
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>