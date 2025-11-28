<?php

use LDAP\Result;

require_once __DIR__ . '/../models/FilmModel.php';
function ListeFilmsComplete()
{
   $result = getAllFilms();

   if ($result) {
      include __DIR__ . '/../views/filmList.php';
   } else {
      echo "<p>Films introuvables.</p>";
   }
}

function FilmById($id)
{
   $film = getById($id);
   if ($film) {
      include __DIR__ . '/../views/film.php';
   } else {
      echo "<p>Film introuvable.</p>";
   }
}

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
         header('Location: index.php?action=dashboard');
         exit;
      } else {
         echo "<p>Impossible d'ajouter le film.</p>";
      }
   }
}

function afficherFormAjout(){
   include __DIR__ . '/../views/admin/add_film.php';
}

// Controler
// Méthode de réception GET ou POST
// appeler les fonctions du modèle
// Choisis la vue a afficher
