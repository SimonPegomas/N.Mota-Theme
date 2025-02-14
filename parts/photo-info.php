<?php
/* Template Name: Info Photo */
get_header(); 

// Vérifie si un ID est passé en paramètre
if (isset($_GET['photo_id'])) {
    $photo_id = intval($_GET['photo_id']); // Sécurisation de l'ID

    // Récupération des infos de la photo
    $photo_post = get_post($photo_id);

    if ($photo_post) {
        ?>
        <div class="photo-info-container">
            <div class="photo-left">
                <h1><?php echo get_the_title($photo_id); ?></h1>
                <p>Référence : <?php the_field('reference', $photo_id); ?></p>
                <p>Catégorie : <?php the_field('categorie', $photo_id); ?></p>
                <p>Format : <?php the_field('format', $photo_id); ?></p>
                <p>Date : <?php echo get_the_date('', $photo_id); ?></p>
            </div>
            <div class="photo-right">
                <?php 
                $image = get_field('fichier', $photo_id);
                if ($image) {
                    echo wp_get_attachment_image($image, 'large');
                }
                ?>
            </div>
        </div>
        <?php
    } else {
        echo '<p>Photo non trouvée.</p>';
    }
} else {
    echo '<p>Aucune photo sélectionnée.</p>';
}

get_footer();
?>
