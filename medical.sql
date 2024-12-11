-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2024 at 09:51 PM
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
-- Database: `medical`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `place` varchar(255) NOT NULL,
  `doctor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `date`, `place`, `doctor`) VALUES
(0, '2024-11-12', 'nairobi', 'her'),
(0, '2024-11-14', 'ruiru', 'Sam'),
(0, '2024-11-18', 'Nakuru level 5', 'Lucy'),
(0, '2024-11-15', 'yuyy', 'yyyy');

-- --------------------------------------------------------

--
-- Table structure for table `drugrefills`
--

CREATE TABLE `drugrefills` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `med_name` varchar(255) NOT NULL,
  `days_left` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drugrefills`
--

INSERT INTO `drugrefills` (`id`, `user_id`, `med_name`, `days_left`, `created_at`) VALUES
(0, 1, '555', 66, '2024-11-11 08:38:55'),
(0, 1, 'panadol', 77, '2024-11-11 16:43:00'),
(0, 1, 'insulin', 22, '2024-11-13 08:12:23'),
(0, 1, 'js', 6, '2024-11-15 08:46:48'),
(0, 1, 'panadol', 1, '2024-11-16 14:23:48');

-- --------------------------------------------------------

--
-- Table structure for table `drugs`
--

CREATE TABLE `drugs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `drug_name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drugs`
--

INSERT INTO `drugs` (`id`, `user_id`, `drug_name`, `start_date`, `end_date`, `created_at`) VALUES
(0, 1, 'panadol', '2024-11-11', '2024-11-12', '2024-11-11 16:42:42'),
(0, 1, '5666', '2024-11-13', '2024-11-13', '2024-11-13 07:57:32'),
(0, 1, '5666', '2024-11-13', '2024-11-13', '2024-11-13 08:45:59'),
(0, 1, 'HCFZ', '2024-11-17', '2024-11-13', '2024-11-16 14:25:29');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `note_content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `user_id`, `note_content`, `created_at`) VALUES
(0, 1, 'hhhhh', '2024-11-16 14:48:32'),
(0, 1, 'hhhhhuuuu', '2024-11-16 14:48:42'),
(0, 1, 'hhhhhuuuu', '2024-11-16 14:50:44'),
(0, 1, 'hello', '2024-11-16 14:51:05'),
(0, 1, 'hello again', '2024-11-16 15:00:30'),
(0, 1, 'hello again', '2024-11-16 15:10:19'),
(0, 1, 'I am going insane', '2024-11-16 15:10:40'),
(0, 1, 'hey', '2024-11-16 15:31:23'),
(0, 1, 'hey', '2024-11-16 15:35:05');

-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

CREATE TABLE `reminders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reminder_time_12hr` varchar(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reminder_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_shown` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reminders`
--

INSERT INTO `reminders` (`id`, `user_id`, `reminder_time_12hr`, `created_at`, `reminder_date`, `description`, `is_shown`) VALUES
(1, 1, '05:15 AM', '2024-11-11 02:15:31', '2024-11-07', '522', 0),
(4, 1, '12:19 PM', '2024-11-11 09:20:07', '2024-10-29', 'hospital', 0),
(5, 1, '12:27 PM', '2024-11-11 09:26:19', '2024-11-11', 'Take your drugs', 0),
(6, 1, '12:30 PM', '2024-11-11 09:29:33', '2024-11-11', 'Take your drugs', 0),
(7, 1, '12:35 PM', '2024-11-11 09:33:59', '2024-11-11', 'Take your drugs', 0),
(12, 1, '15:17', '2024-11-12 12:37:30', '2024-11-11', 'huuu', 0),
(13, 1, '12:44 PM', '2024-11-13 08:49:23', '2024-11-11', 'gggg', 0),
(14, 1, '06:06 AM', '2024-11-21 16:16:23', '2024-11-22', 'wyy', 0),
(15, 1, '09:53 PM', '2024-11-30 18:52:56', '2024-11-30', 'sdsa', 1),
(16, 1, '09:55 PM', '2024-11-30 18:54:50', '2024-11-30', 'sdadsa', 1),
(17, 1, '08:07 PM', '2024-11-30 19:05:12', '2024-11-30', 'Test reminder - will trigger at 08:07 PM', 1),
(18, 1, '09:55 PM', '2024-11-30 19:07:29', '2024-11-30', 'sdadsa', 1),
(19, 1, '09:55 PM', '2024-11-30 19:07:36', '2024-11-30', 'sdadsa', 1),
(20, 1, '10:08 PM', '2024-11-30 19:07:46', '2024-11-30', 'hhjh', 1),
(21, 0, '10:18 PM', '2024-11-30 19:17:05', '2024-11-30', 'hjh', 0),
(22, 0, '10:23 PM', '2024-11-30 19:21:17', '2024-11-30', 'hjhjn', 0),
(23, 0, '10:28 PM', '2024-11-30 19:26:40', '2024-11-30', 'kiki', 0),
(24, 0, '11:01 PM', '2024-11-30 20:00:32', '2024-11-30', 'adwsad', 0),
(25, 1, '11:07 PM', '2024-11-30 20:05:48', '2024-11-30', 'gghj', 1),
(26, 1, '11:09 PM', '2024-11-30 20:08:34', '2024-11-30', 'cxxzc', 1),
(27, 1, '11:22 PM', '2024-11-30 20:21:13', '2024-11-30', 'ASdf', 1),
(28, 1, '11:26 PM', '2024-11-30 20:24:29', '2024-11-30', 'fggn', 1),
(29, 1, '11:32 PM', '2024-11-30 20:30:24', '2024-11-30', 'jjiij', 1),
(30, 1, '11:42 PM', '2024-11-30 20:41:24', '2024-11-30', 'cc', 1),
(31, 1, '11:46 PM', '2024-11-30 20:45:57', '2024-11-30', 'sdsd', 1),
(32, 1, '11:47 PM', '2024-11-30 20:46:14', '2024-11-30', 'iji', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `second_name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `first_name`, `second_name`, `phone`, `age`) VALUES
(0, '12345', 'zavairodney@gmail.com', '$2y$10$Fn53eBf3fdf8rjGIBo2bMuaaqwC2EP4fTtdUPaOuJ/b6kFiMBC.0u', 'rodney', 'zavai', '01234536338', 75),
(0, '12345', '', '$2y$10$ptMu6E4MnwFSEoafyFPRzui3wlJ52Jlin6q4UkXzlmE0Q8MOvxsjW', '', '', '', 0),
(0, 'ken1', 'rodneyzavai@gmail.com', '$2y$10$CRo0payxrBjQMCmc9.Hm0.G/zZP1CjOozXJzXeAvvQINdgs6LxBLq', 'wayne', 'zavai', '0758265242', 12),
(0, 'ken1', '', '$2y$10$DUquigd2MvcQ.mYTBACwwO/6mVSJIPKCunowdbBgd827blEb9v0mO', '', '', '', 0),
(0, 'ken1', '', '$2y$10$9t1l0ObkvQgtkGdT.5fFzOPnFirzB8e.S.1fiJgv7.5aaFV9W7.4.', '', '', '', 0),
(0, 'zavai12345', '', '$2y$10$vnLwrxoFmFHWRR6SWY1gHeXKqVQagF9K7DJu1mjbNrDXLLFKjl4oC', '', '', '', 0),
(0, 'marsha', 'marsha@gmail', '$2y$10$/cOaWyBTOOH64CR2a6NoY.iEWyNt1G/P6OrRxDz6iEruqSWkzbdjK', 'marsha', 'zavai', '07078170089', 14),
(0, 'marsha', '', '$2y$10$tkm9pon7vqV6xIoiVx/PjOjpZ9c90aEfk7gjcB2.A.TmigeSjPXDK', '', '', '', 0),
(0, 'ken1', '', '$2y$10$ZJxiJ.AN8Ek9w9Zq0N21QOrTXyPgl/ea3ZJu0tefIFC8XU8fd9TMW', '', '', '', 0),
(0, 'zetech', '', '$2y$10$ZIx1fWbWgNq4fdZwZZIVce.hXSWUw.l8a31OPiO0oaH7IMoPDiJiS', '', '', '', 0),
(0, 'projekto', 'projo@gmail.com', '$2y$10$KDoZ/4RRcoElolgtQrpqNe6WmUDtL2fy0q0AoPVv1XQF6wJKVD1He', '', '', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reminders`
--
ALTER TABLE `reminders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reminders`
--
ALTER TABLE `reminders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
