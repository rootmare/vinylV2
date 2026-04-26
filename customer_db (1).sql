-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2026 at 10:31 AM
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
-- Database: `customer_db`
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
(0, 'admin_test', '$2y$10$F3/bQY3ObFkVvwVYmc1P9.VQNZCKxzrNUFtg9pZHhVskEyX68Tgbu');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL COMMENT 'Item ID',
  `item_name` varchar(100) NOT NULL COMMENT 'Name/title of the item',
  `category` varchar(50) NOT NULL COMMENT 'Item category/type',
  `details` text NOT NULL COMMENT 'Additional description',
  `value` varchar(50) NOT NULL COMMENT 'could represent cost',
  `created_by` int(11) DEFAULT NULL,
  `image` text NOT NULL COMMENT 'the link to the image for the vinyl',
  `audio` text NOT NULL COMMENT 'the link for the audio mp3'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `item_name`, `category`, `details`, `value`, `created_by`, `image`, `audio`) VALUES
(8, '', '', '', '', NULL, '', ''),
(11, 'Hum of machinery', 'ai', 'factorio song', '5.00', 4, 'https://www.image2url.com/r2/default/files/1776676904757-b5802e83-7e2d-4918-914b-14098c0a2127.jpg', 'https://www.image2url.com/r2/default/files/1776676938021-a7bc8977-3ef3-494e-93f8-267244c05106.mp3'),
(12, 'Hum of machinery', 'ai', 'factorio song', '5.00', 4, 'https://www.image2url.com/r2/default/files/1776676904757-b5802e83-7e2d-4918-914b-14098c0a2127.jpg', 'https://www.image2url.com/r2/default/files/1776676938021-a7bc8977-3ef3-494e-93f8-267244c05106.mp3'),
(13, 'Sleep is a Bottleneck', 'ai', 'automation song', '10.00', 4, 'https://www.image2url.com/r2/default/files/1776677075825-68572b61-ab62-4925-9ec1-fb2c208c5e0a.jpg', 'https://www.image2url.com/r2/default/files/1776677098429-f560bf8b-cf5a-48ae-832c-5114c125d6b0.mp3'),
(14, 'The Factory Must Grow', 'factorio song', 'human made music (no audio)', '20.00', 4, 'https://www.image2url.com/r2/default/files/1776677184154-bc8eb7df-22fc-48c6-a5ef-de40ecd53448.jpg', ''),
(15, 'rtrt', 'rttrt', 'rtrt', '25.00', 4, 'https://image2url.com/r2/default/files/1773843087729-1a78df56-8abf-4fd0-a999-4a08eb2d3833.webp', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'User ID',
  `username` varchar(50) NOT NULL COMMENT 'Login name',
  `password` varchar(255) NOT NULL COMMENT 'Hashed password',
  `email` varchar(100) NOT NULL COMMENT 'Contact email'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES
(1, 'user1', '$2y$10$aKpR9ni/YrynjqvujP6bq.pjOAHnzeHllJYIHm1y4PxmQ2xVLyWq.', 'example@email.com'),
(2, 'admin', '$2y$10$k.3yyqTMlYTTGhHhSfXY6eX7mZZc6blL2SecH1mQypHKCFaLjzMiW', 'exampl3e@email.com'),
(3, 'true', '$2y$10$ZSJnNWe6X2.Xv8dPUil3QOfLiWUWktQ8ZeNFzt4vGQn77B0VTmtY6', 'true@example.com'),
(4, 'false', '$2y$10$/BzNBmO1Szkl3ZPjOjMNqenrkcPqhVdatdlzmzIWwvRyGNyZQTtvW', 'false@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Item ID', AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'User ID', AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
