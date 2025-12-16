<?php include __DIR__ . '/../includes/header.php'; ?>

<section class="newsletter">

    <header class="newsletter-header">
        <h2>S’inscrire à l’infolettre</h2>
        <p>Reçois les nouveautés, sorties à l’affiche et promotions directement par courriel.</p>
    </header>

    <div class="newsletter-card">

        <form class="newsletter-form" method="POST">
            <label>
                Courriel
                <input type="email" name="email" placeholder="exemple@email.com" required>
            </label>

            <label class="checkbox-row">
                <input type="checkbox" name="consent" required>
                <span>J’accepte de recevoir l’infolettre</span>
            </label>

            <button type="submit" class="btn-newsletter">S’inscrire</button>

            <p class="newsletter-note">
                Vous pouvez vous désinscrire à tout moment
            </p>
        </form>

    </div>

</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
