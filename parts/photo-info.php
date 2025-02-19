<?php
/* Template Name: Info Photo */
get_header(); 

// Ajout d'une classe au body pour masquer le hero
add_filter('body_class', function($classes) {
    $classes[] = 'photo-info-page';
    return $classes;
});

// Vérifie si un ID est passé en paramètre
if (isset($_GET['photo_id'])) {
    $photo_id = intval($_GET['photo_id']); // Sécurisation de l'ID

    // Récupération des infos de la photo
    $photo_post = get_post($photo_id);

    if ($photo_post) {
        $titre = get_the_title($photo_id);
        $reference = get_field('reference_', $photo_id) ?: 'Non disponible';
        $categorie = get_field('categorie', $photo_id) ?: 'Non classé';
        $format = get_field('format', $photo_id) ?: 'Inconnu';
        $date = get_field('annee', $photo_id) ?: 'Date inconnue';
        $image = get_field('fichier', $photo_id);
        ?>
        
      <section>  
        <div class="photo-info-container">
            <div class="photo-left">
                <h1><?php echo esc_html($titre); ?></h1>
                <p>Référence : <?php echo esc_html($reference); ?></p>
                <p>Catégorie : <?php echo esc_html($categorie); ?></p>
                <p>Format : <?php echo esc_html($format); ?></p>
                <p>Date : <?php echo esc_html($date); ?></p>
                
                
            </div>
            <div class="photo-right">
                <?php 
                if ($image) {
                    echo '<img src="' . esc_url($image) . '" alt="' . esc_attr($titre) . '">';
                } else {
                    echo '<p>Aucune image disponible.</p>';
                }
                ?>
            </div>
            
        </div>
      </section>

      <div class="photo-separator"></div>

      <section>
                <div class="interest-container">
                    <div class="interest-contact">
                        <div class="photo-inquiry">
                            <p>Cette photo vous intéresse ?</p>
                            <button class="contact-button open-contact-modal" data-photo-ref="<?php echo esc_attr($reference); ?>">Contact</button>
                        </div>
                    </div>    
                </div> 
      </section>
      
      <section>
        <div class="photo-separator"></div>
        <div class="photo-suggestions">
            <h2>Vous aimerez aussi</h2>
            <div class="galerie-photo">
    <?php
    // Requête pour récupérer les photos
    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => 2,
        'post_status'    => 'publish',
        'paged'          => 1, 
    );
    $photo_query = new WP_Query($args);
    if ($photo_query->have_posts()) {
        while ($photo_query->have_posts()) {
            $photo_query->the_post();
            $URLphoto  = get_field('fichier', get_the_ID());
            $alt_text  = get_the_title();
            // Récupérer la référence et la catégorie depuis ACF (vérifiez bien les noms des champs)
            $reference = get_field('reference', get_the_ID());
            $categorie = get_field('categorie', get_the_ID());
            
            echo '<div class="photo-item">';
        echo '<img src="' . esc_url($URLphoto) . '" alt="' . esc_attr($alt_text) . '">';

    // Conteneur des icônes qui apparaissent au hover
        echo '<div class="photo-hover">';

    // Icône "oeil" pour afficher les infos
        echo '<a href="' . get_permalink(get_page_by_path('info-photo')) . '?photo_id=' . get_the_ID() . '" class="photo-info-btn">';
        echo '<img src="' . get_stylesheet_directory_uri() . '/asset/icons/eye-solid.svg" alt="Voir les infos">';
        echo '</a>';


    // Icône "plein écran" pour la lightbox
        echo '<a href="' . esc_url($URLphoto) . '" data-lightbox="galerie" class="photo-lightbox-btn">';
            echo '<img src="' . get_stylesheet_directory_uri() . '/asset/icons/fullscreen.svg" alt="Plein écran">';
        echo '</a>';

        echo '</div>'; // Fin de .photo-hover
        echo '</div>'; // Fin de .photo-item

        }
    } else {
        echo '<p>Aucune photo.</p>';
    }
    wp_reset_postdata();
    ?>
</div>
      </section>  
        <?php
    } else {
        echo '<p>Photo non trouvée.</p>';
    }
} else {
    echo '<p></p>';
}

get_footer();
?>
