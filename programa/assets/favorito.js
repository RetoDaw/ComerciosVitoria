document.addEventListener('DOMContentLoaded', () => {
  initFavoritos().catch(err => console.error('initFavoritos error:', err));
});

async function initFavoritos() {
  console.log('[favorito.js] Iniciando favoritos...');
  
  // Obtener favoritos del servidor
  const favs = await getAll(); // devuelve array de anuncios favoritos
  const favIds = (favs || []).map(f => String(f.id));

  // Marcar iconos en las tarjetas
  document.querySelectorAll('.tarjeta').forEach(tarjeta => {
    const leerMas = tarjeta.querySelector('.leer-mas');
    const img = tarjeta.querySelector('img.favorito');
    if (!leerMas || !img) return;
    const id = String(leerMas.dataset.id);
    if (favIds.includes(id)) {
      img.src = 'https://cdn-icons-png.flaticon.com/512/833/833472.png';
      img.dataset.favorito = 'true';
    } else {
      img.src = 'https://cdn-icons-png.flaticon.com/512/1077/1077035.png';
      img.dataset.favorito = 'false';
    }
  });

  // Delegación: un listener para los clicks en cualquier img.favorito
  document.addEventListener('click', async (e) => {
    const img = e.target.closest('img.favorito');
    if (!img) return;

    const tarjeta = img.closest('.tarjeta');
    const leerMas = tarjeta ? tarjeta.querySelector('.leer-mas') : null;
    if (!leerMas) return;
    const idAnuncio = leerMas.dataset.id;
    if (!idAnuncio) return;

    console.log('[favorito] Click en anuncio', idAnuncio, 'estado previo:', img.dataset.favorito);

    try {
      if (img.dataset.favorito === 'true') {
        const res = await eliminarFavoritos(idAnuncio);
        if (res && (res.success || res.removed)) {
          img.src = 'https://cdn-icons-png.flaticon.com/512/1077/1077035.png';
          img.dataset.favorito = 'false';
        }
      } else {
        const res = await añadirFavoritos(idAnuncio);
        if (res && (res.success || res.added)) {
          img.src = 'https://cdn-icons-png.flaticon.com/512/833/833472.png';
          img.dataset.favorito = 'true';
        }
      }

      // Sincronizar icono del popup si existe
      const popupFav = document.getElementById('popup-favorito');
      if (popupFav && popupFav.dataset && String(popupFav.dataset.id) === String(idAnuncio)) {
        popupFav.src = img.src;
        popupFav.dataset.favorito = img.dataset.favorito;
      }
    } catch (err) {
      console.error('Error al cambiar favorito:', err);
    }
  });
}

/* ==== funciones de comunicación con backend ==== */
async function añadirFavoritos(id_anuncio) {
  try {
    const res = await fetch('?controller=FavoritosController&accion=añadir', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id_anuncio })
    });
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    return await res.json();
  } catch (err) {
    console.error('Error en añadirFavoritos:', err);
    return { success: false, error: err.message || 'network' };
  }
}

async function eliminarFavoritos(id_anuncio) {
  try {
    const res = await fetch('?controller=FavoritosController&accion=eliminar', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id_anuncio })
    });
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    return await res.json();
  } catch (err) {
    console.error('Error en eliminarFavoritos:', err);
    return { success: false, error: err.message || 'network' };
  }
}

async function getAll() {
  try {
    // Llamada GET simple, sin body
    const res = await fetch('?controller=FavoritosController&accion=getAll');
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    const json = await res.json();
    return json.favoritos ?? [];
  } catch (err) {
    console.error('Error en getAll favoritos:', err);
    return [];
  }
}
