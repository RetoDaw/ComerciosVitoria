const usuariosDiv = document.getElementById('usuarios');
const mensajesDiv = document.getElementById('mensajes');
const input = document.getElementById('mensaje-input');
const enviarBtn = document.getElementById('enviar-btn');
console.log(USER_ID);

let receptorId = null;

// Cargar usuarios
async function cargarUsuarios() {
    const res = await fetch('http://localhost/proyecto/ComerciosVitoria-Imanol/programa/?id_emisor=' + USER_ID + '&controller=MensajesController&accion=getConversaciones');
    const usuarios = await res.json();
    usuariosDiv.innerHTML = '';
    usuarios.forEach(u => {
        const div = document.createElement('div');
        div.textContent = u.user_name;
        div.style.cursor = 'pointer';
        div.onclick = () => seleccionarUsuario(u.id, u.user_name);
        usuariosDiv.appendChild(div);
    });

}
let primeraCargaMensajes = true;
// Cargar mensajes entre usuarios
async function cargarMensajes(autoScroll = false) {
    if (!receptorId) return;
    const res = await fetch('http://localhost/proyecto/ComerciosVitoria-Imanol/programa/?id_emisor=' + USER_ID +'&id_receptor=' + receptorId + '&controller=MensajesController&accion=getMensajes');
    const mensajes = await res.json();
    mensajesDiv.innerHTML = '';

    mensajes.forEach(m => {
        const p = document.createElement('div');
        p.classList.add('mensaje');
        p.classList.add(m.id_emisor == USER_ID ? 'yo' : 'otro');
        p.textContent = m.mensaje;
        mensajesDiv.appendChild(p);
    });

    if (autoScroll || primeraCargaMensajes) {
        mensajesDiv.scrollTop = mensajesDiv.scrollHeight;
        primeraCargaMensajes = false;
    }
}

// Enviar mensaje
async function enviarMensaje() {
    const mensaje = input.value.trim();
    
    if (!mensaje || !receptorId) return;
    console.log("todo bien");
    await fetch('http://localhost/proyecto/ComerciosVitoria-Imanol/programa/?controller=MensajesController&accion=sendMensajes', {
        method: 'POST', 
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            id_emisor: USER_ID,
            id_receptor: receptorId,
            mensaje: mensaje
        })
    });

    input.value = '';
    await cargarMensajes(true);
}

// Seleccionar usuario del chat
function seleccionarUsuario(id, nombre) {
    receptorId = id;
    primeraCargaMensajes = true; // para que la primera carga haga scroll
    console.log(id);
    mensajesDiv.innerHTML = `<p><em>Cargando conversación con ${nombre}...</em></p>`;
    cargarMensajes();
    // Auto-refresh cada 3s (como "tiempo real" sin websockets)
    if (window.refreshInterval) clearInterval(window.refreshInterval);
    window.refreshInterval = setInterval(cargarMensajes, 1000);
}

// Eventos
enviarBtn.onclick = enviarMensaje;
input.addEventListener('keypress', e => {
    if (e.key === 'Enter') enviarMensaje();
});

// Iniciar
cargarUsuarios();
