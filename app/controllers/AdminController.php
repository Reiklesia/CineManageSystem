<?php

require_once __DIR__ . '/../models/FilmModel.php';
require_once __DIR__ . '/FilmController.php';

function DashboardAdmin()
{
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== 'admin') {
        header("Location: index.php?action=connexion");
        exit;
    }

    $data = listeFilmsComplete();

    $result       = $data['result'];
    $pageCourante = $data['pageCourante'];
    $pagesTotales = $data['pagesTotales'];
    $sort         = $data['sort'];
    $dir          = $data['dir'];

    include __DIR__ . '/../views/admin/dashboard.php';
}
