-- Active: 1764913120833@@127.0.0.1@3306@takalo
-- Création de la base de données
CREATE DATABASE IF NOT EXISTS takalo;

USE takalo;

DROP TABLE IF EXISTS Propositions;
DROP TABLE IF EXISTS Statut_Proposition;
DROP TABLE IF EXISTS Images;
DROP TABLE IF EXISTS Objets;
DROP TABLE IF EXISTS Categories;
DROP TABLE IF EXISTS Membres;
DROP TABLE IF EXISTS Admin;
-- Table Admin
CREATE TABLE IF NOT EXISTS Admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL
);

-- Table Membres
CREATE TABLE IF NOT EXISTS Membres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL
);

-- Table Categories
CREATE TABLE IF NOT EXISTS Categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL UNIQUE
);

-- Table Objets
CREATE TABLE IF NOT EXISTS Objets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT,
    prix_estimatif DECIMAL(10, 2),
    id_categorie INT NOT NULL,
    id_membre INT NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_categorie) REFERENCES Categories(id) ON DELETE CASCADE,
    FOREIGN KEY (id_membre) REFERENCES Membres(id) ON DELETE CASCADE
);

-- Table Images
CREATE TABLE IF NOT EXISTS Images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    url VARCHAR(500) NOT NULL,
    id_objet INT NOT NULL,
    FOREIGN KEY (id_objet) REFERENCES Objets(id) ON DELETE CASCADE
);

-- Table Statut_Proposition
CREATE TABLE IF NOT EXISTS Statut_Proposition (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE
);

-- Table Propositions
CREATE TABLE IF NOT EXISTS Propositions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_objet_propose INT NOT NULL,
    id_objet_demande INT NOT NULL,
    id_membre_proposeur INT NOT NULL,
    id_membre_receveur INT NOT NULL,
    id_statut_proposition INT NOT NULL,
    date_proposition TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_objet_propose) REFERENCES Objets(id) ON DELETE CASCADE,
    FOREIGN KEY (id_objet_demande) REFERENCES Objets(id) ON DELETE CASCADE,
    FOREIGN KEY (id_membre_proposeur) REFERENCES Membres(id) ON DELETE CASCADE,
    FOREIGN KEY (id_membre_receveur) REFERENCES Membres(id) ON DELETE CASCADE,
    FOREIGN KEY (id_statut_proposition) REFERENCES Statut_Proposition(id) ON DELETE CASCADE
);
-- Table Historique_Echanges
CREATE TABLE IF NOT EXISTS Historique_Echanges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_proposition INT NOT NULL,
    id_objet_propose INT NOT NULL,
    id_objet_demande INT NOT NULL,
    id_membre_proposeur INT NOT NULL,
    id_membre_receveur INT NOT NULL,
    date_echange TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_proposition) REFERENCES Propositions(id) ON DELETE CASCADE,
    FOREIGN KEY (id_objet_propose) REFERENCES Objets(id) ON DELETE CASCADE,
    FOREIGN KEY (id_objet_demande) REFERENCES Objets(id) ON DELETE CASCADE,
    FOREIGN KEY (id_membre_proposeur) REFERENCES Membres(id) ON DELETE CASCADE,
    FOREIGN KEY (id_membre_receveur) REFERENCES Membres(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Historique_Proprietaire_Objet (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_objet INT NOT NULL,
    id_membre INT NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_objet) REFERENCES Objets(id) ON DELETE CASCADE,
    FOREIGN KEY (id_membre) REFERENCES Membres(id) ON DELETE CASCADE
);

-- vue historique d'appartenance d'un objet
CREATE OR REPLACE VIEW v_historique_appartenance_objet AS
SELECT P.id, `O1`.nom AS nom_objet_membre2, `O2`.nom AS nom_objet_membre1, M1.nom AS nom_membre1, M2.nom AS nom_membre2,
`O1`.id as id_objet_membre2, `O2`.id as id_objet_membre1,P.date_proposition
FROM `Propositions` P
JOIN `Membres` M1 ON P.id_membre_proposeur = M1.id
JOIN `Membres` M2 ON P.id_membre_receveur = M2.id
JOIN `Objets` O1 ON P.id_objet_propose = O1.id
JOIN `Objets` O2 ON P.id_objet_demande = O2.id
JOIN `Categories` C ON O1.id_categorie = C.id
JOIN `Categories` C2 ON O2.id_categorie = C2.id
WHERE P.id_statut_proposition = (SELECT id FROM Statut_Proposition WHERE nom = 'Acceptée')
ORDER BY P.date_proposition DESC
;