<?php get_header(); ?>

<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>

        <main class="page-contenu">
            <article class="match">

                <!-- Affichage de l'image à la une du match -->
                <?php if (has_post_thumbnail()) : ?>
                    <div class="match-thumbnail">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <!-- Affichage du titre du match -->
                <h2 class="match-title"><?php the_title(); ?></h2>

                <!-- Affichage du contenu principal du match -->
                <div class="content">
                    <?php the_content(); ?>
                </div>

                <!-- Affichage des informations des équipes -->
                <div class="match-teams">
                    <h3>Équipes participantes :</h3>
                    <div class="teams">
                        <?php
                        // Récupération des équipes à partir des champs ACF 'team_a' et 'team_b'
                        $team_a = get_field('team_a');
                        $team_b = get_field('team_b');
                        
                        // Vérification que les équipes sont définies
                        if ($team_a && is_array($team_a) && isset($team_a[0])) {
                            $team_a_title = $team_a[0]->post_title; // Titre de l'équipe A
                        } else {
                            $team_a_title = 'Équipe non définie';
                        }

                        if ($team_b && is_array($team_b) && isset($team_b[0])) {
                            $team_b_title = $team_b[0]->post_title; // Titre de l'équipe B
                        } else {
                            $team_b_title = 'Équipe non définie';
                        }

                        // Affichage des noms des équipes
                        echo '<p class="team">' . esc_html($team_a_title) . ' vs ' . esc_html($team_b_title) . '</p>';
                        ?>
                    </div>
                </div>

                <!-- Affichage de la date et heure du match -->
                <div class="match-date-time">
                    <h3>Date et Heure du match :</h3>
                    <p><?php echo esc_html(get_field('date_heure_match')); ?></p>
                </div>

                <!-- Affichage du type de match -->
                <div class="match-type">
                    <h3>Type de Match :</h3>
                    <p><?php echo esc_html(get_field('type_match')); ?></p>
                </div>

                <!-- Affichage des informations sur les résultats (si disponibles) -->
                <div class="match-results">
                    <h3>Résultats :</h3>
                    <p><strong>Score :</strong> <?php echo esc_html(get_field('score_match')); ?></p>
                    <p><strong>Vainqueur :</strong> <?php echo esc_html(get_field('vainqueur_match')); ?></p>
                </div>

                <!-- Affichage du statut du match (champ ACF 'statut_match') -->
                <div class="match-status">
                    <h3>Statut du Match :</h3>
                    <?php
                    // Récupérer la valeur du champ ACF 'statut_match' (bouton radio)
                    $statut_match = get_field('statut_match');

                    if ($statut_match) {
                        // Afficher la valeur du statut du match
                        echo '<p>' . esc_html($statut_match) . '</p>';
                    } else {
                        // Si aucun statut n'est défini, afficher un message par défaut
                        echo '<p>Statut non défini.</p>';
                    }
                    ?>
                </div>

            </article>
        </main>

    <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
