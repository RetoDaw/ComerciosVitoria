CREATE TABLE `usuarios` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `user_name` varchar(255) UNIQUE NOT NULL,
  `password` varchar(500) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` int,
  `tipo_usuario` varchar(255) NOT NULL
);

CREATE TABLE `categorias` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL
);

CREATE TABLE `anuncios` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `titulo` varchar(255) UNIQUE NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `carpeta_imagen` varchar(255) NOT NULL,
  `precio` int NOT NULL,
  `id_usuario` int,
  `id_categoria` int
);

CREATE TABLE `favoritos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_anuncio` int NOT NULL
);

CREATE TABLE `user_favoritos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_usuario` int,
  `id_favorito` int
);

ALTER TABLE `anuncios` ADD FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

ALTER TABLE `anuncios` ADD FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`);

ALTER TABLE `anuncios` ADD FOREIGN KEY (`id`) REFERENCES `favoritos` (`id_anuncio`);

ALTER TABLE `usuarios` ADD FOREIGN KEY (`telefono`) REFERENCES `usuarios` (`id`);

ALTER TABLE `user_favoritos` ADD FOREIGN KEY (`id_favorito`) REFERENCES `favoritos` (`id`);

ALTER TABLE `user_favoritos` ADD FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);
