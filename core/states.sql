-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2026 at 12:45 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nnpc`
--

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `capital` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `capital`, `created_at`) VALUES
(1, 'Abia', 'Umuahia', '2026-02-26 13:32:12'),
(2, 'Adamawa', 'Yola', '2026-02-26 13:32:12'),
(3, 'Akwa Ibom', 'Uyo', '2026-02-26 13:32:12'),
(4, 'Anambra', 'Awka', '2026-02-26 13:32:12'),
(5, 'Bauchi', 'Bauchi', '2026-02-26 13:32:12'),
(6, 'Bayelsa', 'Yenagoa', '2026-02-26 13:32:12'),
(7, 'Benue', 'Makurdi', '2026-02-26 13:32:12'),
(8, 'Borno', 'Maiduguri', '2026-02-26 13:32:12'),
(9, 'Cross River', 'Calabar', '2026-02-26 13:32:12'),
(10, 'Delta', 'Asaba', '2026-02-26 13:32:12'),
(11, 'Ebonyi', 'Abakaliki', '2026-02-26 13:32:12'),
(12, 'Edo', 'Benin City', '2026-02-26 13:32:12'),
(13, 'Ekiti', 'Ado Ekiti', '2026-02-26 13:32:12'),
(14, 'Enugu', 'Enugu', '2026-02-26 13:32:12'),
(15, 'Gombe', 'Gombe', '2026-02-26 13:32:12'),
(16, 'Imo', 'Owerri', '2026-02-26 13:32:12'),
(17, 'Jigawa', 'Dutse', '2026-02-26 13:32:12'),
(18, 'Kaduna', 'Kaduna', '2026-02-26 13:32:12'),
(19, 'Kano', 'Kano', '2026-02-26 13:32:12'),
(20, 'Katsina', 'Katsina', '2026-02-26 13:32:12'),
(21, 'Kebbi', 'Birnin Kebbi', '2026-02-26 13:32:12'),
(22, 'Kogi', 'Lokoja', '2026-02-26 13:32:12'),
(23, 'Kwara', 'Ilorin', '2026-02-26 13:32:12'),
(24, 'Lagos', 'Ikeja', '2026-02-26 13:32:12'),
(25, 'Nasarawa', 'Lafia', '2026-02-26 13:32:12'),
(26, 'Niger', 'Minna', '2026-02-26 13:32:12'),
(27, 'Ogun', 'Abeokuta', '2026-02-26 13:32:12'),
(28, 'Ondo', 'Akure', '2026-02-26 13:32:12'),
(29, 'Osun', 'Oshogbo', '2026-02-26 13:32:12'),
(30, 'Oyo', 'Ibadan', '2026-02-26 13:32:12'),
(31, 'Plateau', 'Jos', '2026-02-26 13:32:12'),
(32, 'Rivers', 'Port Harcourt', '2026-02-26 13:32:12'),
(33, 'Sokoto', 'Sokoto', '2026-02-26 13:32:12'),
(34, 'Taraba', 'Jalingo', '2026-02-26 13:32:12'),
(35, 'Yobe', 'Damaturu', '2026-02-26 13:32:12'),
(36, 'Zamfara', 'Gusau', '2026-02-26 13:32:12'),
(37, 'Federal Capital Territory', 'Abuja', '2026-02-26 13:32:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
