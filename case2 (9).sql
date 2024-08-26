-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2024 at 08:49 AM
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
-- Database: `case2`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `freelancer_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`freelancer_id`, `project_id`, `status`) VALUES
(15, 10, 'pending'),
(29, 2, 'pending'),
(29, 23, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

CREATE TABLE `bookmark` (
  `freelancer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'Developer', 'Website aesthetics and behind the scene functionalities', 'Website designer-amico.png'),
(2, 'Data Analyst', 'Involves collecting, processing, and performing statistical analyses on large datasets to identify trends, patterns, and insights that inform business decisions.', 'Data analysis-rafiki.png'),
(3, 'Voice Over ', 'Involves providing vocal narration or character voices for various media, including commercials, animations, audiobooks, and video games, focusing on clear articulation and emotional expression.', 'Voice control-rafiki.png'),
(4, 'Marketing Analyst', 'Involves analyzing market trends, consumer behavior, and campaign performance to develop strategies that optimize marketing efforts and drive business growth.', 'Marketing-amico.png'),
(5, 'Designer', 'Involves creating visual concepts and designs for various media, including print, digital, and product design, focusing on aesthetics, functionality, and user experience.', 'Designer-amicoBLUE.png'),
(6, 'Content Creator', 'Involves producing engaging and relevant content for various platforms, including social media, blogs, and videos, focusing on storytelling, audience engagement, and brand alignment.', 'Content-bro.png');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `freelancer_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `experience_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `comment_text`, `freelancer_id`, `user_id`, `experience_id`) VALUES
(1, 'good job', 15, NULL, 1),
(2, 'nice work', 15, NULL, 2),
(3, 'well done', 15, NULL, 2),
(4, 'test', NULL, 1, 1),
(5, 'test', NULL, 1, 2),
(6, 'test', 29, NULL, 1),
(7, 'testttt', 29, NULL, 2),
(8, 'test', 29, NULL, 3),
(9, 'test comment', 29, NULL, 3),
(10, 'test', 29, NULL, 4),
(11, 'test', 29, NULL, 4);

-- --------------------------------------------------------

--
-- Table structure for table `experience`
--

CREATE TABLE `experience` (
  `experience_id` int(11) NOT NULL,
  `experience_text` text NOT NULL,
  `experience_image` longtext DEFAULT NULL,
  `experience_file` longtext NOT NULL,
  `hidden` tinyint(4) DEFAULT NULL,
  `freelancer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `experience`
--

INSERT INTO `experience` (`experience_id`, `experience_text`, `experience_image`, `experience_file`, `hidden`, `freelancer_id`) VALUES
(1, 'hiiiiiiiii', NULL, '', NULL, 15),
(2, 'byeeeeeeeeeee', NULL, '', NULL, 15),
(3, 'test post by salma', NULL, 'istockphoto-521712471-612x612.jpg', NULL, 29),
(4, 'test add ppst', NULL, '_388d442c-fe30-4d6f-89ef-8ddb92757d40.jpeg', NULL, 29);

-- --------------------------------------------------------

--
-- Table structure for table `freelancer`
--

CREATE TABLE `freelancer` (
  `freelancer_id` int(11) NOT NULL,
  `freelancer_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `national_id` varchar(14) NOT NULL,
  `freelancer_image` longtext DEFAULT NULL,
  `job_title` varchar(255) NOT NULL,
  `available_hours` int(11) DEFAULT NULL,
  `price/hr` float DEFAULT NULL,
  `link1` varchar(255) DEFAULT NULL,
  `link2` varchar(255) DEFAULT NULL,
  `freelancer_file` longtext DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `premium` varchar(255) DEFAULT '0',
  `view` int(11) DEFAULT 0,
  `hidden` tinyint(1) DEFAULT 0,
  `career_id` int(11) NOT NULL,
  `rank_id` int(11) DEFAULT 1,
  `webssite_price` int(11) NOT NULL DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `freelancer`
--

INSERT INTO `freelancer` (`freelancer_id`, `freelancer_name`, `email`, `phone_number`, `password`, `birthdate`, `national_id`, `freelancer_image`, `job_title`, `available_hours`, `price/hr`, `link1`, `link2`, `freelancer_file`, `bio`, `premium`, `view`, `hidden`, `career_id`, `rank_id`, `webssite_price`) VALUES
(14, 'magda', 'magdasherif245@gmail.com', '01128101015', '$2y$10$JvfW76Y5.mvfUJHmTXEnlecx1io7gZCMDts2Xh.OuqCRhdEeXs/QG', '2004-04-29', '30404290102047', NULL, 'manager', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 5),
(15, 'farah', 'farahyasser04@gmail.com', '01128101015', '$2y$10$ei9MrUcmH1dIDbEE8VFO/O34WDQePBD2mY.KyK.CUd/Erm2f6Z8Xa', '2004-04-29', '30404290102047', NULL, 'manager', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 4, 1, 5),
(29, 'salma freelancer', 'salmaa.mohamedd56@gmail.com', '01028970103', '$2y$10$VWSj4gwjTLPGOx7e59.5UOYebmv8EaNdYDyJkmCQAZ4QIcHhDPTPC', '2004-03-03', '30403032102222', 'defaultprofile.png', 'data analyst', NULL, NULL, NULL, NULL, NULL, NULL, '1', 0, 0, 2, 1, 5),
(30, 'Mohamed T.', 'mohamedT@gmail.com', '1033182344', '$2y$10$7hk5TM/bbUxVc4RGr6caTON.99N0U9uAFBKRgMySyV3vcfTRnyrxi', '0000-00-00', '30504170102056', NULL, 'Data Analyst', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, 1, 5),
(31, 'Shireen Z.', 'shrieenZ@gmail.com', '1033182344', '$2y$10$hmO4vuewAW4yYo0AmJVXQuvVwKZt.mhbns37IrrZWwwD6l39zUplW', '0000-00-00', '30504170102056', NULL, 'Data Analyst', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, 1, 5),
(32, 'Ahmed A.', 'ahmedA@gmail.com', '1033182344', '$2y$10$LFc9CTk.cIpgmG0mEK0f7.jMAs2BBE7uLGVxB2y9DUus3S2roqWGW', '0000-00-00', '30504170102056', NULL, 'Data Analyst', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, 1, 5),
(33, 'Youssef S.', 'youssefS@gmail.com', '1033182344', '$2y$10$FuviRpmlWTXVQOjADGr2reUEYgbeP5AtPerUWu4zhKNcbGG1rnHq6', '0000-00-00', '30504170102056', NULL, 'Data Analyst', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, 1, 5),
(34, 'Mohamed Y.', 'mohamedY@gmail.com', '1033182344', '$2y$10$v14lpZ/VTEVw24KcLgV7C./ELk9QV77UsvKrVdMYgPfqxaIJTtnze', '0000-00-00', '30504170102056', NULL, 'Data Analyst', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, 1, 5),
(35, 'Raghdaa A.', 'raghdaaA@gmail.com', '1033182344', '$2y$10$OAAhSBS8MNvxomTmkAiQheS7vX7esK5cWf0PRomNJtiYi4gaGi5sa', '0000-00-00', '30504170102056', NULL, 'Data Analyst', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, 1, 5),
(36, 'Yahya A.', 'yahyaA@gmail.com', '1033182344', '$2y$10$mV7x5PtReXUj6E/9oaaZyuOi60Fgr5yL7X0Mg5tAMLofnp5m6SU4m', '0000-00-00', '30504170102056', NULL, 'Data Analyst', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, 1, 5),
(37, 'Abdelmohsen M.', 'abdelmohsenM@gmail.com', '1033182344', '$2y$10$a97agZHoFICauTmb3F3Kcev9EPxI4y3nmy1xMK4AzqXWZbhO.L3HG', '0000-00-00', '30504170102056', NULL, 'Graphic designer', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 5, 1, 5),
(38, 'Shrief K.', 'shriefK@gmail.com', '1033182344', '$2y$10$oHUFS2D99KMtHDZTzCCGL.nOB4wAvmfbYYugRD1u2hPEy1mBpbVmG', '0000-00-00', '30504170102056', NULL, 'Data Analyst', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, 1, 5),
(39, 'Randa W.', 'randaW@gmail.com', '1033182344', '$2y$10$PoJdNvA5XjjTTtc1OWc0/OJtqkjbYEpow6x0XPO3o1xQecKk2MEci', '0000-00-00', '30504170102056', NULL, 'Data Analyst', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, 1, 5),
(40, 'Ehab A.', 'ehabA@gmail.com', '1033182344', '$2y$10$pxQhnKbt9n6tmvRbEnRNg.3WHiwuMLgTzuUAI9jOsbeS8ea9t3tpu', '0000-00-00', '30504170102056', NULL, 'Graphic designer', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 5, 1, 5),
(41, 'Mohamed A.', 'mohamedA@gmail.com', '1033182344', '$2y$10$KP.UV8oYKqvRWC0MOvWNMuJA2ttms/ABEJH.2m5qh0QqmG4Q.QCc.', '0000-00-00', '30504170102056', NULL, 'Data Analyst', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, 1, 5),
(42, 'Sherif A.', 'sherifA@gmail.com', '1033182344', '$2y$10$/Ojnvv2AY3xDvDvVP8qnGOzXYiH9lL3Ko82s9DDTKWP5PUVFHZVaG', '0000-00-00', '30504170102056', NULL, 'Financial Analyst', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, 1, 5),
(43, 'Ahmed B.', 'ahmedB@gmail.com', '1033182344', '$2y$10$FDYdANpC5DfzNiO6p8/O7O1oreiw/Aca/AK3grROvYr4CHC/fyLP6', '0000-00-00', '30504170102056', NULL, 'Supply chain engineer ', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, 1, 5),
(44, 'Maryam R.', 'maryamR@gmail.com', '1033182344', '$2y$10$rrzdv8xWZHgTGAKHuaDTdeSbehKFTd.t//up6TiIdWAU4/uoSvmHy', '0000-00-00', '30504170102056', NULL, 'Graphic designer', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 5, 1, 5),
(45, 'Mohamed F.', 'mohamedF@gmail.com', '1033182344', '$2y$10$cz9XgEoP4nz49S3ns5jMgevSYwNjtwxRJEaJtlFE6hk5Qkqfwn9qe', '0000-00-00', '30504170102056', NULL, 'Graphic designer', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 5, 1, 5),
(46, 'Haneen H.', 'haneenH@gmail.com', '1033182344', '$2y$10$4rEjyKRoVkKdM96usuRClORNHpGGsKWrspTC.L8BUWZF7V.rk6Ckq', '0000-00-00', '30504170102056', NULL, 'Graphic designer', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 5, 1, 5),
(47, 'Mark E.', 'markE@gmail.com', '1033182344', '$2y$10$eccRp6SAXnAr.IhLz.ps7uOgxYCJIqhmq3CWmoSwoI3DUljdZuAC2', '0000-00-00', '30504170102056', NULL, 'Architect', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 5, 1, 5),
(48, 'Ahmed E.', 'ahmedE@gmail.com', '1033182344', '$2y$10$KKhccfVjU/hCxsEaLWpu4unlanfpBbre8J1Tg5lZht2ynNf1A0WGG', '0000-00-00', '30504170102056', NULL, 'calligrapher', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 5, 1, 5),
(49, 'Mohamed Y.', 'mohamedY@gmail.com', '1033182344', '$2y$10$4JjUBdXFwYG6iampGWniUOsdqbdazcPx2nV9BgstMqFOjgejWnrAS', '0000-00-00', '30504170102056', NULL, 'web developer', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 5),
(50, 'Omar A.', 'omarA@gmail.com', '1033182344', '$2y$10$blToXpuRAXp5FsAKDrKgTOHLg/0mo4E/3rJxRdKQvWIzUoTC9UKsG', '0000-00-00', '30504170102056', NULL, 'Full-stack web developer', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 5),
(51, 'Ahmed H.', 'ahmedH@gmail.com', '1033182344', '$2y$10$18LEJ0ZywHyHRFcJcr4tjeH1fd9uSXmKPN/yrMHIeCSGY/.Q/3qdO', '0000-00-00', '30504170102056', NULL, ' Linux System Administrator', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 5),
(52, 'Eslaam M.', 'eslamM@gmail.com', '1033182344', '$2y$10$WeWmz4Fcr33r2WOiVdqXNugVNxyldcTvtQ3uM3RLDAF2L7Qg11dW6', '0000-00-00', '30504170102056', NULL, 'Squarespace', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 5),
(53, 'Momen A.', 'momenA@gmail.com', '1033182344', '$2y$10$Uz/eoeyf2XgaDaDwGX/eguoxiF0LgbChx5613NRf41RXZ4n3.dXV2', '0000-00-00', '30504170102056', NULL, 'Full-stack web developer', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 5),
(54, 'Ahmed S.', 'ahmedS@gmail.com', '1033182344', '$2y$10$vQG7XJquz43Ff2ZKy46fGe3pfA/CBVJXBYkpoHRUvXH1AKg.letLm', '0000-00-00', '30504170102056', NULL, 'web developer', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 5),
(55, 'Farah F.', 'farahF@gmail.com', '1033182344', '$2y$10$s2etkSNsCT8v21rjSsPCV.WNNuIS3e0ulq1fHb9weXNfhATUlqzmO', '0000-00-00', '30504170102056', NULL, 'web developer', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 5),
(56, 'Mohamed S.', 'mohamedS@gmail.com', '1033182344', '$2y$10$iLaroxDf.BxX4vCilrHah.yz1lkKgXdo0mw7Vz6T5fgKOkpTGJBb6', '0000-00-00', '30504170102056', NULL, 'Senior Application Developer', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 5),
(57, 'Ahmed Amanalla Zehny I.', 'AhmedAmanallaZehnyI@gmail.com', '1033182344', '$2y$10$Quafbf2ppdXxf/1beGe0d.ddAePK0lJE4tL6pu7QNUhiS8Ettrldi', '0000-00-00', '30504170102056', NULL, 'Graphic designer', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, 5),
(58, 'Ahmed S.', 'ahmedS@gmail.com', '1033182344', '$2y$10$7ozXbVWVWbYuRphR5.DliujUj/FM/wedtWj6H.X0oEuRXvm3Fj.X2', '0000-00-00', '30504170102056', NULL, 'web developer', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 5),
(59, 'Amr M.', 'amrM@gmail.com', '1033182344', '$2y$10$RfHCoXfcT.vG4xfcl.8/Su7yAjJOLmAVbrVO8KQPaYPGThRuO.46u', '0000-00-00', '30504170102056', NULL, 'Content Creator', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, 5),
(60, 'Anna A.', 'annaA@gmail.com', '1033182344', '$2y$10$tKHaCpg322BToxmfyVnhH.ioXfODZNhRx6bKn96cT/2UCuaGhUFdK', '0000-00-00', '30504170102056', NULL, 'Voice Over Artist', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, 5),
(61, 'Diaa R.', 'diaaR@gmail.com', '1033182344', '$2y$10$6jHgqHq3nGRBDkyx2YNefeKpEo8JJat.UGPDLOhRCke6oFbPWvsiu', '0000-00-00', '30504170102056', NULL, 'voice over', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, 5),
(62, 'Eslam M.', 'eslamM@gmail.com', '1033182344', '$2y$10$b9fRbOT7g.yKXiua8s1ib.ILPu3rq00GHHCRY1kyx6xhGi54nxKQK', '0000-00-00', '30504170102056', NULL, 'Squarespace', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 5),
(64, 'Fatma S.', 'fatmaS@gmail.com', '1033182344', '$2y$10$W6nGvGS0V2Ip4Cq/ShuexuYODdUo/wA56d2L4VG.OLfWjLTtC/zXC', '0000-00-00', '30504170102056', NULL, 'designer', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, 5),
(65, 'Menna M.', 'mennaM@gmail.com', '1033182344', '$2y$10$C27bQvyfLIcqoCDkaDQfr./szN7WZpmb3rLlgR1jqtJP.6kzy6Bau', '0000-00-00', '30504170102056', NULL, 'Content Creator', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, 5),
(66, 'Mohammad Y.', 'mohammadY@gmail.com', '1033182344', '$2y$10$l/ci3ELLQDmkvA.98ZNFjeRvbf5.0Y2OC6Ki5pOU3I/TeDdwRhcqO', '0000-00-00', '30504170102056', NULL, ' Narrator - Arabic - English Voice Over ', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, 5),
(67, 'Nadeem Khaled', 'nadeemKhaled@gmail.com', '1033182344', '$2y$10$MndpeS5UTEu.4UuhDcj7bOaMPFuEO0Ldd8nlCXbqdyQ0c.25YcDhq', '0000-00-00', '30504170102056', NULL, 'voice over', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, 5),
(68, 'Nouran Z.', 'nouranZ@gmail.com', '1033182344', '$2y$10$M37zJ.RbRNGc6hZL2zHOhesr/GcnXr0T6R3.YgIifb8AHJ5aJqRa6', '0000-00-00', '30504170102056', NULL, 'Content Creator', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, 5),
(69, 'Sarah S.', 'sarahS@gmail.com', '1033182344', '$2y$10$DtxdT9yMwNQ2e/LgbTR0Ru1NxCT4IGm9C6XqLL4OTVZqCa8tmz2H6', '0000-00-00', '30504170102056', NULL, 'Content Creator', 42, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, 5);

-- --------------------------------------------------------

--
-- Table structure for table `like`
--

CREATE TABLE `like` (
  `like_id` int(11) NOT NULL,
  `freelancer_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `experience_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `like`
--

INSERT INTO `like` (`like_id`, `freelancer_id`, `user_id`, `experience_id`) VALUES
(2, 29, NULL, 1),
(3, 29, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `nationality`
--

CREATE TABLE `nationality` (
  `nationality_id` int(11) NOT NULL,
  `nationality` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nationality`
--

INSERT INTO `nationality` (`nationality_id`, `nationality`) VALUES
(1, 'Egyptian'),
(2, 'Saudi'),
(3, 'Emirati'),
(4, 'Lebanese'),
(5, 'Moroccan'),
(6, 'Syrian'),
(7, 'Iraqi'),
(8, 'Tunisian'),
(9, 'Qatari'),
(10, 'Kuwaiti'),
(11, 'Omani'),
(12, 'Libya'),
(13, 'Sudanese'),
(14, 'Yemeni'),
(15, 'Palestinian'),
(16, 'Somali'),
(17, 'Mauritanian'),
(18, 'Comorian'),
(19, 'Bahraini'),
(20, 'Jordanian'),
(21, 'Algerian'),
(22, 'Djiboutian');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `user_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plan`
--

CREATE TABLE `plan` (
  `plan_id` int(11) NOT NULL,
  `plan_name` varchar(255) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `post_description` varchar(250) NOT NULL,
  `availability` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `project_id` int(11) NOT NULL,
  `project_name` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `total_hours` int(11) NOT NULL,
  `deadline_date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `posting` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `project_name`, `description`, `total_hours`, `deadline_date`, `user_id`, `type_id`, `posting`) VALUES
(1, 'website', 'backend', 60, '2024-08-31', 1, 1, 1),
(2, 'design', 'ffffffffffffffffffffff', 25, '2024-08-31', 1, NULL, 1),
(7, 'it', 'kkkkkkkkkkkkk', 30, '2024-09-07', 1, NULL, 1),
(8, 'design2', 'mmmmmmmmmmmmm', 35, '2024-09-10', 1, NULL, 1),
(9, 'design3', 'kkkkkkkkkkk', 30, '2024-09-17', 1, NULL, 1),
(10, 'ittttt', 'farahhhhh', 25, '2024-08-24', 2, NULL, 1),
(11, 'ittttt', 'farahhhhh', 25, '2024-08-24', 2, NULL, 1),
(12, 'design10', 'ffffffffffffffffffffff', 25, '2024-08-25', 1, NULL, 1),
(18, 'test my', 'uiokiuiuk', 7, '2024-03-03', 2, NULL, 1),
(19, 'test post', 'uiokiuiuk', 7, '2024-03-03', 2, NULL, 1),
(20, 'test don\'t post', 'uiokiuiuk', 7, '2024-03-03', 2, NULL, 0),
(21, 'test bgd', 'testdstuiud', 60, '0000-00-00', 1, NULL, 1),
(23, 'test salma', 'jvhjdolfko;dslc', 8, '2025-02-03', 12, NULL, 1),
(24, 'test projecthjdykayyujj', 'hghnm,.', 60, '2024-03-31', 12, NULL, 1),
(25, 'Gamer', 'TestingPromo', 60, '0000-00-00', 13, NULL, 1),
(26, 'That\'slife', 'I can\'t deny it', 70, '0000-00-00', 13, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `promo`
--

CREATE TABLE `promo` (
  `promo_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `promo_code` int(5) DEFAULT NULL,
  `used` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promo`
--

INSERT INTO `promo` (`promo_id`, `user_id`, `promo_code`, `used`) VALUES
(1, 13, 81040, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rank`
--

CREATE TABLE `rank` (
  `rank_id` int(11) NOT NULL,
  `rank` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rank`
--

INSERT INTO `rank` (`rank_id`, `rank`) VALUES
(1, 'Beginner'),
(2, 'Intermediate'),
(3, 'Expert');

-- --------------------------------------------------------

--
-- Table structure for table `rate`
--

CREATE TABLE `rate` (
  `rate_id` int(11) NOT NULL,
  `rate1` varchar(250) NOT NULL,
  `rate2` varchar(11) NOT NULL,
  `rate3` varchar(11) NOT NULL,
  `comment` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `request_id` int(11) NOT NULL,
  `status` varchar(250) NOT NULL DEFAULT 'pending',
  `project_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`request_id`, `status`, `project_id`, `freelancer_id`) VALUES
(25, 'accept', 23, 29),
(26, 'accept', 24, 29);

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `skill_id` int(11) NOT NULL,
  `skill` varchar(250) NOT NULL,
  `freelancer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `plan_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_member`
--

CREATE TABLE `team_member` (
  `team_member_id` int(11) NOT NULL,
  `status` varchar(250) DEFAULT 'In Progress',
  `freelancer_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_member`
--

INSERT INTO `team_member` (`team_member_id`, `status`, `freelancer_id`, `project_id`) VALUES
(1, 'DONE', 15, 10),
(2, 'DONE', 15, 9);

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`type_id`, `type_name`) VALUES
(1, 'individual');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_image` longtext DEFAULT NULL,
  `bio` varchar(255) DEFAULT NULL,
  `nationality_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `email`, `phone_number`, `password`, `user_image`, `bio`, `nationality_id`) VALUES
(1, 'Sarah Shendy', 'salmaa.mohkjhkamedd56@gmail.com', '1096774388', '$2y$10$C6COjrgI83PGbRRFhiPtuuVfMJM3wXV3GLhwnD0RtYgxjCJPrdyzy', '', 'back_end developer', 1),
(2, 'farah', 'farahyasser04@gmail.com', '1128101015', '$2y$10$PzSs6iRKFy2NbBmnVrpoOexRTGbmr7.Bq.TGL5qrYnGtIGDrP0K/W', NULL, NULL, 1),
(12, 'salma client', 'salmaa.mohamedd56@gmail.com', '1028970103', '$2y$10$PzSs6iRKFy2NbBmnVrpoOexRTGbmr7.Bq.TGL5qrYnGtIGDrP0K/W', NULL, NULL, 1),
(13, 'shehab client', 'shehabmohamed7907@gmail.com', '1028970103', '$2y$10$qld9gcSVqW1kUXoZEnGAVOeRQltHXEa/.4xZXFErRldN2Z82WuTi.', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `freelancer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `view_limit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `views`
--

INSERT INTO `views` (`freelancer_id`, `user_id`, `view_limit`) VALUES
(29, 12, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`freelancer_id`,`project_id`),
  ADD KEY `freelancer_id` (`freelancer_id`),
  ADD KEY `request_id` (`project_id`);

--
-- Indexes for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD PRIMARY KEY (`freelancer_id`,`user_id`),
  ADD KEY `freelancer_id` (`freelancer_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `career`
--
ALTER TABLE `career`
  ADD PRIMARY KEY (`career_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `freelancer_id` (`freelancer_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `experience_id` (`experience_id`);

--
-- Indexes for table `experience`
--
ALTER TABLE `experience`
  ADD PRIMARY KEY (`experience_id`),
  ADD KEY `freelancer_id` (`freelancer_id`);

--
-- Indexes for table `freelancer`
--
ALTER TABLE `freelancer`
  ADD PRIMARY KEY (`freelancer_id`),
  ADD KEY `category_id` (`career_id`),
  ADD KEY `rank_id` (`rank_id`);

--
-- Indexes for table `like`
--
ALTER TABLE `like`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `freelancer_id` (`freelancer_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `experience_id` (`experience_id`);

--
-- Indexes for table `nationality`
--
ALTER TABLE `nationality`
  ADD PRIMARY KEY (`nationality_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `freelancer_id` (`freelancer_id`);

--
-- Indexes for table `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`plan_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `promo`
--
ALTER TABLE `promo`
  ADD PRIMARY KEY (`promo_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rank`
--
ALTER TABLE `rank`
  ADD PRIMARY KEY (`rank_id`);

--
-- Indexes for table `rate`
--
ALTER TABLE `rate`
  ADD PRIMARY KEY (`rate_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `freelancer_id` (`freelancer_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `freelancer_id` (`freelancer_id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`skill_id`),
  ADD KEY `freelancer_id` (`freelancer_id`);

--
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`freelancer_id`),
  ADD KEY `plan_id` (`plan_id`),
  ADD KEY `freelancer_id` (`freelancer_id`);

--
-- Indexes for table `team_member`
--
ALTER TABLE `team_member`
  ADD PRIMARY KEY (`team_member_id`),
  ADD KEY `freelancer_id` (`freelancer_id`),
  ADD KEY `team_id` (`project_id`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `nationality_id` (`nationality_id`);

--
-- Indexes for table `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`freelancer_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `career`
--
ALTER TABLE `career`
  MODIFY `career_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `experience`
--
ALTER TABLE `experience`
  MODIFY `experience_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `freelancer`
--
ALTER TABLE `freelancer`
  MODIFY `freelancer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `like`
--
ALTER TABLE `like`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nationality`
--
ALTER TABLE `nationality`
  MODIFY `nationality_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `plan`
--
ALTER TABLE `plan`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `promo`
--
ALTER TABLE `promo`
  MODIFY `promo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rank`
--
ALTER TABLE `rank`
  MODIFY `rank_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rate`
--
ALTER TABLE `rate`
  MODIFY `rate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `skill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `freelancer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team_member`
--
ALTER TABLE `team_member`
  MODIFY `team_member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicants`
--
ALTER TABLE `applicants`
  ADD CONSTRAINT `applicants_ibfk_1` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancer` (`freelancer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `applicants_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD CONSTRAINT `bookmark_ibfk_1` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancer` (`freelancer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bookmark_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancer` (`freelancer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_3` FOREIGN KEY (`experience_id`) REFERENCES `experience` (`experience_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `experience`
--
ALTER TABLE `experience`
  ADD CONSTRAINT `experience_ibfk_1` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancer` (`freelancer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `freelancer`
--
ALTER TABLE `freelancer`
  ADD CONSTRAINT `freelancer_ibfk_1` FOREIGN KEY (`career_id`) REFERENCES `career` (`career_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `freelancer_ibfk_2` FOREIGN KEY (`rank_id`) REFERENCES `rank` (`rank_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `like`
--
ALTER TABLE `like`
  ADD CONSTRAINT `like_ibfk_1` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancer` (`freelancer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `like_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `like_ibfk_3` FOREIGN KEY (`experience_id`) REFERENCES `experience` (`experience_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancer` (`freelancer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_ibfk_3` FOREIGN KEY (`type_id`) REFERENCES `type` (`type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `promo`
--
ALTER TABLE `promo`
  ADD CONSTRAINT `promo_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `rate`
--
ALTER TABLE `rate`
  ADD CONSTRAINT `rate_ibfk_1` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancer` (`freelancer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rate_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rate_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancer` (`freelancer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `request_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `skills_ibfk_1` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancer` (`freelancer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subscription`
--
ALTER TABLE `subscription`
  ADD CONSTRAINT `subscription_ibfk_1` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancer` (`freelancer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subscription_ibfk_2` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`plan_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `team_member`
--
ALTER TABLE `team_member`
  ADD CONSTRAINT `team_member_ibfk_1` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancer` (`freelancer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `team_member_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`nationality_id`) REFERENCES `nationality` (`nationality_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `views`
--
ALTER TABLE `views`
  ADD CONSTRAINT `views_ibfk_1` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancer` (`freelancer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `views_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
