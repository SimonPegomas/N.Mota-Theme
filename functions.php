<?php
// Charger les styles et scripts du thème
function mota_theme_enqueue_assets() {
    // Styles du thème parent et enfant
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('mota-style', get_stylesheet_uri());

    // Styles spécifiques
    wp_enqueue_style('header-footer-style', get_stylesheet_directory_uri() . '/header-footer.css');
    wp_enqueue_style('mota-modal', get_stylesheet_directory_uri() . '/asset/css/modal.css', array(), '1.0', 'all');
    wp_enqueue_style('photo-info-style', get_stylesheet_directory_uri() . '/asset/css/photo-info.css', array(), '1.0', 'all');
    wp_enqueue_style('lightbox-css', get_stylesheet_directory_uri() . '/asset/css/lightbox.css');

    // Scripts JS
    wp_enqueue_script('mota-scripts', get_stylesheet_directory_uri() . '/asset/js/scripts.js', array('jquery'), null, true);
    wp_enqueue_script('lightbox-js', get_stylesheet_directory_uri() . '/asset/js/lightbox.js', array('jquery'), '1.0', true);
    wp_enqueue_script('photo-info-script', get_stylesheet_directory_uri() . '/asset/js/photo-info.js', array('jquery'), '1.0', true);

    // Variables Ajax pour mota-scripts
    wp_localize_script('mota-scripts', 'ajax_object', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));
}

// Ajouter les styles et scripts au bon hook
add_action('wp_enqueue_scripts', 'mota_theme_enqueue_assets');

// Fonction pour charger dynamiquement les photos via Ajax
function filter_photos() {
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $theme = isset($_POST['theme']) && !empty($_POST['theme']) ? intval($_POST['theme']) : '';
    $format = isset($_POST['format']) && !empty($_POST['format']) ? intval($_POST['format']) : '';
    $sort = isset($_POST['sort']) ? sanitize_text_field($_POST['sort']) : 'date_desc';

    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'paged'          => $paged,
        'orderby'        => 'date',
        'order'          => ($sort === 'date_asc') ? 'ASC' : 'DESC',
        'post_status'    => 'publish',
    );

    $tax_query = array('relation' => 'AND');

    if (!empty($theme)) {
        $tax_query[] = array(
            'taxonomy' => 'categorie',
            'field'    => 'term_id',
            'terms'    => $theme,
        );
    }

    if (!empty($format)) {
        $tax_query[] = array(
            'taxonomy' => 'format',
            'field'    => 'term_id',
            'terms'    => $format,
        );
    }

    if (!empty($theme) || !empty($format)) {
        $args['tax_query'] = $tax_query;
    }

    $query = new WP_Query($args);

    ob_start();
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $URLphoto = get_field('fichier', get_the_ID());
            $categorie_nom = get_field('categorie', get_the_ID());
            $reference = get_field('reference_', get_the_ID());
            ?>
            <div class="photo-item">
                <img src="<?php echo esc_url($URLphoto); ?>" alt="<?php the_title(); ?>">

                <!-- Conteneur des icônes au hover -->
                <div class="photo-hover">
                    <!-- Icône "œil" -->
                    <a href="<?php echo get_permalink(get_page_by_path('info-photo')) . '?photo_id=' . get_the_ID(); ?>" class="photo-info-btn">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/asset/icons/eye-solid.png" alt="Voir les infos">
                    </a>

                    <!-- Icône "plein écran" lightbox -->
                    <a href="<?php echo esc_url($URLphoto); ?>" data-lightbox="galerie" data-photo-id="<?php echo get_the_ID(); ?>" class="photo-lightbox-btn">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/asset/icons/fullscreen.png" alt="Plein écran">
                    </a>
                </div>

                <!-- Informations sur la photo -->
                <div class="photo-info photo-info-left" data-photo-id="<?php echo get_the_ID(); ?>">
                    <?php echo esc_html(get_the_title()); ?>
                </div>
                <div class="photo-info photo-info-right" data-photo-id="<?php echo get_the_ID(); ?>">
                    <?php echo esc_html($categorie_nom); ?>
                </div>
            </div>
            <?php
        endwhile;
   
    endif;

    wp_reset_postdata();
    echo ob_get_clean();
    die();
}

// Récupération des détails d'une photo
function get_photo_details($photo_id) {
    if (!$photo_id) return null;

    $photo_post = get_post($photo_id);

    if (!$photo_post) return null;

    return [
        'id'        => $photo_id,
        'titre'     => get_the_title($photo_id),
        'reference' => get_field('reference_', $photo_id) ?: 'Non disponible',
        'categorie' => get_field('categorie', $photo_id) ?: 'Non classé',
        'format'    => get_field('format', $photo_id) ?: 'Inconnu',
        'date'      => get_field('annee', $photo_id) ?: 'Date inconnue',
        'image'     => get_field('fichier', $photo_id)
    ];
}

// Fonction Ajax pour récupérer les détails de la photo
function ajax_get_photo_details() {
    $photo_id = isset($_GET['photo_id']) ? intval($_GET['photo_id']) : 0;
    $photo_info = get_photo_details($photo_id);

    if ($photo_info) {
        wp_send_json($photo_info);
    } else {
        wp_send_json(['error' => 'Photo introuvable'], 404);
    }

    wp_die();
}

add_action('wp_ajax_get_photo_details', 'ajax_get_photo_details');
add_action('wp_ajax_nopriv_get_photo_details', 'ajax_get_photo_details');

add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');
