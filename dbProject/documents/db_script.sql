-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 05, 2015 at 05:03 PM
-- Server version: 5.5.46-0ubuntu0.14.04.2
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rmannava`
--

-- --------------------------------------------------------

--
-- Table structure for table `Aircraft`
--

CREATE TABLE IF NOT EXISTS `Aircraft` (
  `Tail_Number` varchar(16) NOT NULL,
  `Airline` varchar(16) DEFAULT NULL,
  `Manufacture` varchar(16) DEFAULT NULL,
  `Model` varchar(16) DEFAULT NULL,
  `Capacity` int(11) DEFAULT NULL,
  `Status` enum('1','0') DEFAULT NULL,
  `First_Class_Seats` int(11) DEFAULT NULL,
  `Business_Class_Seats` int(11) DEFAULT NULL,
  `Coach_Class_Seats` int(11) DEFAULT NULL,
  `Window_Seats` int(11) NOT NULL,
  `Isle_Seats` int(11) NOT NULL,
  PRIMARY KEY (`Tail_Number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Airports`
--

CREATE TABLE IF NOT EXISTS `Airports` (
  `Airport_Code` varchar(8) NOT NULL,
  `Airport_Name` varchar(128) DEFAULT NULL,
  `City` varchar(32) DEFAULT NULL,
  `State` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`Airport_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Class`
--

CREATE TABLE IF NOT EXISTS `Class` (
  `Class_Id` varchar(16) NOT NULL,
  `Class_Type` varchar(32) DEFAULT NULL,
  `Class_Price` float DEFAULT NULL,
  PRIMARY KEY (`Class_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Credit_Details`
--

CREATE TABLE IF NOT EXISTS `Credit_Details` (
  `Credit_Id` int(11) NOT NULL,
  `Credit_Card` bigint(20) DEFAULT NULL,
  `Exp_Date` varchar(16) DEFAULT NULL,
  `CVC_Code` int(11) DEFAULT NULL,
  PRIMARY KEY (`Credit_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Distance`
--

CREATE TABLE IF NOT EXISTS `Distance` (
  `From` varchar(16) DEFAULT NULL,
  `To` varchar(16) DEFAULT NULL,
  `Distance` float DEFAULT NULL,
  `Distance_Id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Distance_Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=490 ;

-- --------------------------------------------------------

--
-- Table structure for table `Flights`
--

CREATE TABLE IF NOT EXISTS `Flights` (
  `Flight_Number` varchar(16) NOT NULL,
  `Flight_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Tail_Number` varchar(16) DEFAULT NULL,
  `Status` enum('Delayed','On-Time','Cancelled') DEFAULT NULL,
  `Departure_Time` time DEFAULT NULL,
  `Distance_Id` int(11) DEFAULT NULL,
  `Arrival_Time` time DEFAULT NULL,
  PRIMARY KEY (`Flight_Number`,`Flight_Date`),
  KEY `Tail_Number` (`Tail_Number`),
  KEY `Distance_Id` (`Distance_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Flight_Fare`
--

CREATE TABLE IF NOT EXISTS `Flight_Fare` (
  `Start_Date` date DEFAULT NULL,
  `End_Date` date DEFAULT NULL,
  `Cost_Per_Mile` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Meals`
--

CREATE TABLE IF NOT EXISTS `Meals` (
  `Meal_Id` int(11) NOT NULL,
  `Meal_Type` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`Meal_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Price`
--

CREATE TABLE IF NOT EXISTS `Price` (
  `Reservation_Price` float DEFAULT NULL,
  `Reservation_Id` varchar(32) DEFAULT NULL,
  KEY `Reservation_Id` (`Reservation_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Reservations`
--

CREATE TABLE IF NOT EXISTS `Reservations` (
  `Reservations_Id` varchar(32) NOT NULL,
  `Flight_Number` varchar(16) DEFAULT NULL,
  `Flight_Date` timestamp NULL DEFAULT NULL,
  `Seat_Number` varchar(4) DEFAULT NULL,
  `Meal_Id` int(11) DEFAULT NULL,
  `UUID` varchar(32) DEFAULT NULL,
  `Class_Id` varchar(16) NOT NULL,
  PRIMARY KEY (`Reservations_Id`),
  KEY `UUID` (`UUID`),
  KEY `Flight_Number` (`Flight_Number`,`Flight_Date`),
  KEY `Meal_Id` (`Meal_Id`),
  KEY `Class_Id` (`Class_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Role`
--

CREATE TABLE IF NOT EXISTS `Role` (
  `Role_Id` int(11) NOT NULL,
  `User_Type` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`Role_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `UUID` varchar(32) NOT NULL,
  `Last_Name` varchar(64) DEFAULT NULL,
  `First_Name` varchar(64) DEFAULT NULL,
  `Street` varchar(32) DEFAULT NULL,
  `City` varchar(16) DEFAULT NULL,
  `State` varchar(16) DEFAULT NULL,
  `Zip_Code` varchar(16) DEFAULT NULL,
  `Email_Address` varchar(64) DEFAULT NULL,
  `Password` varchar(64) DEFAULT NULL,
  `Phone_Number` varchar(16) DEFAULT NULL,
  ` Role_Id` int(11) NOT NULL,
  `Credit_Id` int(11) NOT NULL,
  PRIMARY KEY (`UUID`),
  KEY `Role` (` Role_Id`),
  KEY `fk_Users_Credit_Details1` (`Credit_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Flights`
--
ALTER TABLE `Flights`
  ADD CONSTRAINT `Distance_Id` FOREIGN KEY (`Distance_Id`) REFERENCES `Distance` (`Distance_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Tail_Number` FOREIGN KEY (`Tail_Number`) REFERENCES `Aircraft` (`Tail_Number`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Price`
--
ALTER TABLE `Price`
  ADD CONSTRAINT `Price_ibfk_1` FOREIGN KEY (`Reservation_Id`) REFERENCES `Reservations` (`Reservations_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Reservations`
--
ALTER TABLE `Reservations`
  ADD CONSTRAINT `Reservations_ibfk_1` FOREIGN KEY (`Class_Id`) REFERENCES `Class` (`Class_Id`),
  ADD CONSTRAINT `Flight_Number` FOREIGN KEY (`Flight_Number`, `Flight_Date`) REFERENCES `Flights` (`Flight_Number`, `Flight_Date`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Meal_Id` FOREIGN KEY (`Meal_Id`) REFERENCES `Meals` (`Meal_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `UUID` FOREIGN KEY (`UUID`) REFERENCES `Users` (`UUID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `fk_Users_Credit_Details1` FOREIGN KEY (`Credit_Id`) REFERENCES `Credit_Details` (`Credit_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Role` FOREIGN KEY (` Role_Id`) REFERENCES `Role` (`Role_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
