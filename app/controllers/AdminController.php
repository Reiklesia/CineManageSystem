<?php

require_once __DIR__ . "/../models/utilisateur/UtilisateurModel.php";
require_once __DIR__ . '/../models/FilmModel.php';
require_once __DIR__ . '/../helper/auth.php';

// David
function DashboardAdmin()
{

    requireAdmin();

    $result = getAllFilms();

    include __DIR__ . '/../views/admin/dashboard.php';
}


?>