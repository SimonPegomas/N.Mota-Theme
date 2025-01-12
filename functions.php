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
?>





 
