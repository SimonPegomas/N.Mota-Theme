
console.log("Chargement du script photo-info.js");

document.addEventListener("DOMContentLoaded", function () {
    // Sélection des éléments
    const infoModal = document.getElementById("photo-info");
    const contactLink = document.getElementById("contact-link");
    const closeModal = document.querySelector(".close-modal");

    // Gestion de l'affichage des informations
    document.querySelectorAll(".photo-info-btn").forEach(button => {
        button.addEventListener("click", function () {
            const photoId = this.getAttribute("data-photo-id");
            afficherInfoPhoto(photoId);
        });
    });

    function afficherInfoPhoto(photoId) {
        infoModal.classList.add("active");
        // Charger les infos spécifiques à la photo si nécessaire
    }

    closeModal.addEventListener("click", () => {
        infoModal.classList.remove("active");
    });

    // Gestion de la lightbox
    document.querySelectorAll(".photo-lightbox-btn").forEach(button => {
        button.addEventListener("click", function (event) {
            event.preventDefault();
            const imageUrl = this.getAttribute("href");
            ouvrirLightbox(imageUrl);
        });
    });

    function ouvrirLightbox(imageUrl) {
        console.log("Ouverture de la lightbox avec l'image :", imageUrl);
    }

    // Effet hover pour afficher les icônes
    document.querySelectorAll(".photo-item").forEach(item => {
        const hoverElement = item.querySelector(".photo-hover");
        if (hoverElement) {
            item.addEventListener("mouseenter", function () {
                hoverElement.classList.add("visible");
            });

            item.addEventListener("mouseleave", function () {
                hoverElement.classList.remove("visible");
            });
        }
    });

    // Remplissage auto de la modale de contact
    if (contactLink) {
        contactLink.addEventListener("click", (e) => {
            e.preventDefault();
            const refPhoto = contactLink.getAttribute("data-ref");
            document.getElementById("contact-modal").classList.add("active");
            document.getElementById("contact-modal input[name='ref']").value = refPhoto;
        });
    }

    // Gestion des miniatures au survol des liens de navigation
    document.querySelectorAll(".nav-link").forEach(link => {
        link.addEventListener("mouseover", function () {
            this.style.setProperty("--thumbnail", `url(${this.getAttribute("data-thumb")})`);
        });
    });
});

// bouton conact page info photo 

document.addEventListener("click", function (event) {
    if (event.target.classList.contains("open-contact-modal")) {
        event.preventDefault();
        let modal = document.getElementById("contact-modal");
        if (modal) {
            modal.style.display = "flex";
            modal.setAttribute("aria-hidden", "false");
            let refInput = document.querySelector("#contact-modal input[name='your-subject']");
            if (refInput) {
                refInput.value = event.target.getAttribute("data-photo-ref");
            }
        }
    }
});

