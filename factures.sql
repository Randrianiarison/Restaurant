-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 21, 2023 at 05:02 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurants`
--

-- --------------------------------------------------------

--
-- Table structure for table `factures`
--

CREATE TABLE `factures` (
  `id` int NOT NULL,
  `Nom` varchar(255) DEFAULT NULL,
  `Plat` varchar(255) DEFAULT NULL,
  `Nombre` int DEFAULT NULL,
  `Somme` decimal(10,2) DEFAULT NULL,
  `Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `factures`
--

INSERT INTO `factures` (`id`, `Nom`, `Plat`, `Nombre`, `Somme`, `Date`) VALUES
(1, 'Aina', 'Pomme Frites', 1, 1500.00, '2023-08-10'),
(2, 'Benja', ' Pizza', 2, 40000.00, '2023-08-10'),
(3, 'Benja', ' Pizza', 2, 40000.00, '2023-08-10'),
(4, 'Benja', ' Pizza', 2, 40000.00, '2023-08-10'),
(5, 'Aina', 'Pomme Frites', 1, 1500.00, '2023-08-10'),
(6, 'fghj,', ' Hulburger', 2, 16000.00, '2023-08-11'),
(7, 'maosa', ' Youzou', 2, 3000.00, '2023-08-14'),
(8, 'Maosa', ' Pizza', 1, 20000.00, '2023-08-14'),
(9, 'benjamina', 'Pomme Frites', 2, 3000.00, '2023-08-14'),
(10, 'Tsilavina', 'Pomme Frites', 2, 3000.00, '2023-08-15'),
(11, 'rakoto', ' Hulburger', 1, 8000.00, '2023-08-19'),
(12, ' Andry', 'Pomme Frites', 2, 3000.00, '2023-08-19'),
(13, '', ' Coca Cola', 2, 4000.00, '2023-08-20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `factures`
--
ALTER TABLE `factures`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `factures`
--
ALTER TABLE `factures`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
