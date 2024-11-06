<?php
/* Template Name: Création Match */

// Vérification de la soumission du formulaire
if (isset($_POST['submit_match'])) {
    // Vérifier le nonce pour la sécurité
    if (!isset($_POST['create_match_nonce']) || !wp_verify_nonce($_POST['create_match_nonce'], 'create_match_nonce')) {
        die('Échec de la vérification de sécurité.');
    }

    // Récupérer les données du formulaire
    $nom_match = sanitize_text_field($_POST['nom_match']);
    $team_a = intval($_POST['team_a']); // ID de l'équipe A
    $team_b = intval($_POST['team_b']); // ID de l'équipe B
    $date_heure_match = sanitize_text_field($_POST['date_heure_match']);
    $type_match = sanitize_text_field($_POST['type_match']);
    $status_match = sanitize_text_field($_POST['status_match']); // Statut du match

    // Créer un nouveau post de type "match"
    $new_match = array(
        'post_title'    => $nom_match,
        'post_status'   => 'publish', // Publier immédiatement le match
        'post_type'     => 'match',   // Type de post "match"
    );

    $post_id = wp_insert_post($new_match);

    // Vérifier que le post a bien été créé
    if ($post_id) {
        // Ajouter les champs ACF pour les équipes, date/heure, type et statut du match
        update_field('team_a', $team_a, $post_id);
        update_field('team_b', $team_b, $post_id);
        update_field('date_heure_match', $date_heure_match, $post_id);
        update_field('type_match', $type_match, $post_id);

        // Ajouter le statut du match via le champ ACF 'statut_match' (bouton radio)
        update_field('statut_match', $status_match, $post_id);

        // Redirection après la création
        wp_redirect(get_permalink($post_id)); // Redirige vers la page du match créé
        exit;
    }
}

get_header();
?>

<!-- Formulaire pour créer un nouveau match -->
<main class="page-contenu">
    <h1>Créer un Match</h1>

    <form method="post" action="" class="form-creer-match">
        <?php wp_nonce_field('create_match_nonce', 'create_match_nonce'); ?>

        <!-- Nom du match -->
        <p>
            <label for="nom_match">Nom du match :</label>
            <input type="text" id="nom_match" name="nom_match" required>
        </p>

        <h3>Équipes Participantes</h3>

        <!-- Sélection des équipes A et B -->
        <div class="selection">
            <label for="team_a">Équipe A</label>
            <select id="team_a" name="team_a" required>
                <option value="">Sélectionner une équipe</option>
                <?php
                // Récupérer les équipes existantes via le CPT 'equipe'
                $teams_a = get_posts(array(
                    'post_type' => 'equipe', // Type de post "equipe"
                    'posts_per_page' => -1,  // Récupérer toutes les équipes
                    'post_status' => 'publish', // Seulement les équipes publiées
                    'orderby' => 'title',  // Tri par titre
                    'order' => 'ASC'  // Ordre alphabétique
                ));
                foreach ($teams_a as $team) {
                    // Vérifier si l'équipe est déjà sélectionnée
                    $selected = isset($_POST['team_a']) && $_POST['team_a'] == $team->ID ? 'selected' : '';
                    echo '<option value="' . esc_attr($team->ID) . '" ' . $selected . '>' . esc_html($team->post_title) . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="selection">
            <label for="team_b">Équipe B</label>
            <select id="team_b" name="team_b" required>
                <option value="">Sélectionner une équipe</option>
                <?php
                // Récupérer les équipes existantes via le CPT 'equipe'
                $teams_b = get_posts(array(
                    'post_type' => 'equipe', // Type de post "equipe"
                    'posts_per_page' => -1,  // Récupérer toutes les équipes
                    'post_status' => 'publish', // Seulement les équipes publiées
                    'orderby' => 'title',  // Tri par titre
                    'order' => 'ASC'  // Ordre alphabétique
                ));
                foreach ($teams_b as $team) {
                    // Vérifier si l'équipe est déjà sélectionnée
                    $selected = isset($_POST['team_b']) && $_POST['team_b'] == $team->ID ? 'selected' : '';
                    echo '<option value="' . esc_attr($team->ID) . '" ' . $selected . '>' . esc_html($team->post_title) . '</option>';
                }
                ?>
            </select>
        </div>

        <!-- Date et heure du match -->
        <p>
            <label for="date_heure_match">Date et Heure du match :</label>
            <input type="datetime-local" id="date_heure_match" name="date_heure_match" required>
        </p>

        <!-- Type de match -->
        <p>
            <label for="type_match">Type de Match :</label>
            <select id="type_match" name="type_match" required>
                <option value="">Sélectionner un type de match</option>
                <?php
                // Récupérer les choix de type de match depuis ACF
                if (function_exists('acf_get_field')) {
                    $type_field = acf_get_field('type_match');
                    if ($type_field && isset($type_field['choices'])) {
                        foreach ($type_field['choices'] as $value => $label) {
                            echo '<option value="' . esc_attr($value) . '">' . esc_html($label) . '</option>';
                        }
                    }
                }
                ?>
            </select>
        </p>

        <h3>Statut du Match</h3>
        <!-- Affichage des boutons radio pour le statut du match -->
        <p>
            <?php
            // Récupérer les choix du champ ACF 'statut_match' (bouton radio)
            if (function_exists('acf_get_field')) {
                $statut_field = acf_get_field('statut_match');
                if ($statut_field && isset($statut_field['choices'])) {
                    foreach ($statut_field['choices'] as $value => $label) {
                        echo '<label>';
                        echo '<input type="radio" name="status_match" value="' . esc_attr($value) . '" required ' . (isset($_POST['status_match']) && $_POST['status_match'] == $value ? 'checked' : '') . '>';
                        echo esc_html($label);
                        echo '</label><br>';
                    }
                }
            }
            ?>
        </p>

        <!-- Bouton de soumission -->
        <p>
            <input type="submit" class="btn-submit" name="submit_match" value="Soumettre le match">
        </p>
    </form>
</main>

<?php get_footer(); ?>
