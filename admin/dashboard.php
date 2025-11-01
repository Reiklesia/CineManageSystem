<?php
session_start();
if(!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
require_once '../includes/db_connect.php';
include '../includes/header.php';

$result = $conn->query("SELECT * FROM films ORDER BY id DESC");
?>

<h2>Dashboard Admin</h2>
<a href="add_film.php">Ajouter un film</a>
<table border="1">
    <tr>
        <th>ID</th><th>Titre</th><th>Actions</th>
    </tr>
    <?php while($film = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $film['id']; ?></td>
        <td><?php echo htmlspecialchars($film['titre']); ?></td>
        <td>
            <a href="edit_film.php?id=<?php echo $film['id']; ?>">Modifier</a> |
            <a href="delete_film.php?id=<?php echo $film['id']; ?>" onclick="return confirm('Supprimer ?')">Supprimer</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<a href="logout.php">Déconnexion</a>
<?php include '../includes/footer.php'; ?>
