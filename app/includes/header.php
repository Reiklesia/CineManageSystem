<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>CinéManage</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/assets/css/style.css">
</head>

<body>
    <header>
        <div class="left">
            <nav>
                <a href="<?php echo BASE_URL; ?>index.php">Consulter l'horaire</a>
                <a href="<?php echo BASE_URL; ?>admin/login.php">Tarifs</a>
                <a href="<?php echo BASE_URL; ?>admin/login.php">Nous contacter</a>
            </nav>
        </div>
        <div class="center">
            <h1>CinéGest</h1>
        </div>
        <div class="right">
            <a class="btn-login" href="<?php echo BASE_URL; ?>admin/login.php">Se connecter</a>
        </div>
    </header>
    <hr>
    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert <?php echo $_SESSION['flash']['type']; ?>">
            <?php echo htmlspecialchars($_SESSION['flash']['message']); ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>