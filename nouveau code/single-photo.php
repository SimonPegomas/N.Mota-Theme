<?php
/**
 * Template Name: Galerie Photo Personnalisée
 */
get_header(); // Inclure le header WordPress
?>

<main class="gallery-container">
    <?php 
    // Récupération des options ACF 
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
            <!-- Filtre par Thème -->
            <select name="theme" id="filter-theme">
                <option value="">Thème</option>
                <?php if ($themes) : 
                    foreach ($themes as $theme) : ?>
                        <option value="<?php echo esc_attr($theme->term_id); ?>">
                            <?php echo esc_html($theme->name); ?>
                        </option>
                    <?php endforeach; 
                endif; ?>
            </select>

            <!-- Filtre par Format -->
            <select name="format" id="filter-format">
                <option value="">Format</option>
                <?php if ($formats) : 
                    foreach ($formats as $format) : ?>
                        <option value="<?php echo esc_attr($format->term_id); ?>">
                            <?php echo esc_html($format->name); ?>
                        </option>
                    <?php endforeach; 
                endif; ?>
            </select>
        </div>

        <!-- Filtre Trier par -->
        <select name="sort" id="filter-sort">
            <option value="">Trier par</option>
            <?php if ($sort_options) : 
                foreach ($sort_options as $sort) : ?>
                    <option value="<?php echo esc_attr($sort['value']); ?>">
                        <?php echo esc_html($sort['label']); ?>
                    </option>
                <?php endforeach; 
            endif; ?>
        </select>
    </div>

    <!-- Affichage des photos -->
    <div class="galerie-photo">
        <?php
        // Requête par défaut pour récupérer les 8 premières photos
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
                $URLphoto = get_field('fichier', get_the_ID());
                $alt_text = get_the_title(); // Utilisation du titre comme alt si pas défini autrement
                echo '<img src="' . esc_url($URLphoto) . '" alt="' . esc_attr($alt_text) . '">';
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
<?php get_footer(); // Inclure le footer WordPress ?>
