-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2026 at 12:37 PM
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
(13, 'New Doctor Added', 'Admin', '2026-03-20 07:50:06'),
(14, 'New Patient Registered', 'Admin', '2026-03-20 16:03:50'),
(15, 'New Patient Registered', 'Admin', '2026-03-20 16:05:17'),
(16, 'New Patient Registered', 'Admin', '2026-03-20 16:23:40'),
(17, 'New Doctor Added', 'Admin', '2026-03-20 18:24:13'),
(18, 'New Doctor Added', 'Admin', '2026-03-20 18:37:00'),
(19, 'New Doctor Added', 'Admin', '2026-04-07 11:12:13'),
(20, 'New Doctor Added', 'Admin', '2026-04-10 20:16:45'),
(21, 'New Doctor Added', 'Admin', '2026-04-10 20:23:34'),
(22, 'New Patient Registered: PAT-2026-001', 'System', '2026-04-16 04:14:42'),
(23, 'New Patient Registered: PAT-2026-002', 'System', '2026-04-16 04:23:04'),
(24, 'New Attendee Registered: ', 'System', '2026-04-16 07:21:05'),
(25, 'New Attendee Registered: ATTN-2026-002', 'System', '2026-04-16 07:28:07');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `appointment_time` time DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `patient_id`, `doctor_id`, `appointment_date`, `appointment_time`, `status`, `created_at`) VALUES
(0, 3, 2, '2026-03-22', '09:00:00', 'Pending', '2026-03-20 14:50:32'),
(0, 3, 2, '2026-03-22', '09:30:00', 'Pending', '2026-03-20 15:09:14'),
(0, 9, 4, '2026-03-28', '09:00:00', 'Pending', '2026-03-20 19:24:03'),
(0, 8, 4, '2026-04-10', '09:00:00', 'Pending', '2026-04-04 21:23:07');

-- --------------------------------------------------------

--
-- Table structure for table `attendees`
--

CREATE TABLE `attendees` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `hospital_branch` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `attendee_code` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendees`
--

INSERT INTO `attendees` (`id`, `full_name`, `email`, `mobile`, `hospital_branch`, `password`, `attendee_code`, `created_at`) VALUES
(2, 'Manish Sharma', 'mca.24mmce34@silicon.ac.in', '8340778990', 'Bhubaneswar', 'mani123', 'ATTN-2026-002', '2026-04-16 07:28:07');

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
('Manish Sharma', 'SHARMAMANISH5846579@GMAIL.COM', 'ko'),
('Manish Sharma', 'SHARMAMANISH5846579@GMAIL.COM', 'bdgbgdbdg');

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
(1, 'DOC-2026-001', 'Manish Sharma', 'Cardiology', 'Surgeon', 5, '8340778990', 'manishsharma081999@gmail.com', '$2y$10$HxdZFUQTsGXi927aUMP7eu9hhFHh92Wi7mxNOAGMYnUjwYiezi4D.', '2026-04-10 20:23:34');

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
(2, 'PAT-2026-002', 'Manish Sharma', 'sharmamanish5846579@gmail.com', '8340778990', '2026-04-02', 'male', '565623232232', 'O+', 'Barajamda', 'Near Reliance Tower Football Ground Barajamda', '$2y$10$qt/oSOoOGeHxCrylKO3XletPWELoNCwmvbZrgkQHNoWn0/wuN5q0i', '2026-04-16 04:23:04');

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
  `doctor_code` varchar(20) DEFAULT NULL,
  `attendee_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `reset_token`, `token_expiry`, `patient_code`, `doctor_code`, `attendee_code`) VALUES
(1, 'Admin', 'admincaresync@gmail.com', '$2y$10$oWI.pFiUhSrJAwM45L/9kO8QU3DNI3wEsLUNRqcgsuc4RaD6ruwUW', 'admin', NULL, NULL, NULL, NULL, NULL),
(2, 'Manish Sharma', 'manishsharma081999@gmail.com', '$2y$10$HxdZFUQTsGXi927aUMP7eu9hhFHh92Wi7mxNOAGMYnUjwYiezi4D.', 'doctor', 'd706e4ecf63580d40c61182b2e1d1355d134a7b10d25cec2ddf6872e20f6281845fa1fa23436e18143635c03b91e3bb10559', '2026-04-16 14:51:32', NULL, 'DOC-2026-001', NULL),
(4, 'Manish Sharma', 'sharmamanish5846579@gmail.com', '$2y$10$qt/oSOoOGeHxCrylKO3XletPWELoNCwmvbZrgkQHNoWn0/wuN5q0i', 'patient', NULL, NULL, 'PAT-2026-002', NULL, NULL),
(7, 'Manish Sharma', 'mca.24mmce34@silicon.ac.in', '$2y$10$D9WciNq8/mlLITpV5O/tmeZWhud4dJCoUoJrBMxovB/ZvBl.eaTTa', 'attendee', NULL, NULL, NULL, NULL, 'ATTN-2026-002');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendees`
--
ALTER TABLE `attendees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `attendee_code` (`attendee_code`);

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
  ADD UNIQUE KEY `doctor_code` (`doctor_code`),
  ADD UNIQUE KEY `attendee_code` (`attendee_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `attendees`
--
ALTER TABLE `attendees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
