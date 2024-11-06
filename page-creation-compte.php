<?php
/* Template Name: Création Compte */

// Gestion de la soumission du formulaire
if (isset($_POST['register_user'])) {
    $username = sanitize_text_field($_POST['username']);
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $email = sanitize_email($_POST['email']);
    $password = sanitize_text_field($_POST['password']);
    $confirm_password = sanitize_text_field($_POST['confirm_password']);
    $accept_conditions = isset($_POST['accept_conditions']) ? true : false; // Vérification si la case est cochée

    // Vérification si les mots de passe correspondent
    if ($password === $confirm_password) {
        if ($accept_conditions) {
            // Création de l'utilisateur
            $user_id = wp_create_user($username, $password, $email);

            if (!is_wp_error($user_id)) {
                // Mise à jour des informations de l'utilisateur (prénom, nom)
                wp_update_user(array(
                    'ID' => $user_id,
                    'first_name' => $first_name,
                    'last_name' => $last_name
                ));

                // Connexion automatique après inscription
                wp_set_current_user($user_id);
                wp_set_auth_cookie($user_id);

                // Redirection vers la page d'accueil après l'inscription
                wp_redirect(home_url());
                exit;
            } else {
                // En cas d'erreur lors de la création de l'utilisateur
                echo '<p class="error">Erreur lors de l\'inscription : ' . $user_id->get_error_message() . '</p>';
            }
        } else {
            // Si la case n'est pas cochée, afficher une erreur
            echo '<p class="error">Vous devez accepter les conditions d\'utilisation, les mentions légales et la politique des cookies.</p>';
        }
    } else {
        // Les mots de passe ne correspondent pas
        echo '<p class="error">Les mots de passe ne correspondent pas.</p>';
    }
}

get_header(); ?>

<main class="page-contenu">
    <div>
        <h1 class="page-title">Créer un compte</h1>
        <form method="post" action="" class="account-form-container">
            <label for="username">Identifiant <span class="required">*</span></label>
            <input type="text" name="username" placeholder="pauldupont" required>

            <label for="first_name">Prénom <span class="required">*</span></label>
            <input type="text" name="first_name" placeholder="Paul" required>

            <label for="last_name">Nom <span class="required">*</span></label>
            <input type="text" name="last_name" placeholder="Dupont" required>

            <label for="email">Adresse Email <span class="required">*</span></label>
            <input type="email" name="email" placeholder="paul.dupont@example.com" required>

            <label for="password">Mot de passe <span class="required">*</span></label>
            <input type="password" name="password" placeholder="Choisissez un mot de passe unique et complexe" required>

            <label for="confirm_password">Confirmez le mot de passe <span class="required">*</span></label>
            <input type="password" name="confirm_password" placeholder="Ré-écrivez votre mot de passe ici" required>

            <!-- Case à cocher pour accepter les conditions -->
            <div class="accept-terms">
                <label for="accept_conditions">
                    <input type="checkbox" name="accept_conditions" id="accept_conditions" required> 
                    J'accepte les <a href="<?php echo get_permalink(get_page_by_path('mentions-legales')); ?>" target="_blank">Mentions légales</a>, 
                    <a href="<?php echo get_permalink(get_page_by_path('politique-de-confidentialite')); ?>" target="_blank">Politique de confidentialité</a>, 
                    et <a href="<?php echo get_permalink(get_page_by_path('politique-des-cookies')); ?>" target="_blank">Politique des cookies</a>.
                </label>
            </div>

            <input type="submit" name="register_user" value="M'inscrire" class="btn btn-submit">
        </form>
    </div>
</main>

<?php get_footer(); ?>
