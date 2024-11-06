<?php
if ( have_posts() ) : 
    while ( have_posts() ) : the_post(); 
        ?>
        <article class="page-contenu">
            <div class="page-title">
                <h1><?php the_title(); ?></h1>  <!-- Affiche le titre de la page -->
</div>
            <div>
                <?php the_content(); ?>  <!-- Affiche le contenu de la page -->
            </div>
        </article>
        <?php
    endwhile; 
else : 
    echo '<p>Aucun contenu disponible.</p>';
endif;
?>
