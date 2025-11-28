<?php

session_start();
require_once __DIR__ . "/../models/utilisateur/UtilisateurModel.php";
function RouteAuthentification()
{

    if (isset($_SESSION["login"])) {

        if ($_SESSION["login"] === 'admin') {
            header("Location: ../app/views/admin/dashboard.php");
            exit;
        } else {
            header("Location: ../../public/index.php");
            exit;
        }
    }
    if (isset($_POST["connexion"])) {
        $login = $_POST["username"] ?? '';
        $motdepasse = $_POST["password"] ?? '';

        $resultat = Authentification($login, $motdepasse);

        if ($resultat) {
            $_SESSION["login"] = $login;

            if ($resultat['nom_utilisateur'] === 'admin') {
                header("Location: ../views/admin/dashboard.php");
                exit;
            } else {
                header("Location: ../../public/index.php");
                exit;
            }
        } else {
            $error = "Identifiants invalides.";
            include __DIR__ . '/../views/login.php';
        }

    } else {
        include __DIR__ . '/../views/login.php';
    }
}

?>