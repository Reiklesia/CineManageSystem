<?php
require_once __DIR__ . "/../models/utilisateur/UtilisateurModel.php";
require_once __DIR__ . '/../helper/auth.php';

// David
function RouteAuthentification()
{

	if (isset($_SESSION["login"])) {
		if (isAdmin()) {
			header("Location: index.php?action=dashboard_users");
			exit;
		} else {
			header("Location: index.php?action=list");
			exit;
		}
	}
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["connexion"])) {
		$login = trim($_POST['username']) ?? '';
		$motdepasse = trim($_POST['password']) ?? '';

		$resultat = Authentification($login, $motdepasse);

		if ($resultat) {
			$_SESSION["login"] = $login;
			$_SESSION["role"] = $resultat['role'];
			$_SESSION['flash'] = [
				'type' => 'success',
				'message' => 'Connexion réussie.'
			];

			if (isAdmin()) {
				header("Location: index.php?action=dashboard_users");
				exit;
			} else {
				header("Location: index.php?action=list");
				exit;
			}
		} else {
			$_SESSION['flash'] = [
				'type' => 'error',
				'message' => 'Identifiants invalides.'
			];
			include __DIR__ . '/../views/login.php';
		}
	} else {
		include __DIR__ . '/../views/login.php';
	}
}

// David
function Logout()
{

	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}

	$_SESSION = [];
	session_destroy();

	header("Location: index.php?action=accueil");
	exit;
}

function AjouterUtilisateur()
{
	requireAdmin();

	if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['add_user'])) {
		include __DIR__ . '/../views/admin/add_user.php';
		return;
	}

	$nomUtilisateur = trim($_POST['nom_utilisateur'] ?? '');
	$motDePasse     = (string)($_POST['mot_de_passe'] ?? '');
	$role           = trim($_POST['role'] ?? 'user');

	$rolesPermis = ['admin', 'user'];
	if (!in_array($role, $rolesPermis, true)) {
		$role = 'user';
	}

	if ($nomUtilisateur === '' || $motDePasse === '') {
		$_SESSION['flash'] = [
			'type' => 'error',
			'message' => 'Nom d’utilisateur et mot de passe sont obligatoires.'
		];
		include __DIR__ . '/../views/admin/add_user.php';
		return;
	}

	$ok = addUser($nomUtilisateur, $motDePasse, $role);

	if ($ok) {
		$_SESSION['flash'] = [
			'type' => 'success',
			'message' => 'Utilisateur ajouté avec succès.'
		];
		header('Location: index.php?action=liste_utilisateurs');
		exit;
	}

	$_SESSION['flash'] = [
		'type' => 'error',
		'message' => "Impossible d'ajouter l’utilisateur (nom déjà utilisé?)."
	];
	include __DIR__ . '/../views/admin/add_user.php';
}
