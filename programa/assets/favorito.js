// ========== FAVORITOS EN TARJETAS ==========
document.querySelectorAll('.tarjeta .favorito').forEach(favorito => {
  // Obtener el ID del anuncio desde el botón "Leer más" de la misma tarjeta
  const tarjeta = favorito.closest('.tarjeta');
  const botonLeerMas = tarjeta.querySelector('.leer-mas');
  const anuncioId = botonLeerMas.dataset.id;
  
  // Verificar si este anuncio ya está en favoritos (desde localStorage)
  let esFavorito = isFavorito(anuncioId);
  
  // Establecer el icono inicial según el estado
  favorito.src = esFavorito
    ? 'https://cdn-icons-png.flaticon.com/512/833/833472.png'
    : 'https://cdn-icons-png.flaticon.com/512/1077/1077035.png';
  
  favorito.addEventListener('click', () => {
    favorito.classList.add('clicked');
    setTimeout(() => {
      esFavorito = !esFavorito;
      
      // Guardar o eliminar de favoritos
      if (esFavorito) {
        addFavorito(anuncioId);
      } else {
        removeFavorito(anuncioId);
      }
      
      favorito.src = esFavorito
        ? 'https://cdn-icons-png.flaticon.com/512/833/833472.png'
        : 'https://cdn-icons-png.flaticon.com/512/1077/1077035.png';
      favorito.classList.remove('clicked');
    }, 150);
  });
});

// ========== FAVORITO EN POPUP ==========
const popupFavorito = document.getElementById('popup-favorito');
let esFavoritoPopup = false;
let currentAnuncioId = null;

// Actualizar el estado del favorito del popup cuando se abre
document.querySelectorAll('.leer-mas').forEach(btn => {
  btn.addEventListener('click', () => {
    currentAnuncioId = btn.dataset.id;
    esFavoritoPopup = isFavorito(currentAnuncioId);
    
    popupFavorito.src = esFavoritoPopup
      ? 'https://cdn-icons-png.flaticon.com/512/833/833472.png'
      : 'https://cdn-icons-png.flaticon.com/512/1077/1077035.png';
  });
});

popupFavorito.addEventListener('click', () => {
  if (!currentAnuncioId) return;
  
  popupFavorito.classList.add('clicked');
  setTimeout(() => {
    esFavoritoPopup = !esFavoritoPopup;
    
    // Guardar o eliminar de favoritos
    if (esFavoritoPopup) {
      addFavorito(currentAnuncioId);
    } else {
      removeFavorito(currentAnuncioId);
    }
    
    popupFavorito.src = esFavoritoPopup
      ? 'https://cdn-icons-png.flaticon.com/512/833/833472.png'
      : 'https://cdn-icons-png.flaticon.com/512/1077/1077035.png';
    
    // Sincronizar con el icono de la tarjeta correspondiente
    sincronizarFavoritoTarjeta(currentAnuncioId, esFavoritoPopup);
    
    popupFavorito.classList.remove('clicked');
  }, 150);
});

// ========== FUNCIONES DE GESTIÓN DE FAVORITOS ==========

// Obtener favoritos del localStorage
function getFavoritos() {
  const favoritos = localStorage.getItem('favoritos');
  return favoritos ? JSON.parse(favoritos) : [];
}

// Verificar si un anuncio está en favoritos
function isFavorito(anuncioId) {
  const favoritos = getFavoritos();
  return favoritos.includes(anuncioId.toString());
}

// Añadir a favoritos
function addFavorito(anuncioId) {
  const favoritos = getFavoritos();
  if (!favoritos.includes(anuncioId.toString())) {
    favoritos.push(anuncioId.toString());
    localStorage.setItem('favoritos', JSON.stringify(favoritos));
  }
}

// Eliminar de favoritos
function removeFavorito(anuncioId) {
  let favoritos = getFavoritos();
  favoritos = favoritos.filter(id => id !== anuncioId.toString());
  localStorage.setItem('favoritos', JSON.stringify(favoritos));
}

// Sincronizar el estado del favorito entre popup y tarjeta
function sincronizarFavoritoTarjeta(anuncioId, esFavorito) {
  document.querySelectorAll('.tarjeta .leer-mas').forEach(btn => {
    if (btn.dataset.id === anuncioId) {
      const tarjeta = btn.closest('.tarjeta');
      const iconoFavorito = tarjeta.querySelector('.favorito');
      
      iconoFavorito.src = esFavorito
        ? 'https://cdn-icons-png.flaticon.com/512/833/833472.png'
        : 'https://cdn-icons-png.flaticon.com/512/1077/1077035.png';
    }
  });
}