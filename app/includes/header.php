<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>CinéManage</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/assets/css/style.css">
</head>

<body>
    <header>
        <h1>CinéManage</h1>
        <nav>
            <a href="index.php?action=list">Liste de films</a>
            <?php if (isset($_SESSION['role'])): ?>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <a href="index.php?action=dashboard">Tableau de bord</a>
                <?php elseif ($_SESSION['role'] === 'user'): ?>
                    <!-- Page profil a ajouter dans le futur. -->
                    <a href="index.php?action=profil">Profil</a>
                <?php endif; ?>
                <a href="index.php?action=logout">Déconnexion</a>
            <?php else: ?>
                <a href="index.php?action=connexion">Connexion</a>
            <?php endif; ?>
        </nav>
    </header>
    <hr>
    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert <?php echo $_SESSION['flash']['type']; ?>">
            <?php echo htmlspecialchars($_SESSION['flash']['message']); ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>