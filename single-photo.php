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
        array('value' => 'date_desc', 'label' => 'Plus récentes'),
        array('value' => 'date_asc', 'label' => 'Plus anciennes')
    );
    ?>

    <!-- Filtres de recherche -->
    <div class="search-filters">
    <div class="filter-group">
        <!-- CATEGORIES -->
        <div class="custom-select">
            <div class="select-selected">CATEGORIES</div>
            <div class="select-options">
                <?php foreach ($themes as $theme) : ?>
                    <div class="select-option" data-value="<?php echo esc_attr($theme->term_id); ?>">
                        <?php echo esc_html($theme->name); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- FORMATS -->
        <div class="custom-select">
            <div class="select-selected">FORMATS</div>
            <div class="select-options">
                <?php foreach ($formats as $format) : ?>
                    <div class="select-option" data-value="<?php echo esc_attr($format->term_id); ?>">
                        <?php echo esc_html($format->name); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- TRIER PAR -->
    <div class="custom-select">
        <div class="select-selected">TRIER PAR</div>
        <div class="select-options">
            <?php foreach ($sort_options as $sort) : ?>
                <div class="select-option" data-value="<?php echo esc_attr($sort['value']); ?>">
                    <?php echo esc_html($sort['label']); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
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
                $categorie_nom = $categories ? $categories[0]->name : 'Non classé';
                ?>
                <?php
                echo '<div class="photo-item">';
                echo '<img src="' . esc_url($URLphoto) . '" alt="' . esc_attr($alt_text) . '">';
                
                // Conteneur des icônes qui apparaissent au hover
                echo '<div class="photo-hover">';
                
                // Ajout des informations dynamiques de la photo avec des balises PHP
                echo '<div class="photo-info photo-info-left" data-photo-id="' . get_the_ID() . '">' . get_the_title() . '</div>';
                echo '<div class="photo-info photo-info-right" data-photo-id="' . get_the_ID() . '">' . get_the_terms(get_the_ID(), 'categorie')[0]->name . '</div>';

                
                echo '<a href="' . get_permalink(get_page_by_path('info-photo')) . '?photo_id=' . get_the_ID() . '" class="photo-info-btn">';
                echo '<img src="' . get_stylesheet_directory_uri() . '/asset/icons/eye-solid.png" alt="Voir les infos">';
                echo '</a>';
                echo '<a href="' . esc_url($URLphoto) . '" data-lightbox="galerie" class="photo-lightbox-btn">';
                echo '<img src="' . get_stylesheet_directory_uri() . '/asset/icons/fullscreen.png" alt="Plein écran">';
                echo '</a>';
                
                echo '</div>'; // Fin de .photo-hover
                echo '</div>'; // Fin de .photo-item
                
                ?>
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
