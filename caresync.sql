-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2026 at 09:54 AM
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
-- Database: `caresync`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `activity`, `user`, `created_at`) VALUES
(1, 'New Doctor Added', 'Admin', '2026-03-17 18:59:34'),
(2, 'New Doctor Added', 'Admin', '2026-03-18 14:20:14'),
(3, 'New Patient Registered', 'Admin', '2026-03-18 17:06:25'),
(4, 'New Patient Registered', 'Admin', '2026-03-18 17:18:14'),
(5, 'New Patient Registered', 'Admin', '2026-03-18 17:36:22'),
(6, 'New Patient Registered', 'Admin', '2026-03-18 18:57:26'),
(7, 'New Patient Registered', 'Admin', '2026-03-18 19:00:16'),
(8, 'New Patient Registered', 'Admin', '2026-03-18 19:05:05'),
(9, 'New Doctor Added', 'Admin', '2026-03-18 19:40:26'),
(10, 'New Patient Registered', 'Admin', '2026-03-18 19:50:35'),
(11, 'New Patient Registered', 'Admin', '2026-03-19 14:11:10'),
(12, 'New Doctor Added', 'Admin', '2026-03-19 17:33:47'),
(13, 'New Doctor Added', 'Admin', '2026-03-20 07:50:06');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`name`, `email`, `message`) VALUES
('Manish Sharma', 'SHARMAMANISH5846579@GMAIL.COM', 'bfhghfgh'),
('Manish Sharma', 'SHARMAMANISH5846579@GMAIL.COM', 'ko');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `doctor_code` varchar(20) DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `department` varchar(50) NOT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `experience` int(11) DEFAULT 0,
  `contact` varchar(15) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `doctor_code`, `full_name`, `department`, `specialization`, `experience`, `contact`, `email`, `password`, `created_at`) VALUES
(2, 'DOC-2026-002', 'AnweshaDas ', 'Cardiology', 'Surgeon', 4, '9456312023', 'anweshadas388@gmail.com', '$2y$10$/FaOJ2cx28QQsxopskONyezf/Rk3C1t7HM8wpXv8U2NY8OcYYHYPC', '2026-03-19 17:33:47'),
(3, 'DOC-2026-003', 'Rahul Kumar', 'Orthopedics', 'Surgeon', 2, '8340778990', 'manishsharna081999@gmail.com', '$2y$10$7fHoLMk5hzlfA96SqBWAauYHI01kABHIRKTPcxpxkQBgAO6I2LS5S', '2026-03-20 07:50:06');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `patient_code` varchar(20) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` varchar(10) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `aadhar` varchar(12) DEFAULT NULL,
  `blood_group` varchar(5) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `patient_code`, `full_name`, `email`, `mobile`, `dob`, `gender`, `aadhar`, `blood_group`, `city`, `address`, `password`, `created_at`) VALUES
(3, 'PAT-2026-003', 'Manish Sharma', 'manishsharma081999@gmail.com', '8340778990', '2026-03-04', 'male', '123456789235', 'B+', 'Barajamda', 'Near Reliance Tower Football Ground Barajamda', '$2y$10$PmyYXI7bwCNEcpb/0JWxXeI.z4UpoGvDfTwZmsbV.2RTiDaEt/d5q', '2026-03-19 14:11:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `patient_code` varchar(20) DEFAULT NULL,
  `doctor_code` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `reset_token`, `token_expiry`, `patient_code`, `doctor_code`) VALUES
(2, 'Admin', 'admincaresync@gmail.com', '$2y$10$kY.6iwQF3JZyXIBHjJfhnuqs.PFDBDPfU2fQbT8.3OUjQkBKy6Gwi', 'admin', NULL, NULL, NULL, NULL),
(5, 'Manish Sharma', 'manishsharma081999@gmail.com', '$2y$10$PmyYXI7bwCNEcpb/0JWxXeI.z4UpoGvDfTwZmsbV.2RTiDaEt/d5q', 'patient', '2eb9a1ade2c25828b96d592f118b5e854ecd734e3a0a89c16a7c1d50a38afaba2152c5552bc00cdfbe9cf74c21ebfe2713be', '2026-03-19 19:29:56', 'PAT-2026-003', NULL),
(6, 'AnweshaDas ', 'anweshadas388@gmail.com', '$2y$10$/FaOJ2cx28QQsxopskONyezf/Rk3C1t7HM8wpXv8U2NY8OcYYHYPC', 'doctor', NULL, NULL, NULL, 'DOC-2026-002'),
(7, 'Rahul Kumar', 'manishsharna081999@gmail.com', '$2y$10$7fHoLMk5hzlfA96SqBWAauYHI01kABHIRKTPcxpxkQBgAO6I2LS5S', 'doctor', NULL, NULL, NULL, 'DOC-2026-003');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password` (`password`),
  ADD UNIQUE KEY `doctor_code` (`doctor_code`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patient_code` (`patient_code`),
  ADD UNIQUE KEY `aadhar` (`aadhar`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password` (`password`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patient_code` (`patient_code`),
  ADD UNIQUE KEY `doctor_code` (`doctor_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
