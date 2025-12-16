<?php include __DIR__ . '/../../includes/header.php'; ?>

<div class="add-film-container">

	<form method="POST"
		action="index.php?action=edit_film&id=<?= (int)($film['id'] ?? 0); ?>"
		enctype="multipart/form-data"
		class="add-film-form">

		<div class="form-left">
			<label>Titre du film
				<input type="text"
					name="titre"
					value="<?= htmlspecialchars($film['titre'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
					required minlength="1" maxlength="100"
					autocomplete="off"
					pattern="^[\p{L}\p{N}\s'\-:,.!?()]+$"
					title="Caractères autorisés: lettres, chiffres, espaces et ponctuation simple.">
			</label>

			<div class="two-cols">
				<label>Année de sortie
					<input type="number"
						name="annee_sortie"
						value="<?= (int)($film['annee_sortie'] ?? 0); ?>"
						required min="1888" max="<?= (int)date('Y') + 1; ?>"
						inputmode="numeric">
				</label>

				<label for="genre">Genre
					<select id="genre" name="genre" required>
						<option value="" disabled>Genre...</option>
						<option value="Action" <?= (($film['genre'] ?? '') === 'Action') ? 'selected' : ''; ?>>Action</option>
						<option value="Drama" <?= (($film['genre'] ?? '') === 'Drama') ? 'selected' : ''; ?>>Drama</option>
						<option value="Comédie" <?= (($film['genre'] ?? '') === 'Comédie') ? 'selected' : ''; ?>>Comédie</option>
						<option value="Horreur" <?= (($film['genre'] ?? '') === 'Horreur') ? 'selected' : ''; ?>>Horreur</option>
						<option value="Science-fiction" <?= (($film['genre'] ?? '') === 'Science-fiction') ? 'selected' : ''; ?>>Science-fiction</option>
						<option value="Documentaire" <?= (($film['genre'] ?? '') === 'Documentaire') ? 'selected' : ''; ?>>Documentaire</option>
						<option value="Animation" <?= (($film['genre'] ?? '') === 'Animation') ? 'selected' : ''; ?>>Animation</option>
						<option value="Romance" <?= (($film['genre'] ?? '') === 'Romance') ? 'selected' : ''; ?>>Romance</option>
						<option value="Thriller" <?= (($film['genre'] ?? '') === 'Thriller') ? 'selected' : ''; ?>>Thriller</option>
						<option value="Aventure" <?= (($film['genre'] ?? '') === 'Aventure') ? 'selected' : ''; ?>>Aventure</option>
						<option value="Fantastique" <?= (($film['genre'] ?? '') === 'Fantastique') ? 'selected' : ''; ?>>Fantastique</option>
						<option value="Musical" <?= (($film['genre'] ?? '') === 'Musical') ? 'selected' : ''; ?>>Musical</option>
						<option value="Biographie" <?= (($film['genre'] ?? '') === 'Biographie') ? 'selected' : ''; ?>>Biographie</option>
						<option value="Guerre" <?= (($film['genre'] ?? '') === 'Guerre') ? 'selected' : ''; ?>>Guerre</option>
						<option value="Policier" <?= (($film['genre'] ?? '') === 'Policier') ? 'selected' : ''; ?>>Policier</option>
						<option value="Western" <?= (($film['genre'] ?? '') === 'Western') ? 'selected' : ''; ?>>Western</option>
					</select>
				</label>
			</div>

			<label for="realisateur">Réalisateur
				<input id="realisateur"
					type="text"
					name="realisateur"
					value="<?= htmlspecialchars($film['realisateur'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
					required minlength="1" maxlength="100"
					autocomplete="off"
					pattern="^[\p{L}\p{N}\s'\-:,.!?()]+$"
					title="Caractères autorisés: lettres, chiffres, espaces et ponctuation simple.">
			</label>

			<label for="description">Description
				<textarea id="description"
					name="description"
					required minlength="10" maxlength="2000"><?= htmlspecialchars($film['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
			</label>
		</div>

		<div class="form-right">
			<div class="image-preview">
				<?php
				$affiche = (string)($film['affiche'] ?? 'placeholder-gris.jpg');

				$base = rtrim(BASE_URL, '/');
				$prefix = (substr($base, -7) === '/public') ? $base : ($base . '/public');

				$srcAffiche = $prefix . '/assets/affiches/' . rawurlencode($affiche);
				?>
				<img
					id="previewAffiche"
					src="<?= htmlspecialchars($srcAffiche, ENT_QUOTES, 'UTF-8'); ?>"
					alt="Affiche du film <?= htmlspecialchars($film['titre'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">

			</div>


			<label class="file-label">Changer l'affiche du film
				<input type="file"
					id="inputAffiche"
					name="affiche"
					accept="image/png,image/jpeg,image/webp">
			</label>
		</div>

		<button type="submit" name="update" class="btn-submit">Enregistrer</button>

	</form>
</div>
<script src="<?= BASE_URL; ?>/public/assets/js/util.js"></script>
<?php include __DIR__ . '/../../includes/footer.php'; ?>