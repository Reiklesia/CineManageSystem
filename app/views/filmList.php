<?php
include __DIR__ . '/../includes/header.php';
?>
<h2>Liste des films</h2>

<p>
    Trier par :
    <a href="index.php?action=list&sort=titre&dir=<?= ($sort === 'titre' && $dir === 'asc') ? 'desc' : 'asc'; ?>">
        Titre <?= $sort === 'titre' ? ($dir === 'asc' ? '↑' : '↓') : '' ?>
    </a> |
    <a href="index.php?action=list&sort=annee_sortie&dir=<?= ($sort === 'annee_sortie' && $dir === 'asc') ? 'desc' : 'asc'; ?>">
        Année <?= $sort === 'annee_sortie' ? ($dir === 'asc' ? '↑' : '↓') : '' ?>
    </a>
</p>

<ul>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($film = $result->fetch_assoc()): ?>
            <li>
                <a href="index.php?action=film&id=<?= (int)$film['id']; ?>">
                    <?= htmlspecialchars($film['titre']); ?> (<?= (int)$film['annee_sortie']; ?>)
                </a>
            </li>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Aucun film trouvé.</p>
    <?php endif; ?>
</ul>

<?php if ($pagesTotales > 1): ?>
    <div class="pagination">
        <?php if ($pageCourante > 1): ?>
            <a href="index.php?action=list&page=<?= $pageCourante - 1 ?>&sort=<?= urlencode($sort) ?>&dir=<?= urlencode($dir) ?>" class="btn">← Précédent</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $pagesTotales; $i++): ?>
            <a href="index.php?action=list&page=<?= $i ?>&sort=<?= urlencode($sort) ?>&dir=<?= urlencode($dir) ?>"
               class="btn <?= $i === $pageCourante ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($pageCourante < $pagesTotales): ?>
            <a href="index.php?action=list&page=<?= $pageCourante + 1 ?>&sort=<?= urlencode($sort) ?>&dir=<?= urlencode($dir) ?>" class="btn">Suivant →</a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php
include __DIR__ . '/../includes/footer.php';
?>