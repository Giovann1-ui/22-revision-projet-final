CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

-- Insertion de données d'exemple pour la table admin
INSERT INTO admin (nom, mot_de_passe) VALUES
('admin1', 'password1'),
('admin2', 'password2'),
('superadmin', 'admin123');

-- Insertion de données d'exemple pour la table categories
INSERT INTO categories (nom) VALUES
('Électronique'),
('Vêtements'),
('Maison et Jardin'),
('Sports et Loisirs'),
('Livres');