<?php include __DIR__ . '/../../includes/header.php' ?>

<div class="add-film-container">

	<form method="POST" action="index.php?action=add_film" enctype="multipart/form-data" class="add-film-form">

		<div class="form-left">
			<label>Titre du film
				<input type="text" name="titre"
					required minlength="1" maxlength="100"
					autocomplete="off"
					pattern="^[\p{L}\p{N}\s'\-:,.!?()]+$"
					title="Caractères autorisés: lettres, chiffres, espaces et ponctuation simple.">
			</label>

			<div class="two-cols">
				<label>Année de sortie
					<input type="number" name="annee_sortie"
						required min="1888" max="<?= date('Y') + 1 ?>"
						inputmode="numeric">
				</label>

				<label>Genre
					<select name="genre" required>
						<option value="" disabled selected>Genre...</option>
						<option value="Action">Action</option>
						<option value="Drama">Drama</option>
						<option value="Comédie">Comédie</option>
						<option value="Horreur">Horreur</option>
						<option value="Science-fiction">Science-fiction</option>
						<option value="Documentaire">Documentaire</option>
						<option value="Animation">Animation</option>
						<option value="Romance">Romance</option>
						<option value="Thriller">Thriller</option>
						<option value="Aventure">Aventure</option>
						<option value="Fantastique">Fantastique</option>
						<option value="Musical">Musical</option>
						<option value="Biographie">Biographie</option>
						<option value="Guerre">Guerre</option>
						<option value="Policier">Policier</option>
						<option value="Western">Western</option>
					</select>
				</label>

			</div>
			<label>Réalisateur
				<input type="text" name="realisateur" required>
			</label>

			<label>Synopsis
				<textarea name="description"
					required minlength="10" maxlength="2000"></textarea>
			</label>
		</div>

		<div class="form-right">
			<div class="image-preview"></div>

			<label class="file-label">Affiche du film
				<input type="file" name="affiche" accept="image/png,image/jpeg,image/webp">
			</label>
		</div>

		<button type="submit" name="add" class="btn-submit">Ajouter</button>

	</form>
</div>


<?php include __DIR__ . '/../../includes/footer.php' ?>