<?php include __DIR__ . '/../../includes/header.php' ?>

<!-- <h2 class="add-film-title">Ajouter un film</h2> -->

<div class="add-film-container">
    
    <form method="POST" action="index.php?action=add_film" enctype="multipart/form-data" class="add-film-form">

        <div class="form-left">
            <label>Titre du film
                <input type="text" name="titre" required>
            </label>

            <div class="two-cols">
                <label>Année de sortie
                    <input type="date" name="annee_sortie" required>
                </label>

                <label>Durée (minutes)
                    <input type="number" name="duree" placeholder="75 minutes" required>
                </label>
            </div>

            <label>Genre
                <select name="genre">
                    <option value="">Genre...</option>
                    <option>Action</option>
                    <option>Drama</option>
                    <option>Comédie</option>
                </select>
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