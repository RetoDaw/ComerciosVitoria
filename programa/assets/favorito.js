// ========== FAVORITOS EN TARJETAS ==========
document.querySelectorAll('.tarjeta .favorito').forEach(favorito => {
  let esFavorito = false;
  favorito.addEventListener('click', () => {
    favorito.classList.add('clicked');
    setTimeout(() => {
      esFavorito = !esFavorito;
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

popupFavorito.addEventListener('click', () => {
  popupFavorito.classList.add('clicked');
  setTimeout(() => {
    esFavoritoPopup = !esFavoritoPopup;
    popupFavorito.src = esFavoritoPopup
      ? 'https://cdn-icons-png.flaticon.com/512/833/833472.png'
      : 'https://cdn-icons-png.flaticon.com/512/1077/1077035.png';
    popupFavorito.classList.remove('clicked');
  }, 150);
});