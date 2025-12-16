<?php include __DIR__ . '/../includes/header.php' ?>

<section class="hero-banner">
	<img
		src="<?php echo BASE_URL; ?>/public/assets/affiches/baniere.jpg"
		alt="Bannière du film à l'affiche"
		class="hero-bg">

	<div class="hero-overlay">
		<div class="hero-content">
			<div class="hero-buttons">
				<a href="#" class="btn btn-primary">Infos et billets</a>
				<a href="https://www.youtube.com/" class="btn btn-secondary">Bande annonce</a>
			</div>
		</div>
	</div>
</section>

<main class="page-accueil">
	<h2 class="accueil-titre">Films à l'affiche</h2>

	<div class="films-grille">
		<?php if ($result && $result->num_rows > 0): ?>
			<?php while ($film = $result->fetch_assoc()): ?>
				<?php
				$id      = (int) $film['id'];
				$titre   = htmlspecialchars($film['titre'], ENT_QUOTES, 'UTF-8');
				$annee   = (int) $film['annee_sortie'];

				$fichierAffiche = trim($film['affiche'] ?? '');
				$srcAffiche = BASE_URL . '/public/assets/affiches/' . rawurlencode($fichierAffiche);
				?>
				<article class="film-carte">
					<a href="index.php?action=film&id=<?php echo $id; ?>" class="film-lien">
						<div class="film-affiche-wrapper">
							<img
								src="<?php echo $srcAffiche; ?>"
								alt="Affiche du film <?php echo $titre; ?>"
								class="film-affiche">
						</div>
						<h3 class="film-titre">
							<?php echo $titre; ?>
							<?php if ($annee > 0): ?>
								<span class="film-annee">(<?php echo $annee; ?>)</span>
							<?php endif; ?>
						</h3>
					</a>
				</article>
			<?php endwhile; ?>
		<?php else: ?>
			<p>Aucun film trouvé.</p>
		<?php endif; ?>
	</div>
	<?php
	if (!isset($sort)) {
		$sort = 'titre';
	}
	if (!isset($dir)) {
		$dir = 'asc';
	}
	?>

	<?php if (!empty($pagesTotales) && $pagesTotales > 1): ?>
		<nav class="pagination">

			<?php if ($pageCourante > 1): ?>
				<a class="btn"
					href="index.php?action=accueil&page=<?= (int)($pageCourante - 1); ?>&sort=<?= urlencode($sort); ?>&dir=<?= urlencode($dir); ?>">
					← Précédent
				</a>
			<?php endif; ?>

			<?php
			$window = 2;
			$start = max(1, $pageCourante - $window);
			$end   = min($pagesTotales, $pageCourante + $window);

			if ($start > 1) {
				echo '<a class="btn" href="index.php?action=accueil&page=1&sort=' . urlencode($sort) . '&dir=' . urlencode($dir) . '">1</a>';
				if ($start > 2) {
					echo '<span class="page-info">…</span>';
				}
			}

			for ($p = $start; $p <= $end; $p++) {
				if ($p === (int)$pageCourante) {
					echo '<span class="btn active">' . (int)$p . '</span>';
				} else {
					echo '<a class="btn" href="index.php?action=accueil&page=' . (int)$p . '&sort=' . urlencode($sort) . '&dir=' . urlencode($dir) . '">' . (int)$p . '</a>';
				}
			}

			if ($end < $pagesTotales) {
				if ($end < $pagesTotales - 1) {
					echo '<span class="page-info">…</span>';
				}
				echo '<a class="btn" href="index.php?action=accueil&page=' . (int)$pagesTotales . '&sort=' . urlencode($sort) . '&dir=' . urlencode($dir) . '">' . (int)$pagesTotales . '</a>';
			}
			?>

			<?php if ($pageCourante < $pagesTotales): ?>
				<a class="btn"
					href="index.php?action=accueil&page=<?= (int)($pageCourante + 1); ?>&sort=<?= urlencode($sort); ?>&dir=<?= urlencode($dir); ?>">
					Suivant →
				</a>
			<?php endif; ?>

		</nav>
	<?php endif; ?>

</main>

<?php include __DIR__ . '/../includes/footer.php' ?>