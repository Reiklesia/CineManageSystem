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
            <a href="<?php echo BASE_URL; ?>index.php">Accueil</a>
            <a href="index.php?action=connexion">Connexion</a>
        </nav>
    </header>
    <hr>
    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert <?php echo $_SESSION['flash']['type']; ?>">
            <?php echo htmlspecialchars($_SESSION['flash']['message']); ?>
        </div>
        <?php unset($_SESSION['flash']); // suppression après affichage ?>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>