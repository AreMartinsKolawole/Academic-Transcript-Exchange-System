-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2024 at 11:45 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tes`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(4, 'Admin', '$2y$10$Dnhmcd5sbqj0zJAY4UGWnOpLeRmYNkvhKhkMK0TtGJepppFhdttIK');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `feedback` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `institutions`
--

CREATE TABLE `institutions` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `institutions`
--

INSERT INTO `institutions` (`id`, `name`, `email`, `password`) VALUES
(11, 'Are Martins', 'aremartins801@gmail.com', '$2y$10$8LXaiYeP1.eSVaY6tV/aEuC6tL1nNXXOpoTdEiyNXQFNVEnDE91pu');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `id` int(11) NOT NULL,
  `matric_no` varchar(20) NOT NULL,
  `token` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `used` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `password_reset`
--

INSERT INTO `password_reset` (`id`, `matric_no`, `token`, `created_at`, `used`) VALUES
(14, 'AUL/SCI/20/00529', '17601eeb53f3eff1e52b1d54d655806e66ff9678c853c7a8a65e271da728b8eb', '2024-04-24 15:50:00', 0),
(15, 'AUL/SCI/20/00529', '9b63b9ccf4c3113d86aaaf1e26deec4eb8ad998674cfeec3f97e0d3eb80bb882', '2024-04-24 15:50:11', 0),
(16, 'AUL/SCI/20/00529', '0ee0cbdac4ec73601398d20b212a2c98a2ac41fdf91b9e834b09296d4a745357', '2024-04-24 15:52:01', 0),
(17, 'AUL/SCI/20/00529', 'c4307d1186ddb8f059738a285d95ad9c01243a1ef47f8eb24ce898acceb5805f', '2024-04-24 15:53:11', 0),
(18, 'AUL/SCI/20/00529', '8381fe12087eed4b5def08597d754a40acd00fe2675a1412092b1fe39aa125e7', '2024-04-24 15:53:22', 0),
(19, 'AUL/SCI/20/00529', 'b9628c69c4228084ae83c1b0572ed75f8f4535f9b578a930ce176359413019ca', '2024-04-24 15:56:33', 0),
(20, 'AUL/SCI/20/00529', '94809bd88c790b617d87be0e0dc141ee7c28dbecde5d7b3f1d6020528e4ceb30', '2024-04-24 15:59:25', 1),
(21, 'AUL/SCI/20/00529', '42e1c6638e52ad2959782c394bc72ea8e2cdaeb0b2e7e588f0025967319a91ad', '2024-05-01 20:56:19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `received_transcripts`
--

CREATE TABLE `received_transcripts` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `received_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transcripts`
--

CREATE TABLE `transcripts` (
  `id` int(11) NOT NULL,
  `matric_number` varchar(20) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `file_content` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transcript_requests`
--

CREATE TABLE `transcript_requests` (
  `id` int(11) NOT NULL,
  `matric_number` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `prev_institution_email` varchar(100) NOT NULL,
  `current_institution_email` varchar(100) NOT NULL,
  `verification_token` varchar(32) NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Accepted','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transcript_requests`
--

INSERT INTO `transcript_requests` (`id`, `matric_number`, `full_name`, `prev_institution_email`, `current_institution_email`, `verification_token`, `request_date`, `status`) VALUES
(36, 'AUL/SCI/20/00529', 'Are Martins', 'aremartins801@gmail.com', 'charusat@gmail.com', 'bd5aff89e8b644d23b0583e133271017', '2024-04-24 16:02:06', 'Accepted'),
(37, 'AUL/SCI/20/00529', 'Are Martins', 'aremartins801@gmail.com', 'charusat@gmail.com', '03001032722ea19ce8e43cd98612bc76', '2024-04-24 16:04:45', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `transcript_uploads`
--

CREATE TABLE `transcript_uploads` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `upload_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `matric_no` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `entry_mode` varchar(20) DEFAULT NULL,
  `program_duration` varchar(10) DEFAULT NULL,
  `course` varchar(100) DEFAULT NULL,
  `programme_mode` varchar(20) DEFAULT NULL,
  `session_admitted` varchar(20) DEFAULT NULL,
  `session_graduated` varchar(20) DEFAULT NULL,
  `personal_residential_address` text DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `state_of_origin` varchar(50) DEFAULT NULL,
  `prev_institution_name` varchar(100) DEFAULT NULL,
  `prev_institution_email` varchar(100) DEFAULT NULL,
  `prev_vc_email` varchar(100) DEFAULT NULL,
  `prev_register_email` varchar(100) DEFAULT NULL,
  `current_institution_name` varchar(100) DEFAULT NULL,
  `current_institution_email` varchar(100) DEFAULT NULL,
  `current_vc_email` varchar(100) DEFAULT NULL,
  `current_register_email` varchar(100) DEFAULT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  `institution_id` int(11) DEFAULT NULL,
  `reset_token` varchar(128) DEFAULT NULL,
  `token` varchar(128) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 0,
  `digitcode` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `matric_no`, `password`, `date_of_birth`, `gender`, `entry_mode`, `program_duration`, `course`, `programme_mode`, `session_admitted`, `session_graduated`, `personal_residential_address`, `telephone`, `state_of_origin`, `prev_institution_name`, `prev_institution_email`, `prev_vc_email`, `prev_register_email`, `current_institution_name`, `current_institution_email`, `current_vc_email`, `current_register_email`, `verification_token`, `institution_id`, `reset_token`, `token`, `verified`, `digitcode`, `created_at`) VALUES
(60, 'Are Martins', 'aremartins801@gmail.com', 'AUL/SCI/20/00529', '$2y$10$riLJrObvBE3UZhJ1Ls1Riegm27mo96F2yHLsoMpFgnEldSelI0Aha', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '449183', '2024-05-01 21:05:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `institutions`
--
ALTER TABLE `institutions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `received_transcripts`
--
ALTER TABLE `received_transcripts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `transcripts`
--
ALTER TABLE `transcripts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transcript_requests`
--
ALTER TABLE `transcript_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transcript_uploads`
--
ALTER TABLE `transcript_uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `matric_no` (`matric_no`),
  ADD KEY `fk_users_institution` (`institution_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `institutions`
--
ALTER TABLE `institutions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `received_transcripts`
--
ALTER TABLE `received_transcripts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transcripts`
--
ALTER TABLE `transcripts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transcript_requests`
--
ALTER TABLE `transcript_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `transcript_uploads`
--
ALTER TABLE `transcript_uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `received_transcripts`
--
ALTER TABLE `received_transcripts`
  ADD CONSTRAINT `received_transcripts_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `institutions` (`id`),
  ADD CONSTRAINT `received_transcripts_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `institutions` (`id`);

--
-- Constraints for table `transcript_uploads`
--
ALTER TABLE `transcript_uploads`
  ADD CONSTRAINT `transcript_uploads_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `institutions` (`id`),
  ADD CONSTRAINT `transcript_uploads_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `institutions` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_institution` FOREIGN KEY (`institution_id`) REFERENCES `institutions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
