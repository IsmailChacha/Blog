-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 07, 2020 at 04:59 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `Articles`
--

CREATE TABLE `Articles` (
  `Id` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Body` text NOT NULL,
  `Image` varchar(255) NOT NULL,
  `String` varchar(255) DEFAULT NULL,
  `AuthorId` int(11) NOT NULL,
  `Published` tinyint(1) NOT NULL DEFAULT 1,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Articles`
--

INSERT INTO `Articles` (`Id`, `Title`, `Body`, `Image`, `String`, `AuthorId`, `Published`, `Date`) VALUES
(3, 'Regular expressions in PHP', 'Regular expressions in PHP', '1596739242_404614.jpg', 'regular_expressions_in_php', 1, 1, '2020-08-06'),
(4, 'Regular expressions continued', '&lt;p&gt;Regular expressions.&lt;/p&gt;', '1596739868_404646.jpg', 'regular_expressions.', 1, 1, '2020-08-07');

-- --------------------------------------------------------

--
-- Table structure for table `ArticleTopics`
--

CREATE TABLE `ArticleTopics` (
  `ArticleId` int(11) NOT NULL,
  `TopicId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ArticleTopics`
--

INSERT INTO `ArticleTopics` (`ArticleId`, `TopicId`) VALUES
(1, 1),
(1, 2),
(3, 1),
(4, 1),
(4, 2),
(4, 3),
(4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `Mailing_List`
--

CREATE TABLE `Mailing_List` (
  `Id` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Mailing_List`
--

INSERT INTO `Mailing_List` (`Id`, `Name`, `Email`) VALUES
(1, 'Ismail', 'ismail.mxxiv@yahoo.com'),
(2, 'Ismail Chacha', 'ismail.mxxiv@gmail.com'),
(3, 'Habiba Boke', 'habibaboke@yahoo.com');

-- --------------------------------------------------------

--
-- Table structure for table `Topics`
--

CREATE TABLE `Topics` (
  `Id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Topics`
--

INSERT INTO `Topics` (`Id`, `Name`, `Description`) VALUES
(1, 'PHP', 'PHP'),
(2, 'JAVA', '<p>Java</p>'),
(3, 'PYTHON', 'Python'),
(4, 'RUBY', 'Ruby');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `Id` int(11) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Superuser` tinyint(1) NOT NULL DEFAULT 0,
  `Admin` tinyint(1) NOT NULL DEFAULT 0,
  `Password` varchar(255) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`Id`, `FirstName`, `LastName`, `Email`, `Superuser`, `Admin`, `Password`, `Date`) VALUES
(1, 'Ismail', 'Chacha', 'ismail.mxxiv@yahoo.com', 1, 1, '$2y$10$q3.db9agMidB24gw4TIUQecUieAc2p/L0qtPq7JsIc4VpR6WBO6MO', '2020-08-06'),
(2, 'Habiba', 'Boke', 'habibaboke@yahoo.com', 0, 1, '$2y$10$zBqGbnkeDPHt/hgq8EUG8ODLDjhOAJ7Nn.4Kd4ZEuSmaRORBqJT/C', '2020-08-06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Articles`
--
ALTER TABLE `Articles`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `authorid` (`AuthorId`),
  ADD KEY `Identifier String` (`String`);

--
-- Indexes for table `ArticleTopics`
--
ALTER TABLE `ArticleTopics`
  ADD PRIMARY KEY (`ArticleId`,`TopicId`);

--
-- Indexes for table `Mailing_List`
--
ALTER TABLE `Mailing_List`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `Topics`
--
ALTER TABLE `Topics`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Articles`
--
ALTER TABLE `Articles`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Mailing_List`
--
ALTER TABLE `Mailing_List`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Topics`
--
ALTER TABLE `Topics`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
