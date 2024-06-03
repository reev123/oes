-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2024 at 05:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oes`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'Billa', 'belmanbilla123');

-- --------------------------------------------------------

--
-- Table structure for table `essay_exam`
--

CREATE TABLE `essay_exam` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `essay_content` text DEFAULT NULL,
  `submission_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `essay_exam`
--

INSERT INTO `essay_exam` (`id`, `username`, `essay_content`, `submission_time`) VALUES
(0, 'arwin123', 'dgssdghqwsvqwhvwvsyqwvywqvyjqwvsyqvwyjdvyqwvdhjqwvdhkqwvxhqwvxhqbj', '2024-06-03 10:40:59');

-- --------------------------------------------------------

--
-- Table structure for table `instructor_requests`
--

CREATE TABLE `instructor_requests` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `instructor_id` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `multiple_choice_answers`
--

CREATE TABLE `multiple_choice_answers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `question` text NOT NULL,
  `selected_answer` text NOT NULL,
  `correct_answer` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registered_instructors`
--

CREATE TABLE `registered_instructors` (
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `instructor_id` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registered_instructors`
--

INSERT INTO `registered_instructors` (`full_name`, `email`, `instructor_id`, `password`, `requested_at`) VALUES
('Arwin M', 'arwin1@gmail.com', 'a123', '12345', '2024-06-03 07:11:53'),
('Ananth', 'a@gmail.com', 'ananth123', '123', '2024-06-03 10:42:34'),
('Reevan Nazareth', 'reev@gmail.com', 'r123', '123', '2024-06-03 07:06:54');

-- --------------------------------------------------------

--
-- Table structure for table `registered_students`
--

CREATE TABLE `registered_students` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registered_students`
--

INSERT INTO `registered_students` (`id`, `username`, `password`, `email`, `full_name`, `status`) VALUES
(101, 'arwin123', '12345', 'arwin@gmail.com', 'Arwin Menezes', 'approved'),
(102, 'melroy', '123', 'm@gmail.com', 'melroy t m', 'approved');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `essay_exam`
--
ALTER TABLE `essay_exam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instructor_requests`
--
ALTER TABLE `instructor_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `multiple_choice_answers`
--
ALTER TABLE `multiple_choice_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registered_instructors`
--
ALTER TABLE `registered_instructors`
  ADD PRIMARY KEY (`instructor_id`);

--
-- Indexes for table `registered_students`
--
ALTER TABLE `registered_students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `instructor_requests`
--
ALTER TABLE `instructor_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `multiple_choice_answers`
--
ALTER TABLE `multiple_choice_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `registered_students`
--
ALTER TABLE `registered_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
