# ComerciosVitoria
Comercios Vitoria nos ha "contratado" para hacer una aplicación web que permita a los comerciantes subir información sobre sus comercios y a los visitantes, poder ver los diferentes comercios.

Enlace trello:
https://trello.com/b/xGIflTgr/comercios-vitoria

Enlace figma:
https://www.figma.com/design/DLUmd5HuIbwA0nVpaGWb9R/PURPOR?node-id=3-5&p=f&t=J1KcncHSzJQACrTm-0

Pasos a seguir:
Al entrar -> Conexion BD -> Mostrar anuncios(solo 1 imagen).

Mostrar anuncio -> Coger datos de tabla anuncios, imagenes de tabla imagenes y datos de contacto del usuario.

Leer mas -> Mostrar toda la informacion (ya esta recogida en variables).

Filtrar -> Mostrar anuncios con filtro (no volver a buscar, sino reiterar con condicion).

Buscar anuncio -> Mostrar anuncios que coincidan con el (LIKE) nombre (no volver a buscar, sino reiterar con condicion).

Crear anuncio -> Subir a tabla anuncios (si los datos no estan vacios), si sale bien: subir imágenes en su tabla.

Iniciar sesion -> Buscar datos en la tabla usuario y si es correcto iniciar sesion para darle privilegios de usuario registrado.

Registrarse -> Todo menos telefono obligatorio, crear el usuario en la base de datos e inciar sesion.

Ver mis favoritos -> Mostrar anuncios que estén en la tabla favoritos.

Ver mis anuncios -> Mostrar anuncios que tengan el id del usuario.

Borrar anuncio -> Borrar imagenes de la bd y si sale bien el anuncio de la bd.

Desactivar anuncio -> Actualizar estado del anuncio a false.

Reactivar anuncio -> Actualizar estado del anuncio a true.

Editar anuncio -> Iniciar formulario con la información actual del anuncio y hacer update en tablas anuncios e imágenes(solo si hubo cambios).

Editar perfil -> Iniciar formulario con la información actual del usuario y hacer update en tabla usuarios (solo si hubo cambios).

Crear categoria -> Añadir a la tabla categorias (si el nombre no está vacío).

Borrar categoria -> Mostrar categorias como en el filtro y borrar de la bd.
