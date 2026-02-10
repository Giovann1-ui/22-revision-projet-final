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
     * @param array $data Les données de l'utilisateur (nom, mot_de_passe)
     * @return int L'ID du nouvel utilisateur créé
     */
    public function createUser($data)
    {
        $stmt = $this->db->prepare("INSERT INTO Membres (nom, mot_de_passe) VALUES (:nom, :mot_de_passe)");
        $stmt->bindValue(':nom', $data['nom'], PDO::PARAM_STR);
        $stmt->bindValue(':mot_de_passe', $data['mot_de_passe'], PDO::PARAM_STR);
        $stmt->execute();

        return $this->db->lastInsertId();
    }

    /**
     * Trouve un utilisateur par son nom
     * @param string $nom Le nom de l'utilisateur
     * @return array|false Les données de l'utilisateur ou false si non trouvé
     */
    public function findByUsername($nom)
    {
        $stmt = $this->db->prepare("SELECT * FROM Membres WHERE nom = :nom");
        $stmt->bindValue(':nom', $nom, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Vérifie si un utilisateur existe, sinon le crée
     * Retourne l'utilisateur dans tous les cas
     * @param string $pseudo Le pseudo de l'utilisateur
     * @return array Les données de l'utilisateur (existant ou nouveau)
     */
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
        $stmt = $this->db->prepare("SELECT * FROM Membres WHERE id != :selfId");
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
        $stmt = $this->db->prepare("SELECT * FROM Membres WHERE id = :id");
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Vérifie les identifiants de connexion d'un utilisateur
     * @param string $nom Le nom de l'utilisateur
     * @param string $mot_de_passe Le mot de passe en clair
     * @return array|false Les données de l'utilisateur si les identifiants sont corrects, false sinon
     */
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