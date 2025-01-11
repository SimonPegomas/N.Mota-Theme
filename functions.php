<?php

//* Enqueue style.css from child theme
function hello_elementor_child_enqueue_scripts() {
wp_enqueue_style(
'hello-elementor-child-style',
get_stylesheet_directory_uri() . '/style.css',
[
'hello-elementor-theme-style',
],
'1.0.0'
);
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts', 20 );

function afficher_image_custom() {
    ob_start();
    ?>
    <div class="container">
        <div class="BranchLeft">  
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/branchLeft.png" alt="BranchLeft" title="BranchLeft" />
        </div>
        <div class="BranchRight">  
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/branchRight.png" alt="BranchRight" title="BranchRight" />
        </div>
        <div class="Bottle">  
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/bottle.png" alt="Bottle" title="Bottle" />
        </div>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('mon_image_custom', 'afficher_image_custom');

function display_admin_link() {
    // Vérifie si l'utilisateur est connecté
    if ( is_user_logged_in() ) {
        // Affiche le lien "Admin" dans le menu
        echo '<li><a href="' . admin_url('index.php') . '">Admin</a></li>';
    }
}


// Fonction pour créer Short Code formulaire 
function custom_form_shortcode() {
    ob_start(); 
    
    ?>
    <form class="custom-form" action="send_mail.php" method="POST">
        <!-- Section produits avec images et quantités -->
        <div class="product-section">
            <div class="product-item">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/fraise.png" alt="Fraise">
                <input type="number" name="fraise" placeholder="0">
            </div>
            <div class="product-item">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/pamplemousse.png" alt="Pamplemousse">
                <input type="number" name="pamplemousse" placeholder="0">
            </div>
            <div class="product-item">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/framboise.png" alt="Framboise">
                <input type="number" name="framboise" placeholder="0">
            </div>
            <div class="product-item">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/citron.png" alt="Citron">
                <input type="number" name="citron" placeholder="0">
            </div>
        </div>

        <!-- Séparation par un trait -->
        <hr class="form-separator">

        <!-- Deux colonnes : informations et livraison -->
        <div class="two-columns">
            <div class="column-left">
                <h2>Vos informations</h2>
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" placeholder="Votre nom">
                
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" placeholder="Votre prénom">
                
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="Votre email">
            </div>

            <div class="column-right">
                <h2>Livraison</h2>
                <label for="adresse">Adresse de livraison</label>
                <input type="text" id="adresse" name="adresse" placeholder="Votre adresse">
                
                <label for="code-postal">Code postal</label>
                <input type="text" id="code-postal" name="code-postal" placeholder="Votre code postal">
                
                <label for="ville">Ville</label>
                <input type="text" id="ville" name="ville" placeholder="Votre ville">
            </div>
        </div>

        <!-- Bouton de soumission -->
        <div class="submit-section">
            <input type="submit" value="Commander">
        </div>
    </form>
    <?php

    return ob_get_clean(); 
}
add_shortcode('custom_form', 'custom_form_shortcode');

 
