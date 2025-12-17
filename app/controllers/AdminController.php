<?php
require_once __DIR__ . '/../controllers/FilmController.php';

// David
function DashboardAdminFilms()
{
	$data = ListeFilmsComplete('admin');

	$film_result  = $data['film_result'];
	$pageCourante = $data['pageCourante'];
	$pagesTotales = $data['pagesTotales'];
	$sort         = $data['sort'];
	$dir          = $data['dir'];
	$nonSupprimables = [];

	if ($film_result) {
		$ids = [];

		while ($row = $film_result->fetch_assoc()) {
			$ids[] = (int)($row['id'] ?? 0);
		}

		$film_result->data_seek(0);

		foreach ($ids as $id) {
			if ($id > 0 && filmEstLie($id)) {
				$nonSupprimables[$id] = true;
			}
		}
	}
	include __DIR__ . '/../views/admin/dashboard_films.php';
}

// David
function DashboardAdminUsers()
{
	requireAdmin();

	$parPage = 10;
	$actionPagination = 'dashboard_users';
	$sortDefaut = 'id';

	$pageCourante = 1;
	if (isset($_GET['page']) && ctype_digit($_GET['page']) && (int)$_GET['page'] > 0) {
		$pageCourante = (int)$_GET['page'];
	}

	$totalUsers   = countAllUtilisateurs();
	$pagesTotales = max(1, (int)ceil($totalUsers / $parPage));

	if ($pageCourante > $pagesTotales) {
		$pageCourante = $pagesTotales;
	}

	$offset = ($pageCourante - 1) * $parPage;

	$allowedSorts = ['id', 'nom_utilisateur', 'role'];

	$sort = $_GET['sort'] ?? $sortDefaut;
	if (!in_array($sort, $allowedSorts, true)) {
		$sort = $sortDefaut;
	}

	$dir = $_GET['dir'] ?? 'asc';
	$dir = strtolower($dir) === 'desc' ? 'desc' : 'asc';

	$user_result = getTousLesUtilisateursPagines($parPage, $offset, $sort, $dir);

	include __DIR__ . '/../views/admin/dashboard_users.php';
}
