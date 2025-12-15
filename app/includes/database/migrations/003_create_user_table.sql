CREATE TABLE
    IF NOT EXISTS utilisateurs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom_utilisateur VARCHAR(50) NOT NULL UNIQUE,
        mot_de_passe VARCHAR(255) NOT NULL,
        role ENUM ('admin', 'user') NOT NULL DEFAULT 'user'
    );