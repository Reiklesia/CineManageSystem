<?php
require_once __DIR__ . '/../../includes/db_connect.php';

function Authentification($nomUtilisateur, $motDePasse)
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM administrateurs WHERE nom_utilisateur = ? and mot_de_passe = ?");
    $stmt->bind_param("ss", $nomUtilisateur, $motDePasse);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return false;
    }

    return $result->fetch_assoc();
}

function countAllUtilisateurs()
{
    global $conn;

    $sql = "SELECT COUNT(*) AS total FROM utilisateurs";
    $result = $conn->query($sql);

    if (!$result) {
        return 0;
    }

    $row = $result->fetch_assoc();
    return (int) ($row['total'] ?? 0);
}

function getTousLesUtilisateurs()
{
    global $conn;
    $sql = "SELECT id, nom_utilisateur FROM utilisateurs ORDER BY nom_utilisateur ASC";
    $result = $conn->query($sql);
    if (!$result) {
        die("Erreur lors de la récupération des utilisateurs : " . $conn->error);
    }
    return $result;
}

function getTousLesUtilisateursPagines(int $parPage, int $offset, string $sort, string $dir)
{
    global $conn;

    $allowedSorts = ['id', 'nom_utilisateur', 'statut'];
    if (!in_array($sort, $allowedSorts, true)) {
        $sort = 'id';
    }

    $dirSql = strtolower($dir) === 'desc' ? 'DESC' : 'ASC';

    $sql = "
        SELECT id, nom_utilisateur, statut
        FROM utilisateurs
        ORDER BY $sort $dirSql
        LIMIT ? OFFSET ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $parPage, $offset);
    $stmt->execute();

    return $stmt->get_result();
}

function getUtilisateurById($id)
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return null;
    }

    return $result->fetch_assoc();
}

function setUserStatus($id, $status)
{
    global $conn;

    $allowedStatus = ['actif', 'inactif'];
    if (!in_array($status, $allowedStatus, true)) {
        $status = 'actif';
    }

    $stmt = $conn->prepare("UPDATE utilisateurs SET statut = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);

    return $stmt->execute();
}

function modifierUtilisateur($id, $nomUtilisateur)
{
    global $conn;

    $stmt = $conn->prepare("
        UPDATE utilisateurs
        SET nom_utilisateur = ?
        WHERE id = ?
    ");

    if (!$stmt) {
        return false;
    }

    $stmt->bind_param("si", $nomUtilisateur, $id);

    return $stmt->execute();
}

function ajoutUtilisateur($nomUtilisateur, $motDePasse, $statut = 'actif')
{
    global $conn;

    $allowedStatus = ['actif', 'inactif'];
    if (!in_array($statut, $allowedStatus, true)) {
        $statut = 'actif';
    }

    $sql = "INSERT INTO utilisateurs (nom_utilisateur, mot_de_passe, statut)
            VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return false;
    }

    $stmt->bind_param('sss', $nomUtilisateur, $motDePasse, $statut);

    return $stmt->execute();
}

function supprimerUtilisateur($id)
{
	global $conn;

	$stmt = $conn->prepare("DELETE FROM utilisateurs WHERE id = ?");
	$stmt->bind_param("i", $id);

	return $stmt->execute();
}