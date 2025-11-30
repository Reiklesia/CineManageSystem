<?php include __DIR__ . '/../../includes/header.php'; ?>

<h2>Tableau de bord</h2>
<a href="index.php?action=form_add_film">Ajouter un film</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Titre</th>
        <th>Réalisateur</th>
        <th>Genre</th>
        <th>Année</th>
        <th>Description</th>
        <th>Éditer</th>
		<th>Statut</th>
        <th>Supprimer</th>
    </tr>
    <?php while ($film = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo (int) $film['id']; ?></td>
            <td><?php echo htmlspecialchars($film['titre']); ?></td>
            <td><?php echo htmlspecialchars($film['realisateur']); ?></td>
            <td><?php echo htmlspecialchars($film['genre']); ?></td>
            <td><?php echo (int) $film['annee_sortie']; ?></td>
            <td><?php echo htmlspecialchars($film['description']); ?></td>
            <td><a href="index.php?action=form_edit_film&id=<?php echo (int) $film['id']; ?>">Éditer</a></td>
			<td>
				<?php if ($film['statut'] === 'actif'): ?>
					Actif
					| <a href="index.php?action=deactivate_film&id=<?= (int)$film['id']; ?>">Désactiver</a>
				<?php else: ?>
					Inactif
					| <a href="index.php?action=activate_film&id=<?= (int)$film['id']; ?>">Activer</a>
				<?php endif; ?>
			</td>
            <td><?php echo '<a href="index.php?action=delete_film&id=' . (int) $film['id'] . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce film ?\')">Supprimer</a>'; ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<?php if ($pagesTotales > 1): ?>
    <div class="pagination">
        <?php if ($pageCourante > 1): ?>
            <a href="index.php?action=dashboard&page=<?= $pageCourante - 1 ?>" class="btn">← Précédent</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $pagesTotales; $i++): ?>
            <a href="index.php?action=dashboard&page=<?= $i ?>"
               class="btn <?= $i === $pageCourante ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($pageCourante < $pagesTotales): ?>
            <a href="index.php?action=dashboard&page=<?= $pageCourante + 1 ?>" class="btn">Suivant →</a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<a href="index.php?action=logout">Déconnexion</a>

<?php include __DIR__ . '/../../includes/footer.php'; ?>