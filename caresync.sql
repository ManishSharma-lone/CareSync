-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2026 at 07:12 PM
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
(25, 'New Attendee Registered: ATTN-2026-002', 'System', '2026-04-16 07:28:07'),
(26, 'New Doctor Added', 'Admin', '2026-04-17 13:45:01');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `patient_code` int(11) NOT NULL COMMENT 'References users.id where role=patient',
  `doctor_code` int(11) NOT NULL COMMENT 'References users.id where role=doctor',
  `slot_id` int(11) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'confirmed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `patient_code`, `doctor_code`, `slot_id`, `reason`, `start_time`, `end_time`, `location`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 2, 2, '', '2026-04-19 14:00:00', '2026-04-19 15:00:00', 'Virtual Call', 'cancelled', '2026-04-17 16:59:52', '2026-04-17 17:01:59');

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
(1, 'DOC-2026-001', 'Manish Sharma', 'Cardiology', 'Surgeon', 5, '8340778990', 'manishsharma081999@gmail.com', '$2y$10$HxdZFUQTsGXi927aUMP7eu9hhFHh92Wi7mxNOAGMYnUjwYiezi4D.', '2026-04-10 20:23:34'),
(2, 'DOC-2026-002', 'Rahul Kumar', 'Orthopedics', 'Surgeon', 5, '9470124686', 'rahul123@gmail.com', '$2y$10$K73hDIFhlLAWxa8L5GPTOOd/HdFW2ew7uMX82NhgTp3f349oIMY3y', '2026-04-17 13:45:01');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'References users.id',
  `message` text NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `type`, `is_read`, `created_at`) VALUES
(1, 2, 'New appointment scheduled with patient #4 for Apr 19, 2026 2:00 PM', 'appointment', 0, '2026-04-17 16:59:52'),
(2, 2, 'Your appointment on Sunday, April 19, 2026 has been cancelled.', 'appointment', 0, '2026-04-17 17:01:59');

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
-- Table structure for table `time_slots`
--

CREATE TABLE `time_slots` (
  `id` int(11) NOT NULL,
  `doctor_code` int(11) NOT NULL COMMENT 'References users.id where role=doctor',
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `status` varchar(20) DEFAULT 'available',
  `location` varchar(100) DEFAULT NULL,
  `capacity` int(11) DEFAULT 1,
  `booked_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `time_slots`
--

INSERT INTO `time_slots` (`id`, `doctor_code`, `start_time`, `end_time`, `status`, `location`, `capacity`, `booked_count`) VALUES
(1, 2, '2026-04-18 09:00:00', '2026-04-18 10:00:00', 'available', 'Room 101, CareSync Main Branch', 1, 0),
(2, 2, '2026-04-19 14:00:00', '2026-04-19 15:00:00', 'available', 'Virtual Call', 1, 0);

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
(2, 'Manish Sharma', 'manishsharma081999@gmail.com', '$2y$10$HxdZFUQTsGXi927aUMP7eu9hhFHh92Wi7mxNOAGMYnUjwYiezi4D.', 'doctor', '8662c0428909722a56ec52a0a8716b3a1726691c689ae18ea3c094faf6f1df9ec3c1d9d56aaed2cc07ab0fe04460fa88aaed', '2026-04-17 14:07:25', NULL, 'DOC-2026-001', NULL),
(4, 'Manish Sharma', 'sharmamanish5846579@gmail.com', '$2y$10$YMxbQYB032seha/a5LooYOBbOlOt8IleA5D9M9aqu8WmJiArpY7Wu', 'patient', NULL, NULL, 'PAT-2026-002', NULL, NULL),
(7, 'Manish Sharma', 'mca.24mmce34@silicon.ac.in', '$2y$10$D9WciNq8/mlLITpV5O/tmeZWhud4dJCoUoJrBMxovB/ZvBl.eaTTa', 'attendee', NULL, NULL, NULL, NULL, 'ATTN-2026-002'),
(8, 'Rahul Kumar', 'rahul123@gmail.com', '$2y$10$K73hDIFhlLAWxa8L5GPTOOd/HdFW2ew7uMX82NhgTp3f349oIMY3y', 'doctor', NULL, NULL, NULL, 'DOC-2026-002', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
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
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `time_slots`
--
ALTER TABLE `time_slots`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendees`
--
ALTER TABLE `attendees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `time_slots`
--
ALTER TABLE `time_slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
