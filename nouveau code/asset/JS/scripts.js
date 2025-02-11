document.addEventListener("DOMContentLoaded", function () {
    console.log("Le fichier JavaScript est bien chargé !");

    // 1. Menu Burger
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

    // 2. Modale Contact
    const modal = document.getElementById('modale-container');
    const closeButton = document.getElementById('close-modale');
    const buttons = document.querySelectorAll('.open-contact-modal');
    const inputRef = document.querySelector('input[name="photo-ref"]');
    const photoReference = document.querySelector('.photo-reference');

    if (modal && closeButton && buttons.length) {
        buttons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const ref = button.dataset.refphoto || (photoReference ? photoReference.textContent.trim() : '');
                if (inputRef) inputRef.value = ref || '';
                modal.style.display = 'flex';
                modal.setAttribute('aria-hidden', 'false');
            });
        });

        closeButton.addEventListener('click', () => {
            modal.style.display = 'none';
            modal.setAttribute('aria-hidden', 'true');
        });

        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
                modal.setAttribute('aria-hidden', 'true');
            }
        });
    }

    // 3. Filtrage et Load More 
    let page = 1;
    const galerie = document.querySelector(".galerie-photo");
    const loadMoreBtn = document.getElementById("load-more");

    function loadPhotos(reset = false) {
        let theme = document.getElementById("filter-theme").value;
        let format = document.getElementById("filter-format").value;
        let sortOrder = document.getElementById("filter-sort").value;

        fetch(ajax_object.ajaxurl, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({
                action: "filter_photos",
                page: reset ? 1 : page,
                theme: theme,
                format: format,
                sort: sortOrder
            }),
        })
        .then(response => response.text())
        .then(data => {
            if (reset) {
                galerie.innerHTML = data;
                page = 1;
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
        document.getElementById(id).addEventListener("change", function () {
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





