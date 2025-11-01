<?php
session_start();
if(!isset($_SESSION['admin'])) header('Location: login.php');

require_once '../includes/db_connect.php';

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM films WHERE id=$id");
$film = $result->fetch_assoc();

if(isset($_POST['update'])) {
    $titre = $_POST['titre'];
    $realisateur = $_POST['realisateur'];
    $genre = $_POST['genre'];
    $annee = intval($_POST['annee_sortie']);
    $desc = $_POST['description'];

    $conn->query("UPDATE films SET titre='$titre', realisateur='$realisateur', genre='$genre', annee_sortie='$annee', description='$desc' WHERE id=$id");
    header('Location: dashboard.php');
    exit;
}

include '../includes/header.php';
?>

<h2>Modifier le film</h2>
<form method="POST">
    <label>Titre: <input type="text" name="titre" value="<?php echo htmlspecialchars($film['titre']); ?>" required></label><br>
    <label>Réalisateur: <input type="text" name="realisateur" value="<?php echo htmlspecialchars($film['realisateur']); ?>" required></label><br>
    <label>Genre: <input type="text" name="genre" value="<?php echo htmlspecialchars($film['genre']); ?>" required></label><br>
    <label>Année: <input type="number" name="annee_sortie" value="<?php echo $film['annee_sortie']; ?>" required></label><br>
    <label>Description:<br><textarea name="description" required><?php echo htmlspecialchars($film['description']); ?></textarea></label><br>
    <button type="submit" name="update">Modifier</button>
</form>

<?php include '../includes/footer.php'; ?>
