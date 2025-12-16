<?php
include __DIR__ . '/../includes/header.php';
?>
<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
/>
<section class="film-page">
  <div class="film-layout">

    <div class="film-poster">
      <img
        src="<?php echo htmlspecialchars($film['affiche']); ?>"
        alt="Affiche de <?php echo htmlspecialchars($film['titre']); ?>"
      >
    </div>

    <div class="film-info">
      <h1 class="film-title">
        <?php echo htmlspecialchars($film['titre']); ?>
      </h1>

      <div class="film-meta">
        <span><?php echo htmlspecialchars($film['annee_sortie']); ?></span>
        <span class="dot">•</span>
        <span><?php echo htmlspecialchars($film['genre']); ?></span>
      </div>

      <p class="film-description">
        <?php echo htmlspecialchars($film['description']); ?>
      </p>
      <a
        href="https://www.youtube.com"
        target="_blank"
        class="trailer-btn"
        >
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
          <?php echo htmlspecialchars($film['realisateur']); ?>
        </p>
      </div>
    </div>

  </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
