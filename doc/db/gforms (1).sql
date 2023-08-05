-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2023 at 03:20 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gforms`
--

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `f_id` int(99) NOT NULL,
  `f_title` varchar(255) NOT NULL,
  `f_desc` text NOT NULL,
  `f_st_time` varchar(100) NOT NULL,
  `f_end_time` varchar(100) NOT NULL,
  `created_by` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`f_id`, `f_title`, `f_desc`, `f_st_time`, `f_end_time`, `created_by`) VALUES
(1, 'Demo ', 'Demo tedasrsz', '', '', '2'),
(2, 'Add Titledfds', 'dsfds', '', '', '2'),
(3, 'Demoo ', 'This is demo', '', '', '2');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `q_id` int(11) NOT NULL,
  `f_id` int(99) NOT NULL,
  `q_title` varchar(500) NOT NULL,
  `q_type` int(11) NOT NULL,
  `q_options` text NOT NULL,
  `created_by` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`q_id`, `f_id`, `q_title`, `q_type`, `q_options`, `created_by`) VALUES
(1, 3, 'What\'s your name', 2, 'Fariha,Mummy,Phopo', '2'),
(2, 3, 'Write Your Question....', 1, '', '2'),
(3, 3, 'Write Your Question....', 1, '', '2'),
(4, 3, 'Write Your Question....', 1, '', '2'),
(5, 3, 'Write Your Question....', 1, '', '2'),
(6, 3, 'Write Your Question....', 1, '', '2'),
(7, 3, 'Write Your Question....', 1, '', '2'),
(8, 3, 'Write Your Question....', 1, '', '2'),
(9, 3, 'Write Your Question....', 1, '', '2'),
(10, 3, 'Write Your Question....', 1, '', '2');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `type`) VALUES
(2, 'Fariha Aqeel', 'fariha@admin.com', 'MTIzNDU=', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`f_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`q_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `f_id` int(99) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `q_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
