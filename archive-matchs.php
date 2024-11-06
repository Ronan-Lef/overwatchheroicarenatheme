<?php get_header(); ?>

<main class="page-contenu">
    <h1 class="page-title">Tous les matchs</h1>

    <div class="match-list">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                ?>
                <article class="match-card">
                    <a href="<?php echo esc_url(get_permalink()); ?>">
                        
                        <!-- Utilisation du titre de la publication pour le nom du match -->
                        <h2 class="match-title"><?php the_title(); ?></h2>

                        <!-- Affiche le nom du tournoi -->
                        <h3 class="tournament-name">
                            <?php echo esc_html(get_field('nom_tournoi')); ?>
                        </h3>
                        
                        <div class="teams">
                            <?php
                            // Récupération des objets des équipes participantes à partir des champs ACF 'team_a' et 'team_b'
                            $team_a = get_field('team_a'); // Objet de l'équipe A
                            $team_b = get_field('team_b'); // Objet de l'équipe B
                           
                            // Vérification que les objets des équipes sont définis
                            if ($team_a && is_array($team_a) && isset($team_a[0])) {
                                $team_a_title = $team_a[0]->post_title; // Accède au titre de la première équipe dans le tableau
                            } else {
                                $team_a_title = 'Équipe non définie';
                            }

                            if ($team_b && is_array($team_b) && isset($team_b[0])) {
                                $team_b_title = $team_b[0]->post_title; // Accède au titre de la première équipe dans le tableau
                            } else {
                                $team_b_title = 'Équipe non définie';
                            }

                            // Affichage des noms des équipes
                            echo '<p class="team">';
                            echo esc_html($team_a_title) . ' vs ' . esc_html($team_b_title);
                            echo '</p>';
                            ?>
                        </div>
                        
                        <div class="match-info">
                            <!-- Affichage de la date et heure du match -->
                            <p class="match-date">
                                Date et Heure : <?php echo esc_html(get_field('date_heure_match')); ?>
                            </p>
                            
                            <!-- Affichage du type de match -->
                            <p class="match-type">
                                Type de Match : <?php echo esc_html(get_field('type_match')); ?>
                            </p>
                            
                            <!-- Affichage de la taxonomie de statut du match (A venir, En cours, Terminé) -->
                            <div class="match-status">
                                <?php
                                $terms = get_the_terms(get_the_ID(), 'status_match');
                                if ($terms && !is_wp_error($terms)) {
                                    foreach ($terms as $term) {
                                        echo '<span class="match-status">' . esc_html($term->name) . '</span>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </a>
                </article>
                <?php
            endwhile;
        else :
            echo '<p>Aucun match trouvé.</p>';
        endif;
        ?>
    </div>

    <?php
    // Affiche le bouton "Créer un nouveau match" uniquement si l'utilisateur est connecté
    if (is_user_logged_in()) : ?>
    <div class="button">
    <a href="<?php echo home_url('/creation-match'); ?>" class="button">Créer un nouveau match</a>
    </div>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
