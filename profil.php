<?php
/* Template Name: Profil */

get_header();

if (is_user_logged_in()) :
    $current_user = wp_get_current_user(); // Récupérer l'utilisateur connecté
    ?>

    <main class="page-contenu">
        <h1 class="page-title">Mon Profil</h1>

        <div class="profile-container">
            <div class="profile-info">
                <!-- Affichage de la photo de profil -->
                <div class="profile-photo">
                    <?php 
                    echo get_avatar($current_user->ID, 96); // Affiche l'avatar de l'utilisateur (taille 96px)
                    ?>
                    <a href="<?php echo esc_url(site_url('/edition-profil/')); ?>" class="btn">Modifier le Profil</a> <!-- Lien vers la page d'édition -->
                </div>

                <!-- Affichage des informations de l'utilisateur -->
                <div class="profile-details">
                    <p><strong>Nom :</strong> <?php echo esc_html($current_user->first_name . ' ' . $current_user->last_name); ?></p>
                    <p><strong>Identifiant :</strong> <?php echo esc_html($current_user->user_login); ?></p>
                    <p><strong>Email :</strong> <?php echo esc_html($current_user->user_email); ?></p>
                    <p><strong>Date d'inscription :</strong> <?php echo esc_html($current_user->user_registered); ?></p>
                </div>
            </div>
        </div>
    </main>

<?php else : ?>
    <p>Vous devez être connecté pour voir cette page.</p>
<?php endif; ?>

<?php get_footer(); ?>
