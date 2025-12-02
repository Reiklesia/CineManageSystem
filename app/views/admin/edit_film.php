<?php include __DIR__ . '/../../includes/header.php'; ?>

<h2>Modifier le film</h2>

<form method="POST" action="index.php?action=edit_film&id=<?php echo (int) $film['id']; ?>">
    <label for="titre">Titre:
        <input id="titre" type="text" name="titre"
               value="<?php echo htmlspecialchars($film['titre']); ?>" required>
    </label><br>

    <label for="realisateur">Réalisateur:
        <input id="realisateur" type="text" name="realisateur"
               value="<?php echo htmlspecialchars($film['realisateur']); ?>" required>
    </label><br>

    <label for="genre">Genre:
        <input id="genre" type="text" name="genre"
               value="<?php echo htmlspecialchars($film['genre']); ?>" required>
    </label><br>

    <label for="annee_sortie">Année:
        <input id="annee_sortie" type="number" name="annee_sortie"
               value="<?php echo (int) $film['annee_sortie']; ?>" required>
    </label><br>

    <label for="description">Description:<br>
        <textarea id="description" name="description" required><?php
            echo htmlspecialchars($film['description']);
        ?></textarea>
    </label><br>

    <button type="submit" name="update">Modifier</button>
	<button type="button" onclick="window.location.href='index.php?action=dashboard'">Annuler</button>
</form>

<?php include __DIR__ . '/../../includes/footer.php'; ?>

<script src="<?php echo BASE_URL; ?>public/assets/js/util.js"></script>
