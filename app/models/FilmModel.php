<?php
require_once __DIR__ . "/../includes/db_connect.php";

// David
function getAllFilms()
{
    // Validation des données : à venir
    global $conn;
    $req = "SELECT * From films 
	ORDER BY titre ASC";
    $result = $conn->query($req);

    if (!$result) {
        die("Erreur de récupération des films:" . $conn->error);
    }

    return $result;
}

// Amélie
function getAllFilmsAvecAffiches()
{
    global $conn;
    $req = "SELECT * FROM films WHERE affiche IS NOT NULL AND affiche <> '' ORDER BY titre ASC";
    $result = $conn->query($req);

    if (!$result) {
        die("Erreur de récupération des films avec affiches : " . $conn->error);
    }

    return $result;
}

// David
function getById($id)
{
    // Validation des données : à venir
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM films WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();


    if ($result->num_rows === 0) {
        return null;
    }

    return $result->fetch_assoc();
}

// Jérémy
function ajoutFilm($titre, $realisateur, $genre, $annee, $description, $affiche)
{
    global $conn;
    $result = $conn->query("INSERT INTO films (titre,realisateur,genre,annee_sortie,description,affiche) 
                 VALUES ('$titre','$realisateur','$genre','$annee','$description','$affiche')");
    return $result;
}

// Amélie
function modifierFilm($id, $titre, $realisateur, $genre, $annee, $description, $affiche)
{
    global $conn;
    $stmt = $conn->prepare("UPDATE films SET titre = ?, realisateur = ?, genre = ?, annee_sortie = ?, description = ?, affiche = ? WHERE id = ?");
    $stmt->bind_param("sssissi", $titre, $realisateur, $genre, $annee, $description, $affiche, $id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

// Amélie
function supprimerFilm($id)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM films WHERE id = ?");
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

?>