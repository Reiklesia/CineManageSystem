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
		<tr>
			<th><a href="<?= htmlspecialchars(sortUrl('nom_utilisateur', (int)$pageCourante, (string)$sort, (string)$dir), ENT_QUOTES, 'UTF-8') ?>">Nom utilisateur</a></th>
			<th><a href="<?= htmlspecialchars(sortUrl('role', (int)$pageCourante, (string)$sort, (string)$dir), ENT_QUOTES, 'UTF-8') ?>">Rôle</a></th>
			<th>Éditer</th>
			<th><a href="<?= htmlspecialchars(sortUrl('statut', (int)$pageCourante, (string)$sort, (string)$dir), ENT_QUOTES, 'UTF-8') ?>">Statut</a></th>
			<th>Supprimer</th>
		</tr>
	</thead>

	<?php if (isset($user_result) && $user_result && $user_result->num_rows > 0): ?>
		<?php while ($user = $user_result->fetch_assoc()): ?>
			<tr>
				<td><?= htmlspecialchars($user['nom_utilisateur'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>

				<td><?= htmlspecialchars($user['role'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
				<td>
					<a class="btn-edit" href="index.php?action=form_edit_user&id=<?= (int)($user['id'] ?? 0); ?>">
						Éditer
					</a>
				</td>
				<td>
					<?php
					$statut = ($user['statut'] ?? 'inactif') === 'actif' ? 'actif' : 'inactif';
					$labelStatut = $statut === 'actif' ? 'Actif' : 'Inactif';
					$labelAction = $statut === 'actif' ? 'Désactiver' : 'Activer';
					?>
					<div class="statut-cell">
						<div class="statut-label"><?= $labelStatut; ?></div>
						<a class="statut-action"
							href="index.php?action=toggle_user_statut&id=<?= (int)($user['id'] ?? 0); ?>&page=<?= (int)$pageCourante; ?>&sort=<?= urlencode($sort); ?>&dir=<?= urlencode($dir); ?>"
							onclick="return confirm('Confirmer: <?= $labelAction; ?> ce user ?');">
							<?= $labelAction; ?>
						</a>
					</div>
				</td>

				<td>
					<?php $idUser = (int)($user['id'] ?? 0); ?>

					<?php if (!empty($nonSupprimables[$idUser])): ?>
						<span class="text-muted">Cet utilisateur ne peut pas être supprimé</span>
					<?php else: ?>
						<a class="btn-delete" href="index.php?action=delete_utilisateur&id=<?= $idUser; ?>"
							onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
							Supprimer
						</a>
					<?php endif; ?>
				</td>
			</tr>
		<?php endwhile; ?>
	<?php else: ?>
		<tr>
			<td colspan="7">Aucun utilisateur trouvé.</td>
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