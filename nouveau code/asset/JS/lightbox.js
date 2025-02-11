

    // Gestion de la Lightbox

    document.addEventListener("DOMContentLoaded", function() {
    console.log("Lightbox JS chargé !");
console.log(document.getElementById("lightbox")); // Vérifie si l'élément existe

    console.log("lightbox.js est bien chargé");
    const lightbox = document.getElementById("lightbox");
    const lightboxImage = document.getElementById("lightbox-image");
    const lightboxTitle = document.getElementById("lightbox-title");
    const lightboxOverlay = document.querySelector(".lightbox-overlay");
    const closeButtonLightbox = document.getElementById("lightbox-close");
    const prevButton = document.getElementById("lightbox-prev");
    const nextButton = document.getElementById("lightbox-next");
    let currentIndex = 0;
    let photos = [];

    document.querySelectorAll(".photo-thumbnail").forEach((img, index) => {
        console.log("Image trouvée :", img.getAttribute("data-full"));
    });
    
    function openLightbox(index) {
        currentIndex = index;
        updateLightbox();
        lightbox.classList.add("show");
    }

    function closeLightbox() {
        lightbox.classList.remove("show");
    }

    function updateLightbox() {
        if (photos.length > 0) {
            lightboxImage.src = photos[currentIndex].src;
            lightboxTitle.textContent = photos[currentIndex].title;
        }
    }

    function navigate(direction) {
        currentIndex += direction;
        if (currentIndex < 0) currentIndex = photos.length - 1;
        if (currentIndex >= photos.length) currentIndex = 0;
        updateLightbox();
    }


    
    
    
    function attachLightboxEvents() {
        document.querySelectorAll(".photo-thumbnail").forEach((img, index) => {
            img.addEventListener("click", function () {
                photos = [...document.querySelectorAll(".photo-thumbnail")].map(img => ({
                    src: img.getAttribute("data-full"),
                    title: img.getAttribute("alt") || "Sans titre",
                }));
                openLightbox(index);
            });
        });
    }
    
    closeButtonLightbox.addEventListener("click", closeLightbox);
    lightboxOverlay.addEventListener("click", closeLightbox);
    prevButton.addEventListener("click", () => navigate(-1));
    nextButton.addEventListener("click", () => navigate(1));
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") closeLightbox();
        if (e.key === "ArrowLeft") navigate(-1);
        if (e.key === "ArrowRight") navigate(1);
    });

});
    
    
