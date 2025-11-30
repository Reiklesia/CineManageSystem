<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="login-container">
    <h2>Connexion Administrateur</h2>



    <form method="POST" class="login-form">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required <button type="submit" name="connexion">Se
        connecter</button>
    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>