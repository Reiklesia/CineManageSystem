<?php
require_once __DIR__ . "/../models/utilisateur/UtilisateurModel.php";
require_once __DIR__ . '/../helper/auth.php';
function RouteAuthentification()
{

    if (isset($_SESSION["login"])) {
        if (isAdmin()) {
            header("Location: index.php?action=dashboard");
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


?>