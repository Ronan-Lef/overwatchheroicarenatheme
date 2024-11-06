<?php
// Enregistrer le menu principal
function owha_register_menus() {
    register_nav_menus(array(
        'main_menu' => 'Menu Principal'
    ));
}
add_action('init', 'owha_register_menus');

// Charger les styles et scripts
function owha_enqueue_styles_scripts() {
    wp_enqueue_style('main-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'owha_enqueue_styles_scripts');
?>

<?php
// Vérification si l'utilisateur est connecté
function custom_menu_items($items, $args) {
    // Vérification si l'utilisateur est connecté
    if (is_user_logged_in()) {
        // L'utilisateur est connecté, on affiche "Déconnexion"
        $logout_url = wp_logout_url(home_url()); // Lien pour déconnexion
        // Vérifier si c'est le menu principal (header)
        if ($args->theme_location == 'main_menu') {
            $items .= '<li class="menu-item"><a href="' . $logout_url . '">Déconnexion</a></li>';
        }
    } else {
        // L'utilisateur n'est pas connecté, on affiche "Connexion" et "Inscription"
        $login_url = home_url('/connexion/');  // Remplace par l'URL de ta page de connexion
        $register_url = home_url('/inscription/');  // Remplace par l'URL de ta page de création de compte
        // Vérifier si c'est le menu principal (header)
        if ($args->theme_location == 'main_menu') {
            $items .= '<li class="menu-item"><a href="' . $login_url . '">Connexion</a></li>';
            $items .= '<li class="menu-item"><a href="' . $register_url . '">Inscription</a></li>';
        }
    }
    
    return $items;
}
add_filter('wp_nav_menu_items', 'custom_menu_items', 10, 2);

// Enregistrer le menu du footer
function register_my_menus() {
    register_nav_menus(
        array(
            'footer_menu' => __('Footer Menu'), // Le menu pour le footer
        )
    );
}
add_action('after_setup_theme', 'register_my_menus');

class Custom_Nav_Walker extends Walker_Nav_Menu {
    // Ajouter des classes personnalisées et des icônes dans chaque élément de menu
    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        // Obtenir l'URL de chaque élément
        $url = $item->url;
        $title = $item->title;

        // Ajouter une icône SVG à chaque item de menu
        $icon = ''; // Default (pas d'icône par défaut)

        // Exemple pour l'élément "Accueil"
        if ($title === 'Matchs') {
            $icon = '<img src="' . get_template_directory_uri() . '/images/icon-matchs.svg" alt="Matchs" />';
        } 
        if ($title === 'Équipes') {
            $icon = '<img src="' . get_template_directory_uri() . '/images/icon-equipes.svg" alt="Équipes" />';
        } 
        if ($title === 'Création') {
            $icon = '<img src="' . get_template_directory_uri() . '/images/icon-creation.svg" alt="Création" />';
        } 

        // Créer l'élément de menu avec l'icône et le lien
        $output .= '<li class="menu-item"><a href="' . $url . '">' . $icon .'</a></li>';
    }
}

?>
