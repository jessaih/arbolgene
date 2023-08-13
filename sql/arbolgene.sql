-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2023 at 06:13 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arbolgene`
--

-- --------------------------------------------------------

--
-- Table structure for table `descendiente`
--

CREATE TABLE `descendiente` (
  `descendiente_id` int(11) NOT NULL,
  `pareja_id_fk` int(11) DEFAULT NULL,
  `familiar_id_fk` int(11) NOT NULL,
  `numero_hermano` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `descendiente`
--

INSERT INTO `descendiente` (`descendiente_id`, `pareja_id_fk`, `familiar_id_fk`, `numero_hermano`) VALUES
(1, 1, 3, 1),
(2, 1, 4, 2),
(3, 2, 7, 1),
(4, 3, 1, 1),
(5, NULL, 2, 1),
(6, NULL, 8, 1),
(7, NULL, 9, 1),
(19, 3, 21, 2),
(22, 3, 27, 3),
(23, 3, 29, 4),
(24, 3, 47, 5),
(28, 3, 56, 6),
(29, 4, 58, 0),
(30, 4, 70, 1);

-- --------------------------------------------------------

--
-- Table structure for table `familiar`
--

CREATE TABLE `familiar` (
  `familiar_id` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `notas` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `familiar`
--

INSERT INTO `familiar` (`familiar_id`, `nombres`, `apellidos`, `notas`) VALUES
(1, 'Josefa', 'González González', NULL),
(2, 'Franscisco', 'González García', NULL),
(3, 'Joaquín', 'González González', NULL),
(4, 'Carlos', 'González González', NULL),
(5, 'José Luis', 'González Meza', NULL),
(6, 'Adela', 'Moreno', NULL),
(7, 'Juan José', 'González Moreno', NULL),
(8, 'Francisco', 'González', '1'),
(9, 'Francisca', 'González', '2'),
(21, 'Maria', 'González González', 'Segunda hija'),
(26, 'Eugenio', 'Lara Lara', 'algo'),
(27, 'Antonio', 'González González', ''),
(28, 'Claudia', 'F F', ''),
(29, 'Francisca', 'González González', 'zzzzz'),
(46, 'Alberto', 'Perez Perez', 'algo'),
(47, 'Teodomira', 'González González', ''),
(51, 'tres3', 'tres3', '33'),
(53, 'cuatro', 'cuatro', '4'),
(54, 'Francisca', 'González', ''),
(55, 'Alfredo', 'Gomez', 'Un hombre fuera de serie'),
(56, 'Mariana', 'González', 'Uuuuy'),
(57, 'Mario', 'Fernández', 'Algo más'),
(58, 'A11', 'B11', 'C11'),
(59, 'E', 'F', 'G'),
(60, 'E', 'F', 'G'),
(61, 'E', 'F', 'G'),
(62, 'G', 'H', 'I'),
(63, 'E', 'F', 'G'),
(64, 'E', 'F', 'G'),
(65, 'E', 'F', 'HG'),
(66, 'E', 'F', 'G'),
(67, 'G1', 'H1', 'E1'),
(68, 'Ricarda', 'Meza', ''),
(69, 'bbb', 'bbbb', 'bbbb'),
(70, 'a12', 'a12', '');

-- --------------------------------------------------------

--
-- Table structure for table `familiar_info`
--

CREATE TABLE `familiar_info` (
  `familiar_info_id` int(11) NOT NULL,
  `ruta_img` varchar(100) DEFAULT NULL,
  `familiar_id_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `familiar_info`
--

INSERT INTO `familiar_info` (`familiar_info_id`, `ruta_img`, `familiar_id_fk`) VALUES
(1, 'img1.jpg', 1),
(2, 'img2.jpg', 1),
(3, 'img3.jpg', 4),
(15, '21img2.jpg', 21),
(17, '27img4.jpg', 27),
(18, '47img6.jpg', 47),
(24, '53img4.jpg', 53),
(25, '8product-img-4.jpg', 8),
(26, '9product-img-6.jpg', 9),
(27, '56product-img-5.jpg', 56),
(28, '57product-img-3.jpg', 57),
(29, '59product-img-5.jpg', 59),
(30, '60product-img-5.jpg', 60),
(31, '61product-img-1.jpg', 61),
(32, '62product-img-1.jpg', 62),
(33, '67product-img-2.jpg', 67),
(34, '58product-img-3.jpg', 58);

-- --------------------------------------------------------

--
-- Table structure for table `pareja`
--

CREATE TABLE `pareja` (
  `pareja_id` int(11) NOT NULL,
  `esposo_id_fk` int(11) NOT NULL,
  `esposa_id_fk` int(11) NOT NULL,
  `nivel` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `pareja`
--

INSERT INTO `pareja` (`pareja_id`, `esposo_id_fk`, `esposa_id_fk`, `nivel`) VALUES
(1, 1, 2, 2),
(2, 5, 6, 3),
(3, 9, 8, 1),
(4, 21, 26, 1),
(5, 27, 28, 1),
(14, 29, 46, 2),
(15, 51, 53, 2),
(16, 47, 55, 2),
(17, 56, 57, 2),
(26, 3, 68, 3),
(27, 58, 69, 2);

-- --------------------------------------------------------

--
-- Table structure for table `pareja_info`
--

CREATE TABLE `pareja_info` (
  `pareja_info_id` int(11) NOT NULL,
  `pareja_id_fk` int(11) NOT NULL,
  `ruta_img` varchar(100) NOT NULL,
  `notas` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `pareja_info`
--

INSERT INTO `pareja_info` (`pareja_info_id`, `pareja_id_fk`, `ruta_img`, `notas`) VALUES
(1, 17, 'img1.jpg', 'Pareja en 1850'),
(2, 3, '3product-img-4.jpg', 'muy bello2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `descendiente`
--
ALTER TABLE `descendiente`
  ADD PRIMARY KEY (`descendiente_id`,`familiar_id_fk`),
  ADD KEY `fk_descendiente_familiar1` (`familiar_id_fk`),
  ADD KEY `fk_descendiente_pareja1` (`pareja_id_fk`);

--
-- Indexes for table `familiar`
--
ALTER TABLE `familiar`
  ADD PRIMARY KEY (`familiar_id`);

--
-- Indexes for table `familiar_info`
--
ALTER TABLE `familiar_info`
  ADD PRIMARY KEY (`familiar_info_id`,`familiar_id_fk`),
  ADD KEY `fk_familiar_info_familiar1` (`familiar_id_fk`);

--
-- Indexes for table `pareja`
--
ALTER TABLE `pareja`
  ADD PRIMARY KEY (`pareja_id`,`esposa_id_fk`,`esposo_id_fk`),
  ADD KEY `fk_pareja_familiar` (`esposo_id_fk`),
  ADD KEY `fk_pareja_familiar1` (`esposa_id_fk`);

--
-- Indexes for table `pareja_info`
--
ALTER TABLE `pareja_info`
  ADD PRIMARY KEY (`pareja_info_id`,`pareja_id_fk`),
  ADD KEY `fk_pareja_info_pareja1` (`pareja_id_fk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `descendiente`
--
ALTER TABLE `descendiente`
  MODIFY `descendiente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `familiar`
--
ALTER TABLE `familiar`
  MODIFY `familiar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `familiar_info`
--
ALTER TABLE `familiar_info`
  MODIFY `familiar_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `pareja`
--
ALTER TABLE `pareja`
  MODIFY `pareja_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `pareja_info`
--
ALTER TABLE `pareja_info`
  MODIFY `pareja_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `descendiente`
--
ALTER TABLE `descendiente`
  ADD CONSTRAINT `fk_descendiente_familiar1` FOREIGN KEY (`familiar_id_fk`) REFERENCES `familiar` (`familiar_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_descendiente_pareja1` FOREIGN KEY (`pareja_id_fk`) REFERENCES `pareja` (`pareja_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `familiar_info`
--
ALTER TABLE `familiar_info`
  ADD CONSTRAINT `fk_familiar_info_familiar1` FOREIGN KEY (`familiar_id_fk`) REFERENCES `familiar` (`familiar_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `pareja`
--
ALTER TABLE `pareja`
  ADD CONSTRAINT `fk_pareja_familiar` FOREIGN KEY (`esposo_id_fk`) REFERENCES `familiar` (`familiar_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pareja_familiar1` FOREIGN KEY (`esposa_id_fk`) REFERENCES `familiar` (`familiar_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `pareja_info`
--
ALTER TABLE `pareja_info`
  ADD CONSTRAINT `fk_pareja_info_pareja1` FOREIGN KEY (`pareja_id_fk`) REFERENCES `pareja` (`pareja_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
