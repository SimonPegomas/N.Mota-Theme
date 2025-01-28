<?php
// Ajout du CSS pour le header et le footer
function mota_theme_enqueue_styles() {
    // Charger le CSS de base de WordPress (si ce n'est pas déjà fait)
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

    // Charger ton fichier CSS personnalisé pour le header et le footer
    wp_enqueue_style( 'header-footer-style', get_stylesheet_directory_uri() . '/header-footer.css' );
}

add_action( 'wp_enqueue_scripts', 'mota_theme_enqueue_styles' );
?>

<?php

function mota_enqueue_styles() {
    // Inclure le style principal du thème enfant
    wp_enqueue_style('mota-style', get_stylesheet_uri());

    // Inclure le CSS pour la modale
    wp_enqueue_style('mota-modal', get_stylesheet_directory_uri() . '/asset/css/modal.css', array(), '1.0', 'all');
}
add_action('wp_enqueue_scripts', 'mota_enqueue_styles');
// Fonction pour charger le JavaScript et CSS
function mota_theme_enqueue_assets() {
    // Charger le fichier JavaScript
    wp_enqueue_script(
        'mota-scripts', // Identifiant unique
        get_stylesheet_directory_uri() . '/asset/JS/scripts.js', // Chemin vers le fichier JS
        array('jquery'), // Dépendances (par exemple, jQuery)
        null, // Version (null pour désactiver la gestion de version)
        true // Charger dans le footer
    );
    
    // Charger le CSS (si besoin pour d'autres styles)
    wp_enqueue_style(
        'mota-styles', // Identifiant unique
        get_stylesheet_directory_uri() . '/header-footer.css', // Chemin vers le fichier CSS
        array(), // Pas de dépendance
        null // Pas de version spécifique
    );
}
add_action( 'wp_enqueue_scripts', 'mota_theme_enqueue_assets' );

function enqueue_photo_template_scripts() {
    wp_enqueue_script( 'photo-template-js', get_stylesheet_directory_uri() . '/js/photo-template.js', ['jquery'], null, true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_photo_template_scripts' );

//Load more 
function charger_scripts() {
    wp_enqueue_script('mon-script', get_template_directory_uri() . '/js/scripts.js', array('jquery'), null, true);

    wp_localize_script('mon-script', 'ajax_object', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'charger_scripts');

function load_more_photos() {
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $photos_per_page = 6; // Nombre de photos à charger à chaque clic

    $args = array(
        'post_type'      => 'photo', // Remplace par ton CPT si différent
        'posts_per_page' => $photos_per_page,
        'paged'          => $paged,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post(); ?>
            <div class="photo-item">
                <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>" alt="<?php the_title(); ?>">
            </div>
        <?php endwhile;
        wp_reset_postdata();
    endif;
    die();
}

add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');
