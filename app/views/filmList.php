<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="page-accueil">
	<h2 class="accueil-titre">Tous les films</h2>

	<div class="films-grille">
		<?php if ($result && $result->num_rows > 0): ?>
			<?php while ($film = $result->fetch_assoc()): ?>
				<?php
				$id    = (int) ($film['id'] ?? 0);
				$titre = htmlspecialchars($film['titre'] ?? '', ENT_QUOTES, 'UTF-8');
				$annee = (int) ($film['annee_sortie'] ?? 0);

				// Tous les films ont une affiche (au minimum placeholder-gris.jpg)
				$fichierAffiche = $film['affiche'];
				$srcAffiche = BASE_URL . '/public/assets/affiches/' . rawurlencode($fichierAffiche);
				?>
				<article class="film-carte">
					<a href="index.php?action=film&id=<?= $id; ?>" class="film-lien">
						<div class="film-affiche-wrapper">
							<img
								src="<?= htmlspecialchars($srcAffiche, ENT_QUOTES, 'UTF-8'); ?>"
								alt="Affiche du film <?= $titre; ?>"
								class="film-affiche">
						</div>

						<h3 class="film-titre">
							<?= $titre; ?>
							<?php if ($annee > 0): ?>
								<span class="film-annee">(<?= $annee; ?>)</span>
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
	// Pagination (si le contrôleur fournit ces variables)
	if (!isset($pageCourante)) {
		$pageCourante = 1;
	}
	if (!isset($pagesTotales)) {
		$pagesTotales = 1;
	}
	if (!isset($sort)) {
		$sort = 'titre';
	}
	if (!isset($dir)) {
		$dir = 'asc';
	}
	?>

	<?php if ($pagesTotales > 1): ?>
		<nav class="pagination">

			<?php if ($pageCourante > 1): ?>
				<a class="btn"
					href="index.php?action=list&page=<?= (int)($pageCourante - 1); ?>&sort=<?= urlencode($sort); ?>&dir=<?= urlencode($dir); ?>">
					← Précédent
				</a>
			<?php endif; ?>

			<?php
			$window = 2;
			$start = max(1, $pageCourante - $window);
			$end   = min($pagesTotales, $pageCourante + $window);

			if ($start > 1) {
				echo '<a class="btn" href="index.php?action=list&page=1&sort=' . urlencode($sort) . '&dir=' . urlencode($dir) . '">1</a>';
				if ($start > 2) echo '<span class="page-info">…</span>';
			}

			for ($p = $start; $p <= $end; $p++) {
				if ($p === (int)$pageCourante) {
					echo '<span class="btn active">' . (int)$p . '</span>';
				} else {
					echo '<a class="btn" href="index.php?action=list&page=' . (int)$p . '&sort=' . urlencode($sort) . '&dir=' . urlencode($dir) . '">' . (int)$p . '</a>';
				}
			}

			if ($end < $pagesTotales) {
				if ($end < $pagesTotales - 1) echo '<span class="page-info">…</span>';
				echo '<a class="btn" href="index.php?action=list&page=' . (int)$pagesTotales . '&sort=' . urlencode($sort) . '&dir=' . urlencode($dir) . '">' . (int)$pagesTotales . '</a>';
			}
			?>

			<?php if ($pageCourante < $pagesTotales): ?>
				<a class="btn"
					href="index.php?action=list&page=<?= (int)($pageCourante + 1); ?>&sort=<?= urlencode($sort); ?>&dir=<?= urlencode($dir); ?>">
					Suivant →
				</a>
			<?php endif; ?>

		</nav>
	<?php endif; ?>

</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>