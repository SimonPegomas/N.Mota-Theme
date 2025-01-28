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

