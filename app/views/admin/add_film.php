<?php include __DIR__ . '/../../includes/header.php' ?>

<div class="add-film-container">

    <form method="POST" action="index.php?action=add_film" enctype="multipart/form-data" class="add-film-form">

        <div class="form-left">
            <label>Titre du film
                <input type="text" name="titre" required>
            </label>

            <div class="two-cols">
                <label>Année de sortie
                    <input type="number" name="annee_sortie" required>
                </label>

                <label>Genre
                    <select name="genre">
                        <option value="">Genre...</option>
                        <option>Action</option>
                        <option>Drama</option>
                        <option>Comédie</option>
                        <option>Horreur</option>
                        <option>Science-fiction</option>
                        <option>Documentaire</option>
                        <option>Animation</option>
                        <option>Romance</option>
                        <option>Thriller</option>
                        <option>Aventure</option>
                        <option>Fantastique</option>
                        <option>Musical</option>
                        <option>Biographie</option>
                        <option>Guerre</option>
                        <option>Policier</option>
                        <option>Western</option>
                    </select>
                </label>

            </div>
            <label>Réalisateur
                <input type="text" name="realisateur" required>
            </label>

            <label>Synopsis
                <textarea name="description" required></textarea>
            </label>
        </div>

        <div class="form-right">
            <div class="image-preview"></div>

            <label class="file-label">Affiche du film
                <input type="file" name="affiche">
            </label>
        </div>

        <button type="submit" name="add" class="btn-submit">Ajouter</button>

    </form>
</div>


<?php include __DIR__ . '/../../includes/footer.php' ?>