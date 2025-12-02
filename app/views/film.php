<?php
require_once __DIR__ . '/../models/FilmModel.php';
include __DIR__ . '/../includes/header.php';
?>

<div class="film-details">
<h2><?php echo htmlspecialchars($film['titre']); ?></h2>
<p><strong>Réalisateur :</strong> <?php echo htmlspecialchars($film['realisateur']); ?></p>
<p><strong>Genre :</strong> <?php echo htmlspecialchars($film['genre']); ?></p>
<p><strong>Année :</strong> <?php echo $film['annee_sortie']; ?></p>
<p><strong>Description :</strong> <?php echo htmlspecialchars($film['description']); ?></p>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>