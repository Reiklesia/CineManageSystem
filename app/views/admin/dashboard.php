<?php include __DIR__ . '/../../includes/header.php'; ?>
<?php include __DIR__ . '/../../includes/header_dashboard.php'; ?>

<table>
	<tr>
		<th>Titre</th>
		<th>Éditer</th>
		<th>Supprimer</th>
	</tr>

	<?php if (isset($film_result) && $film_result && $film_result->num_rows > 0): ?>
		<?php while ($film = $film_result->fetch_assoc()): ?>
			<tr>
				<td><?= htmlspecialchars($film['titre'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>

				<td>
					<a href="index.php?action=form_edit_film&id=<?= (int) ($film['id'] ?? 0); ?>">
						Éditer
					</a>
				</td>

				<td>
					<a href="index.php?action=delete_film&id=<?= (int) ($film['id'] ?? 0); ?>"
						onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce film ?')">
						Supprimer
					</a>
				</td>
			</tr>
		<?php endwhile; ?>
	<?php else: ?>
		<tr>
			<td colspan="3">Aucun film trouvé.</td>
		</tr>
	<?php endif; ?>
</table>

<?php if ($pagesTotales > 1): ?>
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