jQuery(document).ready(function ($) {
    // Gestion de l'ouverture de la popup de contact
    $('#contact-btn').on('click', function () {
        // Récupérer la référence photo depuis un champ PHP
        const ref = "<?php the_field('reference'); ?>";
        // Insérer la référence dans le champ de formulaire
        $('#ref').val(ref);
        // Afficher la popup
        $('#contact-popup').fadeIn();
    });

    // Gestion de la fermeture de la popup (optionnelle)
    $('#contact-popup').on('click', function (event) {
        if ($(event.target).is('#contact-popup')) {
            $(this).fadeOut();
        }
    });

    // Soumission du formulaire de contact
    $('#contact-form').on('submit', function (event) {
        event.preventDefault(); // Empêcher l'envoi classique du formulaire
        alert('Formulaire envoyé avec la référence : ' + $('#ref').val());
        $('#contact-popup').fadeOut(); // Fermer la popup après soumission
    });
});
