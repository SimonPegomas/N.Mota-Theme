document.addEventListener("DOMContentLoaded", function () {
    console.log("Le fichier JS est bien chargé !");

    // 1️⃣ Menu Burger
    const burgerMenu = document.getElementById('burger-menu');
    const menuOverlay = document.getElementById('menu-overlay');

    if (burgerMenu && menuOverlay) {
        burgerMenu.addEventListener('click', () => {
            burgerMenu.classList.toggle('open');
            menuOverlay.style.display = menuOverlay.style.display === 'flex' ? 'none' : 'flex';
        });

        menuOverlay.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                burgerMenu.classList.remove('open');
                menuOverlay.style.display = 'none';
            });
        });
    }

    // 2️⃣ Modale Contact
    console.log("JS de la modale chargé !");

    const modal = document.getElementById('contact-modal');
    const closeButton = document.getElementById('close-modal');

    console.log("Modale trouvée :", modal);
    console.log("Bouton de fermeture trouvé :", closeButton);

    // 🔥 Ajout d'un eventListener global pour capturer les boutons dynamiques
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("open-contact-modal")) {
            event.preventDefault();
            console.log("Bouton cliqué !");
            if (modal) {
                modal.style.display = 'flex'; 
                modal.setAttribute('aria-hidden', 'false');
            } else {
                console.log("Erreur : Modale introuvable !");
            }
        }
    });

    if (closeButton && modal) {
        closeButton.addEventListener('click', () => {
            console.log("Fermeture de la modale");
            modal.style.display = 'none';
            modal.setAttribute('aria-hidden', 'true');
        });

        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                console.log("Clic en dehors de la modale, fermeture");
                modal.style.display = 'none';
                modal.setAttribute('aria-hidden', 'true');
            }
        });
    }

    // 3️⃣ Filtrage et Load More (Optimisé)
    let page = 1;
    const galerie = document.querySelector(".galerie-photo");
    const loadMoreBtn = document.getElementById("load-more");

    function loadPhotos(reset = false) {
        let theme = document.getElementById("filter-theme").value;
        let format = document.getElementById("filter-format").value;
        let sortOrder = document.getElementById("filter-sort").value;

        if (reset) page = 1; // Réinitialisation de la pagination

        fetch(ajax_object.ajaxurl, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({
                action: "filter_photos",
                page: page,
                theme: encodeURIComponent(theme),
                format: encodeURIComponent(format),
                sort: encodeURIComponent(sortOrder)
            }),
        })
        .then(response => response.text())
        .then(data => {
            if (reset) {
                galerie.innerHTML = data;
            } else {
                galerie.insertAdjacentHTML("beforeend", data);
            }

            // Gestion de la visibilité du bouton "Charger plus"
            if (data.trim() === "" || document.querySelectorAll(".photo-item").length < 8) {
                loadMoreBtn.style.display = "none";
            } else {
                loadMoreBtn.style.display = "block";
            }
        })
        .catch(error => console.error("Erreur Ajax :", error));
    }

    // Écouteurs pour les filtres
    ["filter-theme", "filter-format", "filter-sort"].forEach(id => {
        document.getElementById(id)?.addEventListener("change", function () {
            loadPhotos(true);
        });
    });

    // Bouton "Charger plus"
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener("click", function () {
            page++;
            loadPhotos(false);
        });
    }
});

