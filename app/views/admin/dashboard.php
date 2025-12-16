<?php include __DIR__ . '/../../includes/header.php'; ?>
<?php include __DIR__ . '/../../includes/header_dashboard.php'; ?>
<table>
	<tr>
		<th>Titre</th>
		<th>Éditer</th>
		<th>Supprimer</th>
	</tr>
	<?php while ($film = $result->fetch_assoc()): ?>
		<tr>
			<td><?php echo htmlspecialchars($film['titre']); ?></td>
			<td><a href="index.php?action=form_edit_film&id=<?php echo (int) $film['id']; ?>">Éditer</a></td>
			<td><?php echo '<a href="index.php?action=delete_film&id=' . (int) $film['id'] . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce film ?\')">Supprimer</a>'; ?>
			</td>
		</tr>
	<?php endwhile; ?>
</table>


<?php include __DIR__ . '/../../includes/footer.php'; ?>