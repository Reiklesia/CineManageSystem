<?php
session_start();
if(!isset($_SESSION['admin'])) header('Location: login.php');

require_once '../includes/db_connect.php';

if(isset($_POST['add'])) {
    $titre = $_POST['titre'];
    $realisateur = $_POST['realisateur'];
    $genre = $_POST['genre'];
    $annee = intval($_POST['annee_sortie']);
    $desc = $_POST['description'];

    $conn->query("INSERT INTO films (titre,realisateur,genre,annee_sortie,description) 
                 VALUES ('$titre','$realisateur','$genre','$annee','$desc')");
    header('Location: dashboard.php');
    exit;
}
include '../includes/header.php';
?>

<h2>Ajouter un film</h2>
<form method="POST">
    <label>Titre: <input type="text" name="titre" required></label><br>
    <label>Réalisateur: <input type="text" name="realisateur" required></label><br>
    <label>Genre: <input type="text" name="genre" required></label><br>
    <label>Année: <input type="number" name="annee_sortie" required></label><br>
    <label>Description:<br><textarea name="description" required></textarea></label><br>
    <button type="submit" name="add">Ajouter</button>
</form>

<?php include '../includes/footer.php'; ?>
