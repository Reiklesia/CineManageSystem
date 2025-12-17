<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../helper/film_validation.php';

final class FilmValidationTest extends TestCase
{
	public function testTitreVideRetourneErreur(): void
	{
		$err = validerFilm([
			'titre' => '',
			'realisateur' => 'Nolan',
			'genre' => 'Action',
			'annee_sortie' => '2010',
		]);

		$this->assertArrayHasKey('titre', $err);
	}

	public function testAnneeNonNumeriqueRetourneErreur(): void
	{
		$err = validerFilm([
			'titre' => 'Inception',
			'realisateur' => 'Nolan',
			'genre' => 'Action',
			'annee_sortie' => 'abcd',
		]);

		$this->assertArrayHasKey('annee_sortie', $err);
	}

	public function testFilmValideRetourneAucuneErreur(): void
	{
		$err = validerFilm([
			'titre' => 'Inception',
			'realisateur' => 'Nolan',
			'genre' => 'Action',
			'annee_sortie' => '2010',
		]);

		$this->assertSame([], $err);
	}

	public function testAnneeTropPetiteRetourneErreur(): void
	{
		$err = validerFilm([
			'titre' => 'Test',
			'realisateur' => 'Test',
			'genre' => 'Test',
			'annee_sortie' => '1700',
		]);

		$this->assertArrayHasKey('annee_sortie', $err);
	}

	public function testRealisateurVideRetourneErreur(): void
	{
		$err = validerFilm([
			'titre' => 'Test',
			'realisateur' => '',
			'genre' => 'Action',
			'annee_sortie' => '2010',
		]);

		$this->assertArrayHasKey('realisateur', $err);
	}
}
