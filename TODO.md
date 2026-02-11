# TO DO
- [ ] base de données
    - [ ] créer la base de données
    - [ ] créer les tables
        - [ ] admin (id, nom, mot_de_passe)
        - [ ] membres (id, nom, mot_de_passe)
        - [ ] categories (id, nom)
        - [ ] objets (id, nom, description, prix_estimatif, id_categorie, id_membre)
        - [ ] images (id, url, id_objet)
        - [ ] statut_proposition (id, nom)
        - [ ] propositions (id, id_objet1, id_objet2, id_proprietaire1, id_proprietaire2, id_statut_proposition)
    - [ ] creer les vues
    - [ ] insérer des données de test
  
##### Andriantsoa
- [ ] page de connexion et d'inscription (admin)
    - [ ] login (identique à celui de l'utilisateur)
    - [ ] gestion des categories d'objets (je suis pas sur de comprendre le but ici)
        - [ ] ajouter une catégorie
        - [ ] supprimer une catégorie
- [ ] page de connexion et d'inscription (utilisateur)
    - [ ] login
    - [ ] inscription

## Manantsoa 
- [ ] page d'accueil
    - [ ] afficher les objets avec son propriétaire
    - [ ] afficher les membres
- [ ] page de profil
    - [ ] afficher les informations du membre
        - [ ] nom
    - [ ] afficher les objets du membre
    - [ ] ajouter un objet
    - [ ] supprimer un objet

##

- [ ] page pour gerer les objets du membre
    - [ ] mofifier titre
    - [ ] modifier description
    - [ ] modifier / ajouter / supprimer image
    - [ ] modifiere prix estimatif
- Page pour voir la liste des objets des autres utilisateurs
    - [ ] afficher les objets
    - [ ] ficher d'objets
        - [ ] afficher les informations de l'objet
        - [ ] bouton pour proposer un échange
- Page pour voir les propositions d'échange
    - [ ] afficher les propositions d'échange
    - [ ] accepter ou refuser une proposition d'échange