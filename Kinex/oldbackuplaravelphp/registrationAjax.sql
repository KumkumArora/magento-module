-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 26, 2023 at 04:51 PM
-- Server version: 8.0.32-0ubuntu0.22.04.2
-- PHP Version: 7.3.33-10+ubuntu22.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `registrationAjax`
--

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `hobbies` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`id`, `name`, `email`, `password`, `gender`, `hobbies`, `state`) VALUES
(50, 'kumkum arora', 'xyz@gmail.com', 'cdhci5663', 'female', 'Playing,Art & Craft', 'Pakistan'),
(51, 'XYZ abc', 'xyz@gmail.com', 'bghghu65625', 'male', 'Art & Craft,Travelling', 'USA'),
(53, 'kumkum', 'kingherryking@gmail.com', 'vhjuhnikjol', 'female', 'Playing', 'Shree lanka');

-- --------------------------------------------------------

--
-- Table structure for table `userImages`
--

CREATE TABLE `userImages` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `userImages`
--

INSERT INTO `userImages` (`id`, `user_id`, `image`) VALUES
(43, 50, '8273blue-white.jpeg'),
(44, 51, '4124pink-black.jpeg'),
(45, 51, '4208p-green.jpg'),
(49, 53, '6075blue-white.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userImages`
--
ALTER TABLE `userImages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `userImages`
--
ALTER TABLE `userImages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
