-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-03-2025 a las 03:58:24
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
(1, 'Máquinas de Tatuar', NULL, 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(2, 'Tintas para Tatuajes', NULL, 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(3, 'Agujas y Cartuchos', NULL, 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(4, 'Fuentes de Poder', NULL, 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(5, 'Mobiliario y Accesorios', NULL, 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(6, 'Cuidado y Sanitización', NULL, 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(7, 'Transferencia y Diseño', NULL, 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(8, 'Práctica y Aprendizaje', NULL, 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(9, 'Merchandising', NULL, 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(10, 'Otros', NULL, 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13');

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
(1, NULL, 'Mr. Emmett Thompson IV', 'king.candice@example.org', 'Iste a quis', 'contacto', 'cerrada', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(2, NULL, 'Madelynn Rippin', 'violet14@example.com', 'Ipsum et praesentium', 'contacto', 'cerrada', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(3, NULL, 'Prof. Jamarcus Pfeffer', 'wisoky.major@example.com', 'Repellat iure nihil', 'contacto', 'cerrada', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(4, NULL, 'Dr. Mark Tromp', 'dejah.ebert@example.org', 'Doloremque corporis et', 'contacto', 'cerrada', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(5, NULL, 'Mr. Houston Rolfson II', 'braxton69@example.com', 'Debitis magnam illum', 'contacto', 'cerrada', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(6, NULL, 'Geovanni Ortiz', 'feil.elsie@example.org', 'At harum asperiores', 'contacto', 'abierta', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(7, NULL, 'Miss Sandrine Dicki II', 'norris.eichmann@example.net', 'Aut earum esse', 'contacto', 'abierta', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(8, NULL, 'Mekhi McGlynn', 'kirk.goyette@example.com', 'Ipsam neque est', 'contacto', 'abierta', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(9, NULL, 'Dr. Reyes Schulist DDS', 'runolfsson.eliane@example.org', 'Delectus omnis ex', 'contacto', 'abierta', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(10, NULL, 'Kolby Hagenes', 'kbradtke@example.com', 'Quia quas ad', 'contacto', 'abierta', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(11, 4, 'Wilbert Cronin', 'danyka44@example.com', 'Et velit autem', 'consulta', 'abierta', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(12, 15, 'Zora Jones DDS', 'lilla.walker@example.org', 'Maxime aut est', 'consulta', 'abierta', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(13, 21, 'Prof. Nickolas Stroman', 'xschoen@example.org', 'Aliquid dolor et', 'consulta', 'abierta', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(14, 5, 'Mrs. Anais Goldner Sr.', 'soledad50@example.com', 'Quam nisi numquam', 'consulta', 'abierta', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(15, 7, 'Newton Hansen', 'qolson@example.net', 'Excepturi quia explicabo', 'consulta', 'abierta', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(16, 10, 'Mrs. Savanah Nitzsche DDS', 'annie36@example.net', 'Maiores rerum velit', 'consulta', 'abierta', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(17, 14, 'Beverly Bechtelar', 'gerda.abbott@example.org', 'Quia fugiat iste', 'consulta', 'abierta', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(18, 6, 'Bret Gerlach', 'edison.bosco@example.com', 'Consequuntur error sint', 'consulta', 'abierta', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(19, 16, 'Webster Jacobson', 'jerrod.reinger@example.com', 'Commodi sint quam', 'consulta', 'abierta', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(20, 18, 'Cathy Grant', 'alford92@example.com', 'Et soluta natus', 'consulta', 'abierta', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(21, 22, 'Enrique Ramon', 'enriqueramontg@gmail.com', 'Hola', 'consulta', 'cerrada', '2025-02-27 17:35:45', '2025-03-02 02:05:11'),
(22, 22, 'Enrique Ramon Torres Gamarra', 'enriqueramontg@gmail.com', 'Una prueba', 'consulta', 'abierta', '2025-03-02 02:10:33', '2025-03-02 02:10:33');

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

--
-- Volcado de datos para la tabla `detalle_orden`
--

INSERT INTO `detalle_orden` (`id`, `orden_id`, `producto_id`, `cantidad`, `precio_unitario`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 1, 14379.00, '2025-02-27 17:33:00', '2025-02-27 17:33:00'),
(2, 1, 3, 1, 18426.00, '2025-02-27 17:33:00', '2025-02-27 17:33:00'),
(3, 1, 10, 1, 2659751.00, '2025-02-27 17:33:00', '2025-02-27 17:33:00'),
(4, 2, 1, 1, 12500.00, '2025-02-27 19:43:59', '2025-02-27 19:43:59'),
(5, 3, 7, 1, 4897.20, '2025-02-28 20:45:48', '2025-02-28 20:45:48'),
(6, 3, 6, 1, 16783.35, '2025-02-28 20:45:48', '2025-02-28 20:45:48'),
(15, 8, 7, 2, 4897.20, '2025-03-01 20:52:20', '2025-03-01 20:52:20'),
(16, 8, 10, 1, 2659751.00, '2025-03-01 20:52:20', '2025-03-01 20:52:20'),
(17, 9, 10, 1, 2659751.00, '2025-03-01 21:00:10', '2025-03-01 21:00:10'),
(18, 10, 1, 1, 12500.00, '2025-03-01 23:30:05', '2025-03-01 23:30:05'),
(19, 10, 6, 1, 16783.35, '2025-03-01 23:30:05', '2025-03-01 23:30:05');

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
(1, 7, 'Henry Reynolds DVM', 'Sam Circles', '2342', NULL, 'q', 'Shemarfurt', 'Virginia', '38652', '1-351-422-3174', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(2, 15, 'Mr. Sanford Zieme', 'Kaelyn Divide', '868', '8', NULL, 'South Linda', 'South Carolina', '64312', '323.568.8956', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(3, 12, 'Dr. Viola Murphy IV', 'Rice Pass', '850', '6', NULL, 'East Cassidyview', 'Maryland', '43365-8669', '+1-406-743-2587', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(4, 9, 'Owen Watsica PhD', 'Easter Dale', '1697', NULL, 'c', 'North Cesarshire', 'North Dakota', '60118-4755', '361-401-9805', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(5, 21, 'Abraham Blick', 'Terry Court', '695', '7', NULL, 'South Maximillia', 'New Mexico', '52796-0569', '+13375598730', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(6, 20, 'Tristin Flatley', 'Laisha Station', '2361', '3', 'h', 'North Makennahaven', 'Kentucky', '68703-6006', '+1-425-428-0434', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(7, 19, 'Addison Hagenes', 'Mohamed Mountains', '2465', NULL, 'f', 'Funkbury', 'Illinois', '79767-7963', '+1 (606) 435-8094', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(8, 6, 'Dr. Josh Collins III', 'Ortiz Cape', '25', NULL, 's', 'Osinskichester', 'Missouri', '18682-7020', '+1.203.613.0674', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(9, 19, 'Dr. Dagmar Mitchell', 'Renner Row', '433', '7', NULL, 'Luettgenton', 'Idaho', '15968-5395', '661.796.4811', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(10, 9, 'Dortha Jast', 'Deckow Flats', '1391', '3', NULL, 'Magnoliaville', 'Montana', '95965-9767', '+1 (316) 345-6026', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(11, 7, 'Janelle Yundt MD', 'Daryl Ferry', '2537', '8', NULL, 'Hoegerchester', 'Rhode Island', '43277', '+1 (351) 263-7632', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(12, 13, 'Kenny Lang', 'Hamill Squares', '1159', NULL, 'x', 'New Zanderfurt', 'Washington', '54437-3545', '+1-507-631-6447', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(13, 4, 'Mrs. Laurence Gerlach V', 'Hans Ridges', '1744', '6', NULL, 'North Elouiseton', 'Wyoming', '60838', '+1.951.804.0876', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(14, 19, 'Calista Monahan I', 'Upton Knolls', '253', NULL, NULL, 'East Helen', 'Utah', '80117', '1-830-427-2660', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(15, 15, 'Ralph Upton', 'Loma Mountains', '697', NULL, 'c', 'Port Hollyport', 'Missouri', '18315', '+1-775-393-3323', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(16, 2, 'Adrian Price', 'Lynch Fort', '1785', '9', 'b', 'Schimmelland', 'Wyoming', '92320-2725', '+1-680-618-4124', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(17, 6, 'Gayle Mueller', 'Hoeger Village', '2892', NULL, NULL, 'Sporerberg', 'Oregon', '00927', '1-775-827-8768', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(18, 10, 'Miss Alanis Shanahan', 'Allene Motorway', '1807', NULL, NULL, 'North Cynthiastad', 'Arizona', '18142', '980-206-0372', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(19, 17, 'Griffin Medhurst PhD', 'Batz Drives', '2019', '7', 'g', 'Lake Paolo', 'New York', '62144', '(214) 485-2774', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(20, 17, 'Ms. Reba Hickle III', 'Zieme Coves', '943', NULL, 'd', 'Lake Chanceton', 'Alaska', '49213-3052', '+1.678.730.2726', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(21, 22, 'Enrique Ramon Torres Gamarra', 'Las Teresitas', '5630', '', '', 'Corrientes', 'Corrientes', '3400', '03794406775', '2025-02-27 17:32:50', '2025-02-27 17:32:50'),
(22, 22, 'Tamara Rosales', 'San Juan', '1482', 'P. Baja', 'Oficina 3', 'Corrientes', 'Corrientes', '3400', '03794406775', '2025-02-28 20:45:43', '2025-02-28 20:45:43');

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
(1, 'Agujas 1', 1, '/uploads/productos/agujas-1.png', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(2, 'Agujas 2', 2, '/uploads/productos/agujas-2.png', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(3, 'Agujas 3', 3, '/uploads/productos/agujas-3.png', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(4, 'Cartuchos 1', 4, '/uploads/productos/cartuchos-1.png', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(5, 'Cartuchos 2', 5, '/uploads/productos/cartuchos-2.png', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(6, 'Cartuchos 3', 6, '/uploads/productos/cartuchos-3.png', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(7, 'Descartador', 7, '/uploads/productos/descartador.png', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(8, 'Fuente', 8, '/uploads/productos/fuente.png', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(9, 'Llave', 9, '/uploads/productos/llave.png', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(10, 'Maquina 1', 10, '/uploads/productos/maquina-1.png', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(11, 'Maquina 1 a', 10, '/uploads/productos/maquina-1-a.png', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(12, 'Maquina 2', 11, '/uploads/productos/maquina-2.png', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(13, 'Maquina 3', 12, '/uploads/productos/maquina-3.png', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(14, 'Maquina 4', 13, '/uploads/productos/maquina-4.png', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(15, 'Puntera 1', 14, '/uploads/productos/puntera-1.png', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(16, 'Puntera 2', 15, '/uploads/productos/puntera-2.png', '2025-02-27 17:32:13', '2025-02-27 17:32:13');

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
(1, 'Cheyenne Professional Tattoo Equipment', NULL, 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(2, 'Hurricane', NULL, 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(3, 'Spark', NULL, 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(4, 'FK Irons', NULL, 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(5, 'Eternal Ink', NULL, 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(6, 'Intenze Tattoo Ink', NULL, 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(7, 'Dynamic Ink', NULL, 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(8, 'Killer Ink Tattoo', NULL, 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(9, 'World Famous Ink', NULL, 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(10, 'Genérica', NULL, 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(11, 'Mast', NULL, 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(12, 'Excelent', NULL, 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(13, 'Bronc', NULL, 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13');

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
(1, 1, 'visitante', 'Quia voluptas doloribus voluptatem unde. Cum accusantium quia laudantium omnis odio occaecati repellendus. Quam optio dolorem sapiente.', 'si', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(2, 2, 'visitante', 'Veritatis et sed temporibus sit quas debitis. Voluptatem tempora amet nemo totam. Repudiandae tempore quos non illum. Ex necessitatibus aut tempora rerum.', 'si', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(3, 3, 'visitante', 'Eos necessitatibus fuga culpa iusto. Aut est praesentium quisquam est soluta nulla rerum. Amet et eveniet exercitationem qui ut placeat. Dolorum et non maxime et sit.', 'si', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(4, 4, 'visitante', 'Placeat libero velit quaerat. Neque velit et nostrum aut aut rerum aut. Cum laudantium nihil eligendi qui et dolorem excepturi.', 'si', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(5, 5, 'visitante', 'Atque voluptas in saepe aspernatur asperiores minima omnis. Officia et consectetur ut. Unde eos et aliquam. Officia facilis sit est quia sint nam ut ex.', 'si', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(6, 6, 'visitante', 'Dolorem eligendi quibusdam error ex quo ut. Dolore sit doloribus numquam cum possimus. Veniam explicabo ducimus consequatur nam voluptatem quo ratione. Unde id sequi rerum repellat.', 'si', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(7, 7, 'visitante', 'Quia corrupti sint et dolore veritatis. Ipsa id repellat itaque iusto quidem velit. Optio est laboriosam veritatis eligendi nemo sed incidunt.', 'si', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(8, 8, 'visitante', 'Exercitationem consequatur inventore dolorem et. At sequi sed sed molestiae ut quasi reprehenderit eos. Eius aspernatur quae eos qui saepe eos quia. Dolor esse fugiat asperiores et et.', 'si', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(9, 9, 'visitante', 'Explicabo non nisi quisquam labore quia laborum. Quo corrupti ut quod sit et aperiam. Non et accusamus debitis soluta.', 'si', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(10, 10, 'visitante', 'Temporibus et voluptatem quidem tenetur et. Qui architecto ratione distinctio recusandae aut dolorem qui quis. Reiciendis deserunt culpa omnis aut sapiente. Molestias magnam aspernatur rerum amet porro dolor incidunt.', 'si', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(11, 1, 'administrador', 'Atque recusandae ut autem cum. Incidunt quisquam iste reiciendis quae est corporis ut assumenda. Incidunt provident vitae dolor distinctio libero. Sed nihil quae porro sint est dignissimos.', 'si', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(12, 2, 'administrador', 'Quasi cumque repudiandae et perspiciatis. Qui non est aut. Dolore et ut nam saepe perspiciatis repudiandae repudiandae eveniet. Pariatur quos hic impedit quo et sint sed.', 'si', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(13, 3, 'administrador', 'Numquam excepturi sapiente et quasi vero corrupti cupiditate. Ut est sed omnis eum dolores. Quis fuga eos cumque non expedita et ducimus sed. Saepe nisi expedita recusandae doloribus alias quibusdam repudiandae quis.', 'si', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(14, 4, 'administrador', 'Ad ut assumenda occaecati voluptatem quisquam. Enim perspiciatis molestiae accusantium tempore. Occaecati sit blanditiis quaerat qui iusto qui et. Libero voluptas vero fuga in vero.', 'si', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(15, 5, 'administrador', 'Et iure sapiente vel voluptatum aperiam. Velit ab quidem nemo ea incidunt corrupti. Commodi expedita omnis atque eius sit.', 'si', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(16, 11, 'cliente', 'Nisi vero consequatur sit temporibus sit voluptatem. Error corrupti nihil ut fugiat sed ab ut. Dignissimos velit praesentium qui est porro eius velit.', 'no', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(17, 12, 'cliente', 'Consequatur minus magni et officia. Minus odio repellendus consequatur non laborum officiis. Voluptatibus est et dignissimos cupiditate laborum.', 'no', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(18, 13, 'cliente', 'Est incidunt ea eligendi. Quam id atque impedit assumenda. Perferendis repellendus aperiam aperiam aperiam.', 'no', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(19, 14, 'cliente', 'Doloremque magnam corrupti sed enim modi odio. Quas rem veniam quod quis sunt quia aspernatur.', 'no', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(20, 15, 'cliente', 'Quaerat veritatis tempore omnis id pariatur soluta. Facere error veritatis nihil sed. Dolores commodi cum qui consequatur. Aut sint adipisci ipsa modi eveniet velit nostrum.', 'no', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(21, 16, 'cliente', 'Animi est unde exercitationem earum consequatur. Rerum quod quo eum sequi.', 'no', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(22, 17, 'cliente', 'Autem hic ab dolorem voluptas est placeat hic. Rerum cumque incidunt voluptatem dolorem sint. Quis illo veniam omnis id qui facere nihil.', 'no', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(23, 18, 'cliente', 'Minus enim eum totam expedita. Ut doloremque eligendi autem.', 'no', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(24, 19, 'cliente', 'Repellendus modi id animi excepturi. Aut qui fugiat consequatur et dolorum qui. Sit iusto voluptatum quia fugiat corporis perferendis. Autem et culpa quasi ducimus veritatis hic.', 'no', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(25, 20, 'cliente', 'Laudantium ullam voluptatem voluptas qui eum. Quaerat delectus sit explicabo. Veritatis et velit recusandae fuga nesciunt quas nihil optio. Accusamus porro vel sed minus quia.', 'si', '2025-02-27 17:32:15', '2025-02-27 22:19:26'),
(26, 11, 'administrador', 'Itaque eos qui vero eveniet id ab velit. Enim dolorem quia ratione dolorem. Nihil neque consequatur aspernatur consectetur distinctio eveniet ut. Sunt labore qui pariatur sit.', 'no', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(27, 12, 'administrador', 'Id rerum placeat aspernatur consectetur nisi. Molestias sunt commodi nulla nihil totam. Recusandae non et impedit eaque ipsum ipsa quisquam est. Occaecati veritatis perspiciatis ipsum itaque impedit minus fugit.', 'no', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(28, 13, 'administrador', 'Dolor et excepturi ex qui cumque. Praesentium doloribus sit eveniet qui sint aperiam officiis ipsam. Autem voluptatibus vel aut enim error voluptatum quae dolore.', 'no', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(29, 14, 'administrador', 'Illum asperiores saepe non odit quod illum aut. Dolor quia aut dolores et eligendi quas incidunt. Quia dolorum soluta temporibus illo. Reiciendis error repellendus ut fugit beatae. Quia omnis odio placeat quis eos est.', 'no', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(30, 15, 'administrador', 'Quos non nisi harum in. Corrupti dignissimos aliquam illum est excepturi. Eos voluptatem qui animi pariatur veritatis vitae. Commodi aperiam unde exercitationem officia id beatae.', 'no', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(31, 16, 'administrador', 'Molestiae cumque eos cum sed asperiores quidem veniam. Ad et nobis occaecati ducimus. Enim eaque ad sit et.', 'no', '2025-02-27 17:32:15', '2025-02-27 17:32:15'),
(32, 21, 'cliente', 'probando', 'si', '2025-02-27 17:35:45', '2025-02-27 22:19:19'),
(33, 22, 'cliente', 'corroborando cambios', 'no', '2025-03-02 02:10:33', '2025-03-02 02:10:33');

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
(51, '2024-02-13-175626', 'App\\Database\\Migrations\\Categorias', 'default', 'App', 1740677530, 1),
(52, '2024-02-13-183953', 'App\\Database\\Migrations\\Marcas', 'default', 'App', 1740677530, 1),
(53, '2024-02-13-194120', 'App\\Database\\Migrations\\Conversaciones', 'default', 'App', 1740677530, 1),
(54, '2024-02-13-201051', 'App\\Database\\Migrations\\Usuarios', 'default', 'App', 1740677530, 1),
(55, '2024-02-13-201150', 'App\\Database\\Migrations\\CreateDirecciones', 'default', 'App', 1740677530, 1),
(56, '2024-02-13-202802', 'App\\Database\\Migrations\\Mensajes', 'default', 'App', 1740677530, 1),
(57, '2024-02-13-203638', 'App\\Database\\Migrations\\Productos', 'default', 'App', 1740677530, 1),
(58, '2024-02-13-210505', 'App\\Database\\Migrations\\Ordenes', 'default', 'App', 1740677530, 1),
(59, '2024-02-13-211753', 'App\\Database\\Migrations\\DetalleOrden', 'default', 'App', 1740677530, 1),
(60, '2024-05-23-013603', 'App\\Database\\Migrations\\ImagenesProductos', 'default', 'App', 1740677530, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

CREATE TABLE `ordenes` (
  `id` int(11) UNSIGNED NOT NULL,
  `usuario_id` int(11) UNSIGNED NOT NULL,
  `estado` enum('pendiente','procesanda','enviada','completada','cancelada') NOT NULL DEFAULT 'pendiente',
  `total` decimal(10,2) UNSIGNED NOT NULL,
  `direccion_envio_id` int(11) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ordenes`
--

INSERT INTO `ordenes` (`id`, `usuario_id`, `estado`, `total`, `direccion_envio_id`, `created_at`, `updated_at`) VALUES
(1, 22, 'cancelada', 2692556.00, 21, '2025-02-27 17:33:00', '2025-02-27 19:15:54'),
(2, 22, 'completada', 12500.00, 21, '2025-02-27 19:43:59', '2025-02-28 20:47:24'),
(3, 22, 'completada', 21680.55, 22, '2025-02-28 20:45:48', '2025-03-01 00:15:09'),
(8, 22, 'cancelada', 2669545.40, 21, '2025-03-01 20:52:20', '2025-03-02 03:43:24'),
(9, 22, 'pendiente', 2659751.00, 22, '2025-03-01 21:00:10', '2025-03-01 21:00:10'),
(10, 22, 'pendiente', 29283.35, 21, '2025-03-01 23:30:05', '2025-03-01 23:30:05');

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
(1, 'Caja Agujas Tattoo Premium X 50 1203RL', 'Caja que contiene 50 unidades de agujas de tatuaje, cada una con las siguientes características: Diámetro de la aguja: 0.35 mm. Número de agujas en el haz: 3. Tipo de configuración: Round Liner.', 12500.00, 8, 3, 10, '1203 RL', '200 gramos', '12 x 7 x 4 cm', 'Acero inoxidable de grado médico', 'Plateado', 'activo', '2025-02-27 17:32:13', '2025-03-01 23:30:05'),
(2, 'Agujas Para Tatuar Caja X 50u Hurricane 1207RL', 'Caja que contiene 50 unidades de agujas de tatuaje, cada una con las siguientes características: Diámetro de la aguja: 0.35 mm. Número de agujas en el haz: 7. Tipo de configuración: Round Liner.', 15024.00, 10, 3, 2, '1207 RL', '200 gramos', '12 x 7 x 4 cm', 'Acero inoxidable de grado médico', 'Plateado', 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(3, 'Caja Cerrada Agujas Tattoo Lineas x50 Unidades 1213RL', 'Caja que contiene 50 unidades de agujas de tatuaje, cada una con las siguientes características: Diámetro de la aguja: 0.35 mm. Número de agujas en el haz: 13. Tipo de configuración: Round Liner.', 18426.00, 9, 3, 10, '1213 RL', '200 gramos', '12 x 7 x 4 cm', 'Acero inoxidable de grado médico', 'Plateado', 'activo', '2025-02-27 17:32:13', '2025-02-27 17:33:00'),
(4, 'Cartuchos Tattoo Spark Greywash 1203 RL Caja x 20 u.', 'Cartuchos de alta calidad con membrana mejorada. Su sistema de aguja brinda un trabajo más estable y preciso. Todos los cartuchos están fabricados con plásticos de ingeniería médica y acero inoxidable médico 316L. Esterilizado por gas EO. Cajas x 20 unidades.', 14379.00, 14, 3, 3, '1203 RL', '200 gramos', '15 x 10 x 5 cm', 'Plásticos de ingeniería médica y acero inoxidable médico', 'Transparente o translúcido', 'activo', '2025-02-27 17:32:13', '2025-02-27 17:33:00'),
(5, 'Cartuchos Tattoo Spark Greywash 1209 RL Caja x 20 u.', 'Cartuchos de alta calidad con membrana mejorada. Su sistema de aguja brinda un trabajo más estable y preciso. Todos los cartuchos están fabricados con plásticos de ingeniería médica y acero inoxidable médico 316L. Esterilizado por gas EO. Cajas x 20 unidades.', 16780.00, 20, 3, 3, '1209 RL', '200 gramos', '15 x 10 x 5 cm', 'Plásticos de ingeniería médica y acero inoxidable médico', 'Transparente o translúcido', 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(6, 'Cartuchos Tattoo Mast Pro 0805 RL caja de 20', 'Agujas hechas por 304 L, pulidas por máquina automática que trabajan más suavemente. Desinfección completa de óxido de etileno, uso único desechable. Control estricto de calidad y consistencia, suave y libre de impurezas.  4 barras engrosadas aseguraron la alta resistencia de la durabilidad, cerca de 200 fuerza de rebote con dureza.', 16783.35, 6, 3, 11, '0805 RL', '200 gramos', '15 x 10 x 5 cm', 'Plásticos de ingeniería médica y acero inoxidable médico', 'Transparente o translúcido', 'activo', '2025-02-27 17:32:13', '2025-03-01 23:30:05'),
(7, 'Descartador De Agujas Y Cortopunzantes 2.2 Lts.', 'Contenedor diseñado específicamente para la eliminación segura de agujas, jeringas y otros objetos cortopunzantes usados. Este tipo de contenedor es esencial en entornos médicos, de tatuajes, y otros lugares donde se manipulan objetos afilados que pueden ser peligrosos si no se desechan adecuadamente.', 4897.20, 22, 10, 12, 'SIMIL E2', '190 gramos', '12,5 x 14 x 19,5 cm', 'Polipropileno rígido virgen, resistente a caídas y perforaciones.', 'Rojo', 'activo', '2025-02-27 17:32:13', '2025-03-01 20:52:20'),
(8, 'Fuente De Alimentación Tattoo Bronc Tpn-035', 'La fuente de alimentación Bronc para tatuajes es un dispositivo versátil y fácil de usar, diseñado para tatuadores profesionales. Voltaje y Potencia: Funciona en un rango de voltaje de 0-18V. Capacidad de alta salida de 3A. Pantalla y Controles: Equipado con una pantalla LCD a color de alta resolución. Panel de control sensible al tacto que permite ajustes incluso con guantes. Muestra en tiempo real la frecuencia, el voltaje, el porcentaje de carga y la corriente de amperaje. Funcionalidades: 12 configuraciones de voltaje preestablecidas. Función de inicio con un solo botón. Función de registro de tiempo para rastrear la duración de las sesiones. NO INCLUYE CABLE DE CONEXIÓN A 220V.', 193200.00, 5, 4, 13, 'Tpn-035', '625 gramos', '13 x 8 cm', 'Carcasa de plástico de alta resistencia', 'Negro', 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(9, 'Llave Allen Cruz Maquina Tattoo 2 Medidas Ajuste', 'Herramienta para ajustar, calibrar y puesta a punto de máquinas tattoo. Tiene 2 medidas diferentes y una punta con destornillador de plástico para regular y ajustar el tornillo de contacto de las máquinas.', 52782.54, 35, 10, 10, 'Allen Cruz', '50 gramos', '20 oz.', 'Metal y plastico', 'Negro', 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(10, 'Máquina Tattoo Cheyenne Hawk Pen', 'Con el control absoluto y la precisión en mente, Cheyenne ha introducido la mayor innovación en la industria del tatuaje: el bolígrafo Cheyenne Hawk. Esta revolucionaria máquina está especialmente diseñada para parecerse mucho a un bolígrafo real, lo que facilitará procedimientos de tatuaje aún más precisos que antes. El Cheyenne Hawk Pen es compatible con su propio agarre de 0.827 in y 0.984 in, el sistema de cartuchos Cheyenne y las fuentes de alimentación PU I y PU II y los cables de alimentación Cheyenne Thunder y Spirit. Otras marcas de fuentes de alimentación se pueden utilizar con el Hawk Pen, pero necesitarán un cable adaptador dependiendo de su fuente de alimentación particular (enchufes rojos/negros). Esta máquina no necesita una instalación de arranque.', 2659751.00, 0, 1, 1, 'Hawk Pen - MACH-418', '130 gramos', '25,4 x 123 mm', 'Aluminio', 'Negro, bronce, naranja, morado, rojo y plateado.', 'activo', '2025-02-27 17:32:13', '2025-03-01 21:00:10'),
(11, 'Máquina Tattoo Cheyenne Hawk 10th Anniversary Edition', 'HAWK EDICIÓN 10.º ANIVERSARIO. HAWK fue la primera máquina para tatuar de Cheyenne; se lanzó en el 2007 y ganó inmediatamente muchos fans por todo el mundo. Incluso hoy en día es una de las herramientas para tatuar de mayor calidad, de las más valoradas. Con motivo del décimo aniversario, se ha lanzado una nueva edición limitada del clásico, en dos nuevos colores; un producto único, como suele serlo.', 2318745.00, 1, 1, 1, 'Hawk 10th Anniv. Ed.', '130 gramos', '13 x 3 cm', 'Aluminio', 'Negro', 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(12, 'Maquina Rotativa Para Tattoo Tipo Dragonfly Híbrida', 'Máquina para tatuar rotativa tipo DragonFly X2, super livianas con un motor de excelentes prestaciones. Con conexión para cable clip y cable ficha RCA, funcionan indistintamente.', 38855.00, 8, 1, 10, 'Dragonfly', '99 gramos', '100 x 22 x 75 mm', 'Aleación de aluminio', 'Blanco, dorado, negro, rojo, verde.', 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(13, 'Máquina Tattoo Custom Mk97-4 Alloy 10w. Pro Liner Shader', 'Máquina para tatuar con bobinas de 10w. para uso profesional.', 45489.00, 7, 1, 4, 'Custom MK97 Alloy', '250 gramos', '10 x 8 x 5 cm', 'Acero de fundición', 'Negro', 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(14, 'Punteras Descartables 25mm X25u - 9 RL', '25 Punteras Descartables STRONG 25mm', 22990.00, 20, 3, 10, NULL, NULL, '25 mm', 'Plástico', NULL, 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13'),
(15, 'Caja Punteras Descartables 30mm. Línea x15 Unidades 11 RT', 'Estas punteras descartables están diseñadas específicamente para su uso con agujas de tatuaje. Cada grip tiene un diámetro de 30mm, ideal para trabajos precisos y definidos, asegurando un resultado limpio y profesional.', 10487.00, 25, 3, 10, NULL, NULL, '30 mm', 'Plástico', NULL, 'activo', '2025-02-27 17:32:13', '2025-02-27 17:32:13');

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
(1, 'Administrador', 'Principal', 'admin@example.com.org', '$2y$10$W6yyu.W7GmkxSZhvSzZ08ugT374S6wD45tDr7AnVG6qf8M5Uz/IZm', 'administrador', '2025-02-27 17:32:14', '2025-02-27 17:32:14', 'activo'),
(2, 'Kole', 'Denesik', 'ritchie.kailey@example.net', '$2y$10$GOwMB45FZB96pzx4uEN7juHcceq6SinwzKZxIQN9hkIUzasoDuu3q', 'cliente', '2025-02-27 17:32:14', '2025-02-27 17:32:14', 'activo'),
(3, 'Crystal', 'Wolf', 'connie67@example.org', '$2y$10$VITk/YWdeMq1TsOkxuujPekopT20JJQkiZcrw4TcpBymsadf0IiDO', 'cliente', '2025-02-27 17:32:14', '2025-02-27 17:32:14', 'activo'),
(4, 'Rosalyn', 'O\'Keefe', 'alejandrin.stiedemann@example.com', '$2y$10$yI1qX86XNYjO0hEx9fgDWOQlRm6d9XNJ91Vdc02oL5XOaeCwez6Ci', 'cliente', '2025-02-27 17:32:14', '2025-02-27 17:32:14', 'activo'),
(5, 'Cornell', 'Hilpert', 'christelle00@example.net', '$2y$10$Vom8HqfZ8VL78XkU5vCSaO64wl/zj.Cux5NV0/J51xWoHJZ3lxg72', 'cliente', '2025-02-27 17:32:14', '2025-02-27 17:32:14', 'activo'),
(6, 'Osborne', 'Shanahan', 'kbode@example.org', '$2y$10$J2vYGxaa.12ptIBxR4FKH.Yi2suMMXujwz2EuF/IS/g0u00qOFfBe', 'cliente', '2025-02-27 17:32:14', '2025-02-27 17:32:14', 'activo'),
(7, 'Alta', 'Kris', 'jglover@example.net', '$2y$10$Wk.7190V5bAICEE0O2/XSeJfV98lgaU9UO5xYFFpwkLaT/6aBJjbq', 'cliente', '2025-02-27 17:32:14', '2025-02-27 17:32:14', 'activo'),
(8, 'Roy', 'Corwin', 'damore.rickie@example.com', '$2y$10$a6aP3CYP1mjt0VE6XvwKFOxeOJycvVvsUWUabfhpZ59sreZLIIwRq', 'cliente', '2025-02-27 17:32:14', '2025-02-27 17:32:14', 'activo'),
(9, 'Alejandra', 'Schroeder', 'jana75@example.org', '$2y$10$5bJloKf3QqSm2VXrm9FezuYj/vUUkjzvTGFu1hgM3w7iGdxiCbQRG', 'cliente', '2025-02-27 17:32:14', '2025-02-27 17:32:14', 'activo'),
(10, 'Gwen', 'Mitchell', 'camron09@example.org', '$2y$10$e8p2X63Y.JZEyrBzpjZpZef9hklGOn1pvgBtil4l3fXqAoLSLdYPq', 'cliente', '2025-02-27 17:32:14', '2025-02-27 17:32:14', 'activo'),
(11, 'Viola', 'Boyle', 'nikko45@example.net', '$2y$10$PVWFi/CS65qQsRFJnSlXTufsWmlK104eo/Tsu5caqX7.dzDN1q/3K', 'cliente', '2025-02-27 17:32:14', '2025-02-27 17:32:14', 'activo'),
(12, 'Misty', 'Herzog', 'robb.bernhard@example.net', '$2y$10$7e9sg3RnjomdzZIvWCO2zuh1xr4zCaMJmSqoDlfDVqUXbLucKR4Sm', 'cliente', '2025-02-27 17:32:14', '2025-02-27 17:32:14', 'activo'),
(13, 'Maverick', 'Franecki', 'jskiles@example.org', '$2y$10$sS7.4mTknfKD1iGJNKUcx.sRykD7q4ppeVjdHmQtOiy24N9n8v4IG', 'cliente', '2025-02-27 17:32:14', '2025-02-27 17:32:14', 'activo'),
(14, 'Jammie', 'Sipes', 'josiah40@example.org', '$2y$10$fRSKYyn6WvChzYGpprTOGe0w8UKGxN4o.uiOjuCYjfSJEBW5VtK8G', 'cliente', '2025-02-27 17:32:14', '2025-02-27 17:32:14', 'activo'),
(15, 'Fay', 'O\'Reilly', 'rogahn.johann@example.net', '$2y$10$L3XrotXoHQyRR2XCCxjsu.HN0w1jEDDoPS4YXvn6Oxh3x8pvvPEpG', 'cliente', '2025-02-27 17:32:14', '2025-02-27 17:32:14', 'activo'),
(16, 'Gloria', 'Heidenreich', 'harry.monahan@example.com', '$2y$10$EuMwxDqnyHqD5CT6hq2E0.Xon4xCelt8ccU9Rhoj/QeZ4rKMXK7la', 'cliente', '2025-02-27 17:32:14', '2025-02-27 17:32:14', 'activo'),
(17, 'Broderick', 'Weimann', 'sammy.kilback@example.net', '$2y$10$7OP9i1mtKIhoDW5zgKt7sOsxp9MFlIrcXOD4MU.0XDTAKn45.fN22', 'cliente', '2025-02-27 17:32:14', '2025-02-27 17:32:14', 'activo'),
(18, 'Christ', 'Rolfson', 'amaya.wintheiser@example.net', '$2y$10$DlCWvuTbv7LqQf1VLKNCt.tZVo6DF1pAgp/C7ZqwTeut4Odh8MEdm', 'cliente', '2025-02-27 17:32:14', '2025-02-27 17:32:14', 'activo'),
(19, 'Domenica', 'Glover', 'coy85@example.com', '$2y$10$lJmwxWV2QoLFfJWSQxW6k.UTNuOcSFQ14b2/Vfw.1904/SpnwMzVy', 'cliente', '2025-02-27 17:32:14', '2025-02-27 17:32:14', 'activo'),
(20, 'Doris', 'Hill', 'angelica.krajcik@example.com', '$2y$10$YYzv3LKu4/PXw0TNQfJ7XexhYTRjYjf0GAcQcPp4.8kJtZM9xB7dK', 'cliente', '2025-02-27 17:32:14', '2025-02-27 17:32:14', 'activo'),
(21, 'Floy', 'Herzog', 'reyna.murray@example.com', '$2y$10$Iducuqfnhkfrmv.3zX1TzeoQrk9qEKys0XnJ3t8MteCwV4zd6rnG2', 'cliente', '2025-02-27 17:32:14', '2025-02-27 17:32:14', 'activo'),
(22, 'Enrique Ramon', 'Torres Gamarra', 'enriqueramontg@gmail.com', '$2y$10$QaGeI5lTGF.4pg2GCzXtKus/9rxeFLfNXW//XEe5mhAmIF2yN7pVK', 'cliente', '2025-02-27 17:32:27', '2025-03-02 00:22:56', 'activo');

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `conversaciones`
--
ALTER TABLE `conversaciones`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `detalle_orden`
--
ALTER TABLE `detalle_orden`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `imagenes_productos`
--
ALTER TABLE `imagenes_productos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
