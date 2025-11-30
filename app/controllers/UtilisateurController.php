<?php
require_once __DIR__ . "/../models/utilisateur/UtilisateurModel.php";

function RouteAuthentification()
{

    if (isset($_SESSION["login"])) {
        if ($_SESSION["login"] === 'admin') {
            header("Location: index.php?action=dashboard");
            exit;
        } else {
            header("Location: index.php?action=list");
            exit;
        }
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["connexion"])) {
		$login      = trim($_POST['username'] ?? '');
		$motdepasse = trim($_POST['password'] ?? '');

        $resultat = Authentification($login, $motdepasse);

        if ($resultat) {
            $_SESSION["login"] = $login;
            $_SESSION['flash'] = [
                'type' => 'success',
                'message' => 'Connexion réussie.'
            ];

            if ($resultat['nom_utilisateur'] === 'admin') {
                header("Location: index.php?action=dashboard");
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

function listeUtilisateursComplete()
{
    $parPage = 10;

    if (isset($_GET['page_users']) && ctype_digit($_GET['page_users']) && (int)$_GET['page_users'] > 0) {
        $pageCouranteUsers = (int) $_GET['page_users'];
    } else {
        $pageCouranteUsers = 1;
    }

    $totalUtilisateurs = countAllUtilisateurs();
    $pagesTotalesUsers = max(1, (int) ceil($totalUtilisateurs / $parPage));

    if ($pageCouranteUsers > $pagesTotalesUsers) {
        $pageCouranteUsers = $pagesTotalesUsers;
    }

    $offset = ($pageCouranteUsers - 1) * $parPage;

    $allowedSorts = ['id', 'nom_utilisateur', 'statut'];

    $sort = $_GET['user_sort'] ?? 'id';
    if (!in_array($sort, $allowedSorts, true)) {
        $sort = 'id';
    }

    $dir = $_GET['user_dir'] ?? 'asc';
    $dir = strtolower($dir) === 'desc' ? 'desc' : 'asc';

    $result = getTousLesUtilisateursPagines($parPage, $offset, $sort, $dir);

    return [
        'result'             => $result,
        'pageCouranteUsers'  => $pageCouranteUsers,
        'pagesTotalesUsers'  => $pagesTotalesUsers,
        'user_sort'          => $sort,
        'user_dir'           => $dir,
    ];
}

function afficherListeUtilisateursComplete()
{
    $data = listeUtilisateursComplete();

    $result       = $data['result'];
    $pageCourante = $data['pageCourante'];
    $pagesTotales = $data['pagesTotales'];
    $sort         = $data['sort'];
    $dir          = $data['dir'];

    include __DIR__ . '/../views/admin/utilisateurs.php';
}

function addUser()
{
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== 'admin') {
        header("Location: index.php?action=connexion");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['add'])) {
        echo "<p>Requête invalide.</p>";
        return;
    }

    $nomUtilisateur = trim($_POST['nom_utilisateur'] ?? '');
    $motDePasse     = trim($_POST['mot_de_passe'] ?? '');
    $statut         = 'actif';

    $errors = [];

    if ($nomUtilisateur === '') {
        $errors[] = "Le nom d'utilisateur est obligatoire.";
    } elseif (mb_strlen($nomUtilisateur) > 50) {
        $errors[] = "Le nom d'utilisateur ne doit pas dépasser 50 caractères.";
    }

    if ($motDePasse === '') {
        $errors[] = "Le mot de passe est obligatoire.";
    } elseif (mb_strlen($motDePasse) < 4) {
        $errors[] = "Le mot de passe doit contenir au moins 4 caractères.";
    }

    if (!empty($errors)) {
        $_SESSION['flash'] = [
            'type'    => 'error',
            'message' => implode('<br>', $errors)
        ];

        $_SESSION['old_user'] = [
            'nom_utilisateur' => $nomUtilisateur,
            'statut'          => $statut,
        ];

        header('Location: index.php?action=form_add_user');
        exit;
    }

    $result = ajoutUtilisateur($nomUtilisateur, $motDePasse, $statut);

    if ($result) {
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => "Utilisateur ajouté avec succès."
        ];
        header('Location: index.php?action=dashboard');
        exit;
    } else {
        $_SESSION['flash'] = [
            'type' => 'error',
            'message' => "Impossible d'ajouter l'utilisateur."
        ];
    }
}

function activateUser()
{
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== 'admin') {
        header("Location: index.php?action=connexion");
        exit;
    }

    if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
        echo "<p>Requête invalide : identifiant d'utilisateur non valide.</p>";
        return;
    }

    $id = (int) $_GET['id'];

    if ($id <= 0) {
        echo "<p>Requête invalide : identifiant d'utilisateur inconnu.</p>";
        return;
    }

    $result = setUserStatus($id, 'actif');

    if ($result) {
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => "Utilisateur activé avec succès."
        ];
    } else {
        $_SESSION['flash'] = [
            'type' => 'error',
            'message' => "Impossible d'activer l'utilisateur."
        ];
    }

    header('Location: index.php?action=dashboard');
    exit;
}

function deactivateUser()
{
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== 'admin') {
        header("Location: index.php?action=connexion");
        exit;
    }

    if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
        echo "<p>Requête invalide : identifiant d'utilisateur non valide.</p>";
        return;
    }

    $id = (int) $_GET['id'];

    if ($id <= 0) {
        echo "<p>Requête invalide : identifiant d'utilisateur inconnu.</p>";
        return;
    }

    $result = setUserStatus($id, 'inactif');

    if ($result) {
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => "Utilisateur désactivé avec succès."
        ];
    } else {
        $_SESSION['flash'] = [
            'type' => 'error',
            'message' => "Impossible de désactiver l'utilisateur."
        ];
    }

    header('Location: index.php?action=dashboard');
    exit;
}

function editUser()
{
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== 'admin') {
        header("Location: index.php?action=connexion");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['update'])) {
        echo "<p>Requête invalide.</p>";
        return;
    }

    if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
        echo "<p>Requête invalide : identifiant d'utilisateur non valide.</p>";
        return;
    }

    $id = (int) $_GET['id'];

    $nomUtilisateur = trim($_POST['nom_utilisateur'] ?? '');

    $errors = [];

    if ($nomUtilisateur === '') {
        $errors[] = "Le nom d'utilisateur est obligatoire.";
    } elseif (mb_strlen($nomUtilisateur) > 50) {
        $errors[] = "Le nom d'utilisateur ne doit pas dépasser 50 caractères.";
    }

    if (!empty($errors)) {
        $_SESSION['flash'] = [
            'type'    => 'error',
            'message' => implode('<br>', $errors)
        ];

        $_SESSION['old_user'] = [
            'nom_utilisateur' => $nomUtilisateur,
        ];

        header('Location: index.php?action=form_edit_user&id=' . $id);
        exit;
    }

    $result = modifierUtilisateur($id, $nomUtilisateur);

    if ($result) {
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => "Utilisateur modifié avec succès."
        ];
        header('Location: index.php?action=dashboard');
        exit;
    } else {
        $_SESSION['flash'] = [
            'type' => 'error',
            'message' => "Impossible de modifier l'utilisateur."
        ];
    }
}

function afficherFormAjoutUser()
{
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== 'admin') {
        header("Location: index.php?action=connexion");
        exit;
    }

    include __DIR__ . '/../views/admin/add_user.php';
}

function afficherFormEditUser()
{
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== 'admin') {
        header("Location: index.php?action=connexion");
        exit;
    }

    if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
        echo "<p>Utilisateur introuvable.</p>";
        return;
    }

    $id = (int) $_GET['id'];

    $utilisateur = getUtilisateurById($id);

    if (!$utilisateur) {
        echo "<p>Utilisateur introuvable.</p>";
        return;
    }

    include __DIR__ . '/../views/admin/edit_user.php';
}

function Logout()
{

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }


    $_SESSION = [];
    session_destroy();


    header("Location: index.php?action=list");
    exit;
}

function deleteUser()
{
	if (!isset($_SESSION['login']) || $_SESSION['login'] !== 'admin') {
		header("Location: index.php?action=connexion");
		exit;
	}

	if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
		echo "<p>Requête invalide : identifiant d'utilisateur non valide.</p>";
		return;
	}

	$id = (int) $_GET['id'];

	if ($id <= 0) {
		echo "<p>Requête invalide : identifiant d'utilisateur inconnu.</p>";
		return;
	}

	$result = supprimerUtilisateur($id);

	if ($result) {
		$_SESSION['flash'] = [
			'type' => 'success',
			'message' => "Utilisateur supprimé avec succès."
		];
	} else {
		$_SESSION['flash'] = [
			'type' => 'error',
			'message' => "Impossible de supprimer l'utilisateur."
		];
	}

	header('Location: index.php?action=dashboard');
	exit;
}

?>