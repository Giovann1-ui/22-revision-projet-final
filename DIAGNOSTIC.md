# 🔍 Diagnostic : Utilisateur non connecté

## ✅ Corrections effectuées :

1. **Connexion à la base de données activée** dans `app/config/services.php`
   - Les lignes étaient commentées, maintenant décommentées

2. **Messages d'erreur ajoutés** dans `app/config/bootstrap.php`
   - Affiche les erreurs de connexion à la base de données
   - Indique si l'utilisateur id=1 n'existe pas

3. **Affichage des erreurs** dans `app/views/accueil.php`
   - Messages d'alerte pour les erreurs de connexion
   - Confirmation quand l'utilisateur est connecté

## 🔧 Étapes à suivre pour résoudre le problème :

### Option 1 : Utiliser MySQL local

1. **Installer MySQL/MariaDB :**
   ```bash
   sudo apt install mysql-server
   sudo systemctl start mysql
   ```

2. **Créer la base de données :**
   ```bash
   mysql -u root -p < sql/2026_02_09-01-creationBase.sql
   ```

3. **Vérifier la configuration dans `app/config/config.php` :**
   ```php
   'database' => [
       'host'     => 'localhost',
       'dbname'   => 'takalo',
       'user'     => 'root',
       'password' => '',  // Votre mot de passe MySQL
   ],
   ```

### Option 2 : Ajouter MySQL à Docker (Recommandé)

1. **Mettre à jour `docker-compose.yml` :**
   ```yaml
   version: '3.7'

   services:
       flight:
           image: php:8-alpine
           working_dir: /var/www
           command: php -S 0.0.0.0:8080 -t public
           environment:
               docker: "true"
           ports:
               - "8080:8080"
           volumes:
               - .:/var/www
           depends_on:
               - db

       db:
           image: mysql:8.0
           environment:
               MYSQL_ROOT_PASSWORD: root
               MYSQL_DATABASE: takalo
           ports:
               - "3306:3306"
           volumes:
               - ./sql:/docker-entrypoint-initdb.d
               - mysql_data:/var/lib/mysql

   volumes:
       mysql_data:
   ```

2. **Mettre à jour la config (`app/config/config.php`) :**
   ```php
   'database' => [
       'host'     => 'db',  // Nom du service Docker
       'dbname'   => 'takalo',
       'user'     => 'root',
       'password' => 'root',
   ],
   ```

3. **Relancer Docker :**
   ```bash
   docker-compose down
   docker-compose up -d
   ```

### Option 3 : Utiliser SQLite (Plus simple pour le développement)

1. **Créer une base SQLite :**
   ```bash
   sqlite3 app/database.sqlite < sql/2026_02_09-01-creationBase.sql
   ```

2. **Modifier `app/config/config.php` :**
   ```php
   'database' => [
       'file_path' => __DIR__ . '/../database.sqlite',
   ],
   ```

3. **Modifier `app/config/services.php` :**
   ```php
   $dsn = 'sqlite:' . $config['database']['file_path'];
   $app->register('db', $pdoClass, [ $dsn ]);
   ```

## 🎯 Comment vérifier que ça fonctionne :

1. Accédez à `http://localhost:8080/`
2. Vous devriez voir :
   - ✅ Un message vert "Connecté en tant que..." si tout fonctionne
   - ❌ Un message d'erreur rouge avec les détails du problème

## 📝 Vérifications manuelles :

1. **Vérifier si la base existe :**
   ```bash
   mysql -u root -p -e "SHOW DATABASES LIKE 'takalo';"
   ```

2. **Vérifier si l'utilisateur id=1 existe :**
   ```bash
   mysql -u root -p takalo -e "SELECT * FROM Membres WHERE id=1;"
   ```

3. **Créer manuellement l'utilisateur si nécessaire :**
   ```bash
   mysql -u root -p takalo -e "INSERT INTO Membres (nom, mot_de_passe) VALUES ('admin', 'admin');"
   ```
