<?php include __DIR__ . '/../../includes/header.php' ?>


<div class="add-film-container">

    <form method="POST" action="index.php?action=add_film" enctype="multipart/form-data" class="add-film-form">

        <div class="form-left">
            <label>Titre du film
                <input type="text" name="titre" value="<?php echo htmlspecialchars($film['titre']); ?>" required>
            </label>

            <div class="two-cols">
                <label>Année de sortie
                    <input type="number" name="annee_sortie" value="<?php echo (int) $film['annee_sortie']; ?>"
                        required>
                </label>

                <label for="genre">Genre
                    <select id="genre" name="genre">
                        <option value="Action" <?php if ($film['genre'] === 'Action')
                            echo 'selected'; ?>>Action
                        </option>
                        <option value="Drama" <?php if ($film['genre'] === 'Drama')
                            echo 'selected'; ?>>Drama</option>
                        <option value="Comédie" <?php if ($film['genre'] === 'Comédie')
                            echo 'selected'; ?>>Comédie
                        </option>
                        <option value="Horreur" <?php if ($film['genre'] === 'Horreur')
                            echo 'selected'; ?>>Horreur
                        </option>
                        <option value="Science-fiction" <?php if ($film['genre'] === 'Science-fiction')
                            echo 'selected'; ?>>Science-fiction</option>
                        <option value="Documentaire" <?php if ($film['genre'] === 'Documentaire')
                            echo 'selected'; ?>>
                            Documentaire</option>
                        <option value="Animation" <?php if ($film['genre'] === 'Animation')
                            echo 'selected'; ?>>
                            Animation</option>
                        <option value="Romance" <?php if ($film['genre'] === 'Romance')
                            echo 'selected'; ?>>Romance
                        </option>
                        <option value="Thriller" <?php if ($film['genre'] === 'Thriller')
                            echo 'selected'; ?>>Thriller
                        </option>
                        <option value="Aventure" <?php if ($film['genre'] === 'Aventure')
                            echo 'selected'; ?>>Aventure
                        </option>
                        <option value="Fantastique" <?php if ($film['genre'] === 'Fantastique')
                            echo 'selected'; ?>>
                            Fantastique</option>
                        <option value="Musical" <?php if ($film['genre'] === 'Musical')
                            echo 'selected'; ?>>Musical
                        </option>
                        <option value="Biographie" <?php if ($film['genre'] === 'Biographie')
                            echo 'selected'; ?>>
                            Biographie</option>
                        <option value="Guerre" <?php if ($film['genre'] === 'Guerre')
                            echo 'selected'; ?>>Guerre
                        </option>
                        <option value="Policier" <?php if ($film['genre'] === 'Policier')
                            echo 'selected'; ?>>Policier
                        </option>
                        <option value="Western" <?php if ($film['genre'] === 'Western')
                            echo 'selected'; ?>>Western
                        </option>
                    </select>
                </label>

            </div>
            <label for="realisateur">Réalisateur:
                <input id="realisateur" type="text" name="realisateur"
                    value="<?php echo htmlspecialchars($film['realisateur']); ?>" required>
            </label>

            <label for="description">Description:<br>
                <textarea id="description" name="description" required><?php
                echo htmlspecialchars($film['description']);
                ?></textarea>
            </label>
        </div>

        <div class="form-right">
            <div class="image-preview">
                <img src="uploads/<?php echo htmlspecialchars($film['titre']); ?>.png" alt="Aucune affiche disponible">
            </div>

            <label class="file-label">Changer l'affiche du film
                <input type="file" name="affiche">
            </label>
        </div>

        <button type="submit" name="add" class="btn-submit">Ajouter</button>

    </form>
</div>


<?php include __DIR__ . '/../../includes/footer.php' ?>