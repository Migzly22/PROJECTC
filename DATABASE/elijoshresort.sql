-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 14, 2023 at 10:42 PM
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
-- Database: `elijoshresort`
--

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
) ENGINE=MyISAM AUTO_INCREMENT=10037 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `extracharges`
--

INSERT INTO `extracharges` (`ExtraID`, `ItemName`, `Price`, `QuantityAvailable`, `PackageFor`) VALUES
(10001, 'Towel (Big)', '1000.00', 10, 'All'),
(10002, 'Towel (Small)', '500.00', 10, 'All'),
(10003, 'Pillow', '500.00', 10, 'ROOMS'),
(10004, 'Pillow Case', '500.00', 10, 'ROOMS'),
(10005, 'Bedsheet', '1000.00', 10, 'ROOMS'),
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
(10016, 'Refrigerator', NULL, NULL, 'ROOMS'),
(10017, 'Water Dispenser', NULL, NULL, 'ROOMS'),
(10018, 'Television', NULL, NULL, 'ROOMS'),
(10019, 'Single Bed', '500.00', 10, 'ROOMS'),
(10020, 'Queensize Bed', '800.00', 10, 'ROOMS'),
(10021, 'Hand Towel', '100.00', 10, 'All'),
(10022, 'Bath Towel', '200.00', 10, 'All'),
(10023, 'Gas & Stove', '1000.00', 10, 'All'),
(10024, 'Excess Venue Hours', '5000.00', 10, 'All'),
(10025, 'Corkage Fee', '5000.00', NULL, 'VENUE'),
(10026, 'Electricity for Sounds and Light', '5000.00', NULL, 'VENUE'),
(10027, 'Venue Additional Guest', '500.00', NULL, 'VENUE');

-- --------------------------------------------------------

--
-- Table structure for table `greservations`
--

DROP TABLE IF EXISTS `greservations`;
CREATE TABLE IF NOT EXISTS `greservations` (
  `ReservationID` int(11) NOT NULL AUTO_INCREMENT,
  `GuestID` int(11) DEFAULT NULL,
  `CheckInDate` datetime DEFAULT NULL,
  `CheckOutDate` datetime DEFAULT NULL,
  `NumAdults` int(11) DEFAULT NULL,
  `NumChildren` int(11) DEFAULT NULL,
  `NumSeniors` int(11) DEFAULT NULL,
  `NumCottage` int(11) DEFAULT NULL,
  `CottageType` varchar(50) DEFAULT NULL,
  `Entertainment` varchar(50) DEFAULT NULL,
  `Stay` varchar(50) DEFAULT NULL,
  `DaysofWeek` varchar(50) DEFAULT NULL,
  `Venue` varchar(50) DEFAULT NULL,
  `TotalPrice` decimal(10,2) DEFAULT NULL,
  `Downpayment` decimal(10,2) DEFAULT NULL,
  `RoomID` int(11) DEFAULT NULL,
  `ReservationStatus` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ReservationID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `greservations`
--

INSERT INTO `greservations` (`ReservationID`, `GuestID`, `CheckInDate`, `CheckOutDate`, `NumAdults`, `NumChildren`, `NumSeniors`, `NumCottage`, `CottageType`, `Entertainment`, `Stay`, `DaysofWeek`, `Venue`, `TotalPrice`, `Downpayment`, `RoomID`, `ReservationStatus`) VALUES
(1, NULL, '2023-10-17 07:40:41', '2023-10-17 16:40:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `guestextracharges`
--

INSERT INTO `guestextracharges` (`ChargeID`, `ReservationID`, `ChargeDescription`, `quantity`, `ChargeAmount`, `ChargeDate`) VALUES
(25, 33, 'Bath Towel', 1, '200.00', '2023-11-12'),
(24, 33, 'Additional No. of Adult', 2, '500.00', '2023-11-12'),
(21, 33, 'Additional No. of Adult', 2, '500.00', '2023-11-12'),
(22, 33, 'Additional No. of Kid', 2, '500.00', '2023-11-12'),
(23, 33, 'Additional No. of Senior', 2, '400.00', '2023-11-12'),
(30, 31, 'Pillow', 2, '1000.00', '2023-11-12'),
(29, 33, 'Bath Towel', 3, '600.00', '2023-11-12');

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
  PRIMARY KEY (`PaymentID`),
  KEY `ReservationID` (`ReservationID`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `guestpayments`
--

INSERT INTO `guestpayments` (`PaymentID`, `ReservationID`, `PaymentDate`, `AmountPaid`, `PaymentMethod`) VALUES
(22, 33, '2023-11-10', '800.00', 'CASH'),
(20, 33, '2023-11-11', '3950.00', 'CASH'),
(16, 33, '2023-11-12', '2050.00', 'CASH'),
(15, 32, '2023-09-12', '45000.00', 'ONLINE'),
(14, 31, '2023-10-12', '2150.00', 'CASH');

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

DROP TABLE IF EXISTS `guests`;
CREATE TABLE IF NOT EXISTS `guests` (
  `GuestID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(50) DEFAULT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `guests`
--

INSERT INTO `guests` (`GuestID`, `FirstName`, `LastName`, `Email`, `Phone`, `Address`, `City`, `State`, `PostalCode`, `Country`, `MembershipLevel`, `JoinDate`) VALUES
(19, 'Renzo', 'Migrino', 'BLACX@GMAIL.COM', '0999915790999', 'Blk 16 lot 9 Acacia homes', NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'Rolliard', 'Migrino', 'johndoe@example.com', '0999915790999', 'Blk 16 lot 9 Acacia homes', NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'Rolly', 'Migrino', 'noncre123@gmail.com', '0999915790999', 'Blk 16 lot 9 Acacia homes', NULL, NULL, NULL, NULL, NULL, NULL);

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
  `Weekdays22Hrs` decimal(10,2) NOT NULL,
  `WeekendsHolidaysDayPrice` decimal(10,2) DEFAULT NULL,
  `WeekendsHolidaysNightPrice` decimal(10,2) DEFAULT NULL,
  `WeekendsHolidays22Hrs` decimal(10,2) NOT NULL,
  PRIMARY KEY (`RateID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `poolrate`
--

INSERT INTO `poolrate` (`RateID`, `Type`, `WeekdaysDayPrice`, `WeekdaysNightPrice`, `Weekdays22Hrs`, `WeekendsHolidaysDayPrice`, `WeekendsHolidaysNightPrice`, `WeekendsHolidays22Hrs`) VALUES
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
  `CheckOutDate` date DEFAULT NULL,
  `RoomNumber` varchar(20) DEFAULT NULL,
  `CottageTypeID` varchar(100) DEFAULT NULL,
  `NumAdults` int(11) DEFAULT NULL,
  `NumChildren` int(11) DEFAULT NULL,
  `NumSeniors` int(11) DEFAULT NULL,
  `NumExcessPax` int(11) DEFAULT NULL,
  `timapackage` varchar(50) DEFAULT NULL,
  `Eventplace` varchar(50) DEFAULT 'None',
  `TotalPrice` decimal(10,2) DEFAULT NULL,
  `Downpayment` decimal(10,2) NOT NULL,
  `KTVRoomAccess` tinyint(1) DEFAULT NULL,
  `VideokeAccess` tinyint(1) DEFAULT NULL,
  `RoomID` int(11) DEFAULT NULL,
  `ReservationStatus` varchar(50) DEFAULT 'BOOKED',
  PRIMARY KEY (`ReservationID`),
  KEY `GuestID` (`GuestID`),
  KEY `RoomID` (`RoomID`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`ReservationID`, `GuestID`, `CheckInDate`, `CheckOutDate`, `RoomNumber`, `CottageTypeID`, `NumAdults`, `NumChildren`, `NumSeniors`, `NumExcessPax`, `timapackage`, `Eventplace`, `TotalPrice`, `Downpayment`, `KTVRoomAccess`, `VideokeAccess`, `RoomID`, `ReservationStatus`) VALUES
(31, 17, '2023-11-13', '2023-11-12', '1', 'Kubo', 5, 2, 0, 0, 'DayPrice', 'None', '4300.00', '2150.00', NULL, NULL, NULL, 'CHECKIN'),
(32, 18, '2023-11-12', '2023-11-12', '', 'None', 200, 0, 0, 0, 'DayPrice', 'Pavilion', '90000.00', '45000.00', NULL, NULL, NULL, 'CANCELLED'),
(33, 19, '2023-11-16', '2023-11-17', '1', 'Umbrella', 2, 0, 0, 0, 'NightPrice', 'None', '4100.00', '2050.00', NULL, NULL, NULL, 'CHECKOUT');

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
) ENGINE=MyISAM AUTO_INCREMENT=119 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`RoomID`, `RoomNum`, `RoomType`) VALUES
(100, 1, 'Superior Room'),
(101, 2, 'Superior Room'),
(102, 3, 'Superior Room'),
(103, 4, 'Superior Room'),
(104, 5, 'Standard Room'),
(105, 6, 'Standard Room'),
(106, 7, 'Standard Room'),
(107, 8, 'Standard Room'),
(108, 9, 'Family Room'),
(109, 10, 'Family Room'),
(110, 11, 'Family Room'),
(111, 12, 'Family Room'),
(112, 13, 'Barkada Room'),
(113, 14, 'Barkada Room'),
(114, 15, 'Barkada Room'),
(115, 16, 'Barkada Room'),
(116, 17, 'Barkada Room'),
(117, 18, 'Barkada Room'),
(118, 19, 'Standard Room');

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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roomsreservation`
--

INSERT INTO `roomsreservation` (`RR_ID`, `greservationID`, `Room_num`) VALUES
(29, 31, 1),
(30, 33, 1);

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
  `mFirstName` varchar(100) NOT NULL,
  `mMiddleName` varchar(100) NOT NULL,
  `mLastName` varchar(100) NOT NULL,
  `fFirstName` varchar(100) NOT NULL,
  `fMiddleName` varchar(100) NOT NULL,
  `fLastName` varchar(100) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `State` varchar(50) DEFAULT NULL,
  `PostalCode` varchar(15) DEFAULT NULL,
  `Country` varchar(50) DEFAULT NULL,
  `PhoneNumber` varchar(20) DEFAULT NULL,
  `Position` varchar(50) DEFAULT NULL,
  `HireDate` date DEFAULT NULL,
  `Salary` decimal(10,2) DEFAULT NULL,
  `Access` varchar(10) NOT NULL DEFAULT 'STAFF',
  PRIMARY KEY (`userID`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userscredentials`
--

INSERT INTO `userscredentials` (`userID`, `Password`, `Email`, `FirstName`, `LastName`, `MiddleName`, `Gender`, `DateOfBirth`, `mFirstName`, `mMiddleName`, `mLastName`, `fFirstName`, `fMiddleName`, `fLastName`, `Address`, `City`, `State`, `PostalCode`, `Country`, `PhoneNumber`, `Position`, `HireDate`, `Salary`, `Access`) VALUES
(1, '1234567890', 'johndoe@example.com', 'John', 'Doe', 'Michael', 'Male', '1985-04-15', '', '', '', '', '', '', '123 Main Street', 'Los Angeles', 'CA', '90001', 'United States', '555-555-5555', 'Software Engineer', '2022-01-15', '75000.00', 'ADMIN'),
(2, 'p@ssw0rd', 'janedoe@example.com', 'Jane', 'Doe', 'Elizabeth', 'Female', '1987-08-25', '', '', '', '', '', '', '456 Oak Avenue', '456 Oak Avenue', 'NY', '10001', 'United States', '555-555-5556', 'Marketing Manager', '2022-02-10', '65000.00', 'STAFF'),
(4, 'pass12341', 'sarah.miller@example.com', 'Sarah', 'Miller', 'Albeido', 'Female', '1990-06-20', '1', '1', '1', '1', '1', '1', '321 Birch Lane1', '321 Birch Lane1', 'TX1', '770011', 'United States', '555-555-5558', 'HR Specialist', '2022-04-20', '60000.00', 'STAFF'),
(5, 'strongpass', 'robert.jones@example.com', 'Robert', 'Jones', 'Lee', 'Male', '1980-03-28', '', '', '', '', '', '', '987 Willow Road', 'San Francisco', 'CA', '94101', 'United States', '555-555-5559', 'Project Manager', '2022-05-15', '80000.00', 'STAFF'),
(8, 'secure123', 'michael.smith1@example.com', 'Michael', 'Smith', 'qwe', 'Male', '1978-11-03', '', '', '', '', '', '', '789 Elm Street', 'Chicago', 'IL', '60601', 'United States', '555-555-5557', 'Financial Analyst', '2022-03-05', '70000.00', 'STAFF'),
(14, 'FErris@ELownq123', 'ferriseris12@gmail.com', 'Rolly', 'Migriño', 'Lamparas', 'Male', '2023-10-10', 'Arlyn', 'Lamparas', 'Migz', 'R', 'Bon', 'Migz', 'blk 9 lot 9', 'Cavite', 'Unknown', '4114', 'Philippines', '09999999998', NULL, '2023-10-16', NULL, 'STAFF'),
(16, 'testing123', 'noncre1234@gmail.com', 'qweqwe', 'qwewqe', 'qweqwe', 'Male', NULL, '', '', '', '', '', '', 'cavite', 'cavite', 'cavite', 'cavite', 'cavite', NULL, NULL, NULL, NULL, 'CLIENT');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
