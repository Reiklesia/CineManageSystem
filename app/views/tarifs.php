<?php include __DIR__ . '/../includes/header.php'; ?>

<section class="tarifs">

    <header class="tarifs-header">
        <h2>Tarifs</h2>
    </header>

    <div class="tarifs-grid">

        <article class="ticket">
            <h3>Adulte</h3>
            <p class="ticket-price">14,50$</p>
            <p class="ticket-note">Valide tous les jours</p>
        </article>

        <article class="ticket">
            <h3>Étudiant</h3>
            <p class="ticket-price">12,50$</p>
            <p class="ticket-note">Avec carte étudiante</p>
        </article>

        <article class="ticket">
            <h3>Enfant</h3>
            <p class="ticket-price">9,50$</p>
            <p class="ticket-note">12 ans et moins</p>
        </article>

        <article class="ticket">
            <h3>Aîné</h3>
            <p class="ticket-price">11,50$</p>
            <p class="ticket-note">65 ans et +</p>
        </article>

    </div>

    <div class="tarifs-sections">

        <div class="tarifs-box">
            <h3>Suppléments</h3>
            <ul class="tarifs-list">
                <li><span>3D</span><strong>+ 3,00$</strong></li>
                <li><span>IMAX</span><strong>+ 5,00$</strong></li>
                <li><span>VIP (siège premium)</span><strong>+ 6,00$</strong></li>
                <li><span>Soirée première</span><strong>+ 2,00$</strong></li>
            </ul>
        </div>

        <div class="tarifs-box">
            <h3>Rabais & infos</h3>
            <ul class="tarifs-bullets">
                <li>Rabais étudiant : preuve requise à l’entrée.</li>
                <li>Tarif enfant : 12 ans et moins.</li>
                <li>Tarif aîné : 65 ans et plus.</li>
                <li>Les suppléments s’ajoutent au prix du billet.</li>
            </ul>
        </div>

    </div>

    <div class="tarifs-actions">
        <a class="btn-tarifs" href="index.php?action=list">Voir les films</a>
        <a class="btn-tarifs btn-outline" href="index.php?action=contact">Nous contacter</a>
    </div>

</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
