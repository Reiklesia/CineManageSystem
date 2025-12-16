<?php
require_once __DIR__ . '/../models/FilmModel.php';
require_once __DIR__ . '/../helper/auth.php';

// David et Amélie
function ListeFilmsComplete($contexte = 'public')
{
	if ($contexte === 'admin') {
		requireAdmin();
		$parPage = 10;
		$actionPagination = 'dashboard';
		$sortDefaut = 'id';
	} else {
		$parPage = 12;
		$actionPagination = 'list';
		$sortDefaut = 'titre';
	}

	$pageCourante = 1;
	if (isset($_GET['page']) && ctype_digit($_GET['page']) && (int) $_GET['page'] > 0) {
		$pageCourante = (int) $_GET['page'];
	}

	$totalFilms   = countAllFilms();
	$pagesTotales = max(1, (int) ceil($totalFilms / $parPage));

	if ($pageCourante > $pagesTotales) {
		$pageCourante = $pagesTotales;
	}

	$offset = ($pageCourante - 1) * $parPage;

	$allowedSorts = ['id', 'titre', 'realisateur', 'genre', 'annee_sortie', 'statut', 'affiche'];

	$sort = $_GET['sort'] ?? $sortDefaut;
	if (!in_array($sort, $allowedSorts, true)) {
		$sort = $sortDefaut;
	}

	$dir = $_GET['dir'] ?? 'asc';
	$dir = strtolower($dir) === 'desc' ? 'desc' : 'asc';

	$result = getTousLesFilmsPagines($parPage, $offset, $sort, $dir);

	if (!$result) {
		echo "<p>Films introuvables.</p>";
		return;
	}

	if ($contexte === 'admin') {
		return [
			'film_result'  => $result,
			'pageCourante' => $pageCourante,
			'pagesTotales' => $pagesTotales,
			'sort'         => $sort,
			'dir'          => $dir
		];
	}

	include __DIR__ . '/../views/filmList.php';
}

// David
function FilmById($id)
{
	$film = getById($id);
	if ($film) {
		include __DIR__ . '/../views/film.php';
	} else {
		echo "<p>Film introuvable.</p>";
	}
}

// Jérémy
function addFilm()
{
	$nomAffiche = 'placeholder-gris.jpg';

	if (isset($_FILES['affiche']) && $_FILES['affiche']['error'] === UPLOAD_ERR_OK) {
	}

	if (isset($_POST['add'])) {
		$titre = $_POST['titre'];
		$realisateur = $_POST['realisateur'];
		$genre = $_POST['genre'];
		$annee = intval($_POST['annee_sortie']);
		$description = $_POST['description'];
		$affiche = $nomAffiche;

		if (isset($_FILES['affiche']) && $_FILES['affiche']['error'] === UPLOAD_ERR_OK) {
			$affiche = $_FILES['affiche']['name'];
		}

		$result = ajoutFilm($titre, $realisateur, $genre, $annee, $description, $affiche);
		if ($result) {
			$_SESSION['flash'] = [
				'type' => 'success',
				'message' => 'Film ajouté avec succès.'
			];
			header('Location: index.php?action=dashboard');
			exit;
		} else {
			$_SESSION['flash'] = [
				'type' => 'error',
				'message' => "Impossible d'ajouter le film."
			];
		}
	}
}

// Amélie
function editFilm()
{
	if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['update']) || !isset($_GET['id'])) {
		$_SESSION['flash'] = [
			'type' => 'error',
			'message' => 'Requête invalide.'
		];
		header('Location: index.php?action=dashboard');
		exit;
	}

	if (!ctype_digit($_GET['id'])) {
		$_SESSION['flash'] = [
			'type' => 'error',
			'message' => 'Identifiant de film invalide.'
		];
		header('Location: index.php?action=dashboard');
		exit;
	}

	$id = (int) $_GET['id'];

	$titre = trim($_POST['titre'] ?? '');
	$realisateur = trim($_POST['realisateur'] ?? '');
	$genre = trim($_POST['genre'] ?? '');
	$anneeBrut = trim($_POST['annee_sortie'] ?? '');
	$description = trim($_POST['description'] ?? '');
	$affiche = $_FILES['affiche']['name'] ?? null;

	$erreurs = [];

	if ($titre === '') {
		$erreurs['titre'] = "Le titre est obligatoire.";
	}
	if ($realisateur === '') {
		$erreurs['realisateur'] = "Le réalisateur est obligatoire.";
	}
	if ($genre === '') {
		$erreurs['genre'] = "Le genre est obligatoire.";
	}

	if ($anneeBrut === '' || !ctype_digit($anneeBrut)) {
		$erreurs['annee_sortie'] = "L'année de sortie doit être un nombre.";
	} else {
		$annee = (int) $anneeBrut;
		if ($annee < 1888 || $annee > (int) date('Y') + 1) {
			$erreurs['annee_sortie'] = "L'année de sortie n'est pas valide.";
		}
	}

	if (!empty($erreurs)) {
		$_SESSION['erreurs_form'] = $erreurs;
		$_SESSION['old_inputs'] = [
			'titre' => $titre,
			'realisateur' => $realisateur,
			'genre' => $genre,
			'annee_sortie' => $anneeBrut,
			'description'  => $description,
			'affiche'      => $affiche
		];

		$_SESSION['flash'] = [
			'type' => 'error',
			'message' => 'Certains champs sont invalides.'
		];

		header('Location: index.php?action=afficherFormEdit&id=' . $id);
		exit;
	}

	$annee = (int) $anneeBrut;

	$result = modifierFilm($id, $titre, $realisateur, $genre, $annee, $description, $affiche);

	if ($result) {
		$_SESSION['flash'] = [
			'type' => 'success',
			'message' => 'Film modifié avec succès.'
		];
		header('Location: index.php?action=dashboard');
		exit;
	} else {
		$_SESSION['flash'] = [
			'type' => 'error',
			'message' => "Impossible de modifier le film."
		];
	}
}

// Amélie
function deleteFilm()
{
	if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
		$_SESSION['flash'] = [
			'type' => 'error',
			'message' => 'Requête invalide.'
		];
		header('Location: index.php?action=dashboard');
		exit;
	}

	$id = (int) $_GET['id'];
	if ($id <= 0) {
		$_SESSION['flash'] = [
			'type' => 'error',
			'message' => 'Identifiant de film invalide.'
		];
		header('Location: index.php?action=dashboard');
		exit;
	}

	if (filmEstLie($id)) {
		$_SESSION['flash'] = [
			'type' => 'error',
			'message' => "Ce film ne peut pas être supprimé car il est lié à des séances."
		];
		header('Location: index.php?action=dashboard');
		exit;
	}

	$result = supprimerFilm($id);

	if ($result) {
		$_SESSION['flash'] = [
			'type' => 'success',
			'message' => 'Film supprimé avec succès.'
		];
	} else {
		$_SESSION['flash'] = [
			'type' => 'error',
			'message' => "Impossible de supprimer le film."
		];
	}

	header('Location: index.php?action=dashboard');
	exit;
}

function toggleFilmStatut()
{
	if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
		$_SESSION['flash'] = [
			'type' => 'error',
			'message' => 'Requête invalide.'
		];
		header('Location: index.php?action=dashboard');
		exit;
	}

	$id = (int) $_GET['id'];
	if ($id <= 0) {
		$_SESSION['flash'] = [
			'type' => 'error',
			'message' => 'Identifiant de film invalide.'
		];
		header('Location: index.php?action=dashboard');
		exit;
	}

	$result = getById($id);
	if (!$result) {
		$_SESSION['flash'] = [
			'type' => 'error',
			'message' => 'Film introuvable.'
		];
		header('Location: index.php?action=dashboard');
		exit;
	}

	if ($result['statut'] === 'actif') {
		desactiverFilm($id);
		$_SESSION['flash'] = [
			'type' => 'success',
			'message' => 'Film désactivé avec succès.'
		];
	} else {
		global $conn;
		$stmt = $conn->prepare("UPDATE films SET statut = 'actif' WHERE id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->close();

		$_SESSION['flash'] = [
			'type' => 'success',
			'message' => 'Film activé avec succès.'
		];
	}

	header('Location: index.php?action=dashboard');
	exit;
}

// David
function afficherFormAjout()
{
	include __DIR__ . '/../views/admin/add_film.php';
}

// Amélie
function afficherFormEdit()
{
	if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
		$_SESSION['flash'] = [
			'type' => 'error',
			'message' => 'Film introuvable.'
		];
		header('Location: index.php?action=dashboard');
		exit;
	}

	$id = (int) $_GET['id'];
	if ($id <= 0) {
		$_SESSION['flash'] = [
			'type' => 'error',
			'message' => 'Film introuvable.'
		];
		header('Location: index.php?action=dashboard');
		exit;
	}

	$film = getById($id);

	if (!$film) {
		$_SESSION['flash'] = [
			'type' => 'error',
			'message' => 'Film introuvable.'
		];
		header('Location: index.php?action=dashboard');
		exit;
	}

	include __DIR__ . '/../views/admin/edit_film.php';
}

// Amélie
function afficherAccueil()
{
	$parPage = 12;

	$pageCourante = 1;
	if (isset($_GET['page']) && ctype_digit($_GET['page']) && (int) $_GET['page'] > 0) {
		$pageCourante = (int) $_GET['page'];
	}

	$totalFilms   = countAllFilms();
	$pagesTotales = max(1, (int) ceil($totalFilms / $parPage));

	if ($pageCourante > $pagesTotales) {
		$pageCourante = $pagesTotales;
	}

	$offset = ($pageCourante - 1) * $parPage;

	$allowedSorts = ['id', 'titre', 'realisateur', 'genre', 'annee_sortie', 'statut', 'affiche'];
	$sort = $_GET['sort'] ?? 'titre';
	if (!in_array($sort, $allowedSorts, true)) {
		$sort = 'titre';
	}

	$dir = $_GET['dir'] ?? 'asc';
	$dir = strtolower($dir) === 'desc' ? 'desc' : 'asc';

	$result = getTousLesFilmsPagines($parPage, $offset, $sort, $dir);

	if ($result) {
		include __DIR__ . '/../views/accueil.php';
	} else {
		echo "<p>Films introuvables.</p>";
	}
}

// Jérémy
function afficherContact()
{
	include __DIR__ . '/../views/contact_form.php';
}

function afficherTarifs()
{
	include __DIR__ . '/../views/tarifs.php';
}
function afficherInfolettre()
{
	include __DIR__ . '/../views/infolettre.php';
}

function afficherListeFilmsComplete()
{
	ListeFilmsComplete('public');
}

function filtrerFilmsParGenre($genre)
{
	$film_result = getFilmsByGenre($genre);

	$pageCourante = 1;
	$pagesTotales = 1;
	$sort = 'id';
	$dir = 'asc';
	$nonSupprimables = [];

	if ($film_result && $film_result->num_rows > 0) {

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
	$isFiltre = true;
	include __DIR__ . '/../views/admin/dashboard.php';
}

function filtrerFilmsParAnnee($annee)
{
	$annee = (int) $annee;
	$film_result = ($annee > 0) ? getFilmsByAnnee($annee) : null;

	$pageCourante = 1;
	$pagesTotales = 1;
	$sort = 'id';
	$dir = 'asc';
	$nonSupprimables = [];

	if ($film_result && $film_result->num_rows > 0) {
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
	$isFiltre = true;
	include __DIR__ . '/../views/admin/dashboard.php';
}

function filtrerFilmsParRealisateur($realisateur)
{
	$realisateur = trim((string)$realisateur);
	$film_result = ($realisateur !== '') ? getFilmsByRealisateur($realisateur) : null;

	$pageCourante = 1;
	$pagesTotales = 1;
	$sort = 'id';
	$dir = 'asc';
	$nonSupprimables = [];

	if ($film_result && $film_result->num_rows > 0) {
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
	$isFiltre = true;
	include __DIR__ . '/../views/admin/dashboard.php';
}

function filtrerFilmsParTitre($titre)
{
	$titre = trim((string)$titre);
	$film_result = ($titre !== '') ? getFilmsByTitre($titre) : null;

	$pageCourante = 1;
	$pagesTotales = 1;
	$sort = 'id';
	$dir = 'asc';
	$nonSupprimables = [];

	if ($film_result && $film_result->num_rows > 0) {
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
	$isFiltre = true;
	include __DIR__ . '/../views/admin/dashboard.php';
}

function filtrerFilmsParStatut($statut)
{
	$statut = trim((string)$statut);
	$statut = ($statut === 'actif' || $statut === 'inactif') ? $statut : '';

	$film_result = ($statut !== '') ? getFilmsByStatut($statut) : null;

	$pageCourante = 1;
	$pagesTotales = 1;
	$sort = 'id';
	$dir = 'asc';
	$nonSupprimables = [];

	if ($film_result && $film_result->num_rows > 0) {
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
	$isFiltre = true;
	include __DIR__ . '/../views/admin/dashboard.php';
}
