// ========== FUNCIONES DE POPUP ==========
document.querySelectorAll('.leer-mas').forEach(btn => {
  btn.addEventListener('click', () => {
    const id = btn.dataset.id;
    const anuncio = anuncios[id];

    // Llenar contenido del popup
    document.getElementById('popup-titulo').textContent = anuncio.titulo;
    document.getElementById('popup-categoria').textContent = anuncio.categoria;
    document.getElementById('popup-precio').textContent = numberFormat(anuncio.precio) + ' €';
    document.getElementById('popup-descripcion').textContent = anuncio.descripcion;
    document.getElementById('popup-telefono').innerHTML = '📞 ' + anuncio.contacto.telefono;
    document.getElementById('popup-email').innerHTML = '✉️ ' + anuncio.contacto.email;

    // Crear carrusel
    const track = document.getElementById('carouselTrack');
    track.innerHTML = '';
    anuncio.imagenes.forEach(img => {
      const item = document.createElement('div');
      item.className = 'carousel-item';
      item.innerHTML = `<img src="${img}" alt="${anuncio.titulo}">`;
      track.appendChild(item);
    });

    document.getElementById('overlay').classList.add('active');
    initializeCarousel();
  });
});

function closePopup() {
  document.getElementById('overlay').classList.remove('active');
}

// ========== CARRUSEL ==========
let currentSlide = 0;
let totalSlides = 0;
let slideWidth = 0;

function initializeCarousel() {
  const track = document.getElementById('carouselTrack');
  const container = document.querySelector('.carousel-container');
  const items = document.querySelectorAll('.carousel-item');

  totalSlides = items.length;
  slideWidth = container.clientWidth;
  currentSlide = 0;

  track.style.transform = `translateX(0px)`;
}

function moveSlide(direction) {
  const track = document.getElementById('carouselTrack');
  const container = document.querySelector('.carousel-container');

  slideWidth = container.clientWidth;
  currentSlide += direction;

  if (currentSlide < 0) currentSlide = totalSlides - 1;
  else if (currentSlide >= totalSlides) currentSlide = 0;

  track.style.transform = `translateX(-${currentSlide * slideWidth}px)`;
}

// Recalcular carrusel si cambia tamaño
window.addEventListener('resize', () => {
  if (document.getElementById('overlay').classList.contains('active')) {
    initializeCarousel();
  }
});

// Formateo de números
function numberFormat(num) {
  return new Intl.NumberFormat('es-ES', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  }).format(num);
}

// Cerrar popup con ESC
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') closePopup();
});

// Cerrar popup clicando fuera
document.getElementById('overlay').addEventListener('click', e => {
  if (e.target === e.currentTarget) closePopup();
});
