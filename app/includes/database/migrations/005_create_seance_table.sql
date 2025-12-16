CREATE TABLE
    IF NOT EXISTS seances (
        id INT AUTO_INCREMENT PRIMARY KEY,
        film_id INT NOT NULL,
        salle_id INT NOT NULL,
        date_heure DATETIME NOT NULL,
        statut ENUM ('ouverte', 'complète', 'annulée') NOT NULL DEFAULT 'ouverte',
        CONSTRAINT fk_seances_films FOREIGN KEY (film_id) REFERENCES films (id) ON DELETE RESTRICT ON UPDATE CASCADE,
        CONSTRAINT fk_seances_salles FOREIGN KEY (salle_id) REFERENCES salles (id) ON DELETE RESTRICT ON UPDATE CASCADE
    );