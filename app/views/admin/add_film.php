<?php
include __DIR__ . '/../../includes/header.php';
$old = $_SESSION['old'] ?? [];
?>

<h2>Ajouter un film</h2>

<form method="POST" action="index.php?action=add_film">
    <label>Titre:
        <input type="text" name="titre"
               value="<?= htmlspecialchars($old['titre'] ?? '') ?>" required>
    </label><br>

    <label>Réalisateur:
        <input type="text" name="realisateur"
               value="<?= htmlspecialchars($old['realisateur'] ?? '') ?>" required>
    </label><br>

    <label>Genre:
        <input type="text" name="genre"
               value="<?= htmlspecialchars($old['genre'] ?? '') ?>" required>
    </label><br>

    <label>Année:
        <input type="number" name="annee_sortie"
               value="<?= htmlspecialchars($old['annee_sortie'] ?? '') ?>" required>
    </label><br>

    <label>Description:<br>
        <textarea name="description" required><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
    </label><br>

    <button type="submit" name="add">Ajouter</button>
</form>

<?php
unset($_SESSION['old']);
include __DIR__ . '/../../includes/footer.php';
?>

