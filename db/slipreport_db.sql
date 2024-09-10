-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 10, 2024 at 08:21 AM
-- Server version: 8.0.35-cll-lve
-- PHP Version: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zfpszw10_slipreport_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `student_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `slip_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `lname`, `student_id`, `slip_img`, `status`, `update_date`, `created_at`) VALUES
(1, 'Akarawee', 'Yingyong', '6735277029', 'slip-00050.png', '200', '2024-09-09 17:45:02', '2024-09-09 09:59:32');

-- --------------------------------------------------------

--
-- Table structure for table `employees_log`
--

CREATE TABLE `employees_log` (
  `id` int NOT NULL,
  `employee_id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `student_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `slip_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees_log`
--

INSERT INTO `employees_log` (`id`, `employee_id`, `name`, `lname`, `student_id`, `slip_img`, `status`, `update_date`, `created_at`) VALUES
(1, 1, 'Akarawee', 'Yingyong', '6735277029', 'slip-00050.png', '100', NULL, '2024-09-09 09:59:32'),
(2, 1, 'Akarawee', 'Yingyong', '6735277029', 'slip-00050.png', '100', NULL, '2024-09-09 09:59:32'),
(3, 1, 'Akarawee', 'Yingyong', '6735277029', 'slip-00050.png', '200', '2024-09-09 17:28:01', '2024-09-09 09:59:32'),
(4, 1, 'Akarawee', 'Yingyong', '6735277029', 'slip-00050.png', '200', '2024-09-09 17:31:46', '2024-09-09 09:59:32');

-- --------------------------------------------------------

--
-- Table structure for table `employees_log_x`
--

CREATE TABLE `employees_log_x` (
  `id` int NOT NULL,
  `employee_id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `student_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `slip_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees_log_x`
--

INSERT INTO `employees_log_x` (`id`, `employee_id`, `name`, `lname`, `student_id`, `slip_img`, `status`, `update_date`, `created_at`) VALUES
(1, 1, 'Akarawee', 'Yingyong', '6735277029', 'slip-00050.png', '100', NULL, '2024-09-09 09:59:32');

-- --------------------------------------------------------

--
-- Table structure for table `employees_x`
--

CREATE TABLE `employees_x` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `student_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `slip_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees_x`
--

INSERT INTO `employees_x` (`id`, `name`, `lname`, `student_id`, `slip_img`, `status`, `update_date`, `created_at`) VALUES
(1, 'Akarawee', 'Yingyong', '6735277029', 'slip-00050.png', '100', NULL, '2024-09-09 09:59:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `employees_log`
--
ALTER TABLE `employees_log`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `employees_log_x`
--
ALTER TABLE `employees_log_x`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `employees_x`
--
ALTER TABLE `employees_x`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employees_log`
--
ALTER TABLE `employees_log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employees_log_x`
--
ALTER TABLE `employees_log_x`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employees_x`
--
ALTER TABLE `employees_x`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
