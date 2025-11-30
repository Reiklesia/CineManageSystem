<?php

use LDAP\Result;

require_once __DIR__ . "/../includes/db_connect.php";

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

function countAllFilms()
{
    global $conn;
    $sql = "SELECT COUNT(*) AS total FROM films";
    $result = $conn->query($sql);
    if (!$result) return 0;
    $row = $result->fetch_assoc();
    return (int) ($row['total'] ?? 0);
}

function countFilmsActifs()
{
    global $conn;
    $sql = "SELECT COUNT(*) AS total FROM films WHERE statut = 'actif'";
    $result = $conn->query($sql);
    if (!$result) return 0;
    $row = $result->fetch_assoc();
    return (int) ($row['total'] ?? 0);
}

function getFilmsActifsPagines(int $parPage, int $offset, string $sort, string $dir)
{
    global $conn;

    $allowedSorts = ['titre', 'realisateur', 'genre', 'annee_sortie'];
    if (!in_array($sort, $allowedSorts, true)) {
        $sort = 'titre';
    }

    $dirSql = strtolower($dir) === 'desc' ? 'DESC' : 'ASC';

    $sql = "
        SELECT id, titre, realisateur, genre, annee_sortie, description, statut
        FROM films
        WHERE statut = 'actif'
        ORDER BY $sort $dirSql
        LIMIT ? OFFSET ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $parPage, $offset);
    $stmt->execute();

    return $stmt->get_result();
}

function getTousLesFilmsPagines(int $parPage, int $offset, string $sort, string $dir)
{
    global $conn;

    $allowedSorts = ['id', 'titre', 'realisateur', 'genre', 'annee_sortie', 'statut'];
    if (!in_array($sort, $allowedSorts, true)) {
        $sort = 'id';
    }

    $dirSql = strtolower($dir) === 'desc' ? 'DESC' : 'ASC';

    $sql = "
        SELECT id, titre, realisateur, genre, annee_sortie, description, statut
        FROM films
        ORDER BY $sort $dirSql
        LIMIT ? OFFSET ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $parPage, $offset);
    $stmt->execute();

    return $stmt->get_result();
}

function ajoutFilm($titre, $realisateur, $genre, $annee, $description)
{
    global $conn;
    $result = $conn->query("
        INSERT INTO films (titre, realisateur, genre, annee_sortie, description)
        VALUES ('$titre', '$realisateur', '$genre', '$annee', '$description')
    ");
    return $result;
}

function setFilmActiveStatus($id, $status)
{
    global $conn;

    $stmt = $conn->prepare("UPDATE films SET statut = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);

    return $stmt->execute();
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