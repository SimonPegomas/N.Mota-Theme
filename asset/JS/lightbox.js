document.addEventListener('DOMContentLoaded', function () {
    let galleryLinks = [];
    let currentIndex = 0;
  
    // Met à jour le tableau des liens de la galerie
    function updateGalleryLinks() {
        galleryLinks = Array.from(document.querySelectorAll('a[data-lightbox="galerie"]'));
    }
    function attachLightboxListeners() {
      document.querySelector(".galerie-photo")?.addEventListener("click", function (e) {
          const link = e.target.closest('a[data-lightbox="galerie"]');
          if (link) {
              e.preventDefault();
              updateGalleryLinks();
              currentIndex = galleryLinks.indexOf(link);
              openLightbox(currentIndex);
          } // Ajout de l'accolade fermante correcte
      });
  }
  
    // Récupération des éléments de la lightbox
    const lightboxContainer = document.getElementById('lightbox-container');
    const lightboxImage = lightboxContainer.querySelector('.lightbox-image');
    const lightboxClose = lightboxContainer.querySelector('.lightbox-close');
    const lightboxPrev = lightboxContainer.querySelector('.lightbox-prev');
    const lightboxNext = lightboxContainer.querySelector('.lightbox-next');
    const lightboxReference = lightboxContainer.querySelector('.lightbox-reference');
    const lightboxCategory = lightboxContainer.querySelector('.lightbox-category');
  
    // Ouvre la lightbox pour l'image correspondant à l'index donné
    function openLightbox(index) {
        updateGalleryLinks();
        currentIndex = index;
        const link = galleryLinks[currentIndex];
        if (!link) return;
  
        lightboxImage.src = link.getAttribute('href');
  
        // Récupération de l'ID de la photo
        const photoId = link.getAttribute('data-photo-id');
  
        // Chargement dynamique des informations via AJAX
        if (photoId) {
            fetch(`${ajax_object.ajaxurl}?action=get_photo_details&photo_id=${photoId}`)
                .then(response => response.json())
                .then(data => {
                    lightboxReference.textContent = data.reference || 'Absent';
                    lightboxCategory.textContent = data.categorie || 'Non classé';
                })
                .catch(error => console.error('Erreur lors de la récupération des infos :', error));
        }
  
        // Affiche la lightbox en ajoutant la classe "active"
        lightboxContainer.classList.add('active');
    }
  
    // Ferme la lightbox
    function closeLightbox() {
        lightboxContainer.classList.remove('active');
    }
  
    // Affiche l'image suivante
    function showNext() {
        updateGalleryLinks();
        currentIndex = (currentIndex + 1) % galleryLinks.length;
        openLightbox(currentIndex);
    }
  
    // Affiche l'image précédente
    function showPrev() {
        updateGalleryLinks();
        currentIndex = (currentIndex - 1 + galleryLinks.length) % galleryLinks.length;
        openLightbox(currentIndex);
    }
  
    // Délégation d'événement sur le conteneur de la galerie
    const galleryContainer = document.querySelector('.galerie-photo');
    if (galleryContainer) {
        galleryContainer.addEventListener('click', function (e) {
            const link = e.target.closest('a[data-lightbox="galerie"]');
            if (link) {
                e.preventDefault();
                updateGalleryLinks();
                currentIndex = galleryLinks.indexOf(link);
                openLightbox(currentIndex);
            }
        });
    }
  
    // Listenner sur les boutons de navigation et de fermeture
    lightboxClose.addEventListener('click', closeLightbox);
    lightboxNext.addEventListener('click', function (e) {
        e.stopPropagation();
        showNext();
    });
    lightboxPrev.addEventListener('click', function (e) {
        e.stopPropagation();
        showPrev();
    });
  
    // Fermer la lightbox en cliquant en dehors de l'image
    lightboxContainer.addEventListener('click', function (e) {
        if (e.target === lightboxContainer) {
            closeLightbox();
        }
    });
  });
  