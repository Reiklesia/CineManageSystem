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

-- 2️⃣ Table : utilisateurs
CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_utilisateur VARCHAR(50) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user'
);

-- Insérer un administrateur et un utilisateur de test
INSERT INTO utilisateurs (nom_utilisateur, mot_de_passe, role) VALUES
    ('admin', 'admin123', 'admin'),
    ('user',  'user123',  'user');

-- ⚠️ mot de passe en clair (non sécurisé)

-- 3️⃣ Table : films
CREATE TABLE IF NOT EXISTS films (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(100) NOT NULL,
    realisateur VARCHAR(100),
    genre VARCHAR(50),
    annee_sortie INT,
    description TEXT,
    affiche VARCHAR(255)
);


-- Insérer quelques films de démonstration
INSERT INTO films (titre, realisateur, genre, annee_sortie, description) VALUES
    ('Inception', 'Christopher Nolan', 'Science-Fiction', 2010,
     'Un voleur qui infiltre les rêves des autres pour voler leurs secrets doit accomplir une mission presque impossible.'),
    ('The Godfather', 'Francis Ford Coppola', 'Drame', 1972,
     'L’histoire épique d’une famille mafieuse italienne à New York.'),
    ('Interstellar', 'Christopher Nolan', 'Science-Fiction', 2014,
     'Une équipe d’explorateurs voyage à travers un trou de ver à la recherche d’un nouveau monde habitable.'),
    ('Parasite', 'Bong Joon-ho', 'Thriller', 2019,
     'Une satire sociale racontant la rencontre entre deux familles issues de milieux opposés.');

-- 4️⃣ Table : salles
CREATE TABLE IF NOT EXISTS salles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    capacite INT NOT NULL,
    statut ENUM('disponible', 'indisponible') NOT NULL DEFAULT 'disponible'
);

-- Insérer quelques salles de démonstration
INSERT INTO salles (nom, capacite, statut) VALUES
    ('Salle 1', 100, 'disponible'),
    ('Salle 2', 150, 'disponible'),
    ('Salle 3', 200, 'disponible');

-- 5️⃣ Table : seances
CREATE TABLE IF NOT EXISTS seances (
    id INT AUTO_INCREMENT PRIMARY KEY,
    film_id INT NOT NULL,
    salle_id INT NOT NULL,
    date_heure DATETIME NOT NULL,
    statut ENUM('ouverte', 'complète', 'annulée') NOT NULL DEFAULT 'ouverte',

    CONSTRAINT fk_seances_films
        FOREIGN KEY (film_id) REFERENCES films(id)
        ON DELETE RESTRICT ON UPDATE CASCADE,

    CONSTRAINT fk_seances_salles
        FOREIGN KEY (salle_id) REFERENCES salles(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
);

-- Insérer quelques séances de démonstration
INSERT INTO seances (film_id, salle_id, date_heure, statut) VALUES
    (1, 1, '2025-12-10 19:30:00', 'ouverte'),    -- Inception, Salle 1
    (2, 2, '2025-12-10 20:00:00', 'complète'),   -- The Godfather, Salle 2
    (3, 3, '2025-12-11 19:00:00', 'ouverte'),    -- Interstellar, Salle 3
    (4, 1, '2025-12-11 21:00:00', 'complète'),   -- Parasite, Salle 1
    (1, 2, '2025-12-12 18:30:00', 'ouverte'),    -- Inception, Salle 2
    (2, 3, '2025-12-12 21:15:00', 'annulée');    -- The Godfather, Salle 3 (annulée)

-- ===========================================================
-- Fin du script
-- ===========================================================