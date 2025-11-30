<?php

use LDAP\Result;

require_once __DIR__ . "/../includes/db_connect.php";

function getAllFilms()
{
    global $conn;
    $req = "SELECT * From films ORDER BY titre ASC";
    $result = $conn->query($req);

    if (!$result) {
        die("Erreur de récupération des films:" . $conn->error);
    }

    return $result;
}


function getById($id)
{
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

function ajoutFilm($titre,$realisateur,$genre,$annee,$description){
    global $conn;
    $result = $conn->query("INSERT INTO films (titre,realisateur,genre,annee_sortie,description) 
                 VALUES ('$titre','$realisateur','$genre','$annee','$description')");
    return $result;
}

function modifierFilm($id, $titre, $realisateur, $genre, $annee, $description)
{
	global $conn;
	$stmt = $conn->prepare("UPDATE films SET titre = ?, realisateur = ?, genre = ?, annee_sortie = ?, description = ? WHERE id = ?");
	$stmt->bind_param("sssisi", $titre, $realisateur, $genre, $annee, $description, $id);
	return $stmt->execute();
}

function supprimerFilm($id)
{
	global $conn;
	$stmt = $conn->prepare("DELETE FROM films WHERE id = ?");
	$stmt->bind_param("i", $id);
	return $stmt->execute();
}

?>