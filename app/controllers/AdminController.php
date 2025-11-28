<?php

require_once __DIR__ . "/../models/utilisateur/UtilisateurModel.php";
require_once __DIR__ . '/../models/FilmModel.php';
function DashboardAdmin()
{

    if (!isset($_SESSION['login']) || $_SESSION['login'] !== 'admin') {
        header("Location: index.php?action=connexion");
        exit;
    }

    $result = getAllFilms();


    include __DIR__ . '/../views/admin/dashboard.php';
}


?>