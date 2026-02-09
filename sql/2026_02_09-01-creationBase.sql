-- Active: 1770231351790@@127.0.0.1@3306@takalo
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
