
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

// 2. Modale 

document.addEventListener("DOMContentLoaded", () => {
    console.log("JS chargé avec succès");

    // Gestion de l'ouverture de la modale via le lien Contact
    const openModalLinks = document.querySelectorAll(".open-modal");
    const modal = document.getElementById("contact-modal");
    const closeModalButton = document.getElementById("close-modal");

    // Ouvrir la modale
    openModalLinks.forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault(); // Empêche le comportement par défaut du lien
            modal.style.display = "flex";
        });
    });

    // Fermer la modale
    closeModalButton.addEventListener("click", () => {
        modal.style.display = "none";
    });

    // Fermer la modale en cliquant en dehors
    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });
});
 // 3 Template single 
 
 document.addEventListener("DOMContentLoaded", function () {
    const themeFilter = document.getElementById("filter-theme");
    const formatFilter = document.getElementById("filter-format");
    const sortFilter = document.getElementById("filter-sort");
    const items = document.querySelectorAll(".photo-item");

    function filterImages() {
        const selectedTheme = themeFilter.value;
        const selectedFormat = formatFilter.value;

        items.forEach(item => {
            const itemTheme = item.dataset.theme;
            const itemFormat = item.dataset.format;

            // Vérifie si l'image correspond aux filtres sélectionnés
            const matchTheme = selectedTheme === "" || itemTheme === selectedTheme;
            const matchFormat = selectedFormat === "" || itemFormat === selectedFormat;

            if (matchTheme && matchFormat) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });
    }

    themeFilter.addEventListener("change", filterImages);
    formatFilter.addEventListener("change", filterImages);
});

// 4 Load More 

document.addEventListener("DOMContentLoaded", function () {
    let page = 1; // Gère la pagination

    document.getElementById("load-more").addEventListener("click", function () {
        page++;

        fetch(ajax_object.ajaxurl, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({
                action: "load_more_photos",
                page: page,
            }),
        })
        .then(response => response.text())
        .then(data => {
            if (data.trim() === "") {
                document.getElementById("load-more").style.display = "none"; // Cache le bouton si plus de photos
            } else {
                document.querySelector(".galerie-photo").insertAdjacentHTML("beforeend", data);
            }
        })
        .catch(error => console.error("Erreur lors du chargement :", error));
    });
});

