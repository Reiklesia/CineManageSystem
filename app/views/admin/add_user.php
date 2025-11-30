<?php
include __DIR__ . '/../../includes/header.php';
$old = $_SESSION['old'] ?? [];
?>

<h2>Ajouter un utilisateur</h2>

<form method="POST" action="index.php?action=add_user">
    <label>Nom d'utilisateur:
        <input type="text" name="nom_utilisateur"
               value="<?= htmlspecialchars($old['nom_utilisateur'] ?? '') ?>" required>
    </label><br>

    <label>Mot de passe:
        <input type="password" name="mot_de_passe"
               value="<?= htmlspecialchars($old['mot_de_passe'] ?? '') ?>" required>
    </label><br>

    <button type="submit" name="add">Ajouter</button>
</form>

<?php
unset($_SESSION['old']);
include __DIR__ . '/../../includes/footer.php';
?>

