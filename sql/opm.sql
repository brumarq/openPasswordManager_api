-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Apr 10, 2022 at 07:17 PM
-- Server version: 10.6.5-MariaDB-1:10.6.5+maria~focal
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `opm`
--

-- --------------------------------------------------------

--
-- Table structure for table `password`
--

CREATE DATABASE IF NOT EXISTS `opm`;

use opm;

CREATE TABLE `password` (
                            `passwordId` int(11) NOT NULL,
                            `websiteUrl` varchar(255) NOT NULL,
                            `email` varchar(255) NOT NULL,
                            `password` varchar(255) NOT NULL,
                            `fkUserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `password`
--

INSERT INTO `password` (`passwordId`, `websiteUrl`, `email`, `password`, `fkUserId`) VALUES
                                                                                         (28, 'https://www.google.com', 'test@gmail.com', 'yJU++rY1TbayCDsusNauBw==', 11),
                                                                                         (29, 'https://www.yahoo.com', 'test123@gmail.com', 'yJU++rY1TbayCDsusNauBw==', 11),
                                                                                         (30, 'https://www.facebook.com', 'test@gmail.com', 'OMyEIjZG3ihS5572/El3MA==', 11);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
                        `userId` int(11) NOT NULL,
                        `firstName` varchar(255) NOT NULL,
                        `lastName` varchar(255) NOT NULL,
                        `email` varchar(255) NOT NULL,
                        `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `firstName`, `lastName`, `email`, `password`) VALUES
    (11, 'testName', 'testLastName', 'test@gmail.com', '$2y$10$AtxKKKFgS8tP/vzCwBkLDuD3kR80wd5zGblv30JFIxD5apSuprtQy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `password`
--
ALTER TABLE `password`
    ADD PRIMARY KEY (`passwordId`),
  ADD KEY `fkUserId` (`fkUserId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
    ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `password`
--
ALTER TABLE `password`
    MODIFY `passwordId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
    MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `password`
--
ALTER TABLE `password`
    ADD CONSTRAINT `password_ibfk_1` FOREIGN KEY (`fkUserId`) REFERENCES `user` (`userId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
