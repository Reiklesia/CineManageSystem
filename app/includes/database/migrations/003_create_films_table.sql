CREATE TABLE
    IF NOT EXISTS films (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titre VARCHAR(100) NOT NULL,
        realisateur VARCHAR(100),
        genre VARCHAR(50),
        annee_sortie INT,
        description TEXT
    );