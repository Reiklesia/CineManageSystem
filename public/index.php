<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../app/controllers/FilmController.php';
require_once __DIR__ . '/../app/controllers/UtilisateurController.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';
require_once __DIR__ . '/../app/helper/auth.php';


$action = $_GET['action'] ?? 'accueil';

switch ($action) {

	case 'accueil':
		afficherAccueil();
		break;

	case 'contact':
		afficherContact();
		break;

	case 'tarifs':
		afficherTarifs();
		break;

	case 'infolettre':
		afficherInfolettre();
		break;

	case 'list':
		ListeFilmsComplete('public');
		break;

	case 'film':
		if (isset($_GET['id'])) {
			FilmById((int) $_GET['id']);
		}
		break;

	case 'connexion':
		RouteAuthentification();
		break;

	case 'dashboard':
		DashboardAdmin();
		break;

	case 'logout':
		Logout();
		break;

	case 'add_film':
		addFilm();
		break;

	case 'form_add_film':
		afficherFormAjout();
		break;

	case 'edit_film':
		editFilm();
		break;

	case 'form_edit_film':
		afficherFormEdit();
		break;

	case 'delete_film':
		deleteFilm();
		break;

	case 'toggle_film_statut':
		toggleFilmStatut();
		break;

	case 'filtre_films_genre':
		$genre = trim($_GET['genre'] ?? '');
		filtrerFilmsParGenre($genre);
		break;

	case 'filtre_films_annee':
		$annee = isset($_GET['annee']) ? (int) $_GET['annee'] : 0;
		filtrerFilmsParAnnee($annee);
		break;

	case 'filtre_films_realisateur':
		$realisateur = trim($_GET['realisateur'] ?? '');
		filtrerFilmsParRealisateur($realisateur);
		break;

	case 'filtre_films_titre':
		$titre = trim($_GET['titre'] ?? '');
		filtrerFilmsParTitre($titre);
		break;

	case 'filtre_films_statut':
		$statut = trim($_GET['statut'] ?? '');
		filtrerFilmsParStatut($statut);
		break;


	default:
		http_response_code(404);
		echo "<p>Page introuvable.</p>";
		break;
}
