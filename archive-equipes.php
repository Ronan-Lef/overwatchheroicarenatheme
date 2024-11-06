<?php get_header(); ?>

<main class="page-contenu">
    <h1 class="page-title">Les Équipes</h1>
    
    <div class="grid">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                ?>
                <article class="card">
                    <a href="<?php echo esc_url(get_permalink()); ?>">
                        <div class="image">
                            <?php 
                            if (has_post_thumbnail()) {
                                the_post_thumbnail('medium');
                            } else {
                                // Affichage d'une image par défaut si aucune vignette n'est définie
                                // echo '<img src="' . get_template_directory_uri() . '/images/placeholder.jpg" alt="Pas de vignette">';
                            }
                            ?>
                        </div>
                        
                        <!-- Utilise le titre du post comme nom de l'équipe -->
                        <h2 class="title"><?php the_title(); ?></h2>

                        <!-- Affichage des noms des membres de l'équipe -->
                        <div class="team-members">
                            <?php
                            // Récupération des utilisateurs (membres de l'équipe) enregistrés dans les champs ACF
                            $joueurs = array(
                                get_field('joueur_1'), 
                                get_field('joueur_2'), 
                                get_field('joueur_3'), 
                                get_field('joueur_4'), 
                                get_field('joueur_5'), 
                                get_field('joueur_6')
                            );

                            // Filtrer les membres non définis et afficher leurs noms
                            $membres_affiches = array();
                            foreach ($joueurs as $joueur) {
                                if ($joueur) {
                                    $user = get_userdata($joueur); // Utilise l'ID du compte sélectionné
                                    if ($user) {
                                        $membres_affiches[] = esc_html($user->display_name); // Affiche le nom d'affichage du joueur
                                    }
                                }
                            }

                            // Afficher les noms des membres sous forme de texte
                            if (!empty($membres_affiches)) {
                                echo '<p class="team-members">' . implode(', ', $membres_affiches) . '</p>';
                            } else {
                                echo '<p class="team-members">Aucun membre</p>';
                            }
                            ?>
                        </div>

                        <!-- Brève description de l'équipe -->
                        <div class="description">
                            <?php echo wp_trim_words(get_the_content(), 20, '...'); ?>
                        </div>
                    </a>
                </article>
                <?php
            endwhile;
        else :
            echo '<p>Aucune équipe trouvée.</p>';
        endif;
        ?>
    </div>

    <?php
// Affiche le bouton "Créer une nouvelle équipe" uniquement si l'utilisateur est connecté
if (is_user_logged_in()) : ?>
    <div class="button">
        <a href="<?php echo home_url('/creation-equipe'); ?>" class="button">Créer une nouvelle équipe</a>
    </div>
<?php endif; ?>

</main>

<?php get_footer(); ?>
