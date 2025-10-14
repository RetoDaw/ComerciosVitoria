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
  `id_categoria` int NOT NULL,
  `estado` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `titulo` (`titulo`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_categoria` (`id_categoria`),
  CONSTRAINT `anuncios_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `anuncios_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla comercios_vitoria.anuncios: ~3 rows (aproximadamente)
DELETE FROM `anuncios`;
INSERT INTO `anuncios` (`id`, `titulo`, `descripcion`, `direccion`, `precio`, `id_usuario`, `id_categoria`, `estado`) VALUES
	(1, 'iPhone 14 Pro 256GB', 'Vendo iPhone 14 Pro en perfecto estado, sin rayaduras y con caja original.', 'Calle Mayor 12, Madrid', 1050.00, 4, 1, 1),
	(2, 'Coche Seat Ibiza 2018', 'Seat Ibiza gasolina, 80.000 km, único dueño, revisiones al día.', 'Avenida Andalucía 45, Sevilla', 8500.00, 5, 2, 1),
	(3, 'Sofá de 3 plazas gris', 'Sofá cómodo de tela gris, 3 plazas, casi nuevo.', 'Calle Gran Vía 5, Valencia', 220.00, 6, 3, 1);

-- Volcando estructura para tabla comercios_vitoria.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla comercios_vitoria.categorias: ~3 rows (aproximadamente)
DELETE FROM `categorias`;
INSERT INTO `categorias` (`id`, `nombre`) VALUES
	(1, 'Tecnología'),
	(2, 'Vehículos'),
	(3, 'Hogar');

-- Volcando estructura para tabla comercios_vitoria.favoritos
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id_usuario` int NOT NULL,
  `id_anuncio` int NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_anuncio`),
  KEY `id_anuncio` (`id_anuncio`),
  CONSTRAINT `favoritos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `favoritos_ibfk_2` FOREIGN KEY (`id_anuncio`) REFERENCES `anuncios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla comercios_vitoria.favoritos: ~0 rows (aproximadamente)
DELETE FROM `favoritos`;

-- Volcando estructura para tabla comercios_vitoria.imagenes
CREATE TABLE IF NOT EXISTS `imagenes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_anuncio` int NOT NULL,
  `ruta` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_anuncio` (`id_anuncio`),
  CONSTRAINT `imagenes_ibfk_1` FOREIGN KEY (`id_anuncio`) REFERENCES `anuncios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla comercios_vitoria.imagenes: ~0 rows (aproximadamente)
DELETE FROM `imagenes`;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla comercios_vitoria.mensaje: ~0 rows (aproximadamente)
DELETE FROM `mensaje`;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla comercios_vitoria.usuarios: ~6 rows (aproximadamente)
DELETE FROM `usuarios`;
INSERT INTO `usuarios` (`id`, `user_name`, `password`, `nombre`, `apellidos`, `email`, `fecha_nacimiento`, `tipo_usuario`, `telefono`) VALUES
	(1, 'aaron', '$2y$10$318KFkjgRDVDWthPbPXiIO6tJ4MNwnjNkqnhKRCsSh8qm5Zc9LPlu', 'aaron', 'jimenez', 'a@gmail.com', '2006-08-11', 'admin', '676676767'),
	(2, 'imanol', '$2y$10$PXFEtPTe/7kNWdHlqEuQIOhl6k7ZaBfdkwB5BOUz3nn0YKJpEgnia', 'imanol', 'manero', 'i@gmail.com', '2006-02-28', 'admin', '909090909'),
	(3, 'unax', '$2y$10$3Q/KPey2r5wJtS9zuEgCpO2lF5Ogot3jOm3xriN6QeGPcYQlt3Sri', 'unax', 'iriondo', 'u@gmail.com', '2006-10-24', 'admin', '656565656'),
	(4, 'daniel', '$2y$10$318KFkjgRDVDWthPbPXiIO6tJ4MNwnjNkqnhKRCsSh8qm5Zc9LPlu', 'daniel', 'hernandez', 'daniel@gmail.com', '2006-08-11', 'usuario', '623323232'),
	(5, 'jaime', '$2y$10$PXFEtPTe/7kNWdHlqEuQIOhl6k7ZaBfdkwB5BOUz3nn0YKJpEgnia', 'jaime', 'barinagarrementeria', 'jaime@gmail.com', '2006-02-28', 'usuario', '642525252'),
	(6, 'jorge', '$2y$10$3Q/KPey2r5wJtS9zuEgCpO2lF5Ogot3jOm3xriN6QeGPcYQlt3Sri', 'jorge', 'emaldi', 'jorge@gmail.com', '2006-10-24', 'usuario', '678514352');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
