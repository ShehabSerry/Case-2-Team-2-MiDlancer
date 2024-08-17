-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2024 at 01:27 PM
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
(29, 23, 'pending'),
(29, 24, 'pending');

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
(5, 1);

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
  `price/hr` float DEFAULT 5,
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
(2, 'Sarah Shendy', 'sarahshendy23@gmail.com', '1005101234', 'Aa.123', '2003-01-01', '30303030105195', 'defaultprofile.png', 'Epic', 40, 45, NULL, NULL, '', '', '0', 0, 0, 1, 2, 5),
(3, 'Shehab Serry', 'shehabmohamed7907@gmail.com', '1005101234', '$2y$10$qld9gcSVqW1kUXoZEnGAVOeRQltHXEa/.4xZXFErRldN2Z82WuTi.', '2003-01-01', '30303030105194', 'defaultprofile.png', 'Epic', 5, 30, NULL, NULL, '', 'I don\'t know anymore', '0', 0, 0, 1, 1, 5),
(4, 'Alaa', 'Alaa@gmail.com', '1005101234', 'Aa.123', '2003-01-01', '30303030105194', 'defaultprofile.png', 'Epic', 40, 35, 'https://github.com/alaanaguib14', 'https://www.linkedin.com/in/alaa-naguib-59857a31b/', '', '', '0', 0, 0, 1, 2, 5),
(5, 'Bushra', 'Bushra@gmail.com', '1005101234', 'Aa.123', '2003-01-01', '30303030105194', 'defaultprofile.png', 'Epic', 40, 40, NULL, NULL, '', '', '0', 0, 0, 1, 1, 5),
(6, 'Rawan', 'Rawan@gmail.com', '1005101234', 'Aa.123', '2003-01-01', '30303030105196', 'defaultprofile.png', 'Epic', 40, 50, NULL, NULL, '', '', '0', 0, 0, 1, 3, 5),
(14, 'magda', 'magdasherif245@gmail.com', '01128101015', '$2y$10$JvfW76Y5.mvfUJHmTXEnlecx1io7gZCMDts2Xh.OuqCRhdEeXs/QG', '2004-04-29', '30404290102047', NULL, 'manager', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 5),
(15, 'farah', 'farahyasser04@gmail.com', '01128101015', '$2y$10$ei9MrUcmH1dIDbEE8VFO/O34WDQePBD2mY.KyK.CUd/Erm2f6Z8Xa', '2004-04-29', '30404290102047', NULL, 'manager', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, 5),
(29, 'salma freelancer', 'salmaa.mohamedd56@gmail.com', '01028970103', '$2y$10$VWSj4gwjTLPGOx7e59.5UOYebmv8EaNdYDyJkmCQAZ4QIcHhDPTPC', '2004-03-03', '30403032102222', 'defaultprofile.png', 'data analyst', NULL, NULL, NULL, NULL, NULL, NULL, '1', 0, 0, 2, 1, 5),
(47, 'Mohamed T.', 'mohamedT@gmail.com', '01033182344', '$2y$10$LrrWSky6RB/6tzlpIKQMCuxl5hNDSoXufYOHS6yale6rZf1RAdkci', '2005-04-17', '30504170102056', NULL, 'Data Analyst ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, 5),
(48, 'Shireen Z.', 'shrieenZ@gmail.com', '01033182344', '$2y$10$GQnLu5uO3LZNoZ0BeqQf5eIk7ZH/Qp9.JBhOFa.dVTRUCdQU9g/Km', '2005-04-17', '30504170102056', NULL, 'Data Analyst ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, 5),
(49, 'Ahmed A.', 'ahmedA@gmail.com', '01033182344', '$2y$10$/wKmV7Yd/38Wujap26zkKe/EEZIfIF/hAFB4Ni4gUX6G2/lfszX1S', '2005-04-17', '30504170102056', NULL, 'Web Scraper\r\n\r\n', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, 5),
(50, 'Youssef S.', 'youssefS@gmail.com', '01033182344', '$2y$10$igWxK5VNb0WRpIEX0x7JEeRhr6qB91aCFDkvZdbBX1PJT/DAmFVKe', '2005-04-17', '30504170102056', NULL, 'Data Analyst ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, 5),
(51, 'Mohamed Y.', 'mohamedY@gmail.com', '01033182344', '$2y$10$de3gyUZIjqgTu5iVc9dozeb7J1YD/AaJ4P6lbcnH.5s6Mtmu4f3ua', '2005-04-17', '30504170102056', NULL, 'Data Analyst ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, 5),
(52, 'Raghdaa A.', 'raghdaaA@gmail.com', '01033182344', '$2y$10$wTe3hq.rMKhZqNEut6alOOmFi89lQXL0FhW5m1qsuCa/RRuyqYRX2', '2005-04-17', '30504170102056', NULL, 'Data Analyst ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, 5),
(53, 'Yahya A.', 'yehyaA@gmail.com', '01033182344', '$2y$10$KHOympWNVX.zqziN6pY8SeKlaLtP4F7Gh7EPFMuRc9TvnIPmzsy.a', '2005-04-17', '30504170102056', NULL, 'Business Systems Analyst\r\n', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, 5),
(54, 'Abdelmohsen M.', 'abdelmohsenM@gmail.com', '01033182344', '$2y$10$ff2g7LONOLEk24S5jFBP8.tt99OyBVNhB//3kN.y2X.FKd4vSA/Xa', '2005-04-17', '30504170102056', NULL, 'Graphic designer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, 5),
(55, 'Shrief K.', 'shriefK@gmail.com', '01033182344', '$2y$10$kTBAQuXqGtwgPy6Ec0d9vuBxedua1jfj1sDJr9tEYb3uJgOPm2rQe', '2005-04-17', '30504170102056', NULL, 'Financial Analyst\r\n ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, 5),
(56, 'Randa W.', 'randaW@gmail.com', '01033182344', '$2y$10$xiHvd4.MAKiOe0oou2M0TeFXMipBMisjLyIx4orA.3C0tQLhCEhH6', '2005-04-17', '30504170102056', NULL, 'Data Analyst ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, 5),
(57, 'Ehab A.', 'ehabA@gmail.com', '01033182344', '$2y$10$IKqGF0D/I5JcFW0cyQ.U/u/RGfAbNRGESlcBgh09aj12OsBC70stm', '2005-04-17', '30504170102056', NULL, 'Graphic designer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, 5),
(58, 'Mohamed A.', 'mohamedA@gmail.com', '01033182344', '$2y$10$IV6MTR0Fe6RgonCG3Nf.y.EySB.SHOg1ONK99YGEQ.nFxG0GDSRaa', '2005-04-17', '30504170102056', NULL, 'business analyst\r\n ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, 5),
(59, 'Sherif A.', 'sherifA@gmail.com', '01033182344', '$2y$10$mSitDN0J9.Dn..TFzx6T7uGUq4HQktw1fYTxjaCd85SPoyCIpeU1S', '2005-04-17', '30504170102056', NULL, 'Advanced Data Analyst', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, 5),
(60, 'Ahmed B.', 'ahmedB@gmail.com', '01033182344', '$2y$10$Xsw4tftRhm2LusLyqrJbG./ITPR4Eno.W4pDMAG2EywnJVEh9k1ku', '2005-04-17', '30504170102056', NULL, 'Supply chain engineer ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 5),
(61, 'Maryam R', 'maryamR@gmail.com', '01033182344', '$2y$10$VWlShjATccNu10YL8kmWcumuo1JBD/fHPIG1hl2UjaNKwQT6wuwX6', '2005-04-17', '30504170102056', NULL, 'Graphic designer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, 5),
(62, 'Mohamed F.', 'mohamedF@gmail.com', '01033182344', '$2y$10$Q3PXAVfiox.b9FqrMhvHRelPHLC.Hy8uwk8tY.zHhLybcB0Ad.1T6', '2005-04-17', '30504170102056', NULL, 'Graphic designer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, 5),
(63, 'Haneen H. ', 'haneenH@gmail.com', '01033182344', '$2y$10$jLa.2R4sg9RRWRNe7wvdFu1i.yzZtSv.KRHBmGRe8NE9SboOOboqa', '2005-04-17', '30504170102056', NULL, 'Graphic designer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, 5),
(64, 'Mark E.', 'markE@gmail.com', '01033182344', '$2y$10$zkqFdAUuSL8XZ8cbHA605ec62j1EUZpzKHEZWhLKSTHZ6MokxpXSW', '2005-04-17', '30504170102056', NULL, 'Architect', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, 5),
(65, 'Ahmed E.', 'ahmedE@gmail.com', '01033182344', '$2y$10$y6FQAWFI7myz943yqw6pM.yaCFpExBAJOnHxez0quX5UO.VEV15Hq', '2005-04-17', '30504170102056', NULL, 'calligrapher', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, 5),
(66, 'Omar A.', 'omarA@gmail.com', '01033182344', '$2y$10$ruRy/U59Ol3sSJZFajyKV.IZ..Sd6mQJyu8X.GejlQmz1Ch2Ltw4u', '2005-04-17', '30504170102056', NULL, 'Full-stack web developer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 5),
(67, 'Ahmed H.', 'ahmedH@gmail.com', '01033182344', '$2y$10$fu4NGqOngK5s.RJvCNtSn.6jhF6zHWLrcWXyYiYgiAaY8hJSCAnx2', '2005-04-17', '30504170102056', NULL, ' Linux System Administrator', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 5),
(68, 'Eslaam M. ', 'eslamM@gmail.com', '01033182344', '$2y$10$zEiPaztb32NLnF.0siafZuNWVcJBkWcE5Q2S0qpS6hq4jjQMvUlzS', '2005-04-17', '30504170102056', NULL, 'Squarespace', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 5),
(69, 'Momen A. ', 'momenA@gmail.com', '01033182344', '$2y$10$SYQFlf0k9d38BXT2ohn4N.BAEDFDfVK5NEShQLo2O5/q0WC1b.cry', '2005-04-17', '30504170102056', NULL, 'Full stack web developer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 5),
(70, 'Ahmed S.', 'ahmedS@gmail.com', '01033182344', '$2y$10$eJZi3OYjznDROPs471Ytje8c7sebTa9bv.iYdd.a070cZSJ5cFviS', '2005-04-17', '30504170102056', NULL, 'Web Developer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 5),
(71, 'Farah F.', 'farahF@gmail.com', '01033182344', '$2y$10$ooLmhHVSaYYmZQ8jLq2M.OzFh0t1VPLT7UB.EUA8.n82Dfv5x3pJO', '2005-04-17', '30504170102056', NULL, 'Web Developer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 5),
(72, 'Mohamed S.', 'mohmadS@gmail.com', '01033182344', '$2y$10$.nxDu.LPiMPCKRIFeoe0wel2SCSFtCDT4.wMbl1Zv/5UgtlfilUge', '2005-04-17', '30504170102056', NULL, 'Senior Application Developer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 5);

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

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `amount`, `user_id`, `freelancer_id`) VALUES
(1, 1125, 1, 2),
(2, 240, 12, 3),
(3, 240, 12, 3),
(4, 240, 12, 3),
(5, 1800, 13, 3),
(6, 1800, 13, 3),
(7, 1800, 13, 3),
(8, 1800, 13, 3),
(9, 2100, 13, 3);

-- --------------------------------------------------------

--
-- Table structure for table `plan`
--

CREATE TABLE `plan` (
  `plan_id` int(11) NOT NULL,
  `plan_name` varchar(250) NOT NULL,
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
(4, 'accept', 2, 2),
(6, 'decline', 1, 3),
(7, 'decline', 8, 3),
(22, 'accept', 23, 3),
(23, 'accept', 23, 5),
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
  `status` varchar(255) NOT NULL DEFAULT '0',
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
(2, 'DONE', 15, 9),
(3, 'in progress', 2, 2),
(4, 'in progress', 3, 23),
(5, 'in progress', 3, 23),
(6, 'in progress', 3, 23),
(7, 'in progress', 3, 25),
(8, 'in progress', 3, 26);

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
(13, 'shehab client', 'shehabmohamed7907@gmail.com', '1028970103', '$2y$10$qld9gcSVqW1kUXoZEnGAVOeRQltHXEa/.4xZXFErRldN2Z82WuTi.', NULL, NULL, 1),
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
(3, 12, 0),
(3, 12, 0);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `freelancer`
--
ALTER TABLE `freelancer`
  MODIFY `freelancer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `plan`
--
ALTER TABLE `plan`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `freelancer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subscription`
--
ALTER TABLE `subscription`
  ADD CONSTRAINT `subscription_ibfk_1` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancer` (`freelancer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subscription_ibfk_2` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`plan_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
