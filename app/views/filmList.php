<?php
include __DIR__ . '/../includes/header.php';
?>
<h2>Liste des films</h2>

<ul>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($film = $result->fetch_assoc()): ?>
            <li>
				<a href="index.php?action=film&id=<?php echo (int)$film['id']; ?>">
					<?php echo htmlspecialchars($film['titre']); ?> (<?php echo (int)$film['annee_sortie']; ?>)
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
            <a href="index.php?action=list&page=<?= $pageCourante - 1 ?>" class="btn">← Précédent</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $pagesTotales; $i++): ?>
            <a href="index.php?action=list&page=<?= $i ?>"
               class="btn <?= $i === $pageCourante ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($pageCourante < $pagesTotales): ?>
            <a href="index.php?action=list&page=<?= $pageCourante + 1 ?>" class="btn">Suivant →</a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php
include __DIR__ . '/../includes/footer.php';
?>