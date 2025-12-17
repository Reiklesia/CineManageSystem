<?php

function validerFilm(array $data): array
{
	$titre = trim($data['titre'] ?? '');
	$realisateur = trim($data['realisateur'] ?? '');
	$genre = trim($data['genre'] ?? '');
	$anneeBrut = trim((string)($data['annee_sortie'] ?? ''));

	$erreurs = [];

	if ($titre === '') $erreurs['titre'] = "Le titre est obligatoire.";
	if ($realisateur === '') $erreurs['realisateur'] = "Le réalisateur est obligatoire.";
	if ($genre === '') $erreurs['genre'] = "Le genre est obligatoire.";

	if ($anneeBrut === '' || !ctype_digit($anneeBrut)) {
		$erreurs['annee_sortie'] = "L'année de sortie doit être un nombre.";
	} else {
		$annee = (int)$anneeBrut;
		if ($annee < 1888 || $annee > (int)date('Y') + 1) {
			$erreurs['annee_sortie'] = "L'année de sortie n'est pas valide.";
		}
	}

	return $erreurs;
}

function calcPagination(int $total, int $parPage, int $pageCourante): array
{
	$parPage = max(1, $parPage);

	$pagesTotales = max(1, (int) ceil($total / $parPage));

	if ($pageCourante < 1) $pageCourante = 1;
	if ($pageCourante > $pagesTotales) $pageCourante = $pagesTotales;

	$offset = ($pageCourante - 1) * $parPage;

	return [
		'pageCourante' => $pageCourante,
		'pagesTotales' => $pagesTotales,
		'offset'       => $offset,
	];
}
