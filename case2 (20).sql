-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2024 at 12:17 AM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isSuper` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `email`, `password`, `isSuper`) VALUES
(5, 'salma', 'salma@gmail.com', '$2y$10$Imss04mFlCvun8Q.nRcRRuYS0WTasX0Q7iRvLtUmh81QuxSzozHqy', 1),
(6, 'sara', 'sara@gmail.com', '$2y$10$VWSj4gwjTLPGOx7e59.5UOYebmv8EaNdYDyJkmCQAZ4QIcHhDPTPC', 0),
(7, 'sama', 'sama@gmail', '$2y$10$VWSj4gwjTLPGOx7e59.5UOYebmv8EaNdYDyJkmCQAZ4QIcHhDPTPC', 0),
(8, 'alaa', 'alaa@gmail.com', '$2y$10$m1.KtPKbDIDvMAjez870gemjyHtfx0paofm.AXdAaSxcKW/j9Gdki', 0);

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
(29, 53, 'pending'),
(38, 46, 'pending'),
(38, 47, 'pending'),
(38, 48, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

CREATE TABLE `bookmark` (
  `freelancer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookmark`
--

INSERT INTO `bookmark` (`freelancer_id`, `user_id`) VALUES
(29, 1);

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
(1, 'Developer', 'Building and maintaining websites, ensuring functionality, user experience, and performance across various devices and platforms.', 'Website designer-amico.png'),
(2, 'Data Analyst', 'The process of systematically applying statistical and/or logical techniques to describe and illustrate, condense and recap, and evaluate data.', 'Data analysis-rafiki.png'),
(3, 'Voice Over ', 'Production technique that provides off-screen narration or character voices for movie trailers, TV, radio,commercials, explainer videos, and documentaries.', 'Voice control-rafiki.png'),
(4, 'Marketing Analyst', 'Set of processes for creating, communicating, delivering, and exchanging offerings that have value for customers, clients, and society at large.', 'Marketing-amico.png'),
(5, 'Designer', 'Creating visual content to communicate messages through typography, imagery, color, and form for branding, advertising, and digital media.', 'Designer-amicoBLUE.png'),
(6, 'Content Creator', 'Writing, editing, blogging, and updating content for everything from brochures and marketing and promotional materials to emails, websites, and blogs.', 'Content-bro.png');

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
(13, 'good', NULL, 15, 6);

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `conversation_id` int(11) NOT NULL,
  `user_1` int(11) NOT NULL,
  `user_2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `experience`
--

CREATE TABLE `experience` (
  `experience_id` int(11) NOT NULL,
  `experience_text` text NOT NULL,
  `experience_image` longtext DEFAULT NULL,
  `experience_file` longtext DEFAULT NULL,
  `hidden` tinyint(4) DEFAULT 0,
  `freelancer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `experience`
--

INSERT INTO `experience` (`experience_id`, `experience_text`, `experience_image`, `experience_file`, `hidden`, `freelancer_id`) VALUES
(6, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', NULL, '444503628_760460332954697_5489614384164386971_n.jpg', 0, 29),
(7, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', NULL, '_388d442c-fe30-4d6f-89ef-8ddb92757d40.jpeg', 0, 29),
(8, 'perfect', NULL, 'Task session 6.pdf', 0, 29);

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
  `price/hr` float DEFAULT 5,
  `link1` varchar(255) DEFAULT NULL,
  `link2` varchar(255) DEFAULT NULL,
  `freelancer_file` longtext DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `premium` varchar(255) DEFAULT '0',
  `view` int(11) DEFAULT 0,
  `hidden` tinyint(1) DEFAULT 0,
  `admin_hidden` tinyint(1) DEFAULT 0,
  `career_id` int(11) NOT NULL,
  `rank_id` int(11) DEFAULT 1,
  `webssite_price` int(11) NOT NULL DEFAULT 5,
  `fl_join_date` date NOT NULL DEFAULT current_timestamp(),
  `last_seen` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `freelancer`
--

INSERT INTO `freelancer` (`freelancer_id`, `freelancer_name`, `email`, `phone_number`, `password`, `birthdate`, `national_id`, `freelancer_image`, `job_title`, `available_hours`, `price/hr`, `link1`, `link2`, `freelancer_file`, `bio`, `premium`, `view`, `hidden`, `admin_hidden`, `career_id`, `rank_id`, `webssite_price`, `fl_join_date`, `last_seen`) VALUES
(15, 'farah', 'farahyasser04@gmail.com', '01128101015', '$2y$10$ei9MrUcmH1dIDbEE8VFO/O34WDQePBD2mY.KyK.CUd/Erm2f6Z8Xa', '2004-04-29', '30404290102047', 'defaultprofile.png', 'Marketing Manager', 42, 30, NULL, NULL, NULL, NULL, '0', 0, 0, 1, 4, 2, 5, '2024-07-05', '2024-09-02 00:32:58'),
(28, 'Eslam M. S.', 'eslamMS@gmail.com', '01033182344', '$2y$10$b9fRbOT7g.yKXiua8s1ib.ILPu3rq00GHHCRY1kyx6xhGi54nxKQK', '2005-04-17', '30504170102056', 'defaultprofile.png', '.NET Web Developer', 30, 10, NULL, NULL, NULL, NULL, '0', 0, 0, 1, 1, 1, 5, '2024-04-26', '2024-09-02 00:32:58'),
(29, 'salma mohamed', 'salmaa.mohamedd56@gmail.com', '01028970103', '$2y$10$VWSj4gwjTLPGOx7e59.5UOYebmv8EaNdYDyJkmCQAZ4QIcHhDPTPC', '2004-03-03', '30403032102222', 'WhatsApp Image 2024-08-23 at 14.41.28_f51e8df0.jpg', 'Data analyst', 35, 35, 'https://github.com/Salmamohamed33', '', NULL, 'I was extremely happy when I learned the command line. Shortly I learned C and C++.', '0', 0, 0, 0, 2, 2, 5, '2024-09-01', '2024-09-02 00:32:58'),
(30, 'Mohamed T.', 'mohamedT@gmail.com', '01033182344', '$2y$10$7hk5TM/bbUxVc4RGr6caTON.99N0U9uAFBKRgMySyV3vcfTRnyrxi', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Data Analyst', 72, 10, NULL, NULL, NULL, 'I am Mohamed Tahoun, I studied data analysis on udacity .', '0', 0, 0, 0, 2, 1, 5, '2024-06-26', '2024-09-02 00:32:58'),
(31, 'Shireen Z.', 'shrieenZ@gmail.com', '01033182344', '$2y$10$hmO4vuewAW4yYo0AmJVXQuvVwKZt.mhbns37IrrZWwwD6l39zUplW', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Data Analyst', 72, 10, NULL, NULL, NULL, 'I was extremely happy when I learned the command line. Shortly I learned C and C++.', '0', 0, 0, 0, 2, 1, 5, '2024-05-26', '2024-09-02 00:32:58'),
(32, 'Ahmed A.', 'ahmedA@gmail.com', '01033182344', '$2y$10$LFc9CTk.cIpgmG0mEK0f7.jMAs2BBE7uLGVxB2y9DUus3S2roqWGW', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Data Analyst', 48, 30, NULL, NULL, NULL, NULL, '0', 0, 0, 0, 2, 1, 5, '2024-02-26', '2024-09-02 00:32:58'),
(33, 'Youssef S.', 'youssefS@gmail.com', '01033182344', '$2y$10$FuviRpmlWTXVQOjADGr2reUEYgbeP5AtPerUWu4zhKNcbGG1rnHq6', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Data Analyst', 36, 10, NULL, NULL, NULL, 'Passionate Data Analyst with nearly two years of experience in data managing.', '0', 0, 0, 0, 2, 1, 5, '2024-05-26', '2024-09-02 00:32:58'),
(34, 'Mohamed Y.', 'mohamedY@gmail.com', '01033182344', '$2y$10$v14lpZ/VTEVw24KcLgV7C./ELk9QV77UsvKrVdMYgPfqxaIJTtnze', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Data Analyst', 30, 10, NULL, NULL, NULL, 'I am passionate about Data Analytics', '0', 0, 0, 0, 2, 1, 5, '2024-06-26', '2024-09-02 00:32:58'),
(35, 'Raghdaa A.', 'raghdaaA@gmail.com', '01033182344', '$2y$10$OAAhSBS8MNvxomTmkAiQheS7vX7esK5cWf0PRomNJtiYi4gaGi5sa', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Data Analyst', 12, 20, NULL, NULL, NULL, 'Data analyst experienced in business analytics using spreadsheets and Python.', '0', 0, 0, 0, 2, 2, 5, '2024-04-26', '2024-09-02 00:32:58'),
(36, 'Yahya A.', 'yahyaA@gmail.com', '01033182344', '$2y$10$mV7x5PtReXUj6E/9oaaZyuOi60Fgr5yL7X0Mg5tAMLofnp5m6SU4m', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Data Analyst', 32, 20, NULL, NULL, NULL, 'I convert your needs or your dream system into a realistic.', '0', 0, 0, 0, 2, 2, 5, '2024-08-26', '2024-09-02 00:32:58'),
(37, 'Abdelmohsen M.', 'abdelmohsenM@gmail.com', '01033182344', '$2y$10$a97agZHoFICauTmb3F3Kcev9EPxI4y3nmy1xMK4AzqXWZbhO.L3HG', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Graphic designer', 42, 25, NULL, NULL, NULL, 'Web Graphic Design , Logo & Brand Identity , Art & Illustration , Book & Magazine', '0', 0, 0, 0, 5, 1, 5, '2024-04-26', '2024-09-02 00:32:58'),
(38, 'Shrief K.', 'shriefK@gmail.com', '01033182344', '$2y$10$oHUFS2D99KMtHDZTzCCGL.nOB4wAvmfbYYugRD1u2hPEy1mBpbVmG', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Data Analyst', 32, 20, NULL, NULL, NULL, 'Avid reader, passionate translator.', '0', 0, 0, 0, 2, 2, 5, '2024-04-26', '2024-09-02 00:32:58'),
(39, 'Randa W.', 'randaW@gmail.com', '01033182344', '$2y$10$PoJdNvA5XjjTTtc1OWc0/OJtqkjbYEpow6x0XPO3o1xQecKk2MEci', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Data Analyst', 22, 30, NULL, NULL, NULL, 'I received my bachelor, Msc , and phD degrees in information technology.', '0', 0, 0, 0, 2, 3, 5, '2024-04-26', '2024-09-02 00:32:58'),
(40, 'Ehab A.', 'ehabA@gmail.com', '01033182344', '$2y$10$pxQhnKbt9n6tmvRbEnRNg.3WHiwuMLgTzuUAI9jOsbeS8ea9t3tpu', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Graphic designer', 10, 15, NULL, NULL, NULL, 'I am a passionate Graphic designer and 2D Design expert based out of Egypt.\r\n', '0', 0, 0, 0, 5, 1, 5, '2024-05-26', '2024-09-02 00:32:58'),
(41, 'Mohamed A.', 'mohamedA@gmail.com', '01033182344', '$2y$10$KP.UV8oYKqvRWC0MOvWNMuJA2ttms/ABEJH.2m5qh0QqmG4Q.QCc.', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Data Analyst', 28, 30, NULL, NULL, NULL, 'I have 4 years experience in business analysis and application integration.\r\n', '0', 0, 0, 0, 2, 3, 5, '2024-05-26', '2024-09-02 00:32:58'),
(42, 'Sherif A.', 'sherifA@gmail.com', '01033182344', '$2y$10$/Ojnvv2AY3xDvDvVP8qnGOzXYiH9lL3Ko82s9DDTKWP5PUVFHZVaG', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Financial Analyst', 42, 30, NULL, NULL, NULL, 'I have 20 years of work experience that has resulted in a strong understanding.', '0', 0, 0, 0, 2, 3, 5, '2024-07-26', '2024-09-02 00:32:58'),
(43, 'Ahmed B.', 'ahmedB@gmail.com', '01033182344', '$2y$10$FDYdANpC5DfzNiO6p8/O7O1oreiw/Aca/AK3grROvYr4CHC/fyLP6', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Supply chain engineer ', 16, 30, NULL, NULL, NULL, 'I am an industrial engineer\r\nHolding a micro master in supply chain ', '0', 0, 0, 0, 2, 3, 5, '2024-07-26', '2024-09-02 00:32:58'),
(44, 'Maryam R.', 'maryamR@gmail.com', '01033182344', '$2y$10$rrzdv8xWZHgTGAKHuaDTdeSbehKFTd.t//up6TiIdWAU4/uoSvmHy', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Graphic designer', 34, 50, NULL, NULL, NULL, 'I am a student and I am also do graphic designs, business cards, and flyers\r\n', '0', 0, 0, 0, 5, 2, 5, '2024-08-26', '2024-09-02 00:32:58'),
(45, 'Mohamed F.', 'mohamedF@gmail.com', '01033182344', '$2y$10$cz9XgEoP4nz49S3ns5jMgevSYwNjtwxRJEaJtlFE6hk5Qkqfwn9qe', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Graphic designer', 42, 35, NULL, NULL, NULL, NULL, '0', 0, 0, 0, 5, 2, 5, '2024-08-26', '2024-09-02 00:32:58'),
(46, 'Haneen H.', 'haneenH@gmail.com', '01033182344', '$2y$10$4rEjyKRoVkKdM96usuRClORNHpGGsKWrspTC.L8BUWZF7V.rk6Ckq', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Graphic designer', 52, 60, NULL, NULL, NULL, 'I\'m a professional Graphic Designer & Adobe Ambassador with an eye keen for detail.', '0', 0, 0, 0, 5, 3, 5, '2024-08-26', '2024-09-02 00:32:58'),
(47, 'Mark E.', 'markE@gmail.com', '01033182344', '$2y$10$eccRp6SAXnAr.IhLz.ps7uOgxYCJIqhmq3CWmoSwoI3DUljdZuAC2', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Architect', 52, 60, NULL, NULL, NULL, 'I\'m a 3 years experienced multidisciplinary designer, I worked as a spatial designer.\r\n', '0', 0, 0, 0, 5, 3, 5, '2024-08-26', '2024-09-02 00:32:58'),
(48, 'Ahmed E.', 'ahmedE@gmail.com', '01033182344', '$2y$10$KKhccfVjU/hCxsEaLWpu4unlanfpBbre8J1Tg5lZht2ynNf1A0WGG', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Calligrapher', 43, 60, NULL, NULL, NULL, 'I am Ahmed Elsayed a graphic designer from Egypt specializing in designing logos.', '0', 0, 0, 0, 5, 3, 5, '2024-08-26', '2024-09-02 00:32:58'),
(49, 'Mohamed Y. A.', 'mohamedYA@gmail.com', '01033182344', '$2y$10$4JjUBdXFwYG6iampGWniUOsdqbdazcPx2nV9BgstMqFOjgejWnrAS', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Web developer', 42, 25, NULL, NULL, NULL, NULL, '0', 0, 0, 1, 1, 1, 5, '2024-08-26', '2024-09-02 00:32:58'),
(50, 'Omar A.', 'omarA@gmail.com', '01033182344', '$2y$10$blToXpuRAXp5FsAKDrKgTOHLg/0mo4E/3rJxRdKQvWIzUoTC9UKsG', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Full-stack web developer', 33, 25, NULL, NULL, NULL, 'I started my first code when I was 14 years old a VB.NET Calculator.\r\n', '0', 0, 0, 0, 1, 1, 5, '2024-08-26', '2024-09-02 00:32:58'),
(51, 'Ahmed H.', 'ahmedH@gmail.com', '01033182344', '$2y$10$18LEJ0ZywHyHRFcJcr4tjeH1fd9uSXmKPN/yrMHIeCSGY/.Q/3qdO', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Linux System Administrator', 20, 20, NULL, NULL, NULL, 'I\'m an Expert Linux System Administrator/web developer with experience .', '0', 0, 0, 0, 1, 1, 5, '2024-08-26', '2024-09-02 00:32:58'),
(52, 'Eslaam M.', 'eslamM@gmail.com', '01033182344', '$2y$10$WeWmz4Fcr33r2WOiVdqXNugVNxyldcTvtQ3uM3RLDAF2L7Qg11dW6', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Squarespace', 35, 45, NULL, NULL, NULL, 'Creating responsive websites that\'re functional with exceptional user experience.', '0', 0, 0, 0, 1, 2, 5, '2024-08-26', '2024-09-02 00:32:58'),
(53, 'Momen A.', 'momenA@gmail.com', '01033182344', '$2y$10$Uz/eoeyf2XgaDaDwGX/eguoxiF0LgbChx5613NRf41RXZ4n3.dXV2', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Full-stack web developer', 60, 35, NULL, NULL, NULL, 'specialist in web applications expert in javaScript.', '0', 0, 0, 0, 1, 2, 5, '2024-08-26', '2024-09-02 00:32:58'),
(54, 'Ahmed S.', 'ahmedS@gmail.com', '01033182344', '$2y$10$vQG7XJquz43Ff2ZKy46fGe3pfA/CBVJXBYkpoHRUvXH1AKg.letLm', '2005-04-17', '30504170102056', 'defaultprofile.png', 'web developer', 40, 40, NULL, NULL, NULL, 'Have been working as a web developer for 5+ years now and very experienced. ', '0', 0, 0, 0, 1, 2, 5, '2024-08-26', '2024-09-02 00:32:58'),
(55, 'Farah F.', 'farahF@gmail.com', '01033182344', '$2y$10$s2etkSNsCT8v21rjSsPCV.WNNuIS3e0ulq1fHb9weXNfhATUlqzmO', '2005-04-17', '30504170102056', 'defaultprofile.png', 'web developer', 55, 60, NULL, NULL, NULL, 'Web developer and have interest in AI solutions.\r\n', '0', 0, 0, 0, 1, 3, 5, '2024-08-26', '2024-09-02 00:32:58'),
(56, 'Mohamed S.', 'mohamedS@gmail.com', '01033182344', '$2y$10$iLaroxDf.BxX4vCilrHah.yz1lkKgXdo0mw7Vz6T5fgKOkpTGJBb6', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Senior Application Developer', 53, 60, NULL, NULL, NULL, 'An articulate and determined engineer with wide experience in development field.', '0', 0, 0, 0, 1, 3, 5, '2024-08-26', '2024-09-02 00:32:58'),
(57, 'Ahmed Amanalla Zehny I.', 'AhmedAmanallaZehnyI@gmail.com', '01033182344', '$2y$10$Quafbf2ppdXxf/1beGe0d.ddAePK0lJE4tL6pu7QNUhiS8Ettrldi', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Graphic designer', 49, 45, NULL, NULL, NULL, 'Greetings! I\'m a detail-oriented data analyst with expertise in Python.', '0', 0, 0, 0, 5, 2, 5, '2024-08-26', '2024-09-02 00:32:58'),
(58, 'Ahmed S. A.', 'ahmedSA@gmail.com', '01033182344', '$2y$10$7ozXbVWVWbYuRphR5.DliujUj/FM/wedtWj6H.X0oEuRXvm3Fj.X2', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Web developer', 26, 60, NULL, NULL, NULL, NULL, '0', 0, 0, 0, 1, 3, 5, '2024-08-26', '2024-09-02 00:32:58'),
(59, 'Amr M.', 'amrM@gmail.com', '01033182344', '$2y$10$RfHCoXfcT.vG4xfcl.8/Su7yAjJOLmAVbrVO8KQPaYPGThRuO.46u', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Content Creator', 42, 100, NULL, NULL, NULL, 'I\'m a 22-year-old fresh graduate, i graduated from Cairo university in business .', '0', 0, 0, 0, 6, 3, 5, '2024-08-26', '2024-09-02 00:32:58'),
(60, 'Anna A.', 'annaA@gmail.com', '01033182344', '$2y$10$tKHaCpg322BToxmfyVnhH.ioXfODZNhRx6bKn96cT/2UCuaGhUFdK', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Voice Over Artist', 47, 75, NULL, NULL, NULL, 'I\'m singing since I was 3 years, having good voice skills.', '0', 0, 0, 0, 3, 2, 5, '2024-08-26', '2024-09-02 00:32:58'),
(61, 'Diaa R.', 'diaaR@gmail.com', '01033182344', '$2y$10$6jHgqHq3nGRBDkyx2YNefeKpEo8JJat.UGPDLOhRCke6oFbPWvsiu', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Voice Over Artist', 50, 85, NULL, NULL, NULL, 'Audio, Video & Animation\nVoice Over , Podcasts', '0', 0, 0, 0, 3, 2, 5, '2024-08-26', '2024-09-02 00:32:58'),
(64, 'Fatma S.', 'fatmaS@gmail.com', '01033182344', '$2y$10$W6nGvGS0V2Ip4Cq/ShuexuYODdUo/wA56d2L4VG.OLfWjLTtC/zXC', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Frontend web developer', 30, 60, NULL, NULL, NULL, '- I graduated from Benha computers and information Grade a very good.\r\n', '0', 0, 0, 0, 1, 3, 5, '2024-08-26', '2024-09-02 00:32:58'),
(65, 'Menna M.', 'mennaM@gmail.com', '01033182344', '$2y$10$C27bQvyfLIcqoCDkaDQfr./szN7WZpmb3rLlgR1jqtJP.6kzy6Bau', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Content Creator', 65, 100, NULL, NULL, NULL, 'As a an English Department graduate from Alexandria University.', '0', 0, 0, 0, 6, 3, 5, '2024-08-26', '2024-09-02 00:32:58'),
(66, 'Mohammad Y.', 'mohammadY@gmail.com', '01033182344', '$2y$10$l/ci3ELLQDmkvA.98ZNFjeRvbf5.0Y2OC6Ki5pOU3I/TeDdwRhcqO', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Narrator - Arabic - English Voice Over ', 75, 130, NULL, NULL, NULL, 'Voice Over (Documentary - educational - audio-books - news-reporter - advertising )', '0', 0, 0, 0, 3, 3, 5, '2024-08-26', '2024-09-02 00:32:58'),
(67, 'Nadeem Khaled', 'nadeemKhaled@gmail.com', '01033182344', '$2y$10$MndpeS5UTEu.4UuhDcj7bOaMPFuEO0Ldd8nlCXbqdyQ0c.25YcDhq', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Voice Over Actor', 62, 150, NULL, NULL, NULL, 'Nadeem is a professional VO artist since 2010. ', '0', 0, 0, 0, 3, 3, 5, '2024-08-26', '2024-09-02 00:32:58'),
(68, 'Nouran Z.', 'nouranZ@gmail.com', '01033182344', '$2y$10$M37zJ.RbRNGc6hZL2zHOhesr/GcnXr0T6R3.YgIifb8AHJ5aJqRa6', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Content Creator', 32, 50, NULL, NULL, NULL, 'A multi-skilled & reliable translator with 8 years’ experience in translating.', '0', 0, 0, 0, 6, 2, 5, '2024-08-26', '2024-09-02 00:32:58'),
(69, 'Sarah S.', 'sarahS@gmail.com', '01033182344', '$2y$10$DtxdT9yMwNQ2e/LgbTR0Ru1NxCT4IGm9C6XqLL4OTVZqCa8tmz2H6', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Content Creator', 32, 50, NULL, NULL, NULL, 'Graduated from The American University in Cairo with Marketing Communications.', '0', 0, 0, 0, 6, 2, 5, '2024-08-26', '2024-09-02 00:32:58'),
(70, 'Mohamed Y.', 'mohamed@gmail.com', '01033182344', '$2y$10$v14lpZ/VTEVw24KcLgV7C./ELk9QV77UsvKrVdMYgPfqxaIJTtnze', '2005-04-17', '30504170102056', 'defaultprofile.png', 'Web Developer', 13, 15, NULL, NULL, NULL, 'I\'m an engineer . I like web development, programming.', '0', 0, 0, 0, 1, 1, 5, '2024-08-26', '2024-09-02 00:32:58'),
(72, 'sara', 'salmamohamed.presentation@gmail.com', '01028970102', '$2y$10$3fYx9QRVv129/7ZUalqs5udRg/evnU06DYG/EImQp.DNPc.IOVo8m', '2004-03-03', '30403032102222', 'defaultprofile.png', 'backend ', NULL, NULL, NULL, NULL, NULL, NULL, '0', 0, 0, 0, 5, 1, 5, '2024-09-01', NULL);

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
(4, 29, NULL, 6),
(6, NULL, 15, 6);

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
  `commission` float NOT NULL,
  `date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `amount`, `commission`, `date`, `user_id`, `freelancer_id`, `project_id`) VALUES
(14, 900, 15, '2024-08-01', 19, 31, 44),
(15, 10000, 15, '2024-07-12', 18, 33, 35),
(16, 400, 15, '2024-09-02', 2, 35, 40),
(17, 2000, 15, '2024-05-09', 16, 66, 48),
(18, 350, 15, '2024-07-17', 15, 69, 39),
(19, 5000, 15, '2024-04-11', 2, 33, 36);

-- --------------------------------------------------------

--
-- Table structure for table `plan`
--

CREATE TABLE `plan` (
  `plan_id` int(11) NOT NULL,
  `plan_name` varchar(255) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plan`
--

INSERT INTO `plan` (`plan_id`, `plan_name`, `price`) VALUES
(1, 'Free plan', 0),
(2, 'Premium plan', 25);

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
(34, 'logo', 'To create a company logo to grab customer\'s attention and stand out from competitors. ', 25, '2024-09-06', 1, 1, 1),
(35, 'Website(UI/UX)', 'A website proposal is a business document web developers, and designers use to pitch their services to prospective clients.', 150, '2024-09-20', 2, 1, 1),
(36, 'Social media', '\r\nSocial media project management is the process of planning, deploying, and monitoring social media marketing campaigns across multiple platforms to fulfill specific objectives such as increased revenue.', 4, '2024-10-03', 12, 1, 1),
(37, 'Packaging design', 'Packaging design is the connection of form, structure, materials, colour, imagery, typography, and regulatory information with ancillary design elements to make a product suitable for marketing.', 40, '2024-10-04', 13, 1, 1),
(38, 'Basic data cleaning', 'Data cleaning is the process of fixing or removing incorrect, corrupted, incorrectly formatted, duplicate, or incomplete data within a dataset.', 15, '2024-10-02', 15, 1, 1),
(39, 'Dashboard creation', 'Make sure your dashboard is easy to understand at a glance by organizing the data and using a consistent color scheme.', 30, '2024-10-02', 16, 1, 1),
(40, 'Data visualization', 'Data visualization is the graphical representation of information and data.', 25, '2024-10-04', 17, 1, 1),
(41, 'Big data analysis', 'Big data analytics describes the process of uncovering trends, patterns, and correlations in large amounts of raw data to help make data-informed decisions.', 250, '2024-09-10', 18, 1, 1),
(42, 'Small website for business ', 'Small website for business uses various ways to promote its products on its homepage, like listing why people should love the brand and ways to personalize their products.', 120, '2024-09-11', 19, 1, 1),
(43, 'E-commerce', 'The primary goal of an e-commerce site is to sell goods online. This project deals with developing an e-commerce website for Online Product Sale.', 350, '2024-09-15', 20, 1, 1),
(44, 'Landing page', 'If the goal is to obtain a lead, the landing page will include some method for the visitor to get into contact with the company, usually a phone number or an inquiry form.', 30, '2024-09-02', 1, 1, 1),
(45, 'Short commercial', 'Commercial construction involves the construction of buildings and other structures used for commercial purposes. It includes office buildings, retail stores, warehouses, factories, and more.', 3, '2024-09-02', 15, 1, 1),
(46, 'E-learning module', 'The practice of making sure that every part of the eLearning development process runs synchronously, on time, and to standard!', 9, '2024-09-02', 19, 1, 1),
(47, 'Audio book', 'You can convert text to speech from any PDF which uses the English language; You can create audiobook and save that audiobook file as mp3.', 8, '2024-09-02', 20, 1, 1),
(48, 'podcast introduction', 'The best podcast intros are unique to each episode and include a teaser of content from later in the show to hook listeners.', 2, '2024-09-02', 18, 1, 1),
(49, 'new project', 'jasahxsaj', 88, '2024-10-02', 1, 1, 1),
(50, 'test email', 'kduewoiuidi', 9, '2024-10-06', 1, 1, 1),
(51, 'test again', 'dfewfwef', 6, '2024-10-06', 1, 1, 1),
(52, 'new', 'kjhkjhkh', 6, '2024-10-06', 1, 1, 1),
(53, 'send to salma', 'kfjvkjdf', 70, '2024-10-08', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `promo`
--

CREATE TABLE `promo` (
  `promo_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `promo_code` varchar(5) DEFAULT NULL,
  `used` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promo`
--

INSERT INTO `promo` (`promo_id`, `user_id`, `promo_code`, `used`) VALUES
(2, NULL, '6RAAW', 0),
(3, NULL, 'QS6D4', 0),
(4, NULL, 'DKA36', 0),
(5, NULL, 'PDACJ', 0),
(6, NULL, 'AIM9X', 0),
(7, NULL, 'R27ER', 0),
(8, NULL, 'AGM65', 0);

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
  `freelancer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rate`
--

INSERT INTO `rate` (`rate_id`, `rate1`, `rate2`, `rate3`, `comment`, `user_id`, `freelancer_id`) VALUES
(2, '4.8', '4.7', '4.8', 'good freelancer i recommend him', 1, 15),
(3, '4.5', '4.9', '4.3', 'she\'s very talanted and I enjoyed working with her', 18, 33),
(4, '4.8', '4.9', '4.8', 'good freelancer i recommend her', 19, 36),
(5, '4.5', '4.9', '4.3', 'I loved her dedication and commitment', 16, 67),
(6, '4.8', '4.7', '4.8', 'good freelancer i recommend him', 1, 53),
(7, '4.5', '4.9', '5', 'she\'s very talanted and I enjoyed working with her', 18, 50),
(8, '4.8', '4.9', '4.8', 'good freelancer i recommend her', 19, 70);

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
(38, 'pending', 36, 29);

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

--
-- Dumping data for table `subscription`
--

INSERT INTO `subscription` (`plan_id`, `freelancer_id`, `status`, `start_date`, `end_date`) VALUES
(2, 15, 'Active', '2024-08-30', '2024-09-11'),
(2, 29, 'Active', '2024-08-30', '2024-09-11'),
(2, 32, 'Active', '2024-08-30', '2024-09-11'),
(2, 33, 'Active', '2024-08-30', '2024-09-11'),
(1, 37, 'Active', '2024-08-29', '2024-09-10'),
(2, 44, 'Active', '2024-08-30', '2024-09-11'),
(1, 46, 'Active', '2024-08-29', '2024-09-10'),
(2, 47, 'Active', '2024-08-30', '2024-09-11'),
(1, 50, 'Active', '2024-08-29', '2024-09-10'),
(2, 51, 'Active', '2024-08-30', '2024-09-11'),
(1, 53, 'Active', '2024-08-29', '2024-09-10'),
(2, 57, 'Active', '2024-08-30', '2024-09-11'),
(2, 59, 'Active', '2024-08-30', '2024-09-11'),
(2, 61, 'Active', '2024-08-30', '2024-09-11'),
(1, 64, 'Active', '2024-08-29', '2024-09-10'),
(1, 66, 'Active', '2024-08-29', '2024-09-10'),
(1, 67, 'Active', '2024-08-29', '2024-09-10'),
(1, 68, 'Active', '2024-08-29', '2024-09-10'),
(1, 69, 'Active', '2024-08-29', '2024-09-10'),
(1, 72, 'active', '2024-09-01', '2024-09-01');

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
(22, 'In Progress', 15, 38),
(23, 'In Progress', 15, 50);

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
(1, 'individual'),
(2, 'Team');

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
  `user_image` longtext DEFAULT 'defaultprofile.png',
  `bio` varchar(255) DEFAULT NULL,
  `nationality_id` int(11) NOT NULL,
  `last_seen` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `email`, `phone_number`, `password`, `user_image`, `bio`, `nationality_id`, `last_seen`) VALUES
(1, 'Sarah Shendy', 'salmaa.mohkjhkamedd56@gmail.com', '01096774388', '$2y$10$C6COjrgI83PGbRRFhiPtuuVfMJM3wXV3GLhwnD0RtYgxjCJPrdyzy', 'defaultprofile.png', 'backend devloper', 1, '2024-09-02 00:33:51'),
(2, 'farah', 'farahyasser04@gmail.com', '01128101015', '$2y$10$PzSs6iRKFy2NbBmnVrpoOexRTGbmr7.Bq.TGL5qrYnGtIGDrP0K/W', 'defaultprofile.png', 'CEO at instant company', 5, '2024-09-02 00:33:51'),
(12, 'salma client', 'salmaa.mohamedd56@gmail.com', '01028970103', '$2y$10$PzSs6iRKFy2NbBmnVrpoOexRTGbmr7.Bq.TGL5qrYnGtIGDrP0K/W', 'defaultprofile.png', 'Manger at go on graphics ', 7, '2024-09-02 00:33:51'),
(13, 'shehab client', 'shehabmohamed7907@gmail.com', '01028970103', '$2y$10$qld9gcSVqW1kUXoZEnGAVOeRQltHXEa/.4xZXFErRldN2Z82WuTi.', 'defaultprofile.png', 'Specialist at php ', 9, '2024-09-02 00:33:51'),
(15, 'Bushra', 'bushra@gmail.com', '01138484929', '$2y$10$qld9gcSVqW1kUXoZEnGAVOeRQltHXEa/.4xZXFErRldN2Z82WuTi.', 'defaultprofile.png', 'CFO at dolphin company ', 5, '2024-09-02 00:33:51'),
(16, 'Alaa', 'alaa@gmail.com', '01238484929', '$2y$10$qld9gcSVqW1kUXoZEnGAVOeRQltHXEa/.4xZXFErRldN2Z82WuTi.', 'defaultprofile.png', 'owner of EG_games', 4, '2024-09-02 00:33:51'),
(17, 'Mohamed Ahmed', 'mohamed@gmail.com', '01158484929', '$2y$10$qld9gcSVqW1kUXoZEnGAVOeRQltHXEa/.4xZXFErRldN2Z82WuTi.', 'defaultprofile.png', 'Medical content creator', 3, '2024-09-02 00:33:51'),
(18, 'Rawan', 'rawan@gmail.com', '01158484888', '$2y$10$qld9gcSVqW1kUXoZEnGAVOeRQltHXEa/.4xZXFErRldN2Z82WuTi.', 'defaultprofile.png', 'graphic designer ', 2, '2024-09-02 00:33:51'),
(19, 'laila', 'laila@gmail.com', '01198485940', '$2y$10$qld9gcSVqW1kUXoZEnGAVOeRQltHXEa/.4xZXFErRldN2Z82WuTi.', 'defaultprofile.png', 'senior mean full stack', 13, '2024-09-02 00:33:51'),
(20, 'Yousab', 'yousab@gmail.com', '01292873849', '$2y$10$qld9gcSVqW1kUXoZEnGAVOeRQltHXEa/.4xZXFErRldN2Z82WuTi.', 'defaultprofile.png', 'Marketing analyst ', 12, '2024-09-02 00:33:51');

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
(29, 1, 0),
(29, 12, 0),
(50, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

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
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`conversation_id`),
  ADD KEY `user_1` (`user_1`),
  ADD KEY `user_2` (`user_2`);

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
  ADD KEY `freelancer_id` (`freelancer_id`),
  ADD KEY `fk_project` (`project_id`);

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
  ADD KEY `freelancer_id` (`freelancer_id`);

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
  ADD UNIQUE KEY `email` (`email`),
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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `career`
--
ALTER TABLE `career`
  MODIFY `career_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `conversation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `experience`
--
ALTER TABLE `experience`
  MODIFY `experience_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `freelancer`
--
ALTER TABLE `freelancer`
  MODIFY `freelancer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `like`
--
ALTER TABLE `like`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `nationality`
--
ALTER TABLE `nationality`
  MODIFY `nationality_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `plan`
--
ALTER TABLE `plan`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `promo`
--
ALTER TABLE `promo`
  MODIFY `promo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rank`
--
ALTER TABLE `rank`
  MODIFY `rank_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rate`
--
ALTER TABLE `rate`
  MODIFY `rate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `skill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `freelancer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `team_member`
--
ALTER TABLE `team_member`
  MODIFY `team_member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
-- Constraints for table `conversations`
--
ALTER TABLE `conversations`
  ADD CONSTRAINT `conversations_ibfk_1` FOREIGN KEY (`user_1`) REFERENCES `freelancer` (`freelancer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `conversations_ibfk_2` FOREIGN KEY (`user_2`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `fk_project` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE,
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
