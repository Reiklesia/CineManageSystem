<?php
session_start();
require_once '../includes/db_connect.php';


// Activer les erreurs en développement (désactiver en production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['login'])) {
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    if ($user !== '' && $pass !== '') {
        // ⚠️ Utilisation de requêtes préparées pour éviter les injections SQL
        $stmt = $conn->prepare("SELECT * FROM administrateurs WHERE nom_utilisateur = ? AND mot_de_passe = ?");
        $stmt->bind_param("ss", $user, $pass);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['admin'] = $user;
            header('Location: dashboard.php');
            exit;
        } else {
            $error = "Identifiants incorrects";
        }

        $stmt->close();
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>
<?php include '../includes/header.php'; ?>

<div class="login-container">
    <h2>Connexion Administrateur</h2>

    <?php if (isset($error)): ?>
    <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" class="login-form">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" name="login">Se connecter</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>