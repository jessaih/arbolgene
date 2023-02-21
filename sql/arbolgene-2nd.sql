-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-01-2023 a las 00:30:07
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `arbolgene`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descendiente`
--

CREATE TABLE `descendiente` (
  `descendiente_id` int(11) NOT NULL,
  `pareja_id_fk` int(11) DEFAULT NULL,
  `familiar_id_fk` int(11) NOT NULL,
  `numero_hermano` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `descendiente`
--

INSERT INTO `descendiente` (`descendiente_id`, `pareja_id_fk`, `familiar_id_fk`, `numero_hermano`) VALUES
(1, 1, 3, 1),
(2, 1, 4, 2),
(3, 2, 7, 1),
(4, 3, 1, 1),
(5, NULL, 2, 1),
(6, NULL, 8, 1),
(7, NULL, 9, 1),
(8, 3, 10, 2),
(9, 3, 11, 3),
(10, 3, 12, 4),
(11, 3, 13, 5),
(12, 3, 14, 6),
(13, 3, 15, 12),
(14, 3, 16, 3),
(15, 3, 17, 44),
(16, 3, 18, 54),
(17, 3, 19, 43),
(18, 3, 20, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familiar`
--

CREATE TABLE `familiar` (
  `familiar_id` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `notas` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `familiar`
--

INSERT INTO `familiar` (`familiar_id`, `nombres`, `apellidos`, `notas`) VALUES
(1, 'Josefa', 'González González', NULL),
(2, 'Franscisco', 'González García', NULL),
(3, 'Joaquín', 'González González', NULL),
(4, 'Carlos', 'González González', NULL),
(5, 'José Luis', 'González Meza', NULL),
(6, 'Adela', 'Moreno', NULL),
(7, 'Juan José', 'González Moreno', NULL),
(8, 'Francisco', 'González', NULL),
(9, 'Francisca', 'González', NULL),
(10, 'mra', '', 'aaaa'),
(11, 'aaa', 'glez', 'gleeeeez'),
(12, 'fger', 'erdf4', 'rrrrr'),
(13, 'fff', 'ffffff', 'qqqq'),
(14, 'gggg', 'rrrrr', 'rrrrr'),
(15, 'e', 'e', '333'),
(16, 'eeee', 'eeee', '333'),
(17, 'aaaa', 'eeee', 'aaaa'),
(18, 'ffff', 'ffffff', 'eeee'),
(19, 'g', 'rg', '3'),
(20, 'aaa', 'de', '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familiar_info`
--

CREATE TABLE `familiar_info` (
  `familiar_info_id` int(11) NOT NULL,
  `ruta_img` varchar(100) DEFAULT NULL,
  `familiar_id_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `familiar_info`
--

INSERT INTO `familiar_info` (`familiar_info_id`, `ruta_img`, `familiar_id_fk`) VALUES
(1, 'img1.jpg', 1),
(2, 'img2.jpg', 1),
(3, 'img3.jpg', 4),
(4, 'bd.png', 10),
(5, 'bd.png', 11),
(6, '12bd.png', 12),
(7, '13bd.png', 13),
(8, '14bd.png', 14),
(9, '15bd.png', 15),
(10, '16bd.png', 16),
(11, '17bd.png', 17),
(12, '18bd.png', 18),
(13, '19bd.png', 19),
(14, '20bd.png', 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pareja`
--

CREATE TABLE `pareja` (
  `pareja_id` int(11) NOT NULL,
  `esposo_id_fk` int(11) NOT NULL,
  `esposa_id_fk` int(11) NOT NULL,
  `nivel` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `pareja`
--

INSERT INTO `pareja` (`pareja_id`, `esposo_id_fk`, `esposa_id_fk`, `nivel`) VALUES
(1, 1, 2, 2),
(2, 5, 6, 3),
(3, 8, 9, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pareja_info`
--

CREATE TABLE `pareja_info` (
  `pareja_info_id` int(11) NOT NULL,
  `pareja_id_fk` int(11) NOT NULL,
  `ruta_img` varchar(100) NOT NULL,
  `notas` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `pareja_info`
--

INSERT INTO `pareja_info` (`pareja_info_id`, `pareja_id_fk`, `ruta_img`, `notas`) VALUES
(1, 3, 'img1.jpg', 'Pareja en 1850'),
(2, 3, 'img2.jpg', 'Pareja en 1856'),
(3, 3, 'img3.jpg', 'Muy felices en 1870'),
(4, 3, 'img4.jpg', 'Prueba de comentario'),
(5, 3, 'img5.jpg', 'Pareja en 1888'),
(6, 3, 'img6.jpg', 'Muy felices en 1900');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `descendiente`
--
ALTER TABLE `descendiente`
  ADD PRIMARY KEY (`descendiente_id`,`familiar_id_fk`),
  ADD KEY `fk_descendiente_familiar1` (`familiar_id_fk`),
  ADD KEY `fk_descendiente_pareja1` (`pareja_id_fk`);

--
-- Indices de la tabla `familiar`
--
ALTER TABLE `familiar`
  ADD PRIMARY KEY (`familiar_id`);

--
-- Indices de la tabla `familiar_info`
--
ALTER TABLE `familiar_info`
  ADD PRIMARY KEY (`familiar_info_id`,`familiar_id_fk`),
  ADD KEY `fk_familiar_info_familiar1` (`familiar_id_fk`);

--
-- Indices de la tabla `pareja`
--
ALTER TABLE `pareja`
  ADD PRIMARY KEY (`pareja_id`,`esposa_id_fk`,`esposo_id_fk`),
  ADD KEY `fk_pareja_familiar` (`esposo_id_fk`),
  ADD KEY `fk_pareja_familiar1` (`esposa_id_fk`);

--
-- Indices de la tabla `pareja_info`
--
ALTER TABLE `pareja_info`
  ADD PRIMARY KEY (`pareja_info_id`,`pareja_id_fk`),
  ADD KEY `fk_pareja_info_pareja1` (`pareja_id_fk`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `descendiente`
--
ALTER TABLE `descendiente`
  MODIFY `descendiente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `familiar`
--
ALTER TABLE `familiar`
  MODIFY `familiar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `familiar_info`
--
ALTER TABLE `familiar_info`
  MODIFY `familiar_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `pareja`
--
ALTER TABLE `pareja`
  MODIFY `pareja_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pareja_info`
--
ALTER TABLE `pareja_info`
  MODIFY `pareja_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `descendiente`
--
ALTER TABLE `descendiente`
  ADD CONSTRAINT `fk_descendiente_familiar1` FOREIGN KEY (`familiar_id_fk`) REFERENCES `familiar` (`familiar_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_descendiente_pareja1` FOREIGN KEY (`pareja_id_fk`) REFERENCES `pareja` (`pareja_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `familiar_info`
--
ALTER TABLE `familiar_info`
  ADD CONSTRAINT `fk_familiar_info_familiar1` FOREIGN KEY (`familiar_id_fk`) REFERENCES `familiar` (`familiar_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pareja`
--
ALTER TABLE `pareja`
  ADD CONSTRAINT `fk_pareja_familiar` FOREIGN KEY (`esposo_id_fk`) REFERENCES `familiar` (`familiar_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pareja_familiar1` FOREIGN KEY (`esposa_id_fk`) REFERENCES `familiar` (`familiar_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pareja_info`
--
ALTER TABLE `pareja_info`
  ADD CONSTRAINT `fk_pareja_info_pareja1` FOREIGN KEY (`pareja_id_fk`) REFERENCES `pareja` (`pareja_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
