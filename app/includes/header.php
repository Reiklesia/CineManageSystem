<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>CinéGest</title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header class="main-header">
        <div class="left">
            <nav>
                <a href="index.php?action=list">Consulter l'horaire</a>
                <a href="index.php?action=tarifs">Tarifs</a>
                <a href="index.php?action=contact">Nous contacter</a>
            </nav>
        </div>

        <div class="center">
            <h1>CinéGest</h1>
        </div>

        <div class="right">
            <?php if (!isset($_SESSION['login']) && (!isset($_GET['action']) || $_GET['action'] !== 'connexion')): ?>
                <a class="btn-login" href="index.php?action=connexion">
                    Se connecter
                </a>

            <?php else: ?>
                <?php if (isAdmin()): ?>
                    <a class="btn-login" href="index.php?action=dashboard">
                        Tableau de bord
                    </a>
                <?php elseif (isUser()): ?>
                    <a class="btn-login" href="index.php?action=profil">
                        Profil
                    </a>
                <?php endif; ?>
            <?php if (isset($_SESSION['login']) && (!isset($_GET['action']) || $_GET['action'] !== 'connexion')): ?>
                <a class="btn-login" href="index.php?action=logout">
                    Déconnexion
                </a>
                <?php endif; ?>
        <?php endif; ?>
        </div>
    </header>

    <hr>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert <?php echo $_SESSION['flash']['type']; ?>">
            <?php echo htmlspecialchars($_SESSION['flash']['message']); ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
