CREATE TABLE
    IF NOT EXISTS salles (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(50) NOT NULL,
        capacite INT NOT NULL,
        statut ENUM ('disponible', 'indisponible') NOT NULL DEFAULT 'disponible'
    );