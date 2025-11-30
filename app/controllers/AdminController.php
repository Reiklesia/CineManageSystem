<?php

require_once __DIR__ . '/../models/FilmModel.php';

function DashboardAdmin()
{
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== 'admin') {
        header("Location: index.php?action=connexion");
        exit;
    }

    $data = getListeFilmsAvecPagination();

    $result       = $data['result'];
    $pageCourante = $data['pageCourante'];
    $pagesTotales = $data['pagesTotales'];

    include __DIR__ . '/../views/admin/dashboard.php';
}

