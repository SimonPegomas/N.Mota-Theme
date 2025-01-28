<?php
/**
 * The template for displaying the header
 *
 * This is the template that displays all of the <head> section, opens the <body> tag and adds the site's header.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$viewport_content = apply_filters( 'hello_elementor_viewport_content', 'width=device-width, initial-scale=1' );
$enable_skip_link = apply_filters( 'hello_elementor_enable_skip_link', true );
$skip_link_url = apply_filters( 'hello_elementor_skip_link_url', '#content' );
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="<?php echo esc_attr( $viewport_content ); ?>">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<header>
            <div class="container-logo">
				<div class="logo">
    				<a href="<?php echo esc_url(home_url('/')); ?>">
        			<img src="<?php echo get_stylesheet_directory_uri(); ?>/asset/images/logo.png" alt="Mota" title="Mota">
    				</a>
				</div>
    		</div>
            
            <div class="menu">
                <nav>
                    <ul>
                        <li><a href="home" class="menu-link"> Accueil </a></li> 
                        <li><a href="About" class="menu-link"> A propos </a></li>
						<li><a href="#" class="menu-link open-modal">Contact</a></li>

                    </ul>
                
                </nav>    
            </div>
        
            <!-- Menu Burger -->
<div id="burger-menu">
    <span></span>
    <span></span>
    <span></span>
</div>

<!-- Overlay pour le menu -->
		<div id="menu-overlay">
    		<ul>
        		<li><a href="home">Accueil</a></li>
        		<li><a href="About">À propos</a></li>
        		<li><a href="Contact">Contact</a></li>
    		</ul>
</div>

</header>
<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<?php if ( $enable_skip_link ) { ?>
<a class="skip-link screen-reader-text" href="<?php echo esc_url( $skip_link_url ); ?>"><?php echo esc_html__( 'Skip to content', 'hello-elementor' ); ?></a>
<?php } ?>

<?php
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {
	if ( hello_elementor_display_header_footer() ) {
		if ( did_action( 'elementor/loaded' ) && hello_header_footer_experiment_active() ) {
			get_template_part( 'template-parts/dynamic-header' );
		} else {
			get_template_part( 'template-parts/header' );
		}
	}
}
