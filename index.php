<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'includes/db_connect.php';
include 'includes/header.php';

$result = $conn->query("SELECT * FROM films ORDER BY annee_sortie DESC");
?>

<h2>Liste des films</h2>
<ul>
<?php while($film = $result->fetch_assoc()): ?>
    <li>
        <a href="film.php?id=<?php echo $film['id']; ?>">
            <?php echo htmlspecialchars($film['titre']); ?> (<?php echo $film['annee_sortie']; ?>)
        </a>
    </li>
<?php endwhile; ?>
</ul>

<?php include 'includes/footer.php'; ?>
