<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../app/controllers/FilmController.php';
require_once __DIR__ . '/../app/controllers/UtilisateurController.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';


$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        afficherListeFilmsActifs();
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
    
    case 'add_film' :
        addFilm();
        break;
    
    case 'form_add_film':
        afficherFormAjoutFilm();
        break;

	case 'edit_film':
        editFilm();
        break;

	case 'form_edit_film':
		afficherFormEditFilm();
		break;

	case 'activate_film':
		activateFilm();
		break;

	case 'deactivate_film':
		deactivateFilm();
		break;

	case 'delete_film':
		deleteFilm();
		break;

	case 'add_user':
		addUser();
		break;

	case 'form_add_user':
		afficherFormAjoutUser();
		break;

	case 'edit_user':
		editUser();
		break;

	case 'form_edit_user':
		afficherFormEditUser();
		break;

	case 'activate_user':
		activateUser();
		break;

	case 'deactivate_user':
		deactivateUser();
		break;

	case 'delete_user':
		deleteUser();
		break;

    default:
        http_response_code(404);
        echo "<p>Page introuvable.</p>";
        break;
}

?>