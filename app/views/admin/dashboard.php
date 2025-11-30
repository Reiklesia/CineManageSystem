<?php include __DIR__ . '/../../includes/header.php'; ?>

<h2>Tableau de bord</h2>
<a href="index.php?action=form_add_film">Ajouter un film</a>

<table border="1">
    <tr>
        <th>
            <a href="index.php?action=dashboard&sort=id&dir=<?= ($sort === 'id' && $dir === 'asc') ? 'desc' : 'asc'; ?>">
                ID <?= $sort === 'id' ? ($dir === 'asc' ? '↑' : '↓') : '' ?>
            </a>
        </th>
        <th>
            <a href="index.php?action=dashboard&sort=titre&dir=<?= ($sort === 'titre' && $dir === 'asc') ? 'desc' : 'asc'; ?>">
                Titre <?= $sort === 'titre' ? ($dir === 'asc' ? '↑' : '↓') : '' ?>
            </a>
        </th>
        <th>
            <a href="index.php?action=dashboard&sort=realisateur&dir=<?= ($sort === 'realisateur' && $dir === 'asc') ? 'desc' : 'asc'; ?>">
                Réalisateur <?= $sort === 'realisateur' ? ($dir === 'asc' ? '↑' : '↓') : '' ?>
            </a>
        </th>
        <th>
            <a href="index.php?action=dashboard&sort=genre&dir=<?= ($sort === 'genre' && $dir === 'asc') ? 'desc' : 'asc'; ?>">
                Genre <?= $sort === 'genre' ? ($dir === 'asc' ? '↑' : '↓') : '' ?>
            </a>
        </th>
        <th>
            <a href="index.php?action=dashboard&sort=annee_sortie&dir=<?= ($sort === 'annee_sortie' && $dir === 'asc') ? 'desc' : 'asc'; ?>">
                Année <?= $sort === 'annee_sortie' ? ($dir === 'asc' ? '↑' : '↓') : '' ?>
            </a>
        </th>
        <th>Description</th>
        <th>Éditer</th>
        <th>
            <a href="index.php?action=dashboard&sort=statut&dir=<?= ($sort === 'statut' && $dir === 'asc') ? 'desc' : 'asc'; ?>">
                Statut <?= $sort === 'statut' ? ($dir === 'asc' ? '↑' : '↓') : '' ?>
            </a>
        </th>
        <th>Supprimer</th>
    </tr>
    <?php while ($film = $result->fetch_assoc()): ?>
        <tr>
            <td><?= (int) $film['id']; ?></td>
            <td><?= htmlspecialchars($film['titre']); ?></td>
            <td><?= htmlspecialchars($film['realisateur']); ?></td>
            <td><?= htmlspecialchars($film['genre']); ?></td>
            <td><?= (int) $film['annee_sortie']; ?></td>
            <td><?= htmlspecialchars($film['description']); ?></td>
            <td><a href="index.php?action=form_edit_film&id=<?= (int) $film['id']; ?>">Éditer</a></td>
            <td>
                <?php if ($film['statut'] === 'actif'): ?>
                    Actif
                    | <a href="index.php?action=deactivate_film&id=<?= (int)$film['id']; ?>">Désactiver</a>
                <?php else: ?>
                    Inactif
                    | <a href="index.php?action=activate_film&id=<?= (int)$film['id']; ?>">Activer</a>
                <?php endif; ?>
            </td>
            <td>
                <a href="index.php?action=delete_film&id=<?= (int) $film['id']; ?>"
                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce film ?')">
                    Supprimer
                </a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<?php if ($pagesTotales > 1): ?>
    <div class="pagination">
        <?php if ($pageCourante > 1): ?>
            <a href="index.php?action=dashboard&page=<?= $pageCourante - 1 ?>&sort=<?= urlencode($sort) ?>&dir=<?= urlencode($dir) ?>" class="btn">← Précédent</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $pagesTotales; $i++): ?>
            <a href="index.php?action=dashboard&page=<?= $i ?>&sort=<?= urlencode($sort) ?>&dir=<?= urlencode($dir) ?>"
               class="btn <?= $i === $pageCourante ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($pageCourante < $pagesTotales): ?>
            <a href="index.php?action=dashboard&page=<?= $pageCourante + 1 ?>&sort=<?= urlencode($sort) ?>&dir=<?= urlencode($dir) ?>" class="btn">Suivant →</a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<a href="index.php?action=logout">Déconnexion</a>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
