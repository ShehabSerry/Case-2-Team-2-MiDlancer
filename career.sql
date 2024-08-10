-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2024 at 04:00 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `case2`
--

-- --------------------------------------------------------

--
-- Table structure for table `career`
--

CREATE TABLE `career` (
  `career_id` int(11) NOT NULL,
  `career_path` varchar(250) NOT NULL,
  `career_desc` text NOT NULL,
  `career_image` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `career`
--

INSERT INTO `career` (`career_id`, `career_path`, `career_desc`, `career_image`) VALUES
(1, 'Developer', 'Makes and maintains websites, being in charge of a site\'s overall look & feel, handles the technical aspects of a website, like performance & capacity', 'Website designer-amico.png'),
(2, 'Data Analyst', 'The process of systematically applying statistical and/or logical techniques to describe and illustrate, condense and recap, and evaluate data.', 'Data analysis-rafiki.png'),
(3, 'Voice Over ', 'Production technique that provides off-screen narration or character voices for movie trailers, TV, radio,commercials, explainer videos, and documentaries.', 'Voice control-rafiki.png'),
(4, 'Marketing Analyst', 'Set of processes for creating, communicating, delivering, and exchanging offerings that have value for customers, clients, and society at large.', 'Marketing-amico.png'),
(5, 'Designer', 'Involves creating visual concepts and designs for various media, including print, digital, and product design, focusing on aesthetics.', 'Designer-amicoBLUE.png'),
(6, 'Content Creator', 'Writing, editing, blogging, and updating content for everything from brochures and marketing and promotional materials to emails, websites, and blogs.', 'Content-bro.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `career`
--
ALTER TABLE `career`
  ADD PRIMARY KEY (`career_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `career`
--
ALTER TABLE `career`
  MODIFY `career_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
