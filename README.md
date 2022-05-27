# INITIALISATION DU PROJET

## Récupération des sources

Récupération du projet sur GITHUB : [https://github.com/p2sias/uf_b2_persevere](https://github.com/p2sias/uf_b2_persevere)

```sh
git clone https://github.com/p2sias/uf_b2_persevere
```

## Gestion de la base de données

### Création de la base de données

```sql
DROP IF EXISTS db_name;
CREATE DATABASE db_name;
USE db_name;
```

### Création de l'utilisateur de la base de données

```sql
CREATE USER 'new_user'@'localhost' IDENTIFIED BY 'password'
GRANT ALL PRIVILEGES ON db_name . * TO 'new_user'@'localhost';
```

## Configuration de l'application

### Prérequis :

 * Composer 2.0              (version du développement : 2.2.6)
 * Nodejs 16.0               (version du développement : 16.14.2)
 * Apache 2.4                (version du développement : 2.4.51)
 * MySQL 5.7 / MariaDB 10.6  (version du développement : 5.7.36 / 10.6.5)
 * PHP 8.0                   (version du développement : 8.0.13)

### Environnement

```sh
cd uf_b2_persevere
cp .env.example .env
vi .env
```

Configuration du fichier .env de notre application (mettre les informations correctes concernant la base de données créée précédemment) :
```sh
APP_NAME='My Web App'     # Nom de l'application web
APP_ENV=local             # 'production' en cas de mise en production
APP_KEY=
APP_DEBUG=true            # 'false' en cas de mise en production
APP_URL=http://localhost  # Url d'hébergement de l'application

DB_CONNECTION=mysql
DB_HOST=localhost         # '127.0.0.1' en cas d'échec de connexion
DB_PORT=3306
DB_DATABASE=db_name       # Nom de la base de données
DB_USERNAME=new_user      # Utilisateur de la base de données
DB_PASSWORD=password      # Mot de passe de l'utilisateur
```

Supprimer le fichier .env.example
```sh
rm .env.example
```

Génération de la clé
```sh
php artisan key:generate
```

Création du lien symbolique de stockage des fichiers
```sh
php artisan storage:link
```

### Les paquets
```sh
composer update
composer install
npm i
npm run dev
```

### Création des tables de la base de données
```sh
php artisan migrate:fresh --path=database/migrations/v_1.0
```

### Peuplement de la base de données
Exécuter tous les fichiers, dans la base de données, situés dans le dossier : /database/data/v_1.0

##  Mise en production

Modifier le fichier .env avec les prérequis de la mise en production (commentaires).

Mise en cache de la configuration de l'application
```sh
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Enjoy ;) !
