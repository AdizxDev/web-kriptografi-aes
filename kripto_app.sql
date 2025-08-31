-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2025 at 11:54 AM
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
-- Database: `kripto_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `original_name` varchar(255) DEFAULT NULL,
  `encrypted_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `decrypted_name` varchar(255) DEFAULT NULL,
  `file_size` float DEFAULT NULL,
  `status` enum('TERENKRIPSI','SUDAH DIDEKRIPSI') DEFAULT 'TERENKRIPSI',
  `created_at` datetime DEFAULT current_timestamp(),
  `aes_key` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `user_id`, `original_name`, `encrypted_name`, `file_path`, `decrypted_name`, `file_size`, `status`, `created_at`, `aes_key`) VALUES
(6, 1, 'coba enc file.docx', '1752422423-enc.txt', 'uploads/1752422423-enc.txt', 'uploads/decrypted-1752422444-coba enc file.docx', 13.041, 'SUDAH DIDEKRIPSI', '2025-07-14 00:00:23', 'WAZlAp5qDoN7bCDSXW6gyjce6jaSwRHhjc8lZ3bskQE='),
(7, 1, 'tess kripto.docx', '1752422594-enc.txt', 'uploads/1752422594-enc.txt', 'uploads/decrypted-1752422641-tess kripto.docx', 12.9746, 'SUDAH DIDEKRIPSI', '2025-07-14 00:03:14', '/WCasX5Z/ymKv392JE2R1lsw2SabsNkIKXvGgiQVVOk='),
(8, 1, 'tess kripto.docx', '1752423371-enc.txt', 'uploads/1752423371-enc.txt', 'uploads/decrypted-1752423424-tess kripto.docx', 12.9746, 'SUDAH DIDEKRIPSI', '2025-07-14 00:16:11', 'qFzA42PIr38hZcEJiYqyQQSiHzfzhbJ649cl/2uTZm0=');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`) VALUES
(1, 'admin', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9', 'Administrator');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
