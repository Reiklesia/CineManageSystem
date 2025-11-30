<?php

require_once __DIR__ . '/../models/FilmModel.php';
require_once __DIR__ . '/FilmController.php';
require_once __DIR__ . '/../models/utilisateur/UtilisateurModel.php';
require_once __DIR__ . '/UtilisateurController.php';

function DashboardAdmin()
{
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== 'admin') {
        header("Location: index.php?action=connexion");
        exit;
    }

    $films_data = listeFilmsComplete();
    $film_result  = $films_data['result'];
    $pageCourante = $films_data['pageCourante'];
    $pagesTotales = $films_data['pagesTotales'];
    $sort         = $films_data['sort'];
    $dir          = $films_data['dir'];

    $users_data          = listeUtilisateursComplete();
    $utilisateurs_result = $users_data['result'];
    $userPageCourante    = $users_data['pageCouranteUsers'];
    $userPagesTotales    = $users_data['pagesTotalesUsers'];
    $user_sort           = $users_data['user_sort'];
    $user_dir            = $users_data['user_dir'];

    include __DIR__ . '/../views/admin/dashboard.php';
}