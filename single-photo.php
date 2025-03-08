<?php
/**
 * Template Name: Galerie Photo Personnalisée
 */
get_header(); 
get_template_part('parts/hero'); 
?>

<main class="gallery-container">
    <?php 
    // Récupération des taxonomies (catégories et formats)
    $themes = get_terms(array(
        'taxonomy'   => 'categorie',
        'hide_empty' => true,
    ));
    $formats = get_terms(array(
        'taxonomy'   => 'format',
        'hide_empty' => true,
    ));
    $sort_options = array(
        array('value' => 'date_desc', 'label' => 'A partir des plus récentes'),
        array('value' => 'date_asc', 'label' => 'A partir des plus anciennes')
    );
    ?>

    <!-- Filtres de recherche -->
    <div class="search-filters">
        <div class="filter-group">
        <select name="theme" id="filter-theme" class="custom-select">
                <option value="">CATEGORIES</option>
                <?php foreach ($themes as $theme) : ?>
                    <option class="color-select" value="<?php echo esc_attr($theme->term_id); ?>">
                        <?php echo esc_html($theme->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <select name="format" id="filter-format">
                <option value="">FORMATS</option>
                <?php foreach ($formats as $format) : ?>
                    <option value="<?php echo esc_attr($format->term_id); ?>">
                        <?php echo esc_html($format->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <select name="sort" id="filter-sort">
            <option value="">TRIER PAR</option>
            <?php foreach ($sort_options as $sort) : ?>
                <option value="<?php echo esc_attr($sort['value']); ?>">
                    <?php echo esc_html($sort['label']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Affichage des photos -->
<div class="galerie-photo">
    <?php
    // Requête pour récupérer les photos
    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'post_status'    => 'publish',
        'paged'          => 1,
    );
    $photo_query = new WP_Query($args);
    if ($photo_query->have_posts()) {
        while ($photo_query->have_posts()) {
            $photo_query->the_post();
            $URLphoto  = get_field('fichier', get_the_ID());
            $alt_text  = get_the_title();
            $reference = get_field('reference', get_the_ID());
            $categories = get_the_terms(get_the_ID(), 'categorie');
            $categorie_nom = !empty($categories) ? esc_attr($categories[0]->name) : 'Non classé';
            ?>

            <div class="photo-item" 
                data-photo-id="<?php echo get_the_ID(); ?>" 
                data-title="<?php echo esc_attr(get_the_title()); ?>" 
                data-category="<?php echo $categorie_nom; ?>">
                
                <img src="<?php echo esc_url($URLphoto); ?>" alt="<?php echo esc_attr($alt_text); ?>">

                <!-- Conteneur des icônes qui apparaissent au hover -->
                <div class="photo-hover">
                    
                    <!-- Ajout des informations dynamiques de la photo -->
                    <div class="photo-info photo-info-left" data-photo-id="<?php echo get_the_ID(); ?>">
                        <?php echo esc_html(get_the_title()); ?>
                    </div>
                    <div class="photo-info photo-info-right" data-photo-id="<?php echo get_the_ID(); ?>">
                        <?php echo esc_html($categorie_nom); ?>
                    </div>

                    <a href="<?php echo get_permalink(get_page_by_path('info-photo')) . '?photo_id=' . get_the_ID(); ?>" class="photo-info-btn">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/asset/icons/eye-solid.png" alt="Voir les infos">
                    </a>
                    <a href="<?php echo esc_url($URLphoto); ?>" data-lightbox="galerie" class="photo-lightbox-btn">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/asset/icons/fullscreen.png" alt="Plein écran">
                    </a>

                </div> <!-- Fin de .photo-hover -->
            </div> <!-- Fin de .photo-item -->

            <?php
        }
    } else {
        echo '<p>Aucune photo.</p>';
    }
    wp_reset_postdata();
    ?>
</div>


    <div id="load-more-container">
        <button id="load-more">Charger plus</button>
       
    </div>
</main>

<?php get_footer(); ?>
