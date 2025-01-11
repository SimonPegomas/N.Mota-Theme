<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = "simonrumen@yahoo.fr"; // Destinataire de l'email planty.drinks@gmail.com
    $subject = "Nouvelle commande Planty";
    
    // Contenu de l'email
    $message = "Nouvelle commande reçue :\n\n";
    $message .= "Nom: " . $_POST['nom'] . "\n";
    $message .= "Prénom: " . $_POST['prenom'] . "\n";
    $message .= "Email: " . $_POST['email'] . "\n\n";
    $message .= "Adresse de livraison: " . $_POST['adresse'] . "\n";
    $message .= "Code postal: " . $_POST['code-postal'] . "\n";
    $message .= "Ville: " . $_POST['ville'] . "\n\n";
    $message .= "Produits commandés:\n";
    $message .= "Fraise: " . $_POST['fraise'] . "\n";
    $message .= "Pamplemousse: " . $_POST['pamplemousse'] . "\n";
    $message .= "Framboise: " . $_POST['framboise'] . "\n";
    $message .= "Citron: " . $_POST['citron'] . "\n";

    // Entêtes de l'email
    $headers = "From: " . $_POST['email'] . "\r\n";
    $headers .= "Reply-To: " . $_POST['email'] . "\r\n";

    // Envoi de l'email
    if (mail($to, $subject, $message, $headers)) {
        echo "Commande envoyée avec succès.";
    } else {
        echo "Erreur lors de l'envoi de la commande.";
    }
}
?>
