-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 26, 2023 at 04:52 PM
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
-- Database: `userRegistration`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `hobbies` varchar(255) NOT NULL,
  `profile` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `pincode` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `gender`, `hobbies`, `profile`, `address`, `city`, `state`, `pincode`) VALUES
(16, 'demo5mvjhdjoupdate', 'text', 'demo@gmail.com', 'female', 'reading,travelling', '4481black.jpg', 'cheema chownk', 'chandigarh', 'uk', 141007),
(25, 'testing', 'hnhhn', 'kingherryking@gmail.com', 'male', 'travelling', '2584red.jpg', 'noorwala road', 'jalandher', 'uk', 141007),
(30, 'huhihoikp', 'rgbbb', 'kingherryking@gmail.com', 'male', 'reading,travelling', '1955nature.jpeg', 'cheema chownk', 'chandigarh', 'usa', 14007),
(31, 'kumkum', 'arora', 'kingherryking@gmail.com', 'female', 'reading,travelling', '9753white.jpg', 'cheema chownk', 'ludhiana', 'usa', 141007),
(32, 'infino', 'info', 'infino@gmail.com', 'male', 'reading,travelling', '7905red.jpg', 'cheema chownk', 'ludhiana', 'india', 44656554),
(33, 'testingupdate', 'test', 'xyz@gmail.com', 'female', 'reading', '8235nature.jpeg', 'punjab', 'jalandher', 'india', 44656554),
(34, 'kumkum', 'arora', 'kumkum@gmail.com', 'female', 'reading', '6429nature.jpeg', 'cheema chownk', 'ludhiana', 'india', 44656554);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
