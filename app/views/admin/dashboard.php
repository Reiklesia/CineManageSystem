<?php include __DIR__ . '/../../includes/header.php'; ?>

<h2>Dashboard Admin</h2>
<a href="index.php?action=add_film">Ajouter un film</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Titre</th>
        <th>Réalisateur</th>
        <th>Genre</th>
        <th>Année</th>
        <th>Description</th>
    </tr>
    <?php while ($film = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo (int) $film['id']; ?></td>
            <td><?php echo htmlspecialchars($film['titre']); ?></td>
            <td><?php echo htmlspecialchars($film['realisateur']); ?></td>
            <td><?php echo htmlspecialchars($film['genre']); ?></td>
            <td><?php echo (int) $film['annee_sortie']; ?></td>
            <td><?php echo htmlspecialchars($film['description']); ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<a href="index.php?action=logout">Déconnexion</a>

<?php include __DIR__ . '/../../includes/footer.php'; ?>