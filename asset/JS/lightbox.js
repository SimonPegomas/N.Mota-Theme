document.addEventListener('DOMContentLoaded', function() {
    let galleryLinks = [];
    let currentIndex = 0;
  
    // Met à jour le tableau des liens de la galerie
    function updateGalleryLinks() {
      galleryLinks = Array.from(document.querySelectorAll('a[data-lightbox="galerie"]'));
    }
  
    // Récupération des éléments de la lightbox (définis dans le footer)
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
  
      // Mise à jour de la légende avec les attributs data
      lightboxReference.textContent = link.getAttribute('data-reference') || '';
      lightboxCategory.textContent = link.getAttribute('data-category') || '';
  
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
      galleryContainer.addEventListener('click', function(e) {
        const link = e.target.closest('a[data-lightbox="galerie"]');
        if (link) {
          e.preventDefault();
          updateGalleryLinks();
          currentIndex = galleryLinks.indexOf(link);
          openLightbox(currentIndex);
        }
      });
    }
  
    // Écouteurs sur les boutons de navigation et de fermeture
    lightboxClose.addEventListener('click', closeLightbox);
    lightboxNext.addEventListener('click', function(e) {
      e.stopPropagation();
      showNext();
    });
    lightboxPrev.addEventListener('click', function(e) {
      e.stopPropagation();
      showPrev();
    });
  
    // Facultatif : fermer la lightbox en cliquant en dehors du contenu
    lightboxContainer.addEventListener('click', function(e) {
      if (e.target === lightboxContainer) {
        closeLightbox();
      }
    });
  });
  