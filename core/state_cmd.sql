-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2026 at 12:26 PM
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
-- Database: `cme`
--

-- --------------------------------------------------------

--
-- Table structure for table `state_cmd`
--

CREATE TABLE `state_cmd` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `capital` varchar(100) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `zone` char(1) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `statecode` varchar(255) NOT NULL,
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `state_cmd`
--

INSERT INTO `state_cmd` (`id`, `name`, `capital`, `category`, `zone`, `description`, `statecode`, `status`) VALUES
(1, 'Abia', 'Umuahia', 'Command', 'E', NULL, '', 1),
(2, 'Adamawa', 'Yola', 'Command', 'C', NULL, '', 1),
(3, 'Akwa Ibom', 'Uyo', 'Command', 'E', NULL, '', 1),
(4, 'Anambra', 'Awka', 'Command', 'G', NULL, '', 1),
(5, 'Bauchi', 'Bauchi', 'Command', 'C', NULL, '', 1),
(6, 'Bayelsa', 'Yenagoa', 'Command', 'G', NULL, '', 1),
(7, 'Benue', 'Makurdi', 'Command', 'H', NULL, '', 1),
(8, 'Borno', 'Maiduguri', 'Command', 'C', NULL, '', 1),
(9, 'Cross River', 'Calabar', 'Command', 'E', NULL, '', 1),
(10, 'Delta', 'Asaba', 'Command', 'G', NULL, '', 1),
(11, 'Ebonyi', 'Abakaliki', 'Command', 'E', NULL, '', 1),
(12, 'Edo', 'Benin City', 'Command', 'G', NULL, '', 1),
(13, 'Ekiti', 'Ado Ekiti', 'Command', 'F', NULL, '', 1),
(14, 'Enugu', 'Enugu', 'Command', 'G', NULL, '', 1),
(15, 'Gombe', 'Gombe', 'Command', 'C', NULL, '', 1),
(16, 'Imo', 'Owerri', 'Command', 'E', NULL, '', 1),
(17, 'Jigawa', 'Dutse', 'Command', 'B', NULL, '', 1),
(18, 'Kaduna', 'Kaduna', 'Command', 'B', NULL, '', 1),
(19, 'Kano', 'Kano', 'Command', 'B', NULL, '', 1),
(20, 'Katsina', 'Katsina', 'Command', 'B', NULL, '', 1),
(21, 'Kebbi', 'Birnin Kebbi', 'Command', 'D', NULL, '', 1),
(22, 'Kogi', 'Lokoja', 'Command', 'H', NULL, '', 1),
(23, 'Kwara', 'Ilorin', 'Command', 'D', NULL, '', 1),
(24, 'Lagos', 'Ikeja', 'Command', 'A', NULL, '', 1),
(25, 'Nasarawa', 'Lafia', 'Command', 'H', NULL, '', 1),
(26, 'Niger', 'Minna', 'Command', 'D', NULL, '', 1),
(27, 'Ogun', 'Abeokuta', 'Command', 'A', NULL, '', 1),
(28, 'Ondo', 'Akure', 'Command', 'F', NULL, '', 1),
(29, 'Osun', 'Oshogbo', 'Command', 'F', NULL, '', 1),
(30, 'Oyo', 'Ibadan', 'Command', 'F', NULL, '', 1),
(31, 'Plateau', 'Jos', 'Command', 'H', NULL, '', 1),
(32, 'Rivers', 'Port Harcourt', 'Command', 'E', NULL, '', 1),
(33, 'Sokoto', 'Sokoto', 'Command', 'B', NULL, '', 1),
(34, 'Taraba', 'Jalingo', 'Command', 'H', NULL, '', 1),
(35, 'Yobe', 'Damaturu', 'Command', 'C', NULL, '', 1),
(36, 'Zamfara', 'Gusau', 'Command', 'B', NULL, '', 1),
(37, 'Federal Capital Territory', 'Abuja', 'SHQ', 'D', NULL, '', 1),
(38, 'CGIS OFFICE', NULL, 'Office', 'S', 'Comptroller General of Immigration Service Office', '', 1),
(39, 'BM DIRECTORATE', NULL, 'Directorate', 'S', 'Border Management Directorate', '', 1),
(40, 'F & A DIRECTORATE', NULL, 'Directorate', 'S', 'Finance and Accounts Directorate', '', 1),
(41, 'HRM DIRECTORATE', NULL, 'Directorate', 'S', 'Human Resource Management Directorate', '', 1),
(42, 'ICT & CS DIRECTORATE', NULL, 'Directorate', 'S', 'Information & Communication Technology and Citizen Services Directorate', '', 1),
(43, 'I & C DIRECTORATE', NULL, 'Directorate', 'S', 'Investigation and Compliance Directorate', '', 1),
(44, 'MIG DIRECTORATE', NULL, 'Directorate', 'S', 'Migration Directorate', '', 1),
(45, 'POTD DIRECTORATE', NULL, 'Directorate', 'S', 'Passport & Other Travel Documents Directorate', '', 1),
(46, 'PRS DIRECTORATE', NULL, 'Directorate', 'S', 'Planning, Research & Statistics Directorate', '', 1),
(47, 'V & R DIRECTORATE', NULL, 'Directorate', 'S', 'Visa & Residency Directorate', '', 1),
(48, 'W & L DIRECTORATE', NULL, 'Directorate', 'S', 'Works & Logistics Directorate', '', 1),
(49, 'ICSC (SOKOTO) TRAINING INSTITUTION', NULL, 'Training', 'B', 'Immigration Command & Staff College Sokoto', '', 1),
(50, 'ITSK (KANO) TRAINING INSTITUTION', NULL, 'Training', 'B', 'Immigration Training School Kano', '', 1),
(51, 'NITSA (AHOADA) TRAINING INSTITUTION', NULL, 'Training', 'E', 'Nigeria Immigration Training School Ahoada', '', 1),
(52, 'NITSOL (ORLU) TRAINING INSTITUTION', NULL, 'Training', 'E', 'Nigeria Immigration Training School Orlu', '', 1),
(53, 'FOREIGN MISSION', NULL, 'Specialized Command', 'S', 'Nigeria Immigration Service Foreign Missions Operations', '', 1),
(54, 'IDIROKO BORDER CMD', NULL, 'Specialized Command', 'A', 'Idiroko Border Command (Nigeria–Benin Border)', '', 1),
(55, 'ILLELA BORDER CMD', NULL, 'Specialized Command', 'B', 'Illela Border Command (Nigeria–Niger Border)', '', 1),
(56, 'JIBYA BORDER CMD', NULL, 'Specialized Command', 'B', 'Jibiya Border Command (Nigeria–Niger Border)', '', 1),
(57, 'LAGOS BORDER CMD', NULL, 'Specialized Command', 'A', 'Lagos Border Patrol Command', '', 1),
(58, 'LAGOS PASSPORT CMD', NULL, 'Specialized Command', 'A', 'Lagos Passport Command', '', 1),
(59, 'LAGOS SEAPORT CMD', NULL, 'Specialized Command', 'A', 'Lagos Seaport Immigration Command', '', 1),
(60, 'MAKIA CMD', NULL, 'Specialized Command', 'A', 'Mallam Aminu Kano Int\'l Airport Immigration Command', '', 1),
(61, 'MMIA CMD', NULL, 'Specialized Command', 'A', 'Murtala Muhammed Int\'l Airport Immigration Command', '', 1),
(62, 'NAIA CMD', NULL, 'Specialized Command', 'D', 'Nnamdi Azikiwe Int\'l Airport Immigration Command', '', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `state_cmd`
--
ALTER TABLE `state_cmd`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
