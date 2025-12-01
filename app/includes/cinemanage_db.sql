-- ===========================================================
-- Script SQL - Base de données du système existant CinéManage
-- Version : Système initial (avant refonte)
-- Base de données : cinemanage_db
-- Auteur : Équipe de développement initiale
-- ===========================================================

-- 1️⃣ Création de la base de données
CREATE DATABASE IF NOT EXISTS cinemanage_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE cinemanage_db;

-- 2️⃣ Table : administrateurs
CREATE TABLE IF NOT EXISTS administrateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_utilisateur VARCHAR(50) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL
);

-- Insérer un administrateur de test
INSERT INTO administrateurs (nom_utilisateur, mot_de_passe)
VALUES ('admin', 'admin123'); -- ⚠️ mot de passe en clair (non sécurisé)

-- 3️⃣ Table : films
CREATE TABLE IF NOT EXISTS films (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(100) NOT NULL,
    realisateur VARCHAR(100),
    genre VARCHAR(50),
    annee_sortie INT,
    description TEXT
);

-- Insérer quelques films de démonstration
INSERT INTO films (titre, realisateur, genre, annee_sortie, description)
VALUES 
('Inception', 'Christopher Nolan', 'Science-Fiction', 2010, 'Un voleur qui infiltre les rêves des autres pour voler leurs secrets doit accomplir une mission presque impossible.'),
('The Godfather', 'Francis Ford Coppola', 'Drame', 1972, 'L’histoire épique d’une famille mafieuse italienne à New York.'),
('Interstellar', 'Christopher Nolan', 'Science-Fiction', 2014, 'Une équipe d’explorateurs voyage à travers un trou de ver à la recherche d’un nouveau monde habitable.'),
('Parasite', 'Bong Joon-ho', 'Thriller', 2019, 'Une satire sociale racontant la rencontre entre deux familles issues de milieux opposés.');

-- 4️⃣ Index et contraintes
-- (aucune clé étrangère dans le système existant)
-- (aucune normalisation appliquée)

-- 5️⃣ Droits d’accès
-- (aucune gestion d’utilisateurs SQL spécifique dans le système existant)

-- ===========================================================
-- Fin du script
-- ===========================================================
