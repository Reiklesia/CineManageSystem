-- 1️⃣ Création de la base de données
CREATE DATABASE IF NOT EXISTS cinemanage_db CHARACTER
SET
    utf8mb4 COLLATE utf8mb4_general_ci;

USE cinemanage_db;

CREATE TABLE
    migrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        filename VARCHAR(255) NOT NULL UNIQUE,
        applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

-- 2️⃣ Table : utilisateurs
CREATE TABLE
    IF NOT EXISTS utilisateurs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom_utilisateur VARCHAR(50) NOT NULL,
        mot_de_passe VARCHAR(255) NOT NULL,
		UNIQUE (nom_utilisateur),
		role ENUM('admin', 'user') DEFAULT 'user'
    );

-- Insérer des utilisateurs de test
INSERT INTO utilisateurs (nom_utilisateur, mot_de_passe, role)
VALUES ('admin', 'admin123', 'admin'),
	   ('cinemanager', 'cine2024', 'admin'),
	   ('user1', 'userpass', 'user'),
	   ('user2', 'mypassword', 'user');

-- ⚠️ mot de passe en clair (non sécurisé)
-- 3️⃣ Table : films
CREATE TABLE
    IF NOT EXISTS films (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titre VARCHAR(100) NOT NULL,
        realisateur VARCHAR(100),
        genre VARCHAR(50),
        annee_sortie INT,
        description TEXT,
		affiche VARCHAR(255),
		statut ENUM('actif', 'inactif') DEFAULT 'actif'
    );

	INSERT INTO films (titre, realisateur, genre, annee_sortie, description, affiche, statut)
	VALUES
	('Inception', 'Christopher Nolan', 'Science-fiction', 2010, 'Un voleur qui vole des secrets à travers les rêves.', 'inception.jpg', 'actif'),
	('The Dark Knight', 'Christopher Nolan', 'Action', 2008, 'Batman affronte le Joker à Gotham City.', 'dark_knight.jpg', 'actif'),
	('Interstellar', 'Christopher Nolan', 'Science-fiction', 2014, 'Des explorateurs voyagent à travers un trou de ver.', 'interstellar.jpg', 'actif'),
	('Pulp Fiction', 'Quentin Tarantino', 'Crime', 1994, 'Histoires entrelacées de criminels à Los Angeles.', 'pulp_fiction.jpg', 'actif'),
	('The Matrix', 'The Wachowskis', 'Science-fiction', 1999, 'Un hacker découvre la vérité sur la réalité.', 'matrix.jpg', 'actif'),
	('Forrest Gump', 'Robert Zemeckis', 'Drame', 1994, 'La vie extraordinaire de Forrest Gump.', 'forrest_gump.jpg', 'actif'),
	('The Shawshank Redemption', 'Frank Darabont', 'Drame', 1994, "Deux hommes se lient d'amitié en prison.", 'shawshank.jpg', 'actif'),
	('The Godfather', 'Francis Ford Coppola', 'Crime', 1972, 'La saga de la famille Corleone.', 'godfather.jpg', 'actif'),
	('Fight Club', 'David Fincher', 'Drame', 1999, 'Un homme crée un club de combat clandestin.', 'fight_club.jpg', 'actif'),
	('The Lord of the Rings: The Fellowship of the Ring', 'Peter Jackson', 'Fantasy', 2001, 'Un hobbit entreprend une quête pour détruire un anneau maléfique.', 'lotr_fellowship.jpg', 'actif'),
	('The Avengers', 'Joss Whedon', 'Action', 2012, "Des super-héros s\'unissent pour sauver le monde.", 'avengers.jpg', 'actif'),
	('Titanic', 'James Cameron', 'Romance', 1997, "Une histoire d'amour à bord du Titanic.", 'titanic.jpg', 'actif'),
	('Gladiator', 'Ridley Scott', 'Action', 2000, 'Un général romain devient gladiateur.', 'gladiator.jpg', 'actif'),
	('Avatar', 'James Cameron', 'Science-fiction', 2009, 'Un marine paralysé explore une planète extraterrestre.', 'avatar.jpg', 'actif'),
	('Jurassic Park', 'Steven Spielberg', 'Science-fiction', 1993, "Des dinosaures clonés s'échappent dans un parc à thème.", 'jurassic_park.jpg', 'actif'),
	('The Lion King', 'Roger Allers, Rob Minkoff', 'Animation', 1994, 'Un lionceau destiné à devenir roi.', 'lion_king.jpg', 'actif'),
	('Star Wars: Episode IV - A New Hope', 'George Lucas', 'Science-fiction', 1977, "Un jeune fermier rejoint la rébellion contre l'Empire.", 'star_wars_iv.jpg', 'actif'),
	('Back to the Future', 'Robert Zemeckis', 'Science-fiction', 1985, 'Un adolescent voyage dans le temps avec une machine volante.', 'back_to_the_future.jpg', 'actif'),
	('The Silence of the Lambs', 'Jonathan Demme', 'Thriller', 1991, 'Une jeune agente du FBI consulte un tueur en série pour attraper un autre criminel.', 'silence_of_the_lambs.jpg', 'actif'),
	('Saving Private Ryan', 'Steven Spielberg', 'Guerre', 1998, "Une mission pour sauver un soldat derrière les lignes ennemies pendant la Seconde Guerre mondiale.", 'saving_private_ryan.jpg', 'actif'),
	("Schindler's List", 'Steven Spielberg', 'Drame', 1993, "L'histoire vraie d'un industriel allemand qui sauve des Juifs pendant l'Holocauste.", 'schindlers_list.jpg', 'actif');

-- 4️⃣ Table : salles

CREATE TABLE
	IF NOT EXISTS salles (
		id INT AUTO_INCREMENT PRIMARY KEY,
		nom VARCHAR(50) NOT NULL,
		capacite INT NOT NULL,
		statut ENUM('disponible', 'indisponible') DEFAULT 'disponible'
	);

INSERT INTO salles (nom, capacite, statut)
VALUES
('Salle 1', 100, 'disponible'),
('Salle 2', 150, 'disponible'),
('Salle 3', 200, 'disponible'),
('Salle 4', 120, 'disponible'),
('Salle 5', 80, 'disponible');

-- 5️⃣ Table : séances

CREATE TABLE
	IF NOT EXISTS seances (
		id INT AUTO_INCREMENT PRIMARY KEY,
		film_id INT NOT NULL,
		salle_id INT NOT NULL,
		date_heure DATETIME NOT NULL,
		FOREIGN KEY (film_id) REFERENCES films(id) ON DELETE CASCADE,
		FOREIGN KEY (salle_id) REFERENCES salles(id) ON DELETE CASCADE
	);

INSERT INTO seances (film_id, salle_id, date_heure)
VALUES
(1, 1, '2024-07-01 18:00:00'),
(2, 2, '2024-07-01 20:30:00'),
(3, 3, '2024-07-02 17:00:00'),
(4, 4, '2024-07-02 19:30:00'),
(5, 5, '2024-07-03 16:00:00'),
(6, 1, '2024-07-03 19:00:00'),
(7, 2, '2024-07-04 18:30:00'),
(8, 3, '2024-07-04 21:00:00'),
(9, 4, '2024-07-05 17:30:00'),
(10, 5, '2024-07-05 20:00:00'),
(11, 1, '2024-07-06 18:00:00'),
(12, 2, '2024-07-06 21:00:00'),
(13, 3, '2024-07-07 19:00:00'),
(14, 4, '2024-07-07 22:00:00'),
(15, 5, '2024-07-08 16:30:00'),
(16, 1, '2024-07-08 19:30:00'),
(17, 2, '2024-07-09 18:00:00'),
(18, 3, '2024-07-09 20:30:00'),
(19, 4, '2024-07-10 17:00:00'),
(20, 5, '2024-07-10 19:30:00');