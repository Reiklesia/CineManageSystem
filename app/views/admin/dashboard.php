<?php include __DIR__ . '/../../includes/header.php'; ?>
<?php include __DIR__ . '/../../includes/header_dashboard.php'; ?>
<?php
function sortUrl(string $col, int $pageCourante, string $sort, string $dir): string
{
	$nextDir = ($sort === $col && $dir === 'asc') ? 'desc' : 'asc';

	$params = $_GET;
	$params['action'] = $params['action'] ?? 'dashboard';
	$params['page']   = $pageCourante;
	$params['sort']   = $col;
	$params['dir']    = $nextDir;

	return 'index.php?' . http_build_query($params);
}
?>

<table>
	<thead>
		<th><a href="<?= htmlspecialchars(sortUrl('titre', (int)$pageCourante, (string)$sort, (string)$dir), ENT_QUOTES, 'UTF-8') ?>">Titre</a></th>
		<th><a href="<?= htmlspecialchars(sortUrl('annee_sortie', (int)$pageCourante, (string)$sort, (string)$dir), ENT_QUOTES, 'UTF-8') ?>">Année de sortie</a></th>
		<th><a href="<?= htmlspecialchars(sortUrl('genre', (int)$pageCourante, (string)$sort, (string)$dir), ENT_QUOTES, 'UTF-8') ?>">Genre</a></th>
		<th><a href="<?= htmlspecialchars(sortUrl('realisateur', (int)$pageCourante, (string)$sort, (string)$dir), ENT_QUOTES, 'UTF-8') ?>">Réalisateur</a></th>
		<th>Éditer</th>
		<th><a href="<?= htmlspecialchars(sortUrl('statut', (int)$pageCourante, (string)$sort, (string)$dir), ENT_QUOTES, 'UTF-8') ?>">Statut</a></th>
		<th>Supprimer</th>

	</thead>

	<?php if (isset($film_result) && $film_result && $film_result->num_rows > 0): ?>
		<?php while ($film = $film_result->fetch_assoc()): ?>
			<tr>
				<td><?= htmlspecialchars($film['titre'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>

				<td><?= (int)($film['annee_sortie'] ?? 0); ?></td>

				<td><?= htmlspecialchars($film['genre'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>

				<td><?= htmlspecialchars($film['realisateur'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>

				<td>
					<a class="btn-edit" href="index.php?action=form_edit_film&id=<?= (int)($film['id'] ?? 0); ?>">
						Éditer
					</a>
				</td>

				<td>
					<?php
					$statut = ($film['statut'] ?? 'inactif') === 'actif' ? 'actif' : 'inactif';
					$labelStatut = $statut === 'actif' ? 'Actif' : 'Inactif';
					$labelAction = $statut === 'actif' ? 'Désactiver' : 'Activer';
					?>
					<div class="statut-cell">
						<div class="statut-label"><?= $labelStatut; ?></div>
						<a class="statut-action"
							href="index.php?action=toggle_film_statut&id=<?= (int)($film['id'] ?? 0); ?>&page=<?= (int)$pageCourante; ?>&sort=<?= urlencode($sort); ?>&dir=<?= urlencode($dir); ?>"
							onclick="return confirm('Confirmer: <?= $labelAction; ?> ce film ?');">
							<?= $labelAction; ?>
						</a>
					</div>
				</td>

				<td>
					<?php $idFilm = (int)($film['id'] ?? 0); ?>

					<?php if (!empty($nonSupprimables[$idFilm])): ?>
						<span class="text-muted">Ce film ne peut pas être supprimé</span>
					<?php else: ?>
						<a class="btn-delete" href="index.php?action=delete_film&id=<?= $idFilm; ?>"
							onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce film ?')">
							Supprimer
						</a>
					<?php endif; ?>
				</td>
			</tr>
		<?php endwhile; ?>
	<?php else: ?>
		<tr>
			<td colspan="7">Aucun film trouvé.</td>
		</tr>
	<?php endif; ?>
</table>

<?php if (empty($isFiltre) && $pagesTotales > 1): ?>
	<nav class="pagination">
		<?php if ($pageCourante > 1): ?>
			<a class="btn"
				href="index.php?action=dashboard&page=<?= (int) ($pageCourante - 1); ?>&sort=<?= urlencode($sort); ?>&dir=<?= urlencode($dir); ?>">
				← Précédent
			</a>
		<?php endif; ?>

		<?php
		$window = 2;
		$start = max(1, $pageCourante - $window);
		$end   = min($pagesTotales, $pageCourante + $window);

		if ($start > 1) {
		?>
			<a class="btn" href="index.php?action=dashboard&page=1&sort=<?= urlencode($sort); ?>&dir=<?= urlencode($dir); ?>">1</a>
			<?php
			if ($start > 2) {
				echo '<span class="page-info">…</span>';
			}
		}

		for ($p = $start; $p <= $end; $p++) {
			if ($p === (int)$pageCourante) {
				echo '<span class="btn active">' . (int)$p . '</span>';
			} else {
				echo '<a class="btn" href="index.php?action=dashboard&page=' . (int)$p . '&sort=' . urlencode($sort) . '&dir=' . urlencode($dir) . '">' . (int)$p . '</a>';
			}
		}

		if ($end < $pagesTotales) {
			if ($end < $pagesTotales - 1) {
				echo '<span class="page-info">…</span>';
			}
			?>
			<a class="btn" href="index.php?action=dashboard&page=<?= (int)$pagesTotales; ?>&sort=<?= urlencode($sort); ?>&dir=<?= urlencode($dir); ?>">
				<?= (int)$pagesTotales; ?>
			</a>
		<?php
		}
		?>

		<?php if ($pageCourante < $pagesTotales): ?>
			<a class="btn"
				href="index.php?action=dashboard&page=<?= (int) ($pageCourante + 1); ?>&sort=<?= urlencode($sort); ?>&dir=<?= urlencode($dir); ?>">
				Suivant →
			</a>
		<?php endif; ?>
	</nav>
<?php endif; ?>

<?php include __DIR__ . '/../../includes/footer.php'; ?>