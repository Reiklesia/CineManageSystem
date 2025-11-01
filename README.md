# CineManageNode

[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-blue)](https://www.php.net/) 
[![MySQL Version](https://img.shields.io/badge/MySQL-5.7%2B-orange)](https://www.mysql.com/) 
[![License](https://img.shields.io/badge/License-MIT-green)](LICENSE)

## Description
CineManageNode est un système de gestion pour la gestion des films, projections et utilisateurs.  
Développé avec **HTML, CSS, PHP** pour le backend et **MySQL** pour la base de données, le système permet :  

- Gestion des utilisateurs et authentification  
- Ajout, modification et suppression de films  
- Gestion des projections et réservations  
- Interface web intuitive et responsive  

---

## Technologies utilisées
- **Frontend** : HTML, CSS, JavaScript  
- **Backend** : PHP 7.4+  
- **Base de données** : MySQL / MariaDB  
- **Serveur recommandé** : Apache ou Nginx  
- **Environnement de développement** : XAMPP, MAMP, WAMP  

---

## Prérequis
Avant d’installer le projet, assurez-vous d’avoir :  

- PHP 7.4 ou supérieur  
- MySQL ou MariaDB  
- Serveur web Apache ou Nginx  
- Navigateur moderne (Chrome, Firefox, Edge, Safari)  

---

## Installation

### 1. Cloner le projet
```bash
git clone  https://github.com/AsmaTechAI/CineManageSystem.git
cd CineManageNode
2. Importer la base de données
Créez une base de données MySQL (ex. cinemanage)

Importez le fichier SQL fourni (database.sql) via phpMyAdmin ou en ligne de commande :

bash
Copy code
mysql -u root -p cinemanage < database.sql
3. Configurer la connexion à la base de données
Modifiez le fichier config.php avec vos informations MySQL :

php
Copy code
$host = "localhost";
$username = "root";
$password = "";
$database = "cinemanage";
4. Lancer le serveur
Placez le projet dans le dossier htdocs (XAMPP) ou équivalent

Démarrez Apache et MySQL

Accédez au projet via votre navigateur :

arduino
Copy code
http://localhost/CineManageNode/
Structure du projet
bash
Copy code
CineManageNode/
│
├─ index.php           # Page d’accueil
├─ config.php          # Configuration de la base de données
├─ assets/
│   ├─ css/            # Feuilles de style
│   ├─ js/             # Scripts JavaScript
│   └─ images/         # Images du site
├─ includes/           # Fichiers PHP réutilisables (header, footer, fonctions)
├─ pages/              # Pages principales du système
└─ database.sql        # Fichier de la base de données
Sécurité et bonnes pratiques
Évitez d’exposer config.php sur un serveur public.

Utilisez des mots de passe forts pour MySQL et les utilisateurs.

Filtrez et validez toutes les entrées utilisateurs pour éviter les injections SQL.

Activez HTTPS sur votre serveur pour sécuriser les connexions.

Contribution
Les contributions sont les bienvenues !

Fork le projet

Créez une branche pour votre fonctionnalité (git checkout -b feature/ma-fonctionnalité)

Committez vos modifications (git commit -m "Ajout de ..." )

Poussez sur votre branche (git push origin feature/ma-fonctionnalité)

Ouvrez un Pull Request

Licence
Ce projet est sous licence MIT. Voir le fichier LICENSE pour plus de détails.
