-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.4.3 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para comercios_vitoria
CREATE DATABASE IF NOT EXISTS `comercios_vitoria` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `comercios_vitoria`;

-- Volcando estructura para tabla comercios_vitoria.anuncios
CREATE TABLE IF NOT EXISTS `anuncios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `id_usuario` int NOT NULL,
  `id_categoria` int DEFAULT NULL,
  `estado` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `titulo` (`titulo`),
  KEY `id_usuario` (`id_usuario`),
  KEY `anuncios_ibfk_2` (`id_categoria`),
  CONSTRAINT `anuncios_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `anuncios_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla comercios_vitoria.anuncios: ~9 rows (aproximadamente)
DELETE FROM `anuncios`;
INSERT INTO `anuncios` (`id`, `titulo`, `descripcion`, `direccion`, `precio`, `id_usuario`, `id_categoria`, `estado`) VALUES
	(48, 'iPhone 14 Azul', 'Teléfono móvil iPhone 14 en color azul.  - Pantalla de 6.1 pulgadas. - Capacidad de 128 GB. - Cámara dual de 12 MP.', 'C\\Portal de Foronda 28', 350.00, 4, 1, 1),
	(49, 'Escritorio con cajones', 'Escritorio funcional con cajones, ideal para tu espacio de trabajo o estudio. Su diseño sencillo se adapta a cualquier decoración.  - Cajón principal con cerradura. - Juego de tres cajones laterales. - Compartimento abierto superior.', 'C\\  Portal de Foronda 28', 50.00, 4, 3, 1),
	(50, 'Cinta de correr plegable', 'Cinta de correr para entrenar en casa. Su diseño permite guardarla fácilmente.  - Superficie de carrera gris. - Pantalla superior negra. - Sistema de seguridad con pinza roja.', 'C\\ Dato 4', 75.00, 6, 19, 1),
	(51, 'Estufa de leña negra', 'Negociable', 'C\\ Dato 4', 100.00, 6, 1, 1),
	(52, 'Máquina de pesas multifunción', 'Equipo de gimnasio para entrenar en casa.  - Estructura de acero resistente. - Incluye poleas y cables. - Torre de pesas integrada. - Banco acolchado.', 'C\\ Gorbeia 18', 300.00, 5, 19, 1),
	(53, 'Lote Ropa Niña 13/14 Años', 'Lote de ropa para niña de 13 a 14 años.  - Camiseta gris con estampado de The Rolling Stones. - Camiseta gris con estampado floral y texto. - chaqueta deportiva verde con cremallera. -sudadera negra - Vaqueros azules talla s Ropa de tienda de niñas, tallaje para 13/14 años', 'C\\ Gorbeia 18', 12.00, 5, 18, 1),
	(54, 'CD musica en castellano', 'CDs en perfecto estado, se venden todos juntos.', 'C\\ Gorbeia 18', 20.00, 5, 17, 1),
	(55, 'Honda CBR600F - Moto Deportiva', 'Venta urgente, sino entrego en compraventa en breve  Vendo honda cbr600 f de 2005 con 59.000km Ruedas y kit de arrastre nuevos. Indicador de marchas, válvulas acodadas, protectores de motor y baúl Manillar y escape homologado, tengo las piezas de origen también. Valoro cambio por trail de asfalto tipo tracer', 'Avenida Gasteiz 13', 2500.00, 9, 2, 1),
	(56, 'Guitarra Eléctrica Jackson', 'Jackson edición limitada Phill Demmell de Machine Head. Muy ligera. Muy rápida. Acción baja. Pastillas EMG pasivas Muy muy cañera. Incluyo funda rígida a medida y correa Gibson. Ni una sola marca. Como nueva. Está pefecta', 'Avenida Gasteiz 13', 750.00, 9, 17, 1);

-- Volcando estructura para tabla comercios_vitoria.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla comercios_vitoria.categorias: ~5 rows (aproximadamente)
DELETE FROM `categorias`;
INSERT INTO `categorias` (`id`, `nombre`) VALUES
	(1, 'Tecnología'),
	(2, 'Vehículos'),
	(3, 'Hogar'),
	(17, 'Musica'),
	(18, 'Ropa'),
	(19, 'Deporte');

-- Volcando estructura para tabla comercios_vitoria.favoritos
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id_usuario` int NOT NULL,
  `id_anuncio` int NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_anuncio`),
  KEY `id_anuncio` (`id_anuncio`),
  CONSTRAINT `favoritos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `favoritos_ibfk_2` FOREIGN KEY (`id_anuncio`) REFERENCES `anuncios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla comercios_vitoria.favoritos: ~6 rows (aproximadamente)
DELETE FROM `favoritos`;
INSERT INTO `favoritos` (`id_usuario`, `id_anuncio`) VALUES
	(5, 48),
	(6, 49),
	(9, 50),
	(5, 51),
	(9, 51),
	(9, 53),
	(9, 54);

-- Volcando estructura para tabla comercios_vitoria.imagenes
CREATE TABLE IF NOT EXISTS `imagenes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_anuncio` int NOT NULL,
  `ruta` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_anuncio` (`id_anuncio`),
  CONSTRAINT `imagenes_ibfk_1` FOREIGN KEY (`id_anuncio`) REFERENCES `anuncios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla comercios_vitoria.imagenes: ~29 rows (aproximadamente)
DELETE FROM `imagenes`;
INSERT INTO `imagenes` (`id`, `id_anuncio`, `ruta`) VALUES
	(48, 48, 'img/anuncios/48/i6012642593.webp'),
	(49, 48, 'img/anuncios/48/i6012642540.webp'),
	(50, 48, 'img/anuncios/48/i6012642418.webp'),
	(51, 48, 'img/anuncios/48/i6012642404.webp'),
	(52, 49, 'img/anuncios/49/i6029615175.webp'),
	(53, 49, 'img/anuncios/49/i6029614887.webp'),
	(54, 49, 'img/anuncios/49/i6029614837.webp'),
	(55, 50, 'img/anuncios/50/i6029605471.webp'),
	(56, 50, 'img/anuncios/50/i6029605499.webp'),
	(57, 50, 'img/anuncios/50/i6029605449.webp'),
	(58, 51, 'img/anuncios/51/i5990418789.webp'),
	(59, 51, 'img/anuncios/51/i5989847739.webp'),
	(60, 51, 'img/anuncios/51/i5989847706.webp'),
	(61, 52, 'img/anuncios/52/i6029398330.webp'),
	(62, 52, 'img/anuncios/52/i6029398315.webp'),
	(63, 53, 'img/anuncios/53/i6028212068.webp'),
	(64, 53, 'img/anuncios/53/i6028211878.webp'),
	(65, 54, 'img/anuncios/54/i6025245626.webp'),
	(66, 54, 'img/anuncios/54/i6025245346.webp'),
	(67, 55, 'img/anuncios/55/i6010530638.webp'),
	(68, 55, 'img/anuncios/55/i6010530622.webp'),
	(69, 55, 'img/anuncios/55/i6010530635.webp'),
	(70, 55, 'img/anuncios/55/i6010530621.webp'),
	(71, 55, 'img/anuncios/55/i6010530592.webp'),
	(72, 55, 'img/anuncios/55/i6010530642.webp'),
	(73, 56, 'img/anuncios/56/i6024334629.webp'),
	(74, 56, 'img/anuncios/56/i6024340170.webp'),
	(75, 56, 'img/anuncios/56/i6024340144.webp'),
	(76, 56, 'img/anuncios/56/i6024334639.webp');

-- Volcando estructura para tabla comercios_vitoria.mensaje
CREATE TABLE IF NOT EXISTS `mensaje` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_emisor` int NOT NULL,
  `id_receptor` int NOT NULL,
  `mensaje` varchar(1000) NOT NULL,
  `fecha_envio` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_emisor` (`id_emisor`),
  KEY `id_receptor` (`id_receptor`),
  CONSTRAINT `mensaje_ibfk_1` FOREIGN KEY (`id_emisor`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mensaje_ibfk_2` FOREIGN KEY (`id_receptor`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla comercios_vitoria.mensaje: ~39 rows (aproximadamente)
DELETE FROM `mensaje`;
INSERT INTO `mensaje` (`id`, `id_emisor`, `id_receptor`, `mensaje`, `fecha_envio`) VALUES
	(1, 4, 5, 'Hola bro, que taL?', '2025-10-20 08:50:08'),
	(2, 5, 4, 'Todo bien, que quieres?', '2025-10-20 08:50:28'),
	(3, 4, 5, 'Sigue en venta el producto?', '2025-10-20 08:50:44'),
	(4, 5, 4, 'SI, estabas interesado?', '2025-10-20 08:50:57'),
	(13, 4, 5, 'Sii, mucho la verdad', '2025-10-20 11:43:28'),
	(14, 5, 4, 'Cuanto pagarias?', '2025-10-20 11:44:04'),
	(15, 6, 4, 'Hola, que tal?', '2025-10-20 11:44:33'),
	(16, 4, 6, 'Hola jorge, yo bien', '2025-10-20 12:07:06'),
	(17, 4, 6, 'Que querias?', '2025-10-20 12:07:09'),
	(18, 6, 5, 'Me interesa lo que vendes', '2025-10-20 12:07:13'),
	(19, 6, 4, 'Me interesa lo que vendes', '2025-10-20 12:07:35'),
	(20, 4, 5, '78', '2025-10-20 12:08:46'),
	(21, 5, 4, 'Acepto', '2025-10-20 12:08:58'),
	(22, 4, 5, 'Jajja', '2025-10-20 12:30:31'),
	(24, 4, 5, 'Porno de enanitos', '2025-10-20 12:31:13'),
	(25, 5, 4, 'me gusta mucho', '2025-10-20 12:31:21'),
	(37, 4, 5, 'Hola', '2025-10-27 10:38:38'),
	(38, 4, 5, 'Me interesa el seat', '2025-10-27 10:38:57'),
	(39, 5, 4, 'Hola', '2025-10-27 10:40:07'),
	(40, 5, 4, 'Cuanto ofreces?', '2025-10-27 10:40:17'),
	(41, 4, 5, 'Hola', '2025-10-27 10:40:54'),
	(42, 4, 5, '1800€', '2025-10-27 10:41:01'),
	(43, 5, 4, 'Bro eres tonto o que?', '2025-10-27 10:41:18'),
	(44, 4, 6, 'Hola', '2025-10-27 11:46:03'),
	(45, 4, 6, 'Me interesa lo que vendes', '2025-10-27 11:46:10'),
	(46, 4, 5, 'Hola', '2025-10-28 08:25:03'),
	(47, 4, 5, 'todo bien?', '2025-10-28 08:25:09'),
	(48, 4, 5, 'Hola', '2025-10-28 09:38:37'),
	(49, 4, 5, 'Hola', '2025-10-28 09:49:53'),
	(50, 5, 5, 'Hola', '2025-10-28 10:02:40'),
	(51, 5, 4, 'hola', '2025-10-28 10:02:51'),
	(52, 4, 4, 'Hola', '2025-10-28 10:50:12'),
	(53, 4, 6, 'CALLA PUTITTA', '2025-10-29 12:12:40'),
	(54, 6, 5, 'Hola', '2025-10-30 08:28:21'),
	(55, 9, 6, 'Hola', '2025-11-02 22:24:32'),
	(56, 9, 6, 'Me interesa la cinta', '2025-11-02 22:24:55'),
	(57, 9, 6, 'Hola', '2025-11-02 22:29:14'),
	(58, 9, 6, 'Hola', '2025-11-02 22:33:08'),
	(59, 9, 5, 'Hola', '2025-11-02 22:36:05'),
	(60, 9, 5, 'Me interesa la ropa que vendes', '2025-11-02 22:36:11'),
	(61, 5, 9, 'Cuanto ofreces?', '2025-11-02 22:36:30'),
	(62, 6, 9, 'Cuanto me das?', '2025-11-02 22:37:02'),
	(63, 6, 9, 'Yo pido minumo 70', '2025-11-02 22:37:21');

-- Volcando estructura para tabla comercios_vitoria.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(500) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `tipo_usuario` enum('usuario','admin') NOT NULL DEFAULT 'usuario',
  `telefono` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla comercios_vitoria.usuarios: ~8 rows (aproximadamente)
DELETE FROM `usuarios`;
INSERT INTO `usuarios` (`id`, `user_name`, `password`, `nombre`, `apellidos`, `email`, `fecha_nacimiento`, `tipo_usuario`, `telefono`) VALUES
	(1, 'aaron', '$2y$10$318KFkjgRDVDWthPbPXiIO6tJ4MNwnjNkqnhKRCsSh8qm5Zc9LPlu', 'aaron', 'jimenez', 'a@gmail.com', '2006-08-11', 'admin', '676676767'),
	(2, 'imanol', '$2y$10$PXFEtPTe/7kNWdHlqEuQIOhl6k7ZaBfdkwB5BOUz3nn0YKJpEgnia', 'imanol', 'manero', 'i@gmail.com', '2006-02-28', 'admin', '909090909'),
	(3, 'unax', '$2y$10$3Q/KPey2r5wJtS9zuEgCpO2lF5Ogot3jOm3xriN6QeGPcYQlt3Sri', 'unax', 'iriondo', 'u@gmail.com', '2006-10-24', 'admin', '656565656'),
	(4, 'daniel', '$2y$10$318KFkjgRDVDWthPbPXiIO6tJ4MNwnjNkqnhKRCsSh8qm5Zc9LPlu', 'daniel', 'hernandez', 'danielher@gmail.com', '2006-08-11', 'usuario', '623456787'),
	(5, 'jaime', '$2y$10$PXFEtPTe/7kNWdHlqEuQIOhl6k7ZaBfdkwB5BOUz3nn0YKJpEgnia', 'jaime', 'barinagarrementeria', 'jaime@gmail.com', '2006-02-28', 'usuario', '642525252'),
	(6, 'jorge', '$2y$10$3Q/KPey2r5wJtS9zuEgCpO2lF5Ogot3jOm3xriN6QeGPcYQlt3Sri', 'jorge', 'emaldi', 'jorge@gmail.com', '2006-10-24', 'usuario', '678514352'),
	(8, 'kevin', '$2y$10$FaVc25xFifaSm80DY4MM/OOCcZuZG3Zc72FSIqHxVV.iSBBUcno7u', 'Kevin', 'Madero', 'kevin@hotmail.com', '2002-04-13', 'usuario', '778899663'),
	(9, 'ainhoa', '$2y$10$Uu2QzpFf78h1.Ikz4Q/vN.EsGl3tC0iXRsHX/3rJM6LYDyrlsU9W6', 'Ainhoa', 'Alvarez Curros', 'ainhoa@gmail.com', '2007-07-27', 'usuario', '696969696');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
