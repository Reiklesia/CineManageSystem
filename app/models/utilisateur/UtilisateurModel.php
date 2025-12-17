<?php

// David
function Authentification($nomUtilisateur, $motDePasse)
{

	global $conn;

	$stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE nom_utilisateur = ? and mot_de_passe = ?");
	$stmt->bind_param("ss", $nomUtilisateur, $motDePasse);
	$stmt->execute();

	$result = $stmt->get_result();

	if ($result->num_rows === 0) {
		return false;
	}

	return $result->fetch_assoc();
}

function addUser(string $nomUtilisateur, string $motDePasse, string $role): bool
{
	global $conn;

	$hash = password_hash($motDePasse, PASSWORD_DEFAULT);

	$stmt = $conn->prepare("INSERT INTO utilisateurs (nom_utilisateur, mot_de_passe, role) VALUES (?, ?, ?)");
	if (!$stmt) return false;

	$stmt->bind_param("sss", $nomUtilisateur, $hash, $role);
	return $stmt->execute();
}

// Amelie
function countAllUtilisateurs(): int
{
	global $conn;

	$sql = "SELECT COUNT(*) AS total FROM utilisateurs";
	$result = $conn->query($sql);
	if (!$result) return 0;

	$row = $result->fetch_assoc();
	return (int)($row['total'] ?? 0);
}

function getTousLesUtilisateursPagines(int $parPage, int $offset, string $sort, string $dir)
{
	global $conn;

	$allowedSorts = ['id', 'nom_utilisateur', 'role', 'statut'];
	if (!in_array($sort, $allowedSorts, true)) {
		$sort = 'id';
	}

	$dirSql = strtolower($dir) === 'desc' ? 'DESC' : 'ASC';

	$sql = "
		SELECT id, nom_utilisateur, role
		FROM utilisateurs
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
