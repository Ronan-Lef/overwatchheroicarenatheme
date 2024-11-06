<?php
// Charger le header
get_header();
?>

<div class="page-contenu">
<?php
// Catégories à afficher dans l'ordre souhaité
$categories = array(
    'introduction',  // Slug de la catégorie "Introduction"
    'matchs-a-venir', // Slug de la catégorie "Matchs à venir"
    'news'           // Slug de la catégorie "News"
);

// Boucle sur chaque catégorie dans l'ordre défini
foreach ($categories as $category_slug) {

    // Obtenir les détails de la catégorie à partir de son slug
    $category = get_category_by_slug($category_slug);

    // Vérifier si la catégorie existe
    if ($category) {

        // Arguments de la requête WP pour obtenir les posts dans cette catégorie
        $args = array(
            'post_type' => 'accueil',  // Type de post personnalisé "accueil"
            'posts_per_page' => -1,    // Récupérer tous les posts
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',  // Taxonomie par défaut pour les catégories
                    'field'    => 'term_id',
                    'terms'    => $category->term_id,  // ID de la catégorie actuelle
                ),
            ),
        );

        // Requête personnalisée WP_Query
        $query = new WP_Query($args);

        // Vérifier si la requête a des résultats
        if ($query->have_posts()) : ?>
           
            <ul class="article-content">
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <li class="article-card">
                        <h2 class="article-title"><?php the_title(); ?></h2>
                        <div class="post-content">
                            <?php the_content(); // Affiche le contenu complet du post ?>
                        </div>

                        <!-- Champs ACF (auteur et date) -->
                        <div class="post-meta">
                            <?php
                            // Récupérer l'ID de l'auteur depuis le champ ACF "auteur"
                            $auteur_id = get_field('auteur');
                            if ($auteur_id) {
                                // Utiliser get_userdata pour récupérer les informations de l'auteur
                                $auteur_info = get_userdata($auteur_id);
                                if ($auteur_info) {
                                    // Afficher le nom complet (display_name) de l'utilisateur
                                    echo '<p><strong>Auteur :</strong> ' . esc_html($auteur_info->display_name) . '</p>';
                                } else {
                                    echo '<p><strong>Auteur :</strong> Auteur non trouvé.</p>';
                                }
                            } else {
                                echo '<p><strong>Auteur :</strong> Aucun auteur sélectionné.</p>';
                            }
                            ?>
                            <p><strong>Date :</strong> <?php echo esc_html(get_field('date')); ?></p>
                        </div>

                    </li>
                    <hr class="article-separator"> <!-- Ligne séparatrice -->
                <?php endwhile; ?>
            </ul>
        <?php else : ?>
            <p>Aucun article trouvé dans la catégorie "<?php echo esc_html($category->name); ?>"</p>
        <?php endif;

        // Réinitialiser la requête pour éviter tout conflit
        wp_reset_postdata();
    }
}
?>
</div>

<?php
// Charger le footer
get_footer();
?>
