<?php
/* Template Name: Edition Profil */

get_header();

if (is_user_logged_in()) :
    $current_user = wp_get_current_user(); // Récupérer l'utilisateur connecté

    // Traitement du formulaire d'édition
    if (isset($_POST['update_profile'])) {
        $new_first_name = sanitize_text_field($_POST['first_name']);
        $new_last_name = sanitize_text_field($_POST['last_name']);
        $new_email = sanitize_email($_POST['email']);
        
        // Mise à jour de l'utilisateur
        wp_update_user(array(
            'ID' => $current_user->ID,
            'user_email' => $new_email,
            'first_name' => $new_first_name,
            'last_name' => $new_last_name
        ));

        // Mise à jour de la photo de profil (si l'utilisateur a téléchargé une nouvelle image)
        if (isset($_FILES['profile_picture']) && !empty($_FILES['profile_picture']['tmp_name'])) {
            $upload = wp_handle_upload($_FILES['profile_picture'], array('test_form' => false));

            if (isset($upload['file'])) {
                $attachment = array(
                    'post_mime_type' => $upload['type'],
                    'post_title' => sanitize_file_name($_FILES['profile_picture']['name']),
                    'post_content' => '',
                    'post_status' => 'inherit'
                );
                
                // Crée un fichier attaché à l'utilisateur
                $attachment_id = wp_insert_attachment($attachment, $upload['file']);
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                $attachment_data = wp_generate_attachment_metadata($attachment_id, $upload['file']);
                wp_update_attachment_metadata($attachment_id, $attachment_data);
                
                // Mise à jour de la photo de profil de l'utilisateur
                update_user_meta($current_user->ID, 'profile_picture', $attachment_id);
            }
        }

        // Redirection après l'enregistrement
        wp_redirect(get_permalink());
        exit;
    }
    ?>

    <main class="page-contenu">
        <h1 class="page-title">Modifier mon Profil</h1>

        <form method="POST" enctype="multipart/form-data" class="profile-edit-form">
            <div class="form-group">
                <label for="username">Identifiant</label>
                <!-- L'identifiant est affiché mais non modifiable -->
                <input type="text" name="username" value="<?php echo esc_attr($current_user->user_login); ?>" disabled>
                <p><small>Vous ne pouvez pas modifier votre identifiant.</small></p>
            </div>
            <div class="form-group">
                <label for="first_name">Prénom</label>
                <input type="text" name="first_name" value="<?php echo esc_attr($current_user->first_name); ?>" required>
            </div>
            <div class="form-group">
                <label for="last_name">Nom</label>
                <input type="text" name="last_name" value="<?php echo esc_attr($current_user->last_name); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" value="<?php echo esc_attr($current_user->user_email); ?>" required>
            </div>
            <div class="form-group">
                <label for="profile_picture">Photo de Profil</label>
                <input type="file" name="profile_picture">
            </div>
            <input type="submit" name="update_profile" value="Mettre à jour" class="btn">
        </form>
    </main>

<?php else : ?>
    <p>Vous devez être connecté pour éditer votre profil.</p>
<?php endif; ?>

<?php get_footer(); ?>
