<?php get_header(); ?>

<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>

        <main class="page-contenu">
            <article class="equipe">
                <!-- Affichage de l'image à la une de l'équipe -->
                <?php if (has_post_thumbnail()) : ?>
                    <div class="equipe-thumbnail">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <!-- Affichage du titre de l'équipe -->
                <h2 class="equipe-title"><?php the_title(); ?></h2>

                <!-- Affichage du contenu principal de l'équipe -->
                <div class="content">
                    <?php the_content(); ?>
                </div>

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

                <!-- Affichage des matchs de l'équipe -->
                <div class="team-matches">
                    <h3>Matchs de l'Équipe :</h3>
                    <ul>
                        <?php
                        // Récupération des matchs auxquels cette équipe participe
                        $args = array(
                            'post_type' => 'matchs', // Type de publication match
                            'meta_query' => array(
                                array(
                                    'key'     => 'team_a', // Vérifie si l'équipe est team_a
                                    'value'   => get_the_ID(), // L'ID de l'équipe courante
                                    'compare' => 'LIKE',
                                ),
                                array(
                                    'key'     => 'team_b', // Vérifie si l'équipe est team_b
                                    'value'   => get_the_ID(), // L'ID de l'équipe courante
                                    'compare' => 'LIKE',
                                ),
                            ),
                        );

                        $match_query = new WP_Query($args);

                        if ($match_query->have_posts()) :
                            while ($match_query->have_posts()) : $match_query->the_post();
                                echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
                            endwhile;
                        else :
                            echo '<li>Aucun match trouvé pour cette équipe.</li>';
                        endif;

                        wp_reset_postdata(); // Réinitialisation de la requête
                        ?>
                    </ul>
                </div>

                <!-- Affichage des statistiques de l'équipe -->
                <div class="team-stats">
                    <h3>Statistiques de l'Équipe :</h3>
                    <div class="stats-card">
                        <p>Victoires : <?php the_field('nombre_victoires'); ?></p>
                        <p>Défaites : <?php the_field('nombre_defaites'); ?></p>
                        <p>Kills totaux : <?php the_field('nombre_kills'); ?></p>
                    </div>
                </div>
            </article>
        </main>

    <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
