<?php
require_once __DIR__ . "/../includes/db_connect.php";

// David
function getAllFilms()
{
	global $conn;
	$req = "SELECT * From films 
	ORDER BY titre ASC";
	$result = $conn->query($req);

	if (!$result) {
		die("Erreur de récupération des films:" . $conn->error);
	}

	return $result;
}

// David
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

// Amelie
function countAllFilms()
{
	global $conn;
	$sql = "SELECT COUNT(*) AS total FROM films";
	$result = $conn->query($sql);
	if (!$result) return 0;
	$row = $result->fetch_assoc();
	return (int) ($row['total'] ?? 0);
}

// Amelie
function getTousLesFilmsPagines(int $parPage, int $offset, string $sort, string $dir)
{
	global $conn;

	$allowedSorts = ['id', 'titre', 'realisateur', 'genre', 'annee_sortie', 'statut', 'affiche'];
	if (!in_array($sort, $allowedSorts, true)) {
		$sort = 'id';
	}

	$dirSql = strtolower($dir) === 'desc' ? 'DESC' : 'ASC';

	$sql = "
    SELECT id, titre, realisateur, genre, annee_sortie, description, statut, affiche
    FROM films
    ORDER BY $sort $dirSql
    LIMIT ? OFFSET ?";

	$stmt = $conn->prepare($sql);
	if (!$stmt) {
		return false;
	}

	$stmt->bind_param('ii', $parPage, $offset);
	$stmt->execute();

	return $stmt->get_result();
}

// Jérémy
function ajoutFilm($titre, $realisateur, $genre, $annee, $description, $affiche)
{
	global $conn;

	$stmt = $conn->prepare(
		"INSERT INTO films (titre, realisateur, genre, annee_sortie, description, affiche)
         VALUES (?, ?, ?, ?, ?, ?)"
	);
	if (!$stmt) {
		die("Erreur prepare ajoutFilm: " . $conn->error);
	}

	$stmt->bind_param("sssiss", $titre, $realisateur, $genre, $annee, $description, $affiche);
	$result = $stmt->execute();

	$stmt->close();
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

// Amélie
function desactiverFilm($id)
{
	global $conn;
	$stmt = $conn->prepare("UPDATE films SET statut = 'inactif' WHERE id = ?");
	$stmt->bind_param("i", $id);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}

// Amélie
function activerFilm($id)
{
	global $conn;
	$stmt = $conn->prepare("UPDATE films SET statut = 'actif' WHERE id = ?");
	$stmt->bind_param("i", $id);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}

function filmEstLie(int $filmId): bool
{
	global $conn;

	$stmt = $conn->prepare("SELECT 1 FROM seances WHERE film_id = ? LIMIT 1");
	$stmt->bind_param("i", $filmId);
	$stmt->execute();
	$res = $stmt->get_result();
	$estLie = ($res && $res->num_rows > 0);
	$stmt->close();

	return $estLie;
}

function getFilmsByGenre(string $genre)
{
	global $conn;
	$stmt = $conn->prepare("SELECT * FROM films WHERE genre = ?");
	$stmt->bind_param("s", $genre);
	$stmt->execute();
	return $stmt->get_result();
}

function getFilmsByAnnee(int $annee)
{
	global $conn;
	$stmt = $conn->prepare("SELECT * FROM films WHERE annee_sortie = ?");
	$stmt->bind_param("i", $annee);
	$stmt->execute();
	return $stmt->get_result();
}

function getFilmsByRealisateur(string $realisateur)
{
	global $conn;
	$stmt = $conn->prepare("SELECT * FROM films WHERE realisateur LIKE ?");
	$likeRealisateur = "%" . $realisateur . "%";
	$stmt->bind_param("s", $likeRealisateur);
	$stmt->execute();
	return $stmt->get_result();
}

function getFilmsByTitre(string $titre)
{
	global $conn;
	$stmt = $conn->prepare("SELECT * FROM films WHERE titre LIKE ?");
	$likeTitre = "%" . $titre . "%";
	$stmt->bind_param("s", $likeTitre);
	$stmt->execute();
	return $stmt->get_result();
}

function getFilmsByStatut(string $statut)
{
	global $conn;
	$stmt = $conn->prepare("SELECT * FROM films WHERE statut = ?");
	$stmt->bind_param("s", $statut);
	$stmt->execute();
	return $stmt->get_result();
}
