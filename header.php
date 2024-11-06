<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header>
    <div class="logo">
        <a href="<?php echo home_url(); ?>">Overwatch Heroic Arena</a>
    </div>

    <!-- Menu burger -->
    <div class="burger-menu" onclick="toggleMenu()">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <!-- Menu overlay -->
    <nav class="menu">
        <?php
        // Afficher le menu principal
        wp_nav_menu(array(
            'theme_location' => 'main_menu',
            'container' => 'div',
            'menu_class' => 'menu-items',
            'container_class' => 'menu-items'
        ));
        ?>
    </nav>
</header>

<script>
    // Fonction pour ouvrir/fermer le menu overlay
    function toggleMenu() {
        const menu = document.querySelector('.menu');
        const burger = document.querySelector('.burger-menu');
        menu.classList.toggle('active');
        burger.classList.toggle('active');  // Change l'icône en croix
    }

    // Fermer le menu si on clique en dehors
    document.addEventListener('click', function (event) {
        const menu = document.querySelector('.menu');
        const burger = document.querySelector('.burger-menu');
        if (!menu.contains(event.target) && !burger.contains(event.target)) {
            menu.classList.remove('active');
            burger.classList.remove('active');
        }
    });
</script>
