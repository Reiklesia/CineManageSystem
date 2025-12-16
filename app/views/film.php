<?php
include __DIR__ . '/../includes/header.php';

$fichierAffiche = $film['affiche'];
$srcAffiche = BASE_URL . '/public/assets/affiches/' . rawurlencode($fichierAffiche);
?>

<link
	rel="stylesheet"
	href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<section class="film-page">
	<div class="film-layout">

		<div class="film-poster">
			<img
				src="<?= htmlspecialchars($srcAffiche, ENT_QUOTES, 'UTF-8'); ?>"
				alt="Affiche de <?= htmlspecialchars($film['titre'], ENT_QUOTES, 'UTF-8'); ?>">
		</div>

		<div class="film-info">
			<h1 class="film-title">
				<?= htmlspecialchars($film['titre'], ENT_QUOTES, 'UTF-8'); ?>
			</h1>

			<div class="film-meta">
				<span><?= htmlspecialchars((string) $film['annee_sortie'], ENT_QUOTES, 'UTF-8'); ?></span>
				<span class="dot">•</span>
				<span><?= htmlspecialchars($film['genre'], ENT_QUOTES, 'UTF-8'); ?></span>
			</div>

			<p class="film-description">
				<?= htmlspecialchars($film['description'], ENT_QUOTES, 'UTF-8'); ?>
			</p>

			<a
				href="https://www.youtube.com"
				target="_blank"
				rel="noopener noreferrer"
				class="trailer-btn">
				<i class="fa-solid fa-circle-play"></i>
				<span>Bande-annonce</span>
			</a>

			<div class="showtimes">
				<button class="time-btn">19h25</button>
				<button class="time-btn active">21h30</button>
				<button class="time-btn active">23h05</button>
			</div>

			<div class="film-extra">
				<p>
					<strong>Réalisateur :</strong>
					<?= htmlspecialchars($film['realisateur'], ENT_QUOTES, 'UTF-8'); ?>
				</p>
			</div>
		</div>

	</div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>