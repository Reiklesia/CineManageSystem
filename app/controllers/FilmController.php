<?php
require_once __DIR__ . '/../models/FilmModel.php';

// David
function ListeFilmsComplete()
{
    $result = getAllFilms();

    if ($result) {
        include __DIR__ . '/../views/filmList.php';
    } else {
        echo "<p>Films introuvables.</p>";
    }
}

// Amélie
function ListeFilmsAvecAffiches()
{
	$result = getAllFilmsAvecAffiches();
	if ($result) {
		include __DIR__ . '/../views/filmList.php';
   	} else {
		echo "<p>Films introuvables.</p>";
   	}
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
    if (isset($_POST['add'])) {
        $titre = $_POST['titre'];
        $realisateur = $_POST['realisateur'];
        $genre = $_POST['genre'];
        $annee = intval($_POST['annee_sortie']);
        $description = $_POST['description'];

        $result = ajoutFilm($titre, $realisateur, $genre, $annee, $description);
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
    $result = getAllFilmsAvecAffiches();

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