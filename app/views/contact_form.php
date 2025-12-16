<?php include __DIR__ . '/../includes/header.php'; ?>

<section class="contact-container">

    <div class="contact-header">
        <h2>Nous contacter</h2>
        <p>Une question, une suggestion ou un problème ? Écris-nous.</p>
    </div>

    <div class="contact-content">

        <div class="contact-info">
            <h3>Coordonnées</h3>

            <p><strong>Email :</strong><br> contact@cinegest.ca</p>
            <p><strong>Téléphone :</strong><br> +1 (555) 123-4567</p>
            <p><strong>Adresse :</strong><br> Sherbrooke, QC, Canada</p>
        </div>

        <form class="contact-form" method="POST">

            <label>
                Nom
                <input type="text" name="nom" placeholder="Votre nom">
            </label>

            <label>
                Courriel
                <input type="email" name="email" placeholder="exemple@email.com">
            </label>

            <label>
                Message
                <textarea name="message" rows="5" placeholder="Votre message..."></textarea>
            </label>

            <button type="submit" class="btn-contact">
                Envoyer le message
            </button>

        </form>

    </div>

</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
