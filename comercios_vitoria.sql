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
  `titulo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `descripcion` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `telefono_contacto` int NOT NULL,
  `email_contacto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `carpeta_imagen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_usuario` int DEFAULT NULL,
  `id_categoria` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `titulo` (`titulo`) USING BTREE,
  KEY `id_usuario` (`id_usuario`) USING BTREE,
  KEY `id_categoria` (`id_categoria`) USING BTREE,
  CONSTRAINT `anuncios_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `anuncios_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`),
  CONSTRAINT `ck_des_low` CHECK ((`descripcion` = lower(`descripcion`))),
  CONSTRAINT `ck_dir_low` CHECK ((`direccion` = lower(`direccion`))),
  CONSTRAINT `ck_ema_low_anu` CHECK ((`email_contacto` = lower(`email_contacto`))),
  CONSTRAINT `ck_tit_low` CHECK ((`titulo` = lower(`titulo`)))
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla comercios_vitoria.anuncios: ~3 rows (aproximadamente)
DELETE FROM `anuncios`;
INSERT INTO `anuncios` (`id`, `titulo`, `descripcion`, `telefono_contacto`, `email_contacto`, `direccion`, `carpeta_imagen`, `id_usuario`, `id_categoria`) VALUES
	(5, 'tienda de mascotas', 'tienda de mascotas donde adoptar animasles no exoticos', 676676767, 'a@gmail.com', 'C/ Madrid 4, Bajo A', 'C:/laragon/www/proyecto/imagenes/1', 1, 2),
	(6, 'tienda de informatica', 'tienda de informatica para comprar de todo', 676676767, 'a@gmail.com', 'C/ Avenida Gasteiz 8, Bajo A', 'C:/laragon/www/proyecto/imagenes/2', 1, 1),
	(7, 'tienda de construccion', 'tienda de construccion, reforma tu casa en poco tiempo', 909090909, 'i@gmail.com', 'C/ Dato 18, 4 D', 'C:/laragon/www/proyecto/imagenes/3', 2, 4);

-- Volcando estructura para tabla comercios_vitoria.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla comercios_vitoria.categorias: ~0 rows (aproximadamente)
DELETE FROM `categorias`;
INSERT INTO `categorias` (`id`, `nombre`) VALUES
	(1, 'informatica'),
	(2, 'deporte'),
	(3, 'electricidad'),
	(4, 'reformas'),
	(5, 'ropa'),
	(6, 'educacion');

-- Volcando estructura para tabla comercios_vitoria.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(500) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` int DEFAULT NULL,
  `tipo_usuario` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name` (`user_name`),
  CONSTRAINT `ck_ape_low` CHECK ((`apellidos` = lower(`apellidos`))),
  CONSTRAINT `ck_ema_low` CHECK ((`email` = lower(`email`))),
  CONSTRAINT `ck_nom_low` CHECK ((`nombre` = lower(`nombre`))),
  CONSTRAINT `ck_tuser` CHECK (((`tipo_usuario` = _utf8mb4'c') or (`tipo_usuario` = _utf8mb4'v'))),
  CONSTRAINT `ck_usnm_low` CHECK ((`user_name` = lower(`user_name`)))
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla comercios_vitoria.usuarios: ~0 rows (aproximadamente)
DELETE FROM `usuarios`;
INSERT INTO `usuarios` (`id`, `user_name`, `password`, `nombre`, `apellidos`, `email`, `telefono`, `tipo_usuario`) VALUES
	(1, 'aaron', '$2y$10$318KFkjgRDVDWthPbPXiIO6tJ4MNwnjNkqnhKRCsSh8qm5Zc9LPlu', 'aaron', 'jimenez', 'a@gmail.com', 676676767, 'c'),
	(2, 'imanol', '$2y$10$PXFEtPTe/7kNWdHlqEuQIOhl6k7ZaBfdkwB5BOUz3nn0YKJpEgnia', 'imanol', 'manero', 'i@gmail.com', 909090909, 'c'),
	(3, 'unax', '$2y$10$3Q/KPey2r5wJtS9zuEgCpO2lF5Ogot3jOm3xriN6QeGPcYQlt3Sri', 'unax', 'iriondo', 'u@gmail.com', 656565656, 'v');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
