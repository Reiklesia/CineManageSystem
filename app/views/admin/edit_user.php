<?php
include __DIR__ . '/../../includes/header.php';

$oldUser = $_SESSION['old_user'] ?? null;
?>

<h2>Modifier l'utilisateur</h2>

<form method="POST" action="index.php?action=edit_user&id=<?= (int) $utilisateur['id']; ?>">
    <label>Nom d'utilisateur:
        <input type="text" name="nom_utilisateur"
               value="<?= htmlspecialchars($oldUser['nom_utilisateur'] ?? $utilisateur['nom_utilisateur']); ?>"
               required>
    </label><br>

    <button type="submit" name="update">Modifier</button>
</form>

<?php
unset($_SESSION['old_user']);
include __DIR__ . '/../../includes/footer.php';
?>
