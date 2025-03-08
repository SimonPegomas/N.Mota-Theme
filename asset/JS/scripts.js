document.addEventListener("DOMContentLoaded", function () {
    console.log("Le fichier script JS est bien chargé !");
    
    // Fonction de mise à jour des infos des photos
    function updatePhotoInfo() {
        document.querySelectorAll('.photo-item').forEach(item => {
            const photoId = item.getAttribute('data-photo-id');
            if (!photoId) return;

            let leftInfo = item.querySelector('.photo-info-left');
            let rightInfo = item.querySelector('.photo-info-right');

            if (!leftInfo) {
                leftInfo = document.createElement('div');
                leftInfo.className = 'photo-info photo-info-left';
                leftInfo.setAttribute('data-photo-id', photoId);
                leftInfo.textContent = item.getAttribute('data-title') || 'Titre inconnu';
                item.appendChild(leftInfo);
            }

            if (!rightInfo) {
                rightInfo = document.createElement('div');
                rightInfo.className = 'photo-info photo-info-right';
                rightInfo.setAttribute('data-photo-id', photoId);
                rightInfo.textContent = item.getAttribute('data-category') || 'Non classé';
                item.appendChild(rightInfo);
            }
        });
        console.log("Informations des photos mises à jour.");
    }
    
    updatePhotoInfo();

    // Menu Burger
    const burgerMenu = document.getElementById('burger-menu');
    const menuOverlay = document.getElementById('menu-overlay');
    if (burgerMenu && menuOverlay) {
        burgerMenu.addEventListener('click', function (event) {
            event.stopPropagation();
            burgerMenu.classList.toggle('open');
            menuOverlay.classList.toggle('active');
            console.log("Burger menu cliqué ! État actuel : ", menuOverlay.classList.contains('active') ? "OUVERT" : "FERMÉ");
        });

        menuOverlay.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function () {
                burgerMenu.classList.remove('open');
                menuOverlay.classList.remove('active');
                console.log("Lien cliqué, fermeture du menu.");
            });
        });

        document.addEventListener('click', function (event) {
            if (!menuOverlay.contains(event.target) && !burgerMenu.contains(event.target)) {
                burgerMenu.classList.remove('open');
                menuOverlay.classList.remove('active');
                console.log("Clic en dehors du menu, fermeture.");
            }
        });
    }

    // Modale Contact
    const modal = document.getElementById('contact-modal');
    const closeButton = document.getElementById('close-modal');
    console.log("JS de la modale chargé !");

    // Ouvrir la modale
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("open-contact-modal")) {
            event.preventDefault();
            console.log("Bouton cliqué pour ouvrir la modale !");
            if (modal) {
                modal.style.display = 'flex';
                modal.setAttribute('aria-hidden', 'false');
            } else {
                console.log("Erreur : Modale introuvable !");
            }
        }
    });

    // Fermer la modale
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

    // Fonction de chargement des photos avec les filtres et pagination
    let page = 1;
    const galerie = document.querySelector(".galerie-photo");
    const loadMoreBtn = document.getElementById("load-more");

    function loadPhotos(reset = false) {
        let theme = document.getElementById("filter-theme")?.value;
        let format = document.getElementById("filter-format")?.value;
        let sortOrder = document.getElementById("filter-sort")?.value;

        if (reset) page = 1;

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
            
            // Mettre à jour les infos des photos
            updatePhotoInfo();

            // Vérifier s'il y a encore des photos à charger
            if (data.trim() === '') {
                loadMoreBtn.style.display = 'none'; // Masquer le bouton "Charger plus"
            }
        })
        .catch(error => console.error("Erreur Ajax :", error));
    }

    // Écouteurs d'événements pour les filtres
    ["filter-theme", "filter-format", "filter-sort"].forEach(id => {
        document.getElementById(id)?.addEventListener("change", function () {
            loadPhotos(true);
        });
    });

    // Charger plus de photos
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener("click", function () {
            page++;
            loadPhotos(false);
        });
    }

    // Charger les infos au survol de la photo
    document.addEventListener('mouseenter', function(event) {
        if (event.target.closest('.photo-item')) {
            const item = event.target.closest('.photo-item');
            const photoId = item.getAttribute('data-photo-id');
            if (photoId) {
                fetch(`${ajax_object.ajaxurl}?action=get_photo_details&photo_id=${photoId}`)
                    .then(response => response.json())
                    .then(data => {
                        const rightInfo = item.querySelector('.photo-info-right');
                        if (rightInfo) rightInfo.textContent = data.categorie || 'Non classé';
                    })
                    .catch(error => console.error('Erreur lors de la récupération des infos :', error));
            }
        }
    }, true);
});
