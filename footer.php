<?php
/**
 * The template for displaying the footer.
 *
 * Contains the body & html closing tags.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
	if ( hello_elementor_display_header_footer() ) {
		if ( did_action( 'elementor/loaded' ) && hello_header_footer_experiment_active() ) {
			get_template_part( 'template-parts/dynamic-footer' );
		} else {
			get_template_part( 'template-parts/footer' );
		}
	}
}
?>
<?php get_template_part( 'template-parts/contact-modal' ); ?>
<?php get_template_part('parts/photo-info'); ?>



<?php

if (isset($_GET['photo_id'])) {
    $photo_id = intval($_GET['photo_id']); // Sécurisation de l'ID

    // Récupération des infos de la photo
    $photo_post = get_post($photo_id);

    if ($photo_post) {
        $reference = get_field('reference_', $photo_id) ?: 'Non présent ';
        $categorie = get_field('categorie', $photo_id) ?: 'Non classé';
        $image = get_field('fichier', $photo_id);
    }
}
?>

<!-- Lightbox -->
<div id="lightbox-container" style="display: none;">
    <div class="lightbox-content">
        <button class="lightbox-close">&times;</button>
        <button class="lightbox-prev">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/asset/images/prev.png" alt="Précédent">
        </button>
        <img class="lightbox-image" src="<?php echo esc_url($image ?? ''); ?>" alt="Image de la lightbox">
        <div class="lightbox-info">
            <p>Référence : <span class="lightbox-reference"><?php echo esc_html($reference ?? 'Pas disponible '); ?></span></p>
            <p>Catégorie : <span class="lightbox-category"><?php echo esc_html($categorie ?? 'Non classé'); ?></span></p>
        </div>
        <button class="lightbox-next">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/asset/images/next.png" alt="Suivant">
        </button>
    </div>
</div>

<footer class="footer">
    <div class="footer-container">
        <ul class="footer-links">
            <li><a href="#mentions-legales">Mentions légales</a></li>
            <li><a href="#vie-privee">Vie privée</a></li>
            <li><a href="#tous-droits-reserves">Tous droits réservés</a></li>
        </ul>
    </div>

</footer>

<?php wp_footer(); ?>



</body>
</html>

