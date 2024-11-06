<?php
/* Template Name: Page Contact */

get_header();

// Traitement du formulaire de contact
if (isset($_POST['submit_contact'])) {
    // Vérification de la sécurité (nonce)
    if (!isset($_POST['contact_nonce']) || !wp_verify_nonce($_POST['contact_nonce'], 'contact_nonce')) {
        die('Échec de la vérification de sécurité.');
    }

    // Récupérer et assainir les données du formulaire
    $name = sanitize_text_field($_POST['contact_name']);
    $email = sanitize_email($_POST['contact_email']);
    $message = sanitize_textarea_field($_POST['contact_message']);
    
    // Validation de l'email
    if (!is_email($email)) {
        $error = 'L\'email saisi n\'est pas valide.';
    } else {
        // Préparer le contenu de l'email
        $to = get_option('admin_email'); // Envoi à l'email administrateur
        $subject = 'Nouveau message de contact';
        $body = "Nom : $name\nEmail : $email\nMessage : \n$message";
        $headers = array('Content-Type: text/plain; charset=UTF-8');

        // Envoi de l'email
        if (wp_mail($to, $subject, $body, $headers)) {
            $success_message = 'Votre message a été envoyé avec succès !';
        } else {
            $error = 'Une erreur est survenue. Veuillez réessayer.';
        }
    }
}

?>

<main class="page-contact">
    <div class="page-contenu">
    <h1>Contactez-nous</h1>

    <?php if (isset($success_message)) : ?>
        <p class="success-message"><?php echo esc_html($success_message); ?></p>
    <?php elseif (isset($error)) : ?>
        <p class="error-message"><?php echo esc_html($error); ?></p>
    <?php endif; ?>

    <!-- Formulaire de contact -->
    <form action="" method="post" class="contact-form">
        <?php wp_nonce_field('contact_nonce', 'contact_nonce'); ?>

        <div class="form-group">
            <label for="contact_name">Nom :</label>
            <input type="text" id="contact_name" name="contact_name" value="<?php echo isset($_POST['contact_name']) ? esc_attr($_POST['contact_name']) : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="contact_email">Email :</label>
            <input type="email" id="contact_email" name="contact_email" value="<?php echo isset($_POST['contact_email']) ? esc_attr($_POST['contact_email']) : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="contact_message">Message :</label>
            <textarea id="contact_message" name="contact_message" rows="5" required><?php echo isset($_POST['contact_message']) ? esc_textarea($_POST['contact_message']) : ''; ?></textarea>
        </div>

        <!-- Champ de sécurité (Captcha ou autre) -->
        <div class="form-group">
            <label for="captcha">Vérification (Tapez "1234" pour prouver que vous êtes humain) :</label>
            <input type="text" id="captcha" name="captcha" required>
        </div>

        <!-- Bouton de soumission -->
        <div class="form-group">
            <input type="submit" name="submit_contact" value="Envoyer le message">
        </div>
    </form>
    </div>
</main>


<?php get_footer(); ?>
