<nav class="admin-nav">
	<div class="nav-film">
		<a href="index.php?action=dashboard_films">Gérer les films</a> |
		<a href="index.php?action=form_add_film">Ajouter un film</a>
	</div>
	<div class="nav-user">
		<a href="index.php?action=dashboard_users">Gérer les utilisateurs</a> |
		<a href="index.php?action=form_add_user">Ajouter un utilisateur</a>
	</div>
</nav>

<?php
$filtre = $_GET['filtre'] ?? 'titre';
$filtreValide = ['titre', 'realisateur', 'annee', 'statut', 'genre'];
if (!in_array($filtre, $filtreValide, true)) {
	$filtre = 'titre';
}

$titre       = trim($_GET['titre'] ?? '');
$realisateur = trim($_GET['realisateur'] ?? '');
$annee       = isset($_GET['annee']) ? (int)$_GET['annee'] : '';
$statut      = trim($_GET['statut'] ?? '');
$genre       = trim($_GET['genre'] ?? '');

$isModeFiltre = !empty($_GET['action']) && strpos($_GET['action'], 'filtre_films_') === 0;
?>

<div class="admin-recherche-global">

	<div class="admin-filtre-select">
		<label for="selectFiltre">Filtrer par</label>
		<select id="selectFiltre" name="filtre">
			<option value="titre" <?= $filtre === 'titre' ? 'selected' : ''; ?>>Titre</option>
			<option value="realisateur" <?= $filtre === 'realisateur' ? 'selected' : ''; ?>>Réalisateur</option>
			<option value="annee" <?= $filtre === 'annee' ? 'selected' : ''; ?>>Année</option>
			<option value="statut" <?= $filtre === 'statut' ? 'selected' : ''; ?>>Statut</option>
			<option value="genre" <?= $filtre === 'genre' ? 'selected' : ''; ?>>Genre</option>
		</select>
	</div>

	<?php if ($isModeFiltre): ?>
		<div class="admin-reset-filtre">
			<a href="index.php?action=dashboard_films" class="btn-search">Effacer les filtres</a>
		</div>
	<?php endif; ?>

	<form method="GET" action="index.php" class="admin-form-filtre" data-filtre="titre" style="<?= $filtre === 'titre' ? '' : 'display:none;'; ?>">
		<input type="hidden" name="action" value="filtre_films_titre">
		<input type="hidden" name="filtre" value="titre">

		<input type="text" name="titre" placeholder="Rechercher un titre..." value="<?= htmlspecialchars($titre, ENT_QUOTES, 'UTF-8'); ?>">
		<button type="submit" class="btn-search">Rechercher</button>
	</form>

	<form method="GET" action="index.php" class="admin-form-filtre" data-filtre="realisateur" style="<?= $filtre === 'realisateur' ? '' : 'display:none;'; ?>">
		<input type="hidden" name="action" value="filtre_films_realisateur">
		<input type="hidden" name="filtre" value="realisateur">

		<input type="text" name="realisateur" placeholder="Rechercher un réalisateur..." value="<?= htmlspecialchars($realisateur, ENT_QUOTES, 'UTF-8'); ?>">
		<button type="submit" class="btn-search">Rechercher</button>
	</form>

	<form method="GET" action="index.php" class="admin-form-filtre" data-filtre="annee" style="<?= $filtre === 'annee' ? '' : 'display:none;'; ?>">
		<input type="hidden" name="action" value="filtre_films_annee">
		<input type="hidden" name="filtre" value="annee">

		<input type="number" name="annee" placeholder="Rechercher une année..."
			value="<?= htmlspecialchars((string)$annee, ENT_QUOTES, 'UTF-8'); ?>"
			min="1888" max="<?= (int)date('Y') + 1; ?>">
		<button type="submit" class="btn-search">Rechercher</button>
	</form>

	<form method="GET" action="index.php" class="admin-form-filtre" data-filtre="statut" style="<?= $filtre === 'statut' ? '' : 'display:none;'; ?>">
		<input type="hidden" name="action" value="filtre_films_statut">
		<input type="hidden" name="filtre" value="statut">

		<select name="statut">
			<option value="" <?= ($statut === '') ? 'selected' : ''; ?>>Tous statuts</option>
			<option value="actif" <?= ($statut === 'actif') ? 'selected' : ''; ?>>Actif</option>
			<option value="inactif" <?= ($statut === 'inactif') ? 'selected' : ''; ?>>Inactif</option>
		</select>
		<button type="submit" class="btn-search">Rechercher</button>
	</form>

	<form method="GET" action="index.php" class="admin-form-filtre" data-filtre="genre" style="<?= $filtre === 'genre' ? '' : 'display:none;'; ?>">
		<input type="hidden" name="action" value="filtre_films_genre">
		<input type="hidden" name="filtre" value="genre">

		<label>Genre
			<select name="genre" required>
				<option value="" disabled <?= ($genre === '') ? 'selected' : ''; ?>>Genre...</option>
				<option value="Action" <?= ($genre === 'Action') ? 'selected' : ''; ?>>Action</option>
				<option value="Drama" <?= ($genre === 'Drama') ? 'selected' : ''; ?>>Drama</option>
				<option value="Comédie" <?= ($genre === 'Comédie') ? 'selected' : ''; ?>>Comédie</option>
				<option value="Horreur" <?= ($genre === 'Horreur') ? 'selected' : ''; ?>>Horreur</option>
				<option value="Science-fiction" <?= ($genre === 'Science-fiction') ? 'selected' : ''; ?>>Science-fiction</option>
				<option value="Documentaire" <?= ($genre === 'Documentaire') ? 'selected' : ''; ?>>Documentaire</option>
				<option value="Animation" <?= ($genre === 'Animation') ? 'selected' : ''; ?>>Animation</option>
				<option value="Romance" <?= ($genre === 'Romance') ? 'selected' : ''; ?>>Romance</option>
				<option value="Thriller" <?= ($genre === 'Thriller') ? 'selected' : ''; ?>>Thriller</option>
				<option value="Aventure" <?= ($genre === 'Aventure') ? 'selected' : ''; ?>>Aventure</option>
				<option value="Fantastique" <?= ($genre === 'Fantastique') ? 'selected' : ''; ?>>Fantastique</option>
				<option value="Musical" <?= ($genre === 'Musical') ? 'selected' : ''; ?>>Musical</option>
				<option value="Biographie" <?= ($genre === 'Biographie') ? 'selected' : ''; ?>>Biographie</option>
				<option value="Guerre" <?= ($genre === 'Guerre') ? 'selected' : ''; ?>>Guerre</option>
				<option value="Policier" <?= ($genre === 'Policier') ? 'selected' : ''; ?>>Policier</option>
				<option value="Western" <?= ($genre === 'Western') ? 'selected' : ''; ?>>Western</option>
			</select>
		</label>
		<button type="submit" class="btn-search">Rechercher</button>
	</form>
</div>
<script src="<?= rtrim(BASE_URL, '/'); ?>/public/assets/js/util.js"></script>