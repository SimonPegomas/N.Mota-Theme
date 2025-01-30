<?php
// Requête pour récupérer les 8 premières photos
$args = array(
    'post_type'      => 'photo',
    'posts_per_page' => 8,
    'post_status'    => 'publish',
);

$photo_query = new WP_Query($args);
$images = [];

if ($photo_query->have_posts()) {
    while ($photo_query->have_posts()) {
        $photo_query->the_post();
        
        // Récupération du champ ACF "fichier"
        $URLphoto = get_field('fichier', get_the_ID());
        
        // Vérification si l'URL existe avant de l'ajouter au tableau
        if ($URLphoto) {
            $images[] = $URLphoto;
        }
    }
    wp_reset_postdata();
}

// Sélection d'une image aleatoire 
$random_image = !empty($images) ? $images[array_rand($images)] : '';
?>

<?php if ($random_image) : ?>
    <div class="hero" style="background-image: url('<?php echo esc_url($random_image); ?>');">
        <h1>PHOTOGRAPHE EVENT </h1>
    </div>
<?php else : ?>
    <div class="hero" style="background-color: grey;">
        <h1>Aucune image disponible</h1>
    </div>
<?php endif; ?>

