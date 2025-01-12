
// 1. Menu Burger 
console.log("Le fichier JavaScript est bien chargé !");

document.addEventListener('DOMContentLoaded', () => {
    const burgerMenu = document.getElementById('burger-menu');
    const menuOverlay = document.getElementById('menu-overlay');

    // Toggle menu
    burgerMenu.addEventListener('click', () => {
        burgerMenu.classList.toggle('open');
        menuOverlay.style.display = menuOverlay.style.display === 'flex' ? 'none' : 'flex';
    });

    // Fermer le menu en cliquant sur un lien
    const menuLinks = menuOverlay.querySelectorAll('a');
    menuLinks.forEach(link => {
        link.addEventListener('click', () => {
            burgerMenu.classList.remove('open');
            menuOverlay.style.display = 'none';
        });
    });
});


