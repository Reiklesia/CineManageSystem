<?php include __DIR__ . '/../../includes/header.php' ?>

<h2>Ajouter un film</h2>
<form method="POST" action="index.php?action=add_film">
    <label>Titre: <input type="text" name="titre" required></label><br>
    <label>Réalisateur: <input type="text" name="realisateur" required></label><br>
    <label>Genre: <input type="text" name="genre" required></label><br>
    <label>Année: <input type="number" name="annee_sortie" required></label><br>
    <label>Description:<br><textarea name="description" required></textarea></label><br>
    <button type="submit" name="add">Ajouter</button>
</form>

<?php include __DIR__ . '/../../includes/footer.php' ?>