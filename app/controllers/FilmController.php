<?php

use LDAP\Result;

require_once __DIR__ . '/../models/FilmModel.php';

function ListeFilmsComplete()
{
    $result = getAllFilms();

    if (!$result) {
        echo "<p>Erreur lors de la récupération des films.</p>";
        return;
    }

    if ($result->num_rows === 0) {
        echo "<p>Aucun film trouvé.</p>";
        return;
    }

    include __DIR__ . '/../views/filmList.php';
}

function FilmById($id)
{
    if (!is_int($id)) {
        if (!is_numeric($id)) {
            echo "<p>Requête invalide : identifiant de film non valide.</p>";
            return;
        }
        $id = (int) $id;
    }

    if ($id <= 0) {
        echo "<p>Requête invalide : identifiant de film inconnu.</p>";
        return;
    }

    $film = getById($id);

    if ($film) {
        include __DIR__ . '/../views/film.php';
    } else {
        echo "<p>Film introuvable.</p>";
    }
}

function addFilm()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['add'])) {
        echo "<p>Requête invalide.</p>";
        return;
    }

    $titre       = trim($_POST['titre'] ?? '');
    $realisateur = trim($_POST['realisateur'] ?? '');
    $genre       = trim($_POST['genre'] ?? '');
    $anneeBrut   = $_POST['annee_sortie'] ?? '';
    $description = trim($_POST['description'] ?? '');

    $errors = [];

    if ($titre === '') {
        $errors[] = "Le titre est obligatoire.";
    }

    if ($realisateur === '') {
        $errors[] = "Le réalisateur est obligatoire.";
    }

    if ($genre === '') {
        $errors[] = "Le genre est obligatoire.";
    }

    if ($description === '') {
        $errors[] = "La description est obligatoire.";
    }

    if ($anneeBrut === '' || !ctype_digit($anneeBrut)) {
        $errors[] = "L'année de sortie doit être un nombre.";
    } else {
        $annee = (int) $anneeBrut;
        $currentYear = (int) date('Y');

        if ($annee < 1880 || $annee > $currentYear + 1) {
            $errors[] = "L'année de sortie doit être comprise entre 1880 et " . ($currentYear + 1) . ".";
        }
    }

	if (!empty($errors)) {
		$_SESSION['flash'] = [
			'type'    => 'error',
			'message' => implode('<br>', $errors)
		];

		$_SESSION['old'] = [
			'titre'        => $titre,
			'realisateur'  => $realisateur,
			'genre'        => $genre,
			'annee_sortie' => $anneeBrut,
			'description'  => $description,
		];

		header('Location: index.php?action=form_add_film');
		exit;
	}


    $result = ajoutFilm($titre, $realisateur, $genre, (int)$anneeBrut, $description);

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

function editFilm()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['update'])) {
        echo "<p>Requête invalide.</p>";
        return;
    }

    if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
        echo "<p>Requête invalide : identifiant de film non valide.</p>";
        return;
    }

    $id = (int) $_GET['id'];

    $titre       = trim($_POST['titre'] ?? '');
    $realisateur = trim($_POST['realisateur'] ?? '');
    $genre       = trim($_POST['genre'] ?? '');
    $anneeBrut   = $_POST['annee_sortie'] ?? '';
    $description = trim($_POST['description'] ?? '');

    $errors = [];

    if ($titre === '') {
        $errors[] = "Le titre est obligatoire.";
    }

    if ($realisateur === '') {
        $errors[] = "Le réalisateur est obligatoire.";
    }

    if ($genre === '') {
        $errors[] = "Le genre est obligatoire.";
    }

    if ($description === '') {
        $errors[] = "La description est obligatoire.";
    }

    if ($anneeBrut === '' || !ctype_digit($anneeBrut)) {
        $errors[] = "L'année de sortie doit être un nombre.";
    } else {
        $annee = (int) $anneeBrut;
        $currentYear = (int) date('Y');

        if ($annee < 1880 || $annee > $currentYear + 1) {
            $errors[] = "L'année de sortie doit être comprise entre 1880 et " . ($currentYear + 1) . ".";
        }
    }

    if (!empty($errors)) {
        $_SESSION['flash'] = [
            'type'    => 'error',
            'message' => implode('<br>', $errors)
        ];

        $_SESSION['old'] = [
            'titre'        => $titre,
            'realisateur'  => $realisateur,
            'genre'        => $genre,
            'annee_sortie' => $anneeBrut,
            'description'  => $description,
        ];

        header('Location: index.php?action=form_edit_film&id=' . $id);
        exit;
    }

    $result = modifierFilm($id, $titre, $realisateur, $genre, (int)$anneeBrut, $description);

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

function deleteFilm()
{
    if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
        echo "<p>Requête invalide : identifiant de film non valide.</p>";
        return;
    }

    $id = (int) $_GET['id'];

    if ($id <= 0) {
        echo "<p>Requête invalide : identifiant de film inconnu.</p>";
        return;
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

function afficherFormAjout()
{
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== 'admin') {
        header("Location: index.php?action=connexion");
        exit;
    }

    include __DIR__ . '/../views/admin/add_film.php';
}

function afficherFormEdit()
{
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== 'admin') {
        header("Location: index.php?action=connexion");
        exit;
    }

    if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
        echo "<p>Film introuvable.</p>";
        return;
    }

    $id = (int) $_GET['id'];

    $film = getById($id);

    if (!$film) {
        echo "<p>Film introuvable.</p>";
        return;
    }

    include __DIR__ . '/../views/admin/edit_film.php';
}

// Controler
// Méthode de réception GET ou POST
// appeler les fonctions du modèle
// Choisis la vue a afficher