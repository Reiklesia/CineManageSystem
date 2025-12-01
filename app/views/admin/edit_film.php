<?php
include __DIR__ . '/../../includes/header.php';
?>

<h2>Modifier le film</h2>

<form method="POST" action="index.php?action=edit_film&id=<?php echo (int) $film['id']; ?>">
    <label>Titre:
        <input type="text" name="titre"
               value="<?php echo htmlspecialchars($film['titre']); ?>" required>
    </label><br>

    <label>Réalisateur:
        <input type="text" name="realisateur"
               value="<?php echo htmlspecialchars($film['realisateur']); ?>" required>
    </label><br>

    <label>Genre:
        <input type="text" name="genre"
               value="<?php echo htmlspecialchars($film['genre']); ?>" required>
    </label><br>

    <label>Année:
        <input type="number" name="annee_sortie"
               value="<?php echo (int) $film['annee_sortie']; ?>" required>
    </label><br>

    <label>Description:<br>
        <textarea name="description" required><?php
            echo htmlspecialchars($film['description']);
        ?></textarea>
    </label><br>

    <button type="submit" name="update">Modifier</button>
</form>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
