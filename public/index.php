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
        ListeFilmsComplete();
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

    default:
        http_response_code(404);
        echo "<p>Page introuvable.</p>";
        break;
}



?>