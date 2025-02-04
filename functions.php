<?php
// Charger les styles et scripts du thème
function mota_theme_enqueue_assets() {
    // Charger le CSS du thème parent et enfant
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('mota-style', get_stylesheet_uri());

    // Charger les styles spécifiques
    wp_enqueue_style('header-footer-style', get_stylesheet_directory_uri() . '/header-footer.css');
    wp_enqueue_style('mota-modal', get_stylesheet_directory_uri() . '/asset/css/modal.css', array(), '1.0', 'all');

    // Charger les scripts JS
    wp_enqueue_script('mota-scripts', get_stylesheet_directory_uri() . '/asset/JS/scripts.js', array('jquery'), null, true);
    wp_enqueue_script('photo-template-js', get_stylesheet_directory_uri() . '/js/photo-template.js', array('jquery'), null, true);

    // Ajouter les variables Ajax
    wp_localize_script('mota-scripts', 'ajax_object', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));
}
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
            echo '<img src="' . esc_url($URLphoto) . '" alt="' . esc_attr(get_the_title()) . '">';
        endwhile;
    else:
        echo '<p>Aucune photo trouvée.</p>';
    endif;

    wp_reset_postdata();
    echo ob_get_clean();
    die();
}

add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');


