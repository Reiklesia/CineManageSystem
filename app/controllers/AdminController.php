<?php
require_once __DIR__ . '/../controllers/FilmController.php';

// David
function DashboardAdmin()
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

		$film_result = getTousLesFilmsPagines(10, ($pageCourante - 1) * 10, $sort, $dir);

		foreach ($ids as $id) {
			if ($id > 0 && filmEstLie($id)) {
				$nonSupprimables[$id] = true;
			}
		}
	}

	include __DIR__ . '/../views/admin/dashboard.php';
}
