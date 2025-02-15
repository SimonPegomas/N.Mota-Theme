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
                    <div class="photo-separator"></div>
                    
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

        <section>
            <div class="photo-inquiry">
                    <p>Cette photo vous intéresse ?</p>
                    <button class="contact-button open-contact-modal" data-photo-ref="<?php echo esc_attr($reference); ?>">Contact</button>
            </div> 
        </section>        
        
        <?php
    } else {
        echo '<p>Photo non trouvée.</p>';
    }
} else {
    echo '<p>Aucune photo sélectionnée.</p>';
}

get_footer();
?>
