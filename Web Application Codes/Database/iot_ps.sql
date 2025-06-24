-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2025 at 09:14 AM
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
-- Database: `iot_ps`
--

-- --------------------------------------------------------

--
-- Table structure for table `parkings`
--

CREATE TABLE `parkings` (
  `id` int(11) NOT NULL,
  `parking_code` varchar(50) DEFAULT NULL,
  `parking_type` varchar(20) DEFAULT NULL,
  `parking_name` varchar(100) NOT NULL,
  `price` float NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parkings`
--

INSERT INTO `parkings` (`id`, `parking_code`, `parking_type`, `parking_name`, `price`, `status`, `location`) VALUES
(1, 'SLT0001', NULL, 'Slot 1', 30, 0, 'House on Fire'),
(2, 'SLT0002', NULL, 'Slot 2', 30, 1, 'House on Fire'),
(3, 'SLT0003', NULL, 'Slot 3', 30, 1, 'House on Fire'),
(4, 'SLT0004', NULL, 'Slot 4', 30, 1, 'House on Fire');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `user` varchar(255) DEFAULT NULL,
  `vehicle_registration` varchar(20) DEFAULT NULL,
  `parking_code` varchar(255) DEFAULT NULL,
  `reserved_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `parked_at` timestamp NULL DEFAULT NULL,
  `left_at` timestamp NULL DEFAULT NULL,
  `init_duration` float NOT NULL,
  `amount_paid` float NOT NULL,
  `payment_method` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `user`, `vehicle_registration`, `parking_code`, `reserved_at`, `parked_at`, `left_at`, `init_duration`, `amount_paid`, `payment_method`) VALUES
(4, 'philanivilakatig@gmail.com', 'Choose your vehicle', 'SLT0001', '2025-05-01 19:08:59', NULL, NULL, 2, 60, 'momo');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `phone`, `password`, `created_at`, `updated_at`) VALUES
(3, 'Zwelakhe Dlamini', 'MceDla@mail.com', '79796707', '827ccb0eea8a706c4c34a16891f84e7b', '2025-03-08 18:58:33', '2025-03-08 18:58:33'),
(4, 'Wiseman', 'wisistohlophes@gmail.com', '78295776', '827ccb0eea8a706c4c34a16891f84e7b', '2025-04-18 07:58:43', '2025-04-18 07:58:43'),
(5, 'Mceisi', 'dlamini@gmail.com', '78295776', '81dc9bdb52d04dc20036dbd8313ed055', '2025-04-21 11:25:56', '2025-04-21 11:25:56'),
(6, 'Musa', 'mk@gmail.com', '76992262', '81dc9bdb52d04dc20036dbd8313ed055', '2025-04-21 12:03:23', '2025-04-21 12:03:23'),
(7, 'Philan', 'philanivilakatig@gmail.com', 'Vilakati', '81dc9bdb52d04dc20036dbd8313ed055', '2025-05-01 18:35:27', '2025-05-01 18:35:27');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `vehicle_reg` varchar(10) DEFAULT NULL,
  `owner` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `vehicle_reg`, `owner`, `created_at`) VALUES
(1, 'AAA 000 YZ', 'mk@gmail.com', '2025-05-01 17:11:06'),
(2, 'ZZZ 111 YY', 'mk@gmail.com', '2025-05-01 17:55:31'),
(3, 'XSD 123 Bh', 'philanivilakatig@gmail.com', '2025-05-01 19:08:11'),
(4, 'ASD 214 AL', 'philanivilakatig@gmail.com', '2025-05-01 20:21:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `parkings`
--
ALTER TABLE `parkings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `parkings`
--
ALTER TABLE `parkings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
