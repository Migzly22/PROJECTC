-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 20, 2023 at 01:40 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elijosh2`
--

-- --------------------------------------------------------

--
-- Table structure for table `additionalhead`
--

DROP TABLE IF EXISTS `additionalhead`;
CREATE TABLE IF NOT EXISTS `additionalhead` (
  `AH_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Type` varchar(50) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`AH_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `additionalhead`
--

INSERT INTO `additionalhead` (`AH_ID`, `Type`, `Price`) VALUES
(1, 'Day', '250.00'),
(2, 'Night', '300.00'),
(3, '22Hrs', '400.00');

-- --------------------------------------------------------

--
-- Table structure for table `cottage`
--

DROP TABLE IF EXISTS `cottage`;
CREATE TABLE IF NOT EXISTS `cottage` (
  `CottageID` int(11) NOT NULL AUTO_INCREMENT,
  `Cottagenum` int(11) NOT NULL,
  `CottageType` varchar(50) NOT NULL,
  PRIMARY KEY (`CottageID`)
) ENGINE=InnoDB AUTO_INCREMENT=209 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cottage`
--

INSERT INTO `cottage` (`CottageID`, `Cottagenum`, `CottageType`) VALUES
(201, 1, 'Umbrella'),
(202, 2, 'Umbrella'),
(203, 3, 'Kubo'),
(204, 4, 'Kubo'),
(205, 5, 'Gazebo'),
(206, 6, 'Gazebo'),
(207, 7, 'Tent'),
(208, 8, 'Tent');

-- --------------------------------------------------------

--
-- Table structure for table `cottagereservation`
--

DROP TABLE IF EXISTS `cottagereservation`;
CREATE TABLE IF NOT EXISTS `cottagereservation` (
  `cr_id` int(11) NOT NULL AUTO_INCREMENT,
  `reservationID` int(11) NOT NULL,
  `cottagenum` int(11) NOT NULL,
  PRIMARY KEY (`cr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cottagetypes`
--

DROP TABLE IF EXISTS `cottagetypes`;
CREATE TABLE IF NOT EXISTS `cottagetypes` (
  `ServiceTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `ServiceTypeName` varchar(100) DEFAULT NULL,
  `DayPrice` decimal(10,2) DEFAULT NULL,
  `NightPrice` decimal(10,2) DEFAULT NULL,
  `MinPersons` int(11) NOT NULL,
  `MaxPersons` int(11) DEFAULT NULL,
  PRIMARY KEY (`ServiceTypeID`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cottagetypes`
--

INSERT INTO `cottagetypes` (`ServiceTypeID`, `ServiceTypeName`, `DayPrice`, `NightPrice`, `MinPersons`, `MaxPersons`) VALUES
(2, 'Umbrella', '400.00', '600.00', 2, 4),
(3, 'Kubo', '1000.00', '1500.00', 8, 10),
(4, 'Gazebo', '1500.00', '2000.00', 1, 15),
(5, 'Tent', '2000.00', '2500.00', 20, 25);

-- --------------------------------------------------------

--
-- Table structure for table `eventpav`
--

DROP TABLE IF EXISTS `eventpav`;
CREATE TABLE IF NOT EXISTS `eventpav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Pavtype` varchar(50) NOT NULL,
  `MaxPax` int(11) NOT NULL,
  `MinPax` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eventpav`
--

INSERT INTO `eventpav` (`id`, `Pavtype`, `MaxPax`, `MinPax`) VALUES
(1, 'Pavilion', 200, 50),
(2, 'Grand Pavilion', 300, 100);

-- --------------------------------------------------------

--
-- Table structure for table `eventplace`
--

DROP TABLE IF EXISTS `eventplace`;
CREATE TABLE IF NOT EXISTS `eventplace` (
  `Evntid` int(11) NOT NULL AUTO_INCREMENT,
  `PAX` int(11) NOT NULL,
  `Pavilion` int(11) NOT NULL,
  `Grand Pavilion` int(11) NOT NULL,
  PRIMARY KEY (`Evntid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `eventplace`
--

INSERT INTO `eventplace` (`Evntid`, `PAX`, `Pavilion`, `Grand Pavilion`) VALUES
(1, 50, 25000, 60000),
(2, 100, 35000, 60000),
(3, 150, 35000, 70000),
(4, 200, 50000, 80000),
(5, 250, 50000, 90000),
(6, 300, 50000, 100000);

-- --------------------------------------------------------

--
-- Table structure for table `eventreservation`
--

DROP TABLE IF EXISTS `eventreservation`;
CREATE TABLE IF NOT EXISTS `eventreservation` (
  `e_ID` int(11) NOT NULL AUTO_INCREMENT,
  `reservationID` int(11) DEFAULT NULL,
  `eventname` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`e_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `extracharges`
--

DROP TABLE IF EXISTS `extracharges`;
CREATE TABLE IF NOT EXISTS `extracharges` (
  `ExtraID` int(11) NOT NULL AUTO_INCREMENT,
  `ItemName` varchar(100) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `QuantityAvailable` int(11) DEFAULT NULL,
  `PackageFor` varchar(50) NOT NULL,
  PRIMARY KEY (`ExtraID`)
) ENGINE=MyISAM AUTO_INCREMENT=10039 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `extracharges`
--

INSERT INTO `extracharges` (`ExtraID`, `ItemName`, `Price`, `QuantityAvailable`, `PackageFor`) VALUES
(10001, 'Towel (Big)', '1000.00', 10, 'All'),
(10002, 'Towel (Small)', '500.00', 10, 'All'),
(10003, 'Pillow', '500.00', 10, 'ROOMS'),
(10004, 'Pillow Case', '500.00', 10, 'ROOMS'),
(10005, 'Bedsheet', '1000.00', 10, ''),
(10006, 'Flat sheet', '1000.00', 10, 'ROOMS'),
(10007, 'Duvet', '1500.00', 10, 'ROOMS'),
(10008, 'Room Key', '2000.00', 10, 'ROOMS'),
(10009, 'Hair Dryer', '1500.00', 10, 'All'),
(10010, 'Electric Kettle', '1000.00', 10, 'All'),
(10011, 'Remote Control (T.V.)', '1000.00', 10, 'ROOMS'),
(10012, 'Remote Control (Aircon)', '1000.00', 10, 'ROOMS'),
(10013, 'Glass', '1000.00', 10, 'All'),
(10014, 'Cup & Saucer', '1000.00', 200, 'All'),
(10015, 'Bath Mat', '1000.00', 10, 'All'),
(10019, 'Single Bed', '500.00', 10, 'ROOMS'),
(10020, 'Queensize Bed', '800.00', 10, 'ROOMS'),
(10021, 'Hand Towel', '100.00', 10, 'All'),
(10022, 'Bath Towel', '200.00', 10, 'All'),
(10023, 'Gas & Stove', '1000.00', 10, 'All'),
(10024, 'Excess Venue Hours', '5000.00', 10, 'All');

-- --------------------------------------------------------

--
-- Table structure for table `guestextracharges`
--

DROP TABLE IF EXISTS `guestextracharges`;
CREATE TABLE IF NOT EXISTS `guestextracharges` (
  `ChargeID` int(11) NOT NULL AUTO_INCREMENT,
  `ReservationID` int(11) DEFAULT NULL,
  `ChargeDescription` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `ChargeAmount` decimal(10,2) DEFAULT NULL,
  `ChargeDate` date DEFAULT NULL,
  PRIMARY KEY (`ChargeID`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `guestpayments`
--

DROP TABLE IF EXISTS `guestpayments`;
CREATE TABLE IF NOT EXISTS `guestpayments` (
  `PaymentID` int(11) NOT NULL AUTO_INCREMENT,
  `ReservationID` int(11) DEFAULT NULL,
  `PaymentDate` date DEFAULT NULL,
  `AmountPaid` decimal(10,2) DEFAULT NULL,
  `PaymentMethod` varchar(50) DEFAULT NULL,
  `Description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`PaymentID`),
  KEY `ReservationID` (`ReservationID`)
) ENGINE=MyISAM AUTO_INCREMENT=130 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

DROP TABLE IF EXISTS `guests`;
CREATE TABLE IF NOT EXISTS `guests` (
  `GuestID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(50) DEFAULT NULL,
  `MiddleName` varchar(100) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `State` varchar(50) DEFAULT NULL,
  `PostalCode` varchar(15) DEFAULT NULL,
  `Country` varchar(50) DEFAULT NULL,
  `MembershipLevel` varchar(50) DEFAULT NULL,
  `JoinDate` date DEFAULT NULL,
  PRIMARY KEY (`GuestID`)
) ENGINE=MyISAM AUTO_INCREMENT=137 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `poolrate`
--

DROP TABLE IF EXISTS `poolrate`;
CREATE TABLE IF NOT EXISTS `poolrate` (
  `RateID` int(11) NOT NULL AUTO_INCREMENT,
  `Type` varchar(10) DEFAULT NULL,
  `WeekdaysDayPrice` decimal(10,2) DEFAULT NULL,
  `WeekdaysNightPrice` decimal(10,2) DEFAULT NULL,
  `Weekdays22HrsPrice` decimal(10,2) NOT NULL,
  `WeekendsHolidaysDayPrice` decimal(10,2) DEFAULT NULL,
  `WeekendsHolidaysNightPrice` decimal(10,2) DEFAULT NULL,
  `WeekendsHolidays22HrsPrice` decimal(10,2) NOT NULL,
  PRIMARY KEY (`RateID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `poolrate`
--

INSERT INTO `poolrate` (`RateID`, `Type`, `WeekdaysDayPrice`, `WeekdaysNightPrice`, `Weekdays22HrsPrice`, `WeekendsHolidaysDayPrice`, `WeekendsHolidaysNightPrice`, `WeekendsHolidays22HrsPrice`) VALUES
(1, 'Adult', '150.00', '200.00', '200.00', '200.00', '250.00', '250.00'),
(2, 'Kids', '100.00', '150.00', '150.00', '150.00', '180.00', '180.00');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `ReservationID` int(11) NOT NULL AUTO_INCREMENT,
  `GuestID` int(11) DEFAULT NULL,
  `CheckInDate` date DEFAULT NULL,
  `eCheckin` datetime DEFAULT NULL,
  `CheckOutDate` datetime DEFAULT NULL,
  `finalCheckout` datetime DEFAULT NULL,
  `NumAdults` int(11) DEFAULT NULL,
  `NumChildren` int(11) DEFAULT NULL,
  `NumSeniors` int(11) DEFAULT NULL,
  `NumExcessPax` int(11) DEFAULT NULL,
  `timapackage` varchar(50) DEFAULT NULL,
  `package` varchar(20) DEFAULT NULL,
  `Eventplace` varchar(50) DEFAULT 'None',
  `TotalPrice` decimal(10,2) DEFAULT NULL,
  `Downpayment` decimal(10,2) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `ReservationStatus` varchar(50) DEFAULT 'BOOKED',
  PRIMARY KEY (`ReservationID`),
  KEY `GuestID` (`GuestID`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
CREATE TABLE IF NOT EXISTS `rooms` (
  `RoomID` int(11) NOT NULL AUTO_INCREMENT,
  `RoomNum` int(11) DEFAULT NULL,
  `RoomType` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`RoomID`)
) ENGINE=MyISAM AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`RoomID`, `RoomNum`, `RoomType`) VALUES
(100, 1, 'Superior Room'),
(104, 5, 'Standard Room'),
(108, 9, 'Family Room'),
(112, 13, 'Barkada Room');

-- --------------------------------------------------------

--
-- Table structure for table `roomsreservation`
--

DROP TABLE IF EXISTS `roomsreservation`;
CREATE TABLE IF NOT EXISTS `roomsreservation` (
  `RR_ID` int(11) NOT NULL AUTO_INCREMENT,
  `greservationID` int(11) NOT NULL,
  `Room_num` int(11) NOT NULL,
  PRIMARY KEY (`RR_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `roomtypes`
--

DROP TABLE IF EXISTS `roomtypes`;
CREATE TABLE IF NOT EXISTS `roomtypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `RoomType` varchar(50) NOT NULL,
  `DayTimePrice` decimal(10,2) DEFAULT NULL,
  `NightTimePrice` decimal(10,2) DEFAULT NULL,
  `Hours22` decimal(10,2) DEFAULT NULL,
  `MinPeople` int(11) NOT NULL,
  `MaxPeople` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roomtypes`
--

INSERT INTO `roomtypes` (`id`, `RoomType`, `DayTimePrice`, `NightTimePrice`, `Hours22`, `MinPeople`, `MaxPeople`) VALUES
(1, 'Superior Room', '2000.00', '3000.00', '5000.00', 2, 3),
(2, 'Standard Room', '2500.00', '3500.00', '5000.00', 2, 4),
(3, 'Family Room', '5000.00', '6500.00', '10000.00', 4, 6),
(4, 'Barkada Room', '8000.00', '9000.00', '15000.00', 15, 20);

-- --------------------------------------------------------

--
-- Table structure for table `userscredentials`
--

DROP TABLE IF EXISTS `userscredentials`;
CREATE TABLE IF NOT EXISTS `userscredentials` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `MiddleName` varchar(50) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `PostalCode` varchar(15) DEFAULT NULL,
  `Country` varchar(50) DEFAULT NULL,
  `PhoneNumber` varchar(20) DEFAULT NULL,
  `Access` varchar(10) NOT NULL DEFAULT 'CLIENT',
  PRIMARY KEY (`userID`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
