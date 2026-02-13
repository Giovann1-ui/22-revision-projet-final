-- Active: 1764913120833@@127.0.0.1@3306@takalo

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
    ('iphone12.jpg', 1),
    ('velo.jpg', 2),
    ('livre-cuisine.jpg', 3),
    ('table-basse.jpg', 4),
    ('ps4.jpg', 5);

-- Insertion de propositions de test
INSERT INTO Propositions (id_objet_propose, id_objet_demande, id_membre_proposeur, id_membre_receveur, id_statut_proposition) VALUES 
    (1, 5, 1, 3, 1),
    (2, 4, 1, 2, 2);