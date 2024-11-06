<?php
/* Template Name: Création Équipe */

if (isset($_POST['submit_equipe'])) {
    // Vérifier le nonce pour la sécurité
    if (!isset($_POST['create_equipe_nonce']) || !wp_verify_nonce($_POST['create_equipe_nonce'], 'create_equipe_nonce')) {
        die('Échec de la vérification de sécurité.');
    }

    // Récupérer les données du formulaire
    $nom_equipe = sanitize_text_field($_POST['nom_equipe']);
    $joueur_1 = sanitize_text_field($_POST['joueur_1']);
    $joueur_2 = sanitize_text_field($_POST['joueur_2']);
    $joueur_3 = sanitize_text_field($_POST['joueur_3']);
    $joueur_4 = sanitize_text_field($_POST['joueur_4']);
    $joueur_5 = sanitize_text_field($_POST['joueur_5']);
    $joueur_6 = sanitize_text_field($_POST['joueur_6']);

    // Créer un nouveau post de type "équipe"
    $new_equipe = array(
        'post_title'    => $nom_equipe,
        'post_status'   => 'pending', // En attente de validation par un administrateur
        'post_type'     => 'equipe',  // Utilise le type de post 'equipe'
    );

    $post_id = wp_insert_post($new_equipe);

    // Vérifier que le post a bien été créé
    if ($post_id) {
        // Ajouter les champs ACF pour les membres de l'équipe
        update_field('joueur_1', $joueur_1, $post_id);
        update_field('joueur_2', $joueur_2, $post_id);
        update_field('joueur_3', $joueur_3, $post_id);
        update_field('joueur_4', $joueur_4, $post_id);
        update_field('joueur_5', $joueur_5, $post_id);
        update_field('joueur_6', $joueur_6, $post_id);

        // Redirection après soumission
        wp_redirect(get_permalink($post_id)); // Redirige vers la page de l'équipe une fois soumise
        exit;
    }
}

get_header();
?>

<!-- Formulaire pour créer une nouvelle équipe -->
<main class="page-contenu">
    <h1>Créer une Équipe</h1>

    <form method="post" action="" class="form-creer-equipe">
        <?php wp_nonce_field('create_equipe_nonce', 'create_equipe_nonce'); ?>

        <!-- Nom de l'équipe -->
        <p>
            <label for="nom_equipe">Nom de l'équipe :</label>
            <input type="text" id="nom_equipe" name="nom_equipe" required>
        </p>

        <h3>Membres de l'Équipe</h3>

        <!-- Sélection des membres de l'équipe -->
        <div class="selection">
            <label for="joueur_1">Joueur 1</label>
            <select id="joueur_1" name="joueur_1" required>
                <option value="">Sélectionner un joueur</option>
                <?php
$users = get_users(array('role' => 'joueur')); // Récupère uniquement les utilisateurs ayant le rôle "joueur"
foreach ($users as $user) {
    echo '<option value="' . esc_attr($user->ID) . '">' . esc_html($user->display_name) . '</option>';
}
?>
            </select>
        </div>

        <div class="selection">
            <label for="joueur_2">Joueur 2</label>
            <select id="joueur_2" name="joueur_2" required>
                <option value="">Sélectionner un joueur</option>
                <?php
                foreach ($users as $user) {
                    echo '<option value="' . esc_attr($user->ID) . '">' . esc_html($user->display_name) . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="selection">
            <label for="joueur_3">Joueur 3</label>
            <select id="joueur_3" name="joueur_3" required>
                <option value="">Sélectionner un joueur</option>
                <?php
                foreach ($users as $user) {
                    echo '<option value="' . esc_attr($user->ID) . '">' . esc_html($user->display_name) . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="selection">
            <label for="joueur_4">Joueur 4</label>
            <select id="joueur_4" name="joueur_4" required>
                <option value="">Sélectionner un joueur</option>
                <?php
                foreach ($users as $user) {
                    echo '<option value="' . esc_attr($user->ID) . '">' . esc_html($user->display_name) . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="selection">
            <label for="joueur_5">Joueur 5</label>
            <select id="joueur_5" name="joueur_5" required>
                <option value="">Sélectionner un joueur</option>
                <?php
                foreach ($users as $user) {
                    echo '<option value="' . esc_attr($user->ID) . '">' . esc_html($user->display_name) . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="selection">
            <label for="joueur_6">Joueur 6</label>
            <select id="joueur_6" name="joueur_6" required>
                <option value="">Sélectionner un joueur</option>
                <?php
                foreach ($users as $user) {
                    echo '<option value="' . esc_attr($user->ID) . '">' . esc_html($user->display_name) . '</option>';
                }
                ?>
            </select>
        </div>

        <!-- Bouton de soumission -->
        <p>
            <input type="submit" class="btn-submit" name="submit_equipe" value="Soumettre l'équipe">
        </p>
    </form>
</main>

<?php get_footer(); ?>
