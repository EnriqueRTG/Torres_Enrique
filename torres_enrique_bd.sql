-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-02-2025 a las 18:28:25
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
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Máquinas de Tatuar', '', 'activo', '2025-02-21 01:29:28', '2025-02-22 18:40:25'),
(2, 'Tintas para Tatuajes', NULL, 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(3, 'Agujas y Cartuchos', NULL, 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(4, 'Fuentes de Poder', NULL, 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(5, 'Mobiliario y Accesorios', NULL, 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(6, 'Cuidado y Sanitización', NULL, 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(7, 'Transferencia y Diseño', NULL, 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(8, 'Práctica y Aprendizaje', NULL, 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(9, 'Merchandising', NULL, 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(10, 'Otros', 'null', 'activo', '2025-02-21 01:29:28', '2025-02-21 13:15:26'),
(11, 'Probando', '', 'inactivo', '2025-02-21 13:11:49', '2025-02-21 13:15:29'),
(12, 'Categoria de Prueba', '', 'activo', '2025-02-22 18:40:13', '2025-02-24 03:04:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conversaciones`
--

CREATE TABLE `conversaciones` (
  `id` int(11) UNSIGNED NOT NULL,
  `usuario_id` int(11) UNSIGNED DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `tipo_conversacion` enum('consulta','contacto') NOT NULL DEFAULT 'consulta',
  `estado` enum('abierta','cerrada') NOT NULL DEFAULT 'abierta',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `conversaciones`
--

INSERT INTO `conversaciones` (`id`, `usuario_id`, `nombre`, `email`, `asunto`, `tipo_conversacion`, `estado`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Cullen Hand', 'senger.alicia@example.com', 'Totam assumenda id', 'contacto', 'cerrada', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(2, NULL, 'Ms. Kathleen Miller DVM', 'maude.pfannerstill@example.com', 'Consequatur nisi voluptatum', 'contacto', 'cerrada', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(3, NULL, 'Rosamond Murray', 'franecki.austen@example.org', 'Dolor id eveniet', 'contacto', 'cerrada', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(4, NULL, 'Prof. Alexzander Swaniawski', 'vwilkinson@example.net', 'Est rerum quo', 'contacto', 'cerrada', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(5, NULL, 'Carolyn Hyatt', 'sigurd.walsh@example.com', 'Sunt inventore aut', 'contacto', 'cerrada', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(6, NULL, 'Jeanne Steuber III', 'morris.bernhard@example.com', 'Nemo qui fuga', 'contacto', 'abierta', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(7, NULL, 'Dayna Stehr DDS', 'hhomenick@example.com', 'Tempora suscipit minima', 'contacto', 'abierta', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(8, NULL, 'Kaya Rohan', 'jackson.denesik@example.net', 'Cum officia sunt', 'contacto', 'abierta', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(9, NULL, 'Ernestina Huels I', 'rosenbaum.karley@example.org', 'Recusandae nemo ullam', 'contacto', 'abierta', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(10, NULL, 'Prof. Keith Crona', 'corkery.joannie@example.net', 'Laudantium non reprehenderit', 'contacto', 'abierta', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(11, 7, 'Felix Stracke', 'eliseo30@example.com', 'In aut quo', 'consulta', 'abierta', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(12, 20, 'Jaylan Wyman', 'stamm.price@example.com', 'Optio iste sint', 'consulta', 'abierta', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(13, 20, 'Esperanza Olson', 'philip74@example.org', 'Distinctio consequatur accusantium', 'consulta', 'abierta', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(14, 6, 'Myrtie Kris', 'nichole.boyer@example.com', 'Illo consequuntur tempore', 'consulta', 'abierta', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(15, 13, 'Mrs. Gladys Harvey V', 'kulas.elwin@example.net', 'Hic fuga quis', 'consulta', 'abierta', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(16, 2, 'Mr. Clint Welch', 'bstark@example.com', 'Qui maiores rerum', 'consulta', 'abierta', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(17, 2, 'Hester Schoen', 'isai99@example.com', 'Debitis id animi', 'consulta', 'abierta', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(18, 10, 'Dr. Avis Kling', 'kaleb73@example.org', 'Ab modi nobis', 'consulta', 'abierta', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(19, 11, 'Hoyt Orn', 'gschumm@example.org', 'Neque nihil quidem', 'consulta', 'abierta', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(20, 2, 'Harrison Franecki I', 'luciano.ruecker@example.net', 'Ea ratione in', 'consulta', 'abierta', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(21, NULL, 'Enrique Ramon', 'enriqueramontg@gmail.com', 'Probado', 'contacto', 'cerrada', '2025-02-21 01:44:12', '2025-02-21 01:55:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_orden`
--

CREATE TABLE `detalle_orden` (
  `id` int(11) UNSIGNED NOT NULL,
  `orden_id` int(11) UNSIGNED NOT NULL,
  `producto_id` int(11) UNSIGNED NOT NULL,
  `cantidad` int(11) UNSIGNED NOT NULL,
  `precio_unitario` decimal(10,2) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `id` int(11) UNSIGNED NOT NULL,
  `usuario_id` int(11) UNSIGNED NOT NULL,
  `nombre_destinatario` varchar(255) NOT NULL,
  `calle` varchar(255) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `piso` varchar(10) DEFAULT NULL,
  `departamento` varchar(10) DEFAULT NULL,
  `ciudad` varchar(255) NOT NULL,
  `provincia` varchar(255) NOT NULL,
  `codigo_postal` varchar(50) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `direcciones`
--

INSERT INTO `direcciones` (`id`, `usuario_id`, `nombre_destinatario`, `calle`, `numero`, `piso`, `departamento`, `ciudad`, `provincia`, `codigo_postal`, `telefono`, `created_at`, `updated_at`) VALUES
(1, 8, 'Aubrey Heaney PhD', 'Cristobal Rest', '2926', '7', 'y', 'Nataliaberg', 'Kansas', '44951', '+1.609.791.2823', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(2, 8, 'Jess Pfannerstill', 'Freddie Park', '2572', '3', NULL, 'West Nedra', 'Indiana', '65082', '(386) 316-2729', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(3, 9, 'Herta Kuhlman', 'Kovacek Place', '1040', NULL, 'n', 'Trompfort', 'Idaho', '82258-2642', '831.795.8067', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(4, 1, 'Rahul Pfannerstill', 'Auer Lights', '855', NULL, 'z', 'Port Hunter', 'Arizona', '78226-8872', '660.449.9383', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(5, 4, 'Halie O\'Kon', 'Elena Camp', '2355', '10', NULL, 'West Dayanahaven', 'Tennessee', '94253-4709', '+1.863.710.7909', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(6, 11, 'Freeda Gislason', 'Sammie Mission', '1381', NULL, 'v', 'East Ambrosemouth', 'West Virginia', '34577-7571', '(315) 683-0921', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(7, 2, 'Holden Larkin', 'Oran Lodge', '1375', NULL, 'y', 'New Bettybury', 'North Carolina', '78666', '541.744.7200', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(8, 17, 'Rebeka Dibbert', 'Hahn Vista', '1225', '2', 'z', 'Haneport', 'New Hampshire', '80688', '(619) 492-8168', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(9, 9, 'Louvenia Gusikowski', 'Mohr Mission', '1079', '5', NULL, 'Ryanland', 'Idaho', '24173-5650', '657-419-0098', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(10, 18, 'Prof. Marley Rath', 'Clare Isle', '1089', '10', NULL, 'Xavierview', 'Louisiana', '55186', '+15852777688', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(11, 4, 'Toney Hermiston', 'Parker Mews', '568', NULL, NULL, 'West Craigfort', 'Idaho', '91183-2894', '1-864-617-5153', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(12, 2, 'Jayme Witting PhD', 'Nelson Fork', '928', NULL, 'a', 'South Sabrinamouth', 'Tennessee', '90042-2092', '+1 (937) 776-1369', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(13, 16, 'Eli Kozey', 'Nader Rapid', '2301', '4', 'v', 'Duncanshire', 'Florida', '96390', '+1-716-388-1560', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(14, 1, 'Tyrel Bernhard', 'Marquardt Dale', '1655', '3', 'd', 'Stiedemannborough', 'New York', '87442-9187', '+1-256-838-1395', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(15, 18, 'Marlen Reichert', 'Marks Parkways', '349', '3', 'b', 'South Daniela', 'Connecticut', '25605', '1-585-770-5962', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(16, 8, 'Arne Barton', 'Predovic Parkway', '1049', NULL, 'v', 'Lake Caleside', 'Vermont', '31080-4886', '+1 (718) 872-5588', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(17, 11, 'Shayna Grady', 'Francis Mill', '963', NULL, NULL, 'North Mariahfort', 'Connecticut', '32445-2158', '619.562.3849', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(18, 9, 'Ansley Kovacek', 'Botsford Locks', '1097', '5', NULL, 'South Baron', 'Montana', '07925', '+13415144817', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(19, 2, 'Rocky Willms', 'Sipes Haven', '343', NULL, 'm', 'Port Trycia', 'Vermont', '62966', '606-556-0553', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(20, 12, 'Mr. Kieran Kohler PhD', 'Faustino Extensions', '2015', '3', 'n', 'Deborahmouth', 'Hawaii', '35087-7106', '(435) 999-1326', '2025-02-21 01:29:29', '2025-02-21 01:29:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_productos`
--

CREATE TABLE `imagenes_productos` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `producto_id` int(11) UNSIGNED NOT NULL,
  `ruta_imagen` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `imagenes_productos`
--

INSERT INTO `imagenes_productos` (`id`, `nombre`, `producto_id`, `ruta_imagen`, `created_at`, `updated_at`) VALUES
(1, 'Agujas 1', 1, '/uploads/productos/agujas-1.png', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(2, 'Agujas 2', 2, '/uploads/productos/agujas-2.png', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(3, 'Agujas 3', 3, '/uploads/productos/agujas-3.png', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(4, 'Cartuchos 1', 4, '/uploads/productos/cartuchos-1.png', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(5, 'Cartuchos 2', 5, '/uploads/productos/cartuchos-2.png', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(6, 'Cartuchos 3', 6, '/uploads/productos/cartuchos-3.png', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(7, 'Descartador', 7, '/uploads/productos/descartador.png', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(8, 'Fuente', 8, '/uploads/productos/fuente.png', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(9, 'Llave', 9, '/uploads/productos/llave.png', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(10, 'Maquina 1', 10, '/uploads/productos/maquina-1.png', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(11, 'Maquina 1 a', 10, '/uploads/productos/maquina-1-a.png', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(12, 'Maquina 2', 11, '/uploads/productos/maquina-2.png', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(13, 'Maquina 3', 12, '/uploads/productos/maquina-3.png', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(14, 'Maquina 4', 13, '/uploads/productos/maquina-4.png', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(15, 'Puntera 1', 14, '/uploads/productos/puntera-1.png', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(16, 'Puntera 2', 15, '/uploads/productos/puntera-2.png', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(20, '28.jpg', 11, 'uploads/productos/1740250722_3074c8a4ed56e59b1560.png', '2025-02-22 18:58:42', '2025-02-22 18:58:42'),
(25, '28.jpg', 16, 'uploads/productos/1740360478_fcdd2a663360187a28a3.png', '2025-02-24 01:27:58', '2025-02-24 01:27:58'),
(27, '28.jpg', 16, 'uploads/productos/1740360516_0b7db7e34178858fa15e.png', '2025-02-24 01:28:36', '2025-02-24 01:28:36'),
(28, '28.jpg', 18, 'uploads/productos/1740362237_b214c65537d493556705.png', '2025-02-24 01:57:17', '2025-02-24 01:57:17'),
(29, '28.jpg', 18, 'uploads/productos/1740362251_d61492f3e2bb897739eb.png', '2025-02-24 01:57:31', '2025-02-24 01:57:31'),
(30, '28.jpg', 18, 'uploads/productos/1740362261_be071d58daae252c8d05.png', '2025-02-24 01:57:41', '2025-02-24 01:57:41'),
(31, '28.jpg', 18, 'uploads/productos/1740362293_e3b62520c221200cafc8.png', '2025-02-24 01:58:13', '2025-02-24 01:58:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id`, `nombre`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Cheyenne Professional Tattoo Equipment', '', 'activo', '2025-02-21 01:29:28', '2025-02-22 18:38:07'),
(2, 'Hurricane', NULL, 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(3, 'Spark', NULL, 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(4, 'FK Irons', NULL, 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(5, 'Eternal Ink', NULL, 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(6, 'Intenze Tattoo Ink', NULL, 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(7, 'Dynamic Ink', NULL, 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(8, 'Killer Ink Tattoo', NULL, 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(9, 'World Famous Ink', NULL, 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(10, 'Genérica', NULL, 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(11, 'Mast', NULL, 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(12, 'Excelent', NULL, 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(13, 'Bronc', NULL, 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(14, 'Prueba', '', 'inactivo', '2025-02-21 12:38:25', '2025-02-21 14:04:50'),
(15, 'Marca de Prueba', '', 'inactivo', '2025-02-22 18:37:43', '2025-02-22 18:38:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(11) UNSIGNED NOT NULL,
  `conversacion_id` int(11) UNSIGNED NOT NULL,
  `tipo_remitente` enum('cliente','administrador','visitante') NOT NULL DEFAULT 'visitante',
  `mensaje` text NOT NULL,
  `leido` enum('si','no') NOT NULL DEFAULT 'no',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `conversacion_id`, `tipo_remitente`, `mensaje`, `leido`, `created_at`, `updated_at`) VALUES
(1, 1, 'visitante', 'Esse ut vero enim est laborum. Perspiciatis eveniet officiis quibusdam doloremque quas pariatur. Suscipit quia rem et repudiandae consequatur.', 'si', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(2, 2, 'visitante', 'Dolores doloribus a autem ut et. Delectus aperiam et non omnis. Corporis nobis explicabo sequi qui quasi omnis.', 'si', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(3, 3, 'visitante', 'Qui eos tempore blanditiis. Quasi sapiente vero ut est. Sed sed doloremque itaque sed est voluptas. Molestiae et voluptatibus beatae velit molestiae.', 'si', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(4, 4, 'visitante', 'Illum voluptatem nisi labore iusto. Itaque id cupiditate animi saepe. Tenetur qui officiis velit et.', 'si', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(5, 5, 'visitante', 'Dolorum ex unde ut iure sit eaque. Officiis sunt sint sed recusandae quia dolorem autem. Voluptas velit animi ut accusamus non officia et.', 'si', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(6, 6, 'visitante', 'Id sed architecto earum quod tenetur sit. Architecto dolores laboriosam molestiae quisquam. Quasi et laudantium aperiam qui autem in. Dolor optio odio ut perspiciatis.', 'si', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(7, 7, 'visitante', 'Quia nobis harum deserunt. Pariatur maiores enim aut at. Enim voluptatem accusantium id qui beatae id excepturi. Consequatur voluptatem omnis voluptatem nemo repellat consequatur.', 'si', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(8, 8, 'visitante', 'Et amet hic labore libero dignissimos vitae doloremque sunt. Et illo aut nemo id. Itaque possimus dignissimos et pariatur.', 'si', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(9, 9, 'visitante', 'Porro illum ut dicta excepturi earum. Sit quod ducimus ea et itaque omnis. Magnam rerum iusto tempora quia eligendi ut vel nihil. Voluptatem modi nihil ad corrupti a.', 'si', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(10, 10, 'visitante', 'Eum minus atque sint sapiente. Fuga aperiam voluptatem distinctio iste. Eius ad debitis quos perferendis et quod maxime.', 'si', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(11, 1, 'administrador', 'Eum mollitia impedit voluptate atque quod quia. In nam mollitia corrupti officiis. Aut similique veritatis sequi voluptates repudiandae non. Iure quasi sit non at culpa dolorem corporis ut.', 'si', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(12, 2, 'administrador', 'Laudantium et distinctio suscipit reiciendis. Aliquam molestiae eos veniam tenetur neque sequi ut. Repellendus qui consectetur nemo molestiae. Voluptas sunt repellendus placeat odio nulla dignissimos.', 'si', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(13, 3, 'administrador', 'Voluptate corrupti magni consequatur praesentium inventore temporibus molestiae. Nobis et voluptates explicabo et ex. Deleniti provident nihil est. Vel dignissimos esse tempora.', 'si', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(14, 4, 'administrador', 'Aut corporis ut expedita provident quis sit possimus. Nemo quia dolores dolorem aut quam consequuntur nostrum deleniti. Aut et eaque architecto explicabo nemo consequatur. Qui numquam dignissimos aliquam cumque expedita saepe sit aut.', 'si', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(15, 5, 'administrador', 'Fuga assumenda totam sed qui. Officiis praesentium maiores tenetur minus. Voluptas voluptatem pariatur ratione aut atque consequatur. Quis blanditiis tempora voluptatem.', 'si', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(16, 11, 'cliente', 'Reiciendis perferendis nostrum earum aliquid placeat. Libero quidem consectetur odit sed soluta amet. Molestias aspernatur ab voluptatem consequatur quam animi eligendi.', 'si', '2025-02-21 01:29:29', '2025-02-21 01:59:52'),
(17, 12, 'cliente', 'Veritatis quia autem asperiores quam quos quas repellat dolorem. Maxime esse sunt voluptatem facilis quis provident vero. Quidem sed accusantium voluptate itaque. Pariatur velit quam quia blanditiis.', 'si', '2025-02-21 01:29:29', '2025-02-21 19:54:47'),
(18, 13, 'cliente', 'Voluptas perspiciatis facilis dicta quam vel beatae qui. Voluptates vel quo facere aut perferendis esse quo.', 'si', '2025-02-21 01:29:29', '2025-02-21 19:54:51'),
(19, 14, 'cliente', 'Neque assumenda deserunt natus distinctio asperiores omnis atque. Maiores quis reprehenderit officia assumenda maxime. Autem recusandae fugit eligendi sint.', 'si', '2025-02-21 01:29:29', '2025-02-21 19:54:54'),
(20, 15, 'cliente', 'Corporis nisi molestias delectus recusandae. Et molestiae at iste cumque est maiores. Recusandae voluptatibus eaque blanditiis veniam non. Error nihil voluptas ex et cumque.', 'si', '2025-02-21 01:29:29', '2025-02-21 19:54:57'),
(21, 16, 'cliente', 'Sit laborum aut quaerat ut. Qui nemo veritatis sed non tempora voluptates consequatur dolore. Voluptas non aut qui est incidunt omnis quibusdam corrupti.', 'si', '2025-02-21 01:29:29', '2025-02-21 19:55:01'),
(22, 17, 'cliente', 'Eaque facere et iste. Quis nisi corporis quis officiis ut veritatis tempore itaque. Totam praesentium et ullam earum neque id reiciendis. Quae esse distinctio rem consectetur veritatis eaque. Accusamus velit quod ipsa reiciendis aut et.', 'si', '2025-02-21 01:29:29', '2025-02-21 19:55:05'),
(23, 18, 'cliente', 'Iure qui nostrum ea voluptas vel incidunt. Sed iste minima voluptates laborum. Et amet qui voluptates eligendi deserunt laudantium cupiditate dolorum. Odit nulla natus ea quia fugiat.', 'si', '2025-02-21 01:29:29', '2025-02-22 14:00:47'),
(24, 19, 'cliente', 'Eligendi in quae aut qui. Quasi neque dolores aspernatur similique voluptatum dolorem numquam facilis. Quasi exercitationem aut provident et fugiat quia dolorum et.', 'si', '2025-02-21 01:29:29', '2025-02-21 01:59:49'),
(25, 20, 'cliente', 'Maxime ea assumenda quas eum perferendis consequatur. Reiciendis ut commodi vel corrupti consectetur quae. Et autem dolorem voluptatem soluta est nam totam.', 'si', '2025-02-21 01:29:29', '2025-02-21 01:59:45'),
(26, 11, 'administrador', 'Ducimus illo sunt accusantium voluptatem. Dolorem voluptatem odio dolorem pariatur quo sit. Incidunt amet illo aut labore.', 'no', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(27, 12, 'administrador', 'Quia fugiat ut dolorem est voluptatem sit non reprehenderit. Voluptatum animi impedit voluptatem sit. Numquam voluptatibus consequatur eos consequatur. Rerum est adipisci ut reprehenderit enim dolorem.', 'no', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(28, 13, 'administrador', 'Omnis a et expedita consequatur nam odio. Ratione dolor quisquam quae perferendis a possimus blanditiis. Iure est aperiam autem eos quia praesentium sint. Et qui ratione qui vel non.', 'no', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(29, 14, 'administrador', 'Accusamus quibusdam eos est soluta. Ea labore voluptatibus aut eveniet. Modi rerum omnis perferendis quod consequuntur. Fugiat dicta sit voluptatibus est.', 'no', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(30, 15, 'administrador', 'Aut aut nisi exercitationem possimus dolores est laboriosam. Laboriosam inventore qui labore porro ea. Ullam eveniet voluptatem sapiente.', 'no', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(31, 16, 'administrador', 'Est non rem sint non voluptatem. Dignissimos sed esse qui ratione sint. Iure nesciunt ratione corporis repudiandae sapiente nihil. Ut iusto laboriosam nobis praesentium aspernatur quibusdam occaecati et.', 'no', '2025-02-21 01:29:29', '2025-02-21 01:29:29'),
(32, 21, 'visitante', '1234 probando', 'si', '2025-02-21 01:44:12', '2025-02-21 01:44:25'),
(33, 21, 'administrador', 'de 10, ahora parece funcionar', 'si', '2025-02-21 01:55:59', '2025-02-21 01:55:59');

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
(141, '2024-02-13-175626', 'App\\Database\\Migrations\\Categorias', 'default', 'App', 1740101366, 1),
(142, '2024-02-13-183953', 'App\\Database\\Migrations\\Marcas', 'default', 'App', 1740101366, 1),
(143, '2024-02-13-194120', 'App\\Database\\Migrations\\Conversaciones', 'default', 'App', 1740101366, 1),
(144, '2024-02-13-201051', 'App\\Database\\Migrations\\Usuarios', 'default', 'App', 1740101366, 1),
(145, '2024-02-13-201150', 'App\\Database\\Migrations\\CreateDirecciones', 'default', 'App', 1740101366, 1),
(146, '2024-02-13-202802', 'App\\Database\\Migrations\\Mensajes', 'default', 'App', 1740101366, 1),
(147, '2024-02-13-203638', 'App\\Database\\Migrations\\Productos', 'default', 'App', 1740101366, 1),
(148, '2024-02-13-210505', 'App\\Database\\Migrations\\Ordenes', 'default', 'App', 1740101366, 1),
(149, '2024-02-13-211753', 'App\\Database\\Migrations\\DetalleOrden', 'default', 'App', 1740101366, 1),
(150, '2024-02-13-212751', 'App\\Database\\Migrations\\Facturas', 'default', 'App', 1740101366, 1),
(151, '2024-05-23-013603', 'App\\Database\\Migrations\\ImagenesProductos', 'default', 'App', 1740101366, 1),
(152, '2024-07-30-175910', 'App\\Database\\Migrations\\Carritos', 'default', 'App', 1740101366, 1),
(153, '2024-07-30-192903', 'App\\Database\\Migrations\\DetalleCarrito', 'default', 'App', 1740101366, 1),
(154, '2024-08-01-010729', 'App\\Database\\Migrations\\DetalleFactura', 'default', 'App', 1740101366, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

CREATE TABLE `ordenes` (
  `id` int(11) UNSIGNED NOT NULL,
  `usuario_id` int(11) UNSIGNED NOT NULL,
  `fecha` datetime NOT NULL,
  `estado` enum('pendiente','procesanda','enviada','completada','cancelada') NOT NULL DEFAULT 'pendiente',
  `total` decimal(10,2) UNSIGNED NOT NULL,
  `direccion_envio_id` int(11) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) UNSIGNED NOT NULL,
  `stock` int(11) UNSIGNED NOT NULL,
  `categoria_id` int(11) UNSIGNED NOT NULL,
  `marca_id` int(11) UNSIGNED NOT NULL,
  `modelo` varchar(255) DEFAULT NULL,
  `peso` varchar(255) DEFAULT NULL,
  `dimensiones` varchar(255) DEFAULT NULL,
  `material` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `stock`, `categoria_id`, `marca_id`, `modelo`, `peso`, `dimensiones`, `material`, `color`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Caja Agujas Tattoo Premium X 50 1203RL', 'Caja que contiene 50 unidades de agujas de tatuaje, cada una con las siguientes características: Diámetro de la aguja: 0.35 mm. Número de agujas en el haz: 3. Tipo de configuración: Round Liner.', 16500.00, 15, 3, 10, '1203 RL', '200 grs', '12 x 7 x 4 cm', 'Acero inoxidable de grado médico', 'Plateado', 'activo', '2025-02-21 01:29:28', '2025-02-22 19:08:59'),
(2, 'Agujas Para Tatuar Caja X 50u Hurricane 1207RL', 'Caja que contiene 50 unidades de agujas de tatuaje, cada una con las siguientes características: Diámetro de la aguja: 0.35 mm. Número de agujas en el haz: 7. Tipo de configuración: Round Liner.', 15024.00, 10, 3, 2, '1207 RL', '200 gramos', '12 x 7 x 4 cm', 'Acero inoxidable de grado médico', 'Plateado', 'activo', '2025-02-21 01:29:28', '2025-02-22 18:58:23'),
(3, 'Caja Cerrada Agujas Tattoo Lineas (x50 Unidades) 1213RL', 'Caja que contiene 50 unidades de agujas de tatuaje, cada una con las siguientes características: Diámetro de la aguja: 0.35 mm. Número de agujas en el haz: 13. Tipo de configuración: Round Liner.', 18426.00, 10, 3, 10, '1213 RL', '200 gramos', '12 x 7 x 4 cm', 'Acero inoxidable de grado médico', 'Plateado', 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(4, 'Cartuchos Tattoo Spark Greywash 1203 RL (Caja x 20 u.)', 'Cartuchos de alta calidad con membrana mejorada. Su sistema de aguja brinda un trabajo más estable y preciso. Todos los cartuchos están fabricados con plásticos de ingeniería médica y acero inoxidable médico 316L. Esterilizado por gas EO. Cajas x 20 unidades.', 14379.00, 15, 3, 3, '1203 RL', '200 gramos', '15 x 10 x 5 cm', 'Plásticos de ingeniería médica y acero inoxidable médico', 'Transparente o translúcido', 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(5, 'Cartuchos Tattoo Spark Greywash 1209 RL (Caja x 20 u.)', 'Cartuchos de alta calidad con membrana mejorada. Su sistema de aguja brinda un trabajo más estable y preciso. Todos los cartuchos están fabricados con plásticos de ingeniería médica y acero inoxidable médico 316L. Esterilizado por gas EO. Cajas x 20 unidades.', 16780.00, 20, 3, 3, '1209 RL', '200 gramos', '15 x 10 x 5 cm', 'Plásticos de ingeniería médica y acero inoxidable médico', 'Transparente o translúcido', 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(6, 'Cartuchos Tattoo Mast Pro 0805 RL (caja de 20)', 'Agujas hechas por 304 L, pulidas por máquina automática que trabajan más suavemente. Desinfección completa de óxido de etileno, uso único desechable. Control estricto de calidad y consistencia, suave y libre de impurezas.  4 barras engrosadas aseguraron la alta resistencia de la durabilidad, cerca de 200 fuerza de rebote con dureza.', 16783.35, 8, 3, 11, '0805 RL', '200 gramos', '15 x 10 x 5 cm', 'Plásticos de ingeniería médica y acero inoxidable médico', 'Transparente o translúcido', 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(7, 'Descartador De Agujas Y Cortopunzantes 2.2 Lts.', 'Contenedor diseñado específicamente para la eliminación segura de agujas, jeringas y otros objetos cortopunzantes usados. Este tipo de contenedor es esencial en entornos médicos, de tatuajes, y otros lugares donde se manipulan objetos afilados que pueden ser peligrosos si no se desechan adecuadamente.', 4897.20, 25, 10, 12, 'SIMIL E2', '190 gramos', '12,5 x 14 x 19,5 cm', 'Polipropileno rígido virgen, resistente a caídas y perforaciones.', 'Rojo', 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(8, 'Fuente De Alimentación Tattoo Bronc Tpn-035', 'La fuente de alimentación Bronc para tatuajes es un dispositivo versátil y fácil de usar, diseñado para tatuadores profesionales. Voltaje y Potencia: Funciona en un rango de voltaje de 0-18V. Capacidad de alta salida de 3A. Pantalla y Controles: Equipado con una pantalla LCD a color de alta resolución. Panel de control sensible al tacto que permite ajustes incluso con guantes. Muestra en tiempo real la frecuencia, el voltaje, el porcentaje de carga y la corriente de amperaje. Funcionalidades: 12 configuraciones de voltaje preestablecidas. Función de inicio con un solo botón. Función de registro de tiempo para rastrear la duración de las sesiones. NO INCLUYE CABLE DE CONEXIÓN A 220V.', 193200.00, 5, 4, 13, 'Tpn-035', '625 gramos', '13 x 8 cm', 'Carcasa de plástico de alta resistencia', 'Negro', 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(9, 'Llave Allen Cruz Maquina Tattoo 2 Medidas Ajuste', 'Herramienta para ajustar, calibrar y puesta a punto de máquinas tattoo. Tiene 2 medidas diferentes y una punta con destornillador de plástico para regular y ajustar el tornillo de contacto de las máquinas.', 52782.54, 35, 10, 10, 'Allen Cruz', '50 gramos', '20 oz.', 'Metal y plastico', 'Negro', 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(10, 'Máquina Tattoo Cheyenne Hawk Pen', 'Con el control absoluto y la precisión en mente, Cheyenne ha introducido la mayor innovación en la industria del tatuaje: el bolígrafo Cheyenne Hawk. Esta revolucionaria máquina está especialmente diseñada para parecerse mucho a un bolígrafo real, lo que facilitará procedimientos de tatuaje aún más precisos que antes. El Cheyenne Hawk Pen es compatible con su propio agarre de 0.827 in y 0.984 in, el sistema de cartuchos Cheyenne y las fuentes de alimentación PU I y PU II y los cables de alimentación Cheyenne Thunder y Spirit. Otras marcas de fuentes de alimentación se pueden utilizar con el Hawk Pen, pero necesitarán un cable adaptador dependiendo de su fuente de alimentación particular (enchufes rojos/negros). Esta máquina no necesita una instalación de arranque.', 2659751.00, 3, 1, 1, 'Hawk Pen - MACH-418', '130 gramos', '25,4 x 123 mm', 'Aluminio', 'Negro, bronce, naranja, morado, rojo y plateado.', 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(11, 'Máquina Tattoo Cheyenne Hawk 10th Anniversary Edition', 'HAWK EDICIÓN 10.º ANIVERSARIO. HAWK fue la primera máquina para tatuar de Cheyenne; se lanzó en el 2007 y ganó inmediatamente muchos fans por todo el mundo. Incluso hoy en día es una de las herramientas para tatuar de mayor calidad, de las más valoradas. Con motivo del décimo aniversario, se ha lanzado una nueva edición limitada del clásico, en dos nuevos colores; un producto único, como suele serlo.', 2318745.00, 1, 1, 1, 'Hawk 10th Anniv. Ed.', '130 gramos', '13 x 3 cm', 'Aluminio', 'Negro', 'activo', '2025-02-21 01:29:28', '2025-02-22 18:58:42'),
(12, 'Maquina Rotativa Para Tattoo Tipo Dragonfly Híbrida', 'Máquina para tatuar rotativa tipo DragonFly X2, super livianas con un motor de excelentes prestaciones. Con conexión para cable clip y cable ficha RCA, funcionan indistintamente.', 38855.00, 8, 1, 10, 'Dragonfly', '99 gramos', '100 x 22 x 75 mm', 'Aleación de aluminio', 'Blanco, dorado, negro, rojo, verde.', 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(13, 'Máquina Tattoo Custom Mk97-4 Alloy 10w. Pro Liner Shader', 'Máquina para tatuar con bobinas de 10w. para uso profesional.', 45489.00, 7, 1, 4, 'Custom MK97 Alloy', '250 gramos', '10 x 8 x 5 cm', 'Acero de fundición', 'Negro', 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(14, 'Punteras Descartables 25mm X25u - 9 RL', '25 Punteras Descartables STRONG 25mm', 22990.00, 20, 3, 10, NULL, NULL, '25 mm', 'Plástico', NULL, 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(15, 'Caja Punteras Descartables 30mm. Línea (x15 Unidades) 11 RT', 'Estas punteras descartables están diseñadas específicamente para su uso con agujas de tatuaje. Cada grip tiene un diámetro de 30mm, ideal para trabajos precisos y definidos, asegurando un resultado limpio y profesional.', 10487.00, 25, 3, 10, NULL, NULL, '30 mm', 'Plástico', NULL, 'activo', '2025-02-21 01:29:28', '2025-02-21 01:29:28'),
(16, 'Producto de Prueba', 'probando el alta de un nuevo producto', 200.00, 10, 12, 15, 'prueba', '1000 kilogramos', '', '', '', 'inactivo', '2025-02-22 18:49:35', '2025-02-24 01:29:05'),
(17, 'Producto de Prueba 2', '', 1000.00, 100, 11, 14, '', '', '', '', '', 'inactivo', '2025-02-22 19:16:09', '2025-02-24 01:21:58'),
(18, 'PRODUCTO DE PRUEBA 3', 'probando el campo \'estado\'', 5200.50, 50, 12, 15, 'MODELO 3', '1 TONELADA', '100 X 100 METROS', 'URANIO', 'PERLA', 'activo', '2025-02-24 01:38:36', '2025-02-24 01:58:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('administrador','cliente') NOT NULL DEFAULT 'cliente',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `password`, `rol`, `created_at`, `updated_at`, `estado`) VALUES
(1, 'Administrador', 'Principal', 'admin@example.com.org', '$2y$10$zwRT6rP0xjo1R4J4FLNLmuoxWIjSI85Ho7d.g/vY.eeAJMx/jq9H.', 'administrador', '2025-02-21 01:29:29', '2025-02-21 01:29:29', 'activo'),
(2, 'Valentina', 'Parker', 'pfeffer.alysa@example.com', '$2y$10$N8GbpYMMunrFFD9xa.2FlOYTo1Sb9nD/A6xgcjIUfRRmRPs4IgFNq', 'cliente', '2025-02-21 01:29:29', '2025-02-21 01:29:29', 'activo'),
(3, 'Elissa', 'Gerhold', 'immanuel.swift@example.org', '$2y$10$xkQENjA7T0aycBho30.4fOZfoqjjgZwxk.23BEo69S7sGxNIs5tom', 'cliente', '2025-02-21 01:29:29', '2025-02-21 01:29:29', 'activo'),
(4, 'Bonita', 'Abbott', 'nellie.feil@example.net', '$2y$10$93QE5H/uXF1yRc9J1J4jWeRybnKHtNNAQYSb5MeleRKWb32NkbkBm', 'cliente', '2025-02-21 01:29:29', '2025-02-21 01:29:29', 'activo'),
(5, 'Gavin', 'Kub', 'bartoletti.darron@example.net', '$2y$10$09KLqxvCVJ0eV5xVgRRWpu7BNE9OURdxagOMoRhYFMX.AyGcSXsuK', 'cliente', '2025-02-21 01:29:29', '2025-02-21 01:29:29', 'activo'),
(6, 'Ila', 'Olson', 'ischuster@example.org', '$2y$10$vXGEYaFFePfN/sm3EV71ZekqeB9XKgq8GNwuE4r7RQmv9HLbKlZR2', 'cliente', '2025-02-21 01:29:29', '2025-02-21 01:29:29', 'activo'),
(7, 'Nelle', 'Feil', 'autumn.stroman@example.org', '$2y$10$P4n3ywAsZxsiNPO2YyqoA.gO8s4S1lFa1OtNQvwrBrK.HalsGqCq6', 'cliente', '2025-02-21 01:29:29', '2025-02-21 01:29:29', 'activo'),
(8, 'Mikel', 'Rempel', 'murazik.dagmar@example.org', '$2y$10$tCBvVcxKrJ1r8ZowH1MC0ejLuqrJJtmCvYl4oqhBnIjUn8tEbGbFm', 'cliente', '2025-02-21 01:29:29', '2025-02-21 01:29:29', 'activo'),
(9, 'Elmira', 'Kshlerin', 'vito98@example.org', '$2y$10$7qZph1PhITn89aJ.jeqaGOKdPX.bI3/uhH/riPp7sUdBPzXNewk2C', 'cliente', '2025-02-21 01:29:29', '2025-02-21 01:29:29', 'activo'),
(10, 'Albertha', 'Legros', 'xzemlak@example.org', '$2y$10$yFuCcw1uDEBrJr7nYb3.qu7qMvFpGNL44hMS6HTQ0GcTDJ1Wonwdu', 'cliente', '2025-02-21 01:29:29', '2025-02-21 01:29:29', 'activo'),
(11, 'Macy', 'Connelly', 'klocko.nola@example.com', '$2y$10$vH4XSTfID2viF4FW5Sz2l.8Iqvw.zyfor6H4S3Ah0ONeVFXEgDkjC', 'cliente', '2025-02-21 01:29:29', '2025-02-21 01:29:29', 'activo'),
(12, 'Elinore', 'Hermiston', 'wolf.gretchen@example.org', '$2y$10$mBl1u7y1ADo7Vn13wEmdI.rjvE0S7G3obrC7Mjc22zEUjGT16DTqu', 'cliente', '2025-02-21 01:29:29', '2025-02-21 01:29:29', 'activo'),
(13, 'Carissa', 'Russel', 'jkoch@example.com', '$2y$10$OMMxw3pfVBmPj1bc6HMMj.ZZSfcOFOCgkFlBPCWTo/FH26sXvAp8a', 'cliente', '2025-02-21 01:29:29', '2025-02-21 01:29:29', 'activo'),
(14, 'Caesar', 'Rath', 'domenica84@example.net', '$2y$10$qt9AmH2m0PErBCZ6zHA0UuNJ5wti7ratK84jfSjgxCXwwoMUi7L5K', 'cliente', '2025-02-21 01:29:29', '2025-02-21 01:29:29', 'activo'),
(15, 'Hank', 'Toy', 'anderson.karli@example.org', '$2y$10$ns7afwuVntv1zwIQO7PH7uCARQGyRNXPwbicJq2fcrBcIvrYaDgFS', 'cliente', '2025-02-21 01:29:29', '2025-02-21 01:29:29', 'activo'),
(16, 'Torrance', 'Stamm', 'johnson.joany@example.com', '$2y$10$whBkHym9g2mq7LkSFV8fH.1eAoO.9iozy60Rn50alY4iGiNXN2Z1u', 'cliente', '2025-02-21 01:29:29', '2025-02-21 01:29:29', 'activo'),
(17, 'Jerald', 'Lang', 'corene.kuhic@example.org', '$2y$10$sP4O6MyIm1WAktLkBo4PteGkqGKE.aUDW6ae7T6VbJ.XNJrE9mBj2', 'cliente', '2025-02-21 01:29:29', '2025-02-21 01:29:29', 'activo'),
(18, 'Britney', 'Abbott', 'jose.trantow@example.com', '$2y$10$yaLsCJDsLI61Ri35JqOIKuAHJM03hQ3WQ4DFazUQrAWQL8.bzYH9i', 'cliente', '2025-02-21 01:29:29', '2025-02-21 01:29:29', 'activo'),
(19, 'Cicero', 'Reilly', 'gaston25@example.net', '$2y$10$abeIqWtFsXC3xnbuw1VexeHHQGtgjtH5u7VHWV3SeB7RsZ5V3iUlO', 'cliente', '2025-02-21 01:29:29', '2025-02-21 01:29:29', 'activo'),
(20, 'Abigail', 'Friesen', 'irving.lakin@example.com', '$2y$10$5fyjwF7rvVFPU6yIaXbL2uQHShO9bQEcQllLiO1PTrMVjrj25zq.S', 'cliente', '2025-02-21 01:29:29', '2025-02-21 01:29:29', 'activo'),
(21, 'Valentin', 'Krajcik', 'joelle17@example.net', '$2y$10$BMfLh4wtj15DvL9UQm4Zje1Xi4/NEF6JvriJ8IkUUaWbuYh0odTG2', 'cliente', '2025-02-21 01:29:29', '2025-02-21 01:29:29', 'activo');

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
-- Indices de la tabla `conversaciones`
--
ALTER TABLE `conversaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `detalle_orden`
--
ALTER TABLE `detalle_orden`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_orden_orden_id_foreign` (`orden_id`),
  ADD KEY `detalle_orden_producto_id_foreign` (`producto_id`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `direcciones_usuario_id_foreign` (`usuario_id`);

--
-- Indices de la tabla `imagenes_productos`
--
ALTER TABLE `imagenes_productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `imagenes_productos_producto_id_foreign` (`producto_id`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mensajes_conversacion_id_foreign` (`conversacion_id`);

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
  ADD KEY `ordenes_usuario_id_foreign` (`usuario_id`),
  ADD KEY `ordenes_direccion_envio_id_foreign` (`direccion_envio_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `productos_categoria_id_foreign` (`categoria_id`),
  ADD KEY `productos_marca_id_foreign` (`marca_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `conversaciones`
--
ALTER TABLE `conversaciones`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `detalle_orden`
--
ALTER TABLE `detalle_orden`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `imagenes_productos`
--
ALTER TABLE `imagenes_productos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_orden`
--
ALTER TABLE `detalle_orden`
  ADD CONSTRAINT `detalle_orden_orden_id_foreign` FOREIGN KEY (`orden_id`) REFERENCES `ordenes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_orden_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD CONSTRAINT `direcciones_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `imagenes_productos`
--
ALTER TABLE `imagenes_productos`
  ADD CONSTRAINT `imagenes_productos_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_conversacion_id_foreign` FOREIGN KEY (`conversacion_id`) REFERENCES `conversaciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD CONSTRAINT `ordenes_direccion_envio_id_foreign` FOREIGN KEY (`direccion_envio_id`) REFERENCES `direcciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ordenes_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productos_marca_id_foreign` FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
