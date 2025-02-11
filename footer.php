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



<footer class="footer">
    <div class="footer-container">
        <ul class="footer-links">
            <li><a href="#mentions-legales">Mentions légales</a></li>
            <li><a href="#vie-privee">Vie privée</a></li>
            <li><a href="#tous-droits-reserves">Tous droits réservés</a></li>
        </ul>
    </div>

</footer>
<!-- Lightbox -->
<div id="lightbox-container" style="display: none;">
  <div class="lightbox-content">
    <button class="lightbox-close">&times;</button>
    <button class="lightbox-prev">
      <img src="<?php echo get_stylesheet_directory_uri(); ?>/asset/images/prev.png" alt="Précédent">
    </button>
    <img class="lightbox-image" src="" alt="">
    <button class="lightbox-next">
      <img src="<?php echo get_stylesheet_directory_uri(); ?>/asset/images/next.png" alt="Suivant">
    </button>
    <div class="lightbox-caption">
      <div class="lightbox-reference"></div>
      <div class="lightbox-category"></div>
    </div>
  </div>
</div>


<?php wp_footer(); ?>



</body>
</html>

