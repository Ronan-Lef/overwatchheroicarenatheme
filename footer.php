<footer>
    <div class="footer-nav">
        <?php
        // Afficher le menu de navigation du footer
        wp_nav_menu(array(
            'theme_location' => 'footer_menu',
            'container' => false,
            'menu_class' => 'footer-menu',
            'items_wrap' => '%3$s',
            'walker' => new Custom_Nav_Walker(), // Utiliser notre walker personnalisé
        ));
        ?>
        <!-- Ajout des pages supplémentaires (Contact et pages de politique) -->
        <ul class="footer-extra-pages">
            <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a></li>
            <li><a href="<?php echo esc_url(home_url('/mentions-legales/')); ?>">Mentions légales</a></li>
            <li><a href="<?php echo esc_url(home_url('/politique-confidentialite/')); ?>">Politique de confidentialité</a></li>
            <li><a href="<?php echo esc_url(home_url('/politique-cookies/')); ?>">Politique des cookies</a></li>
        </ul>
    </div>
    
    <p>&copy; <?php echo date("Y"); ?> Overwatch Heroic Arena</p>
</footer>

<?php wp_footer(); ?>
</body>
</html>
