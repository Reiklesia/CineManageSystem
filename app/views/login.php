<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="login-container">

    <form method="POST" class="login-form">
        <legend>S'identifier</legend>
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <button class="submit-btn" name="connexion">Se connecter</button>
    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>