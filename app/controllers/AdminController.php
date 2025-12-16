<?php

require_once __DIR__ . "/../models/utilisateur/UtilisateurModel.php";
require_once __DIR__ . '/../controllers/FilmController.php';
require_once __DIR__ . '/../helper/auth.php';

// David
function DashboardAdmin()
{
	requireAdmin();

	$data = ListeFilmsComplete('admin');

	$film_result  = $data['film_result'];
	$pageCourante = $data['pageCourante'];
	$pagesTotales = $data['pagesTotales'];
	$sort         = $data['sort'];
	$dir          = $data['dir'];

	include __DIR__ . '/../views/admin/dashboard.php';
}
