-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-07-2024 a las 04:50:14
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `torres_enrique_bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carritos`
--

CREATE TABLE `carritos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(6) UNSIGNED NOT NULL,
  `nombre` varchar(125) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `baja` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `created_at`, `updated_at`, `baja`) VALUES
(1, 'Agujas', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(2, 'Cartuchos', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(3, 'Grip', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(4, 'Libreria', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(5, 'Maquinas', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(6, 'Fuentes', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(7, 'Herramientas', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(8, 'Mobiliario', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(9, 'Electrónica', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(10, 'Descartables', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(11, 'Otros', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(12, 'Accesorios', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(13, 'Higiene', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(14, 'Iluminación', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(15, 'Merch', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(16, 'Insumos', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas`
--

CREATE TABLE `consultas` (
  `id` int(6) UNSIGNED NOT NULL,
  `usuario_id` int(6) UNSIGNED NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `leido` tinyint(1) NOT NULL DEFAULT 0,
  `baja` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

CREATE TABLE `contactos` (
  `id` int(6) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(125) NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `leido` tinyint(1) NOT NULL DEFAULT 0,
  `baja` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contactos`
--

INSERT INTO `contactos` (`id`, `nombre`, `email`, `asunto`, `mensaje`, `created_at`, `updated_at`, `leido`, `baja`) VALUES
(1, 'Fulanito', 'fulanito@gmail.com', 'Prueba de Contacto', 'Haciendo prueba de alta de contacto', '2024-06-09 08:54:20', '2024-06-09 08:54:20', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles`
--

CREATE TABLE `detalles` (
  `id` int(6) UNSIGNED NOT NULL,
  `orden_id` int(6) UNSIGNED NOT NULL,
  `producto_id` int(6) UNSIGNED NOT NULL,
  `cantidad` int(3) UNSIGNED NOT NULL,
  `precio_unitario` decimal(10,0) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id` int(6) UNSIGNED NOT NULL,
  `orden_id` int(6) UNSIGNED NOT NULL,
  `metodo_pago_id` tinyint(2) UNSIGNED NOT NULL,
  `nro_documento` varchar(10) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `total` decimal(10,0) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE `imagenes` (
  `id` int(5) UNSIGNED NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `extension` varchar(255) NOT NULL,
  `data` varchar(500) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `ruta` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `imagenes`
--

INSERT INTO `imagenes` (`id`, `imagen`, `extension`, `data`, `created_at`, `updated_at`, `ruta`, `nombre`) VALUES
(1, '2024-05-23 05:05:57', 'Pendiente', 'Pendiente', '2024-05-31 00:44:16', '2024-05-31 00:44:16', '', ''),
(2, '2024-05-23 05:05:58', 'Pendiente', 'Pendiente', '2024-05-31 00:44:16', '2024-05-31 00:44:16', '', ''),
(3, '2024-05-23 05:05:59', 'Pendiente', 'Pendiente', '2024-05-31 00:44:16', '2024-05-31 00:44:16', '', ''),
(4, '2024-05-23 05:06:00', 'Pendiente', 'Pendiente', '2024-05-31 00:44:16', '2024-05-31 00:44:16', '', ''),
(5, '2024-05-31 10:05:34', 'Pendiente', 'Pendiente', '2024-05-31 10:10:34', '2024-05-31 10:10:34', '', ''),
(6, '2024-05-31 10:05:37', 'Pendiente', 'Pendiente', '2024-05-31 10:28:37', '2024-05-31 10:28:37', '', ''),
(7, '2024-05-31 10:05:01', 'Pendiente', 'Pendiente', '2024-05-31 10:34:01', '2024-05-31 10:34:01', '', ''),
(8, '2024-05-31 10:05:27', 'Pendiente', 'Pendiente', '2024-05-31 10:34:27', '2024-05-31 10:34:27', '', ''),
(9, '2024-05-31 10:05:52', 'Pendiente', 'Pendiente', '2024-05-31 10:34:52', '2024-05-31 10:34:52', '', ''),
(10, '2024-05-31 10:05:10', 'Pendiente', 'Pendiente', '2024-05-31 10:35:10', '2024-05-31 10:35:10', '', ''),
(11, '2024-05-31 10:05:56', 'Pendiente', 'Pendiente', '2024-05-31 10:35:56', '2024-05-31 10:35:56', '', ''),
(12, '2024-05-31 10:05:22', 'Pendiente', 'Pendiente', '2024-05-31 10:36:22', '2024-05-31 10:36:22', '', ''),
(13, '2024-05-31 10:05:42', 'Pendiente', 'Pendiente', '2024-05-31 10:36:42', '2024-05-31 10:36:42', '', ''),
(14, '2024-05-31 10:05:12', 'Pendiente', 'Pendiente', '2024-05-31 10:37:12', '2024-05-31 10:37:12', '', ''),
(15, '2024-05-31 10:05:14', 'Pendiente', 'Pendiente', '2024-05-31 10:37:14', '2024-05-31 10:37:14', '', ''),
(16, '2024-05-31 10:05:19', 'Pendiente', 'Pendiente', '2024-05-31 10:37:19', '2024-05-31 10:37:19', '', ''),
(17, '2024-05-31 10:05:22', 'Pendiente', 'Pendiente', '2024-05-31 10:37:22', '2024-05-31 10:37:22', '', ''),
(18, '2024-05-31 10:05:53', 'Pendiente', 'Pendiente', '2024-05-31 10:37:53', '2024-05-31 10:37:53', '', ''),
(19, '2024-05-31 10:05:55', 'Pendiente', 'Pendiente', '2024-05-31 10:37:55', '2024-05-31 10:37:55', '', ''),
(20, '2024-05-31 10:05:58', 'Pendiente', 'Pendiente', '2024-05-31 10:37:58', '2024-05-31 10:37:58', '', ''),
(21, '2024-05-31 10:05:59', 'Pendiente', 'Pendiente', '2024-05-31 10:37:59', '2024-05-31 10:37:59', '', ''),
(22, '2024-05-31 10:05:04', 'Pendiente', 'Pendiente', '2024-05-31 10:38:04', '2024-05-31 10:38:04', '', ''),
(23, '2024-05-31 10:05:09', 'Pendiente', 'Pendiente', '2024-05-31 10:38:09', '2024-05-31 10:38:09', '', ''),
(24, '2024-05-31 10:05:11', 'Pendiente', 'Pendiente', '2024-05-31 10:38:11', '2024-05-31 10:38:11', '', ''),
(25, '2024-05-31 10:05:15', 'Pendiente', 'Pendiente', '2024-05-31 10:39:15', '2024-05-31 10:39:15', '', ''),
(26, '2024-05-31 10:05:22', 'Pendiente', 'Pendiente', '2024-05-31 10:39:22', '2024-05-31 10:39:22', '', ''),
(27, '2024-05-31 10:05:25', 'Pendiente', 'Pendiente', '2024-05-31 10:39:25', '2024-05-31 10:39:25', '', ''),
(28, '2024-05-31 10:05:35', 'Pendiente', 'Pendiente', '2024-05-31 10:39:35', '2024-05-31 10:39:35', '', ''),
(29, '2024-05-31 10:05:38', 'Pendiente', 'Pendiente', '2024-05-31 10:39:38', '2024-05-31 10:39:38', '', ''),
(30, '2024-05-31 10:05:39', 'Pendiente', 'Pendiente', '2024-05-31 10:39:39', '2024-05-31 10:39:39', '', ''),
(31, '2024-05-31 10:05:42', 'Pendiente', 'Pendiente', '2024-05-31 10:39:42', '2024-05-31 10:39:42', '', ''),
(32, '2024-05-31 10:05:49', 'Pendiente', 'Pendiente', '2024-05-31 10:39:49', '2024-05-31 10:39:49', '', ''),
(33, '2024-05-31 10:05:51', 'Pendiente', 'Pendiente', '2024-05-31 10:39:51', '2024-05-31 10:39:51', '', ''),
(34, '2024-05-31 10:05:52', 'Pendiente', 'Pendiente', '2024-05-31 10:39:52', '2024-05-31 10:39:52', '', ''),
(35, '2024-05-31 10:05:18', 'Pendiente', 'Pendiente', '2024-05-31 10:40:18', '2024-05-31 10:40:18', '', ''),
(36, '2024-05-31 10:05:21', 'Pendiente', 'Pendiente', '2024-05-31 10:40:21', '2024-05-31 10:40:21', '', ''),
(37, '2024-05-31 10:05:37', 'Pendiente', 'Pendiente', '2024-05-31 10:40:37', '2024-05-31 10:40:37', '', ''),
(38, '2024-05-31 10:05:40', 'Pendiente', 'Pendiente', '2024-05-31 10:40:40', '2024-05-31 10:40:40', '', ''),
(39, '2024-05-31 10:05:45', 'Pendiente', 'Pendiente', '2024-05-31 10:40:45', '2024-05-31 10:40:45', '', ''),
(40, '2024-05-31 10:05:48', 'Pendiente', 'Pendiente', '2024-05-31 10:40:48', '2024-05-31 10:40:48', '', ''),
(41, '2024-05-31 10:05:29', 'Pendiente', 'Pendiente', '2024-05-31 10:41:29', '2024-05-31 10:41:29', '', ''),
(42, '2024-05-31 10:05:35', 'Pendiente', 'Pendiente', '2024-05-31 10:41:35', '2024-05-31 10:41:35', '', ''),
(43, '2024-05-31 10:05:02', 'Pendiente', 'Pendiente', '2024-05-31 10:42:02', '2024-05-31 10:42:02', '', ''),
(44, '2024-05-31 10:05:10', 'Pendiente', 'Pendiente', '2024-05-31 10:42:10', '2024-05-31 10:42:10', '', ''),
(45, '2024-05-31 10:05:12', 'Pendiente', 'Pendiente', '2024-05-31 10:43:12', '2024-05-31 10:43:12', '', ''),
(46, '2024-05-31 10:05:14', 'Pendiente', 'Pendiente', '2024-05-31 10:43:14', '2024-05-31 10:43:14', '', ''),
(47, '2024-05-31 10:05:21', 'Pendiente', 'Pendiente', '2024-05-31 10:43:21', '2024-05-31 10:43:21', '', ''),
(48, '2024-05-31 10:05:39', 'Pendiente', 'Pendiente', '2024-05-31 10:43:39', '2024-05-31 10:43:39', '', ''),
(49, '2024-05-31 10:05:04', 'Pendiente', 'Pendiente', '2024-05-31 10:44:04', '2024-05-31 10:44:04', '', ''),
(50, '2024-05-31 10:05:20', 'Pendiente', 'Pendiente', '2024-05-31 10:44:20', '2024-05-31 10:44:20', '', ''),
(51, '2024-05-31 10:05:23', 'Pendiente', 'Pendiente', '2024-05-31 10:44:23', '2024-05-31 10:44:23', '', ''),
(52, '2024-05-31 10:05:27', 'Pendiente', 'Pendiente', '2024-05-31 10:44:27', '2024-05-31 10:44:27', '', ''),
(53, '2024-05-31 10:05:42', 'Pendiente', 'Pendiente', '2024-05-31 10:44:42', '2024-05-31 10:44:42', '', ''),
(54, '2024-05-31 10:05:44', 'Pendiente', 'Pendiente', '2024-05-31 10:44:44', '2024-05-31 10:44:44', '', ''),
(55, '2024-05-31 10:05:46', 'Pendiente', 'Pendiente', '2024-05-31 10:44:46', '2024-05-31 10:44:46', '', ''),
(56, '2024-05-31 10:05:50', 'Pendiente', 'Pendiente', '2024-05-31 10:44:50', '2024-05-31 10:44:50', '', ''),
(57, '2024-05-31 10:05:59', 'Pendiente', 'Pendiente', '2024-05-31 10:44:59', '2024-05-31 10:44:59', '', ''),
(58, '2024-05-31 10:05:15', 'Pendiente', 'Pendiente', '2024-05-31 10:45:15', '2024-05-31 10:45:15', '', ''),
(59, '2024-05-31 10:05:09', 'Pendiente', 'Pendiente', '2024-05-31 10:46:09', '2024-05-31 10:46:09', '', ''),
(60, '2024-05-31 10:05:35', 'Pendiente', 'Pendiente', '2024-05-31 10:46:35', '2024-05-31 10:46:35', '', ''),
(61, '2024-05-31 10:05:47', 'Pendiente', 'Pendiente', '2024-05-31 10:46:47', '2024-05-31 10:46:47', '', ''),
(62, '2024-05-31 10:05:13', 'Pendiente', 'Pendiente', '2024-05-31 10:47:13', '2024-05-31 10:47:13', '', ''),
(63, '2024-05-31 10:05:15', 'Pendiente', 'Pendiente', '2024-05-31 10:47:15', '2024-05-31 10:47:15', '', ''),
(64, '2024-05-31 10:05:16', 'Pendiente', 'Pendiente', '2024-05-31 10:47:16', '2024-05-31 10:47:16', '', ''),
(65, '2024-05-31 10:05:19', 'Pendiente', 'Pendiente', '2024-05-31 10:47:19', '2024-05-31 10:47:19', '', ''),
(66, '2024-05-31 10:05:22', 'Pendiente', 'Pendiente', '2024-05-31 10:47:22', '2024-05-31 10:47:22', '', ''),
(67, '2024-05-31 10:05:24', 'Pendiente', 'Pendiente', '2024-05-31 10:47:24', '2024-05-31 10:47:24', '', ''),
(68, '2024-05-31 10:05:35', 'Pendiente', 'Pendiente', '2024-05-31 10:47:35', '2024-05-31 10:47:35', '', ''),
(69, '2024-05-31 10:05:38', 'Pendiente', 'Pendiente', '2024-05-31 10:47:38', '2024-05-31 10:47:38', '', ''),
(70, '2024-05-31 10:05:40', 'Pendiente', 'Pendiente', '2024-05-31 10:47:40', '2024-05-31 10:47:40', '', ''),
(71, '2024-05-31 10:05:46', 'Pendiente', 'Pendiente', '2024-05-31 10:47:46', '2024-05-31 10:47:46', '', ''),
(72, '2024-05-31 10:05:47', 'Pendiente', 'Pendiente', '2024-05-31 10:47:47', '2024-05-31 10:47:47', '', ''),
(73, '2024-05-31 10:05:51', 'Pendiente', 'Pendiente', '2024-05-31 10:47:51', '2024-05-31 10:47:51', '', ''),
(74, '2024-05-31 10:05:53', 'Pendiente', 'Pendiente', '2024-05-31 10:47:53', '2024-05-31 10:47:53', '', ''),
(75, '2024-05-31 10:05:59', 'Pendiente', 'Pendiente', '2024-05-31 10:47:59', '2024-05-31 10:47:59', '', ''),
(76, '2024-05-31 10:05:19', 'Pendiente', 'Pendiente', '2024-05-31 10:48:19', '2024-05-31 10:48:19', '', ''),
(77, '2024-05-31 10:05:55', 'Pendiente', 'Pendiente', '2024-05-31 10:56:55', '2024-05-31 10:56:55', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` int(6) UNSIGNED NOT NULL,
  `nombre` varchar(125) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `baja` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id`, `nombre`, `created_at`, `updated_at`, `baja`) VALUES
(1, 'Royal Ak', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(2, 'Kwadron', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(3, 'Revo', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(4, 'Lance', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(5, 'Emalla', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(6, 'EZ', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(7, 'Cheyenne', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(8, 'Solid Ink', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(9, 'Star Ink', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(10, 'Dynamic Ink', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(11, 'Nocturnal Ink', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(12, 'Panthera Ink', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(13, 'Eclipse Tattoo Ink', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(14, 'Vice', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(15, 'Tones', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(16, 'World Famous Ink', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(17, 'Klug Ink', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(18, 'FK Irons', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(19, 'Jconly', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(20, 'Pepax', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(21, 'Bronc', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(22, 'AVA', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(23, 'INKONE', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(24, 'Divine', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(25, 'Thunderlord', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(26, 'Genérica', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(27, 'Hurricane', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(28, 'Musotoku', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(29, 'Eikon', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(30, 'Sergio García', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(31, 'Ruski', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(32, 'Critical', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(33, 'EvoTech', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(34, 'Némesis', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(35, 'Ultra Premium', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(36, 'Hawk', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(37, 'King Power', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(38, 'Power Plant', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(39, 'Cosmos', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(40, 'Hummingbird', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(41, 'ELITE', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(42, 'Art Driver', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(43, 'Mast', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(44, 'Believa', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(45, 'Spirit', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(46, 'Easy Tattoo', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(47, 'Biotatum', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(48, 'INKDRAW', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(49, 'Hornet', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(50, 'Aloe Tattoo', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(51, 'Tears', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(52, 'Tattoo Cream', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(53, 'Espadol', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(54, 'Mieauty', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(55, 'HP', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(56, 'Epson', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(57, 'Samsung', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(58, 'Apple', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(59, 'Sharpie', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(60, 'Brother', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(61, 'Unistar', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos_pago`
--

CREATE TABLE `metodos_pago` (
  `id` tinyint(2) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `otros_detalles` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(375, '2024-02-13-175626', 'App\\Database\\Migrations\\Categorias', 'default', 'App', 1717116253, 1),
(376, '2024-02-13-183953', 'App\\Database\\Migrations\\Marcas', 'default', 'App', 1717116253, 1),
(377, '2024-02-13-184731', 'App\\Database\\Migrations\\Roles', 'default', 'App', 1717116253, 1),
(378, '2024-02-13-190058', 'App\\Database\\Migrations\\MetodosDePago', 'default', 'App', 1717116253, 1),
(379, '2024-02-13-190936', 'App\\Database\\Migrations\\Subcategorias', 'default', 'App', 1717116253, 1),
(380, '2024-02-13-194120', 'App\\Database\\Migrations\\Contactos', 'default', 'App', 1717116253, 1),
(381, '2024-02-13-201051', 'App\\Database\\Migrations\\Usuarios', 'default', 'App', 1717116253, 1),
(382, '2024-02-13-202802', 'App\\Database\\Migrations\\Consultas', 'default', 'App', 1717116253, 1),
(383, '2024-02-13-203638', 'App\\Database\\Migrations\\Productos', 'default', 'App', 1717116253, 1),
(384, '2024-02-13-210505', 'App\\Database\\Migrations\\Ordenes', 'default', 'App', 1717116253, 1),
(385, '2024-02-13-211753', 'App\\Database\\Migrations\\Detalles', 'default', 'App', 1717116253, 1),
(386, '2024-02-13-212751', 'App\\Database\\Migrations\\Facturas', 'default', 'App', 1717116253, 1),
(387, '2024-05-23-011831', 'App\\Database\\Migrations\\Imagenes', 'default', 'App', 1717116253, 1),
(388, '2024-05-23-013603', 'App\\Database\\Migrations\\ProductoImagen', 'default', 'App', 1717116253, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

CREATE TABLE `ordenes` (
  `id` int(6) UNSIGNED NOT NULL,
  `usuario_id` int(6) UNSIGNED NOT NULL,
  `estado` enum('CONFIRMADA','PENDIENTE','CANCELADA') NOT NULL DEFAULT 'PENDIENTE',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `baja` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(6) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(12,2) UNSIGNED NOT NULL,
  `stock` int(6) UNSIGNED NOT NULL,
  `marca_id` int(6) UNSIGNED NOT NULL,
  `subcategoria_id` int(6) UNSIGNED NOT NULL,
  `presentacion` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `baja` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `stock`, `marca_id`, `subcategoria_id`, `presentacion`, `created_at`, `updated_at`, `baja`) VALUES
(1, 'Algo', 'Algo', 14721.37, 10, 7, 7, '10 unidades', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(2, 'Otra Cosa', 'Otra Cosa', 52782.54, 20, 10, 90, '20 oz.', '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(3, 'Probando', 'Prueba 3. Para implementar grids', 80.00, 10, 6, 76, 'texto', '2024-07-24 21:30:25', '2024-07-24 21:30:32', 0),
(4, 'Otra Cosa Mariposa', 'parte de la prueba 2 para probar grids', 999.00, 99, 22, 72, 'numero', '2024-07-24 21:30:36', '2024-07-24 21:30:38', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_imagen`
--

CREATE TABLE `producto_imagen` (
  `producto_id` int(6) UNSIGNED NOT NULL,
  `imagen_id` int(5) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto_imagen`
--

INSERT INTO `producto_imagen` (`producto_id`, `imagen_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-05-31 00:44:16', '2024-05-31 00:44:16'),
(1, 2, '2024-05-31 00:44:16', '2024-05-31 00:44:16'),
(2, 3, '2024-05-31 00:44:16', '2024-05-31 00:44:16'),
(2, 4, '2024-05-31 00:44:16', '2024-05-31 00:44:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` tinyint(2) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'Admin'),
(2, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategorias`
--

CREATE TABLE `subcategorias` (
  `id` int(6) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `categoria_id` int(6) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `baja` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `subcategorias`
--

INSERT INTO `subcategorias` (`id`, `nombre`, `categoria_id`, `created_at`, `updated_at`, `baja`) VALUES
(1, 'Round Liner', 1, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(2, 'Magnum', 1, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(3, 'Magnum Curved', 1, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(4, 'Round Shader', 1, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(5, 'Flat', 1, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(6, 'Magnum M', 1, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(7, 'Round Liner', 2, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(8, 'Magnum', 2, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(9, 'Magnum Curved', 2, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(10, 'Round Shader', 2, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(11, 'Flat', 2, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(12, 'Magnum M', 2, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(13, 'Grip Aluminio', 3, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(14, 'Grip Descartable', 3, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(15, 'Grip Acero Inoxidable', 3, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(16, 'Papel Hectografico', 4, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(17, 'Marcadores', 4, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(18, 'Cinta Adhesiva', 4, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(19, 'Cinta de Papel', 4, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(20, 'Resma A4', 4, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(21, 'Lapiceras', 4, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(22, 'Lapices', 4, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(23, 'Borradores', 4, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(24, 'Tejeras', 4, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(25, 'Cutter', 4, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(26, 'Reglas', 4, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(27, 'Escuadras', 4, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(28, 'Maquinas de Bobina', 5, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(29, 'Maquinas Rotativas', 5, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(30, 'Maquinas Pen', 5, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(31, 'Maquinas Neumáticas', 5, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(32, 'Fuentes Analógicas', 6, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(33, 'Maquinas Digital', 6, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(34, 'Maquinas Inalámbricas', 6, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(35, 'Llaves Allen', 7, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(36, 'Destornilladores', 7, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(37, 'Juego de Destornilladores', 7, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(38, 'Alicate de Corte', 7, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(39, 'Pinza Alicate', 7, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(40, 'Set Kit Pinzas', 7, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(41, 'Kit Herramienta de Presicion', 7, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(42, 'Cintas Metricas', 7, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(43, 'Estufa De Esterilización', 7, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(44, 'Camillas', 8, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(45, 'Sillones', 8, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(46, 'Sillas de Escritorio', 8, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(47, 'Taburetes', 8, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(48, 'Apoya Brazos', 8, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(49, 'Escritorios', 8, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(50, 'Sillas', 8, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(51, 'Mesas de Trabajo', 8, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(52, 'Estantes', 8, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(53, 'Bibliotecas Estanterias', 8, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(54, 'Bancos', 8, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(55, 'Organizador de Herramientas', 8, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(56, 'Carro Gabinete', 8, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(57, 'Organizardor Tablero', 8, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(58, 'Impresoras', 9, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(59, 'Impresoras termicas', 9, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(60, 'Notebooks', 9, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(61, 'Tablets', 9, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(62, 'Tabletas Gráficas', 9, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(63, 'Smart TV', 9, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(64, 'Home Theater', 9, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(65, 'Microcomponente', 9, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(66, 'Servilletas', 10, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(67, 'Film Transparente', 10, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(68, 'Cubre Máquina', 10, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(69, 'Cubre Clipcord', 10, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(70, 'Descartador de Agujas', 10, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(71, 'Bajalenguas', 10, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(72, 'Cinta Flex', 10, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(73, 'Tetinas', 10, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(74, 'Niples', 10, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(75, 'Banditas Elasticas', 10, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(76, 'Dosificador Box', 11, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(77, 'Flejes Maquinas', 11, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(78, 'Plugs Swich', 11, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(79, 'Cables RCA', 12, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(80, 'Clips Cord', 12, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(81, 'Baterias', 12, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(82, 'Jabon Liquido Desinfectante', 13, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(83, 'Jabones', 13, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(84, 'Lamparas de Pie', 14, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(85, 'Remeras', 15, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(86, 'Gorras', 15, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(87, 'Buzos', 15, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(88, 'Baselina', 16, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(89, 'Witch Hazel', 16, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0),
(90, 'Pigmentos', 16, '2024-05-31 00:44:16', '2024-05-31 00:44:16', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(6) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `email` varchar(125) NOT NULL,
  `password` varchar(255) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `rol_id` tinyint(2) UNSIGNED NOT NULL DEFAULT 2,
  `baja` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `password`, `direccion`, `telefono`, `created_at`, `updated_at`, `rol_id`, `baja`) VALUES
(1, 'Enrique', 'Torres', 'enriquetorres@gmail.com', '$2y$10$5QmNuLDiBqrMCRV37Cal/.C4LzE7bUU/KEHpsIXnZZPz5rSvW85WS', 'Las teresitas 5630', '3794406775', '2024-05-31 06:46:23', '2024-05-31 06:46:23', 2, 0),
(2, 'Tamara', 'Rosales', 'tamararosales@gmail.com', '$2y$10$PouhO8zk019Alzxuny3.buuUagZVgovyr8IAh7nF1ainMdxobtMji', 'Los lirios 554', '3784211509', '2024-05-31 06:48:17', '2024-05-31 06:48:17', 2, 0),
(3, 'Jose', 'Juarez', 'pepejua@hotmail.com', '$2y$10$f3u0l.4mDAoY2lSXUwt6auh6hU.VOgtlq1M0Cyqh.w54hkKz0fiXG', 'Av Frondizi 398', '44589560', '2024-05-31 06:52:35', '2024-05-31 06:52:35', 2, 0),
(4, 'Romina', 'Bernasconi', 'bernasconiroo@outlook.com.ar', '$2y$10$wkq9WKuWLkJfwM2rNTa0lO9ZMiYuuRCa1l8mr7pe99FPxy9xVYjGS', 'Chaco 1287', '1135679002', '2024-05-31 06:56:40', '2024-05-31 06:56:40', 2, 0),
(5, 'Usuario Admin', 'Administrador', 'admin@gmail.com', '$2y$10$lsS8UvRpP3Ez16TSLe9hK.zYak0J5i6bsY2axzYsBOhRwYiH0YvMK', 'Los administradores 999', '99999999', '2024-05-31 06:59:25', '2024-05-31 06:59:25', 1, 0),
(6, 'Matias', 'Recalde', 'matiasrecalde@gmail.com', '$2y$10$QbDPI.7mRhzFKgoNneQZUeGeZcyBQOcEG.fxwkb2bM66usu7B94WO', 'Los Alamos 533', '118902121789', '2024-07-23 23:55:17', '2024-07-23 23:55:17', 2, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_consultas_usuarios` (`usuario_id`);

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalles`
--
ALTER TABLE `detalles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detalles_ordenes` (`orden_id`),
  ADD KEY `fk_detalles_productos` (`producto_id`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_facturas_ordenes` (`orden_id`),
  ADD KEY `fk_facturas_metodosPago` (`metodo_pago_id`);

--
-- Indices de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ordenes_usuarios` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_productos_marcas` (`marca_id`),
  ADD KEY `fk_productos_subcategorias` (`subcategoria_id`);

--
-- Indices de la tabla `producto_imagen`
--
ALTER TABLE `producto_imagen`
  ADD KEY `producto_imagen_producto_id_foreign` (`producto_id`),
  ADD KEY `producto_imagen_imagen_id_foreign` (`imagen_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_subcategoria_categoria` (`categoria_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_usuarios_roles` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalles`
--
ALTER TABLE `detalles`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  MODIFY `id` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=389;

--
-- AUTO_INCREMENT de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD CONSTRAINT `fk_consultas_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalles`
--
ALTER TABLE `detalles`
  ADD CONSTRAINT `fk_detalles_ordenes` FOREIGN KEY (`orden_id`) REFERENCES `ordenes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detalles_productos` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `fk_facturas_metodosPago` FOREIGN KEY (`metodo_pago_id`) REFERENCES `metodos_pago` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_facturas_ordenes` FOREIGN KEY (`orden_id`) REFERENCES `ordenes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD CONSTRAINT `fk_ordenes_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_marcas` FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_productos_subcategorias` FOREIGN KEY (`subcategoria_id`) REFERENCES `subcategorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto_imagen`
--
ALTER TABLE `producto_imagen`
  ADD CONSTRAINT `producto_imagen_imagen_id_foreign` FOREIGN KEY (`imagen_id`) REFERENCES `imagenes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_imagen_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD CONSTRAINT `fk_subcategoria_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
