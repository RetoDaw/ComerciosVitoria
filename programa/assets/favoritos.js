
async function añadirFavoritos(USER_ID, id_anuncio){
    
    await fetch('http://localhost/proyecto/ComerciosVitoria-UnaxIriondo/programa/?controller=FavoritosController&accion=añadir', {
        method: 'POST', 
        headers: { 'Content-Type': 'application/json'},
        body: JSON.stringify({
            id_usuario: USER_ID,
            id_anuncio: id_anuncio
        })
    });

    input.value = '';
    await cargarMensajes(true);
}
async function eliminarFavoritos(USER_ID, id_anuncio){
    
    await fetch('http://localhost/proyecto/ComerciosVitoria-UnaxIriondo/programa/?controller=FavoritosController&accion=eliminar', {
        method: 'POST', 
        headers: { 'Content-Type': 'application/json'},
        body: JSON.stringify({
            id_usuario: USER_ID,
            id_anuncio: id_anuncio
        })
    });

    input.value = '';
    await cargarMensajes(true);
}
async function getAll(USER_ID){
    
    const respuesta = await fetch('http://localhost/proyecto/ComerciosVitoria-UnaxIriondo/programa/?controller=FavoritosController&accion=getAll', {
        method: 'POST', 
        headers: { 'Content-Type': 'application/json'},
        body: JSON.stringify({
            id_usuario: USER_ID})
        })

}
