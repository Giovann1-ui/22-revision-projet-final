-- Création de la base de données
CREATE DATABASE IF NOT EXISTS takalo;

USE takalo;

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
    id_objet1 INT NOT NULL,
    id_objet2 INT NOT NULL,
    id_proprietaire1 INT NOT NULL,
    id_proprietaire2 INT NOT NULL,
    id_statut_proposition INT NOT NULL,
    date_proposition TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_objet1) REFERENCES Objets(id) ON DELETE CASCADE,
    FOREIGN KEY (id_objet2) REFERENCES Objets(id) ON DELETE CASCADE,
    FOREIGN KEY (id_proprietaire1) REFERENCES Membres(id) ON DELETE CASCADE,
    FOREIGN KEY (id_proprietaire2) REFERENCES Membres(id) ON DELETE CASCADE,
    FOREIGN KEY (id_statut_proposition) REFERENCES Statut_Proposition(id) ON DELETE CASCADE
);

-- Insertion des statuts de proposition par défaut
INSERT INTO Statut_Proposition (nom) VALUES 
    ('En attente'),
    ('Acceptée'),
    ('Refusée'),
    ('Annulée');

-- Insertion de catégories de test
INSERT INTO Categories (nom) VALUES 
    ('Électronique'),
    ('Vêtements'),
    ('Livres'),
    ('Meubles'),
    ('Sports & Loisirs'),
    ('Jouets'),
    ('Autres');

-- Insertion d'un admin de test (mot de passe: admin)
INSERT INTO Admin (nom, mot_de_passe) VALUES 
    ('admin', 'admin');

-- Insertion de membres de test
INSERT INTO Membres (nom, mot_de_passe) VALUES 
    ('jean_dupont', 'password123'),
    ('marie_martin', 'password123'),
    ('pierre_durand', 'password123');

-- Insertion d'objets de test
INSERT INTO Objets (nom, description, prix_estimatif, id_categorie, id_membre) VALUES 
    ('iPhone 12', 'Téléphone en bon état, peu utilisé', 450.00, 1, 1),
    ('Vélo de montagne', 'VTT en excellent état', 200.00, 5, 1),
    ('Livre de cuisine', 'Collection de recettes traditionnelles', 15.00, 3, 2),
    ('Table basse', 'Table en bois massif', 80.00, 4, 2),
    ('Console PS4', 'Console avec 2 manettes', 180.00, 1, 3);

-- Insertion d'images de test
INSERT INTO Images (url, id_objet) VALUES 
    ('/assets/images/iphone12.jpg', 1),
    ('/assets/images/velo.jpg', 2),
    ('/assets/images/livre-cuisine.jpg', 3),
    ('/assets/images/table-basse.jpg', 4),
    ('/assets/images/ps4.jpg', 5);

-- Insertion de propositions de test
INSERT INTO Propositions (id_objet1, id_objet2, id_proprietaire1, id_proprietaire2, id_statut_proposition) VALUES 
    (1, 5, 1, 3, 1),
    (2, 4, 1, 2, 2);