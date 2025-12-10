
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-brand">
            Ciné<span>Manage</span>
        </div>

        <div class="footer-links">
            <?php if (!isset($_SESSION['login'])): ?>
                <a href="index.php?action=contact">Nous contacter</a>
                <a href="index.php?action=afficherFormInfolettre">S’inscrire à l’infolettre</a>
                <?php else: ?>
                <a href="index.php?action=list">Retourner à l'accueil</a>
            <?php endif; ?>
            <?php if (!isset($_SESSION['login']) && (!isset($_GET['action']) || $_GET['action'] !== 'connexion')): ?>
                <a href="index.php?action=connexion">Se connecter</a>
            <?php endif; ?>
        </div>

        <div class="footer-social">
            <a href="#" class="social-icon"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" class="social-icon"><i class="fa-brands fa-instagram"></i></a>
            <a href="#" class="social-icon"><i class="fa-brands fa-x-twitter"></i></a>
        </div>

        <p class="footer-copy">
            © <?php echo date('Y'); ?> CinéGest Inc. Tous droits réservés.
        </p>
    </div>
</footer>
</body>
</html>
