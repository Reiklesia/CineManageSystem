<?php
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
// Controler
// Méthode de réception GET ou POST
// appeler les fonctions du modèle
// Choisis la vue a afficher
?>