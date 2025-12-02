<?php include __DIR__ . '/../includes/header.php'; ?>

<h2>Liste des films</h2>
<ul>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($film = $result->fetch_assoc()): ?>
            <li>
                <a href="index.php?action=film&id=<?php echo (int) $film['id']; ?>">
                    <?php echo htmlspecialchars($film['titre']); ?> (<?php echo (int)$film['annee_sortie']; ?>
)
                </a>
            </li>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Aucun film trouvé.</p>
    <?php endif; ?>
</ul>

<?php include __DIR__ . '/../includes/footer.php'; ?>