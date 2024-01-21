-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 18, 2024 at 05:09 AM
-- Server version: 10.6.15-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u970357751_elijoshresort`
--

-- --------------------------------------------------------

--
-- Table structure for table `additionalhead`
--

CREATE TABLE `additionalhead` (
  `AH_ID` int(11) NOT NULL,
  `Type` varchar(50) NOT NULL,
  `Price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `additionalhead`
--

INSERT INTO `additionalhead` (`AH_ID`, `Type`, `Price`) VALUES
(1, 'Day', 250.00),
(2, 'Night', 300.00),
(3, '22Hrs', 400.00);

-- --------------------------------------------------------

--
-- Table structure for table `cottage`
--

CREATE TABLE `cottage` (
  `CottageID` int(11) NOT NULL,
  `Cottagenum` int(11) NOT NULL,
  `CottageType` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `cottagereservation` (
  `cr_id` int(11) NOT NULL,
  `reservationID` int(11) NOT NULL,
  `cottagenum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cottagereservation`
--

INSERT INTO `cottagereservation` (`cr_id`, `reservationID`, `cottagenum`) VALUES
(59, 39, 1),
(60, 39, 2),
(61, 40, 1),
(62, 40, 2),
(63, 41, 4),
(64, 42, 4),
(65, 44, 6),
(66, 45, 8),
(67, 45, 7),
(68, 46, 8),
(69, 46, 7),
(70, 47, 1),
(71, 48, 4),
(72, 50, 3),
(73, 50, 5),
(74, 51, 1),
(75, 51, 2),
(76, 51, 3),
(77, 51, 4),
(78, 52, 1),
(79, 52, 2),
(80, 52, 3),
(81, 52, 4),
(82, 52, 5),
(83, 52, 6),
(84, 52, 7),
(85, 52, 8),
(86, 53, 1),
(87, 53, 2),
(88, 53, 3),
(89, 53, 4),
(90, 54, 1),
(91, 54, 2),
(92, 54, 3),
(93, 54, 4),
(94, 54, 5),
(95, 55, 1),
(96, 56, 5),
(97, 56, 1),
(98, 56, 2),
(99, 57, 1),
(100, 57, 2),
(101, 57, 3),
(102, 57, 4),
(103, 58, 1),
(104, 59, 7),
(105, 58, 2),
(106, 61, 1),
(107, 61, 2);

-- --------------------------------------------------------

--
-- Table structure for table `cottagetypes`
--

CREATE TABLE `cottagetypes` (
  `ServiceTypeID` int(11) NOT NULL,
  `ServiceTypeName` varchar(100) DEFAULT NULL,
  `DayPrice` decimal(10,2) DEFAULT NULL,
  `NightPrice` decimal(10,2) DEFAULT NULL,
  `MinPersons` int(11) NOT NULL,
  `MaxPersons` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cottagetypes`
--

INSERT INTO `cottagetypes` (`ServiceTypeID`, `ServiceTypeName`, `DayPrice`, `NightPrice`, `MinPersons`, `MaxPersons`) VALUES
(2, 'Umbrella', 400.00, 600.00, 2, 4),
(3, 'Kubo', 1000.00, 1500.00, 8, 10),
(4, 'Gazebo', 1500.00, 2000.00, 1, 15),
(5, 'Tent', 2000.00, 2500.00, 20, 25);

-- --------------------------------------------------------

--
-- Table structure for table `eventpav`
--

CREATE TABLE `eventpav` (
  `id` int(11) NOT NULL,
  `Pavtype` varchar(50) NOT NULL,
  `MaxPax` int(11) NOT NULL,
  `MinPax` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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

CREATE TABLE `eventplace` (
  `Evntid` int(11) NOT NULL,
  `PAX` int(11) NOT NULL,
  `Pavilion` int(11) NOT NULL,
  `Grand Pavilion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `eventreservation` (
  `e_ID` int(11) NOT NULL,
  `reservationID` int(11) DEFAULT NULL,
  `eventname` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `extracharges`
--

CREATE TABLE `extracharges` (
  `ExtraID` int(11) NOT NULL,
  `ItemName` varchar(100) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `QuantityAvailable` int(11) DEFAULT NULL,
  `PackageFor` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `extracharges`
--

INSERT INTO `extracharges` (`ExtraID`, `ItemName`, `Price`, `QuantityAvailable`, `PackageFor`) VALUES
(10001, 'Towel (Big)', 1000.00, 10, 'All'),
(10002, 'Towel (Small)', 500.00, 10, 'All'),
(10003, 'Pillow', 500.00, 50, 'ROOMS'),
(10004, 'Pillow Case', 500.00, 10, 'ROOMS'),
(10005, 'Bedsheet', 1000.00, 10, ''),
(10006, 'Flat sheet', 1000.00, 10, 'ROOMS'),
(10007, 'Duvet', 1500.00, 10, 'ROOMS'),
(10008, 'Room Key', 2000.00, 10, 'ROOMS'),
(10009, 'Hair Dryer', 1500.00, 10, 'All'),
(10010, 'Electric Kettle', 1000.00, 10, 'All'),
(10011, 'Remote Control (T.V.)', 1000.00, 10, 'ROOMS'),
(10012, 'Remote Control (Aircon)', 1000.00, 10, 'ROOMS'),
(10013, 'Glass', 1000.00, 10, 'All'),
(10014, 'Cup & Saucer', 1000.00, 200, 'All'),
(10015, 'Bath Mat', 1050.00, 20, 'All'),
(10019, 'Single Bed', 500.00, 10, 'ROOMS'),
(10020, 'Queensize Bed', 800.00, 10, 'ROOMS'),
(10021, 'Hand Towel', 100.00, 10, 'All'),
(10022, 'Bath Towel', 200.00, 10, 'All'),
(10023, 'Gas & Stove', 1000.00, 10, 'All'),
(10024, 'Excess Venue Hours', 5000.00, 10, 'All'),
(10042, 'Videoke', 1000.00, 5, 'ALL');

-- --------------------------------------------------------

--
-- Table structure for table `guestextracharges`
--

CREATE TABLE `guestextracharges` (
  `ChargeID` int(11) NOT NULL,
  `ReservationID` int(11) DEFAULT NULL,
  `ChargeDescription` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `ChargeAmount` decimal(10,2) DEFAULT NULL,
  `ChargeDate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guestextracharges`
--

INSERT INTO `guestextracharges` (`ChargeID`, `ReservationID`, `ChargeDescription`, `quantity`, `ChargeAmount`, `ChargeDate`) VALUES
(42, 39, 'Additional Number of Heads', 1, 250.00, '2023-12-23'),
(43, 39, 'Towel (Big)', 1, 1000.00, '2023-12-23'),
(44, 40, 'Remote Control (Aircon)', 10, 10000.00, '2024-01-02'),
(45, 40, 'Pillow', 10, 5000.00, '2024-01-02'),
(46, 50, 'Additional Number of Heads', 2, 500.00, '2024-01-11'),
(47, 50, 'Additional Number of Heads', 1, 250.00, '2024-01-11'),
(48, 50, 'Additional Number of Heads', 1, 250.00, '2024-01-11'),
(49, 53, 'Bath Towel', 4, 800.00, '2024-01-12'),
(50, 53, 'Additional Number of Heads', 1, 250.00, '2024-01-12'),
(51, 54, 'Additional Number of Heads', 2, 600.00, '2024-01-12'),
(52, 54, 'Bath Mat', 10, 10500.00, '2024-01-12'),
(53, 56, 'Additional Number of Heads', 1, 300.00, '2024-01-13'),
(54, 56, 'Bath Towel', 3, 600.00, '2024-01-13'),
(55, 56, 'Single Bed', 1, 500.00, '2024-01-13'),
(56, 58, 'Additional Number of Heads', 1, 250.00, '2024-01-14'),
(57, 58, 'Glass', 1, 1000.00, '2024-01-14'),
(58, 58, 'Bath Towel', 1, 200.00, '2024-01-14'),
(59, 58, 'Hand Towel', 1, 100.00, '2024-01-14'),
(60, 58, 'Pillow', 1, 500.00, '2024-01-14');

-- --------------------------------------------------------

--
-- Table structure for table `guestpayments`
--

CREATE TABLE `guestpayments` (
  `PaymentID` int(11) NOT NULL,
  `ReservationID` int(11) DEFAULT NULL,
  `PaymentDate` date DEFAULT NULL,
  `AmountPaid` decimal(10,2) DEFAULT NULL,
  `PaymentMethod` varchar(50) DEFAULT NULL,
  `Description` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guestpayments`
--

INSERT INTO `guestpayments` (`PaymentID`, `ReservationID`, `PaymentDate`, `AmountPaid`, `PaymentMethod`, `Description`) VALUES
(130, 39, '2023-12-23', 600.00, 'ONLINE', 'Downpayment'),
(131, 40, '2024-01-02', 15400.00, 'PAYPAL', '3CL5120115465835P'),
(132, 41, '2024-01-03', 760.00, 'PAYPAL', '89933670EY1260413'),
(133, 42, '2024-01-04', 685.00, 'PAYPAL', '3DJ83492AF477474X'),
(134, 43, '2024-01-08', 5000.00, 'PAYPAL', '0PL770608F698644B'),
(135, 44, '2024-01-09', 1500.00, 'PAYPAL', '53Y08994LR815381R'),
(136, 45, '2024-01-09', 3850.00, 'PAYPAL', '1L507990J6961972E'),
(137, 46, '2024-01-09', 3850.00, 'PAYPAL', '6LY78378HH5178003'),
(138, 47, '2024-01-09', 7800.00, 'PAYPAL', '3UA128719R588042S'),
(139, 48, '2024-01-09', 5750.00, 'PAYPAL', '7WG364587G367583T'),
(140, 49, '2024-01-09', 2500.00, 'PAYPAL', '84H502223V146642B'),
(141, 50, '2024-01-09', 2325.00, 'PAYPAL', '0NR9254409282363G'),
(142, 51, '2024-01-10', 9150.00, 'PAYPAL', '4LE312355K6037030'),
(143, 52, '2024-01-10', 6750.00, 'PAYPAL', '3AT13983LH837853E'),
(144, 53, '2024-01-12', 2100.00, 'PAYPAL', '6GS73680CP010062S'),
(145, 53, '2024-01-12', 6650.00, 'CASH', 'CHECKOUT'),
(146, 54, '2024-01-12', 2420.00, 'PAYPAL', '6U857905M5578845C'),
(147, 54, '2024-01-12', 20520.00, 'CASH', 'CHECKOUT'),
(148, 55, '2024-01-13', 1450.00, 'PAYPAL', '6KU34424UE548542V'),
(149, 56, '2024-01-13', 6000.00, 'CASH', 'Downpayment'),
(150, 56, '2024-01-13', 8600.00, 'ECASH', 'CHECKOUT'),
(151, 57, '2024-01-14', 11600.00, 'PAYPAL', '9JT776865X503214V'),
(152, 58, '2024-01-14', 350.00, 'PAYPAL', '9PM08936X9977774S'),
(153, 59, '2024-01-14', 2180.00, 'PAYPAL', '3TW61982HB481364T'),
(154, 58, '2024-01-14', 5300.00, 'CASH', 'CHECKOUT'),
(155, 60, '2024-01-15', 1000.00, 'PAYPAL', '4EH51860TC473921X'),
(156, 61, '2024-01-15', 5400.00, 'PAYPAL', '94G64274T3953241A');

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE `guests` (
  `GuestID` int(11) NOT NULL,
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
  `JoinDate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guests`
--

INSERT INTO `guests` (`GuestID`, `FirstName`, `MiddleName`, `LastName`, `Email`, `Phone`, `Address`, `City`, `State`, `PostalCode`, `Country`, `MembershipLevel`, `JoinDate`) VALUES
(137, 'ROLLY', 'LAMPARAS', 'MIGRINO', 'rolly.migrino02@gmail.com', '09991570900', 'BLK 16 LOT 9 ACACIA HOMES', NULL, NULL, NULL, NULL, NULL, NULL),
(138, 'ROLLY', 'LAMPARAS', 'MIGRINO', 'noncre123@gmail.com', '09991570900', 'BLK 16 LOT 9 ACACIA HOMES', NULL, NULL, NULL, NULL, NULL, NULL),
(139, 'NAZARENE', 'DE VERA ', 'BALOR', 'balornazarene@gmail.com', '09978633698', 'WELLINGTON PLACE ', NULL, NULL, NULL, NULL, NULL, NULL),
(140, 'NAZARENE', 'DE VERA ', 'BALOR', 'balornazarene@gmail.com', '09978633698', 'WELLINGTON PLACE ', NULL, NULL, NULL, NULL, NULL, NULL),
(141, 'JUSTIN AYN', 'CELIS', 'ABAINZA', 'jstnabainza19@gmail.com', '09605445616', 'BLK 15, LOT 11, PINAGKAISA VILLAGE', NULL, NULL, NULL, NULL, NULL, NULL),
(142, 'ERIC YEOJ', 'HORLANDA', 'SORIANO', 'ericyeoj.soriano@cvsu.edu.ph', '09387171963', '7 MARS ST ', NULL, NULL, NULL, NULL, NULL, NULL),
(143, 'JOLLIBEE', 'ESPIRITU', 'PANGINDIAN', 'jbbypngndn07@gmail.com', '09683220957', 'SALINAS', NULL, NULL, NULL, NULL, NULL, NULL),
(144, 'JOLLIBEE', 'ESPIRITU', 'PANGINDIAN', 'jbbypngndn07@gmail.com', '09683220957', 'SALINAS', NULL, NULL, NULL, NULL, NULL, NULL),
(145, 'DIANNE', 'D', 'BUAGAS', 'princesdianne.buagas@gmail.com', '09677130950', 'ANABU ', NULL, NULL, NULL, NULL, NULL, NULL),
(146, 'DANICE', 'CUTIE', 'DELA CRUZ', 'princesdianne.buagas@cvsu.edu.ph', '09677130950', 'SOMEWHERE SA LAS PIÑAS', NULL, NULL, NULL, NULL, NULL, NULL),
(147, 'ROEL', 'BIANITO', 'BALOR', 'roelbalot@gmail.com', '09757071408', 'BLK 98 LOT 49 PHS 12A', NULL, NULL, NULL, NULL, NULL, NULL),
(148, 'VENICE', 'V', 'PANIGBATAN', 'abbypngbtn07@gmail.com', '09958669588', 'GREEN ESTATE', NULL, NULL, NULL, NULL, NULL, NULL),
(149, 'RHONA', 'LAM', 'MIGZ', 'rhonamigrino@gmail.com', '09606954955', 'BLK 16 LOT 9 ', NULL, NULL, NULL, NULL, NULL, NULL),
(150, 'JOHN DANIEL', 'STO, THOMAS', 'HERNAL ', 'jdhernal7@gmail.com', ' 639686652541', 'BLK P LOT 7', NULL, NULL, NULL, NULL, NULL, NULL),
(151, 'JAMES', 'LAZARO', 'LAZARO', 'ferriseris1234@gmail.com', '09991570900', 'BLK 16 LOT 9 ACACIA HOMES', NULL, NULL, NULL, NULL, NULL, NULL),
(152, 'Rue Lee', 'Renkaku', 'Smigth', 'ruelee01@gmail.com', '09999999999', 'Blk 99 Lot 5 Brgy. Sinukuan', NULL, NULL, NULL, NULL, NULL, NULL),
(153, 'RAFLESIO', 'DELA CRUZ', 'KURDAPYO', 'raflesio@gmail.com', '09999324566', 'BLK 16 LOT 20', NULL, NULL, NULL, NULL, NULL, NULL),
(154, 'JENELYN', 'MARSUPIO', 'MENDEZ', 'jenelyn@gmail.com', '09686234567', 'BLK 16 LOT 9 ACACIA HOMES', NULL, NULL, NULL, NULL, NULL, NULL),
(155, 'NAZARENE', 'DE VERA ', 'BALOR', 'balornazarene@gmail.com', '09978633698', 'WELLINGTON PLACE ', NULL, NULL, NULL, NULL, NULL, NULL),
(156, 'NAZARENE', 'DE VERA ', 'BALOR', 'balornazarene@gmail.com', '09978633698', 'WELLINGTON PLACE ', NULL, NULL, NULL, NULL, NULL, NULL),
(157, 'NAZARENE', 'DE VERA ', 'BALOR', 'balornazarene@gmail.com', '09978633698', 'WELLINGTON PLACE ', NULL, NULL, NULL, NULL, NULL, NULL),
(158, 'NAZARENE', 'DE VERA ', 'BALOR', 'balornazarene@gmail.com', '09978633698', 'WELLINGTON PLACE ', NULL, NULL, NULL, NULL, NULL, NULL),
(159, 'NAZARENE', 'DE VERA ', 'BALOR', 'balornazarene@gmail.com', '09978633698', 'WELLINGTON PLACE ', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `poolrate`
--

CREATE TABLE `poolrate` (
  `RateID` int(11) NOT NULL,
  `Type` varchar(10) DEFAULT NULL,
  `WeekdaysDayPrice` decimal(10,2) DEFAULT NULL,
  `WeekdaysNightPrice` decimal(10,2) DEFAULT NULL,
  `Weekdays22HrsPrice` decimal(10,2) NOT NULL,
  `WeekendsHolidaysDayPrice` decimal(10,2) DEFAULT NULL,
  `WeekendsHolidaysNightPrice` decimal(10,2) DEFAULT NULL,
  `WeekendsHolidays22HrsPrice` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `poolrate`
--

INSERT INTO `poolrate` (`RateID`, `Type`, `WeekdaysDayPrice`, `WeekdaysNightPrice`, `Weekdays22HrsPrice`, `WeekendsHolidaysDayPrice`, `WeekendsHolidaysNightPrice`, `WeekendsHolidays22HrsPrice`) VALUES
(1, 'Adult', 150.00, 200.00, 200.00, 200.00, 250.00, 250.00),
(2, 'Kids', 100.00, 150.00, 150.00, 150.00, 180.00, 180.00);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `ReservationID` int(11) NOT NULL,
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
  `ReservationStatus` varchar(50) DEFAULT 'BOOKED'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`ReservationID`, `GuestID`, `CheckInDate`, `eCheckin`, `CheckOutDate`, `finalCheckout`, `NumAdults`, `NumChildren`, `NumSeniors`, `NumExcessPax`, `timapackage`, `package`, `Eventplace`, `TotalPrice`, `Downpayment`, `UserID`, `ReservationStatus`) VALUES
(39, 137, '2023-12-23', '2023-12-23 10:42:00', '2023-12-23 17:00:00', NULL, 2, 0, 0, 0, 'Day', 'Package1', 'None', 1200.00, 600.00, NULL, 'CHECKIN'),
(40, 138, '2024-01-04', '2024-01-04 09:19:00', '2024-01-06 17:00:00', NULL, 4, 2, 0, 0, 'Day', 'Package2', 'None', 30800.00, 15400.00, 33, 'CANCELLED'),
(41, 139, '2024-01-10', '2024-01-10 10:02:00', '2024-01-10 17:00:00', NULL, 2, 1, 1, 0, 'Day', 'Package1', 'None', 1520.00, 760.00, 32, 'CANCELLED'),
(42, 140, '2024-01-04', '2024-01-04 13:37:00', '2024-01-04 17:00:00', NULL, 1, 1, 1, 0, 'Day', 'Package1', 'None', 1370.00, 685.00, 32, 'CANCELLED'),
(43, 141, '2024-01-09', '2024-01-09 12:36:00', '2024-01-11 12:00:00', NULL, 2, 0, 0, 0, '22Hrs', 'Package2', 'None', 10000.00, 5000.00, 34, 'BOOKED'),
(44, 142, '2024-01-09', '2024-01-09 20:44:00', '2024-01-09 17:00:00', NULL, 10, 0, 0, 0, 'Day', 'Package1', 'None', 3000.00, 1500.00, 35, 'BOOKED'),
(45, 143, '2024-01-10', '2024-01-10 21:00:00', '2024-01-10 17:00:00', NULL, 10, 10, 10, 0, 'Day', 'Package1', 'None', 7700.00, 3850.00, 36, 'BOOKED'),
(46, 144, '2024-01-10', '2024-01-10 21:00:00', '2024-01-10 17:00:00', NULL, 10, 10, 10, 0, 'Day', 'Package1', 'None', 7700.00, 3850.00, 36, 'BOOKED'),
(47, 145, '2024-01-31', '2024-01-31 10:00:00', '2024-02-01 12:00:00', NULL, 4, 3, 0, 0, '22Hrs', 'Package2', 'None', 15600.00, 7800.00, 37, 'BOOKED'),
(48, 146, '2024-01-31', '2024-01-31 13:30:00', '2024-02-01 12:00:00', NULL, 5, 0, 0, 0, '22Hrs', 'Package2', 'None', 11500.00, 5750.00, 38, 'BOOKED'),
(49, 147, '2024-01-17', '2024-01-17 22:22:00', '2024-01-17 17:00:00', NULL, 5, 1, 0, 0, 'Day', 'Package2', 'None', 5000.00, 2500.00, 39, 'BOOKED'),
(50, 148, '2024-01-11', '2024-01-11 01:10:00', '2024-01-11 17:00:00', NULL, 13, 2, 0, 4, 'Day', 'Package1', 'None', 4650.00, 2325.00, 40, 'CHECKIN'),
(51, 149, '2024-08-21', '2024-08-21 15:15:00', '2024-08-21 17:00:00', NULL, 2, 4, 1, 0, 'Day', 'Package2', 'None', 18300.00, 9150.00, 41, 'BOOKED'),
(52, 150, '2024-01-30', '2024-01-30 12:27:00', '2024-01-30 17:00:00', NULL, 10, 10, 10, 0, 'Day', 'Package1', 'None', 13500.00, 6750.00, 44, 'BOOKED'),
(53, 151, '2024-01-12', '2024-01-12 09:43:00', '2024-01-12 17:00:00', '2024-01-12 01:55:22', 12, 0, 0, 1, 'Day', 'Package1', 'None', 7700.00, 2100.00, 46, 'CHECKOUT'),
(54, 152, '2024-01-12', '2024-01-12 19:02:00', '2024-01-13 07:00:00', '2024-01-12 11:20:01', 4, 3, 3, 2, 'Night', 'Package1', 'None', 11840.00, 2420.00, 29, 'CHECKOUT'),
(55, 153, '2024-02-14', '2024-02-14 08:45:00', '2024-02-14 17:00:00', NULL, 2, 0, 0, 0, 'Day', 'Package2', 'None', 2900.00, 1450.00, 49, 'BOOKED'),
(56, 154, '2024-01-13', '2024-01-13 17:57:00', '2024-01-14 07:00:00', '2024-01-13 10:07:48', 6, 2, 1, 1, 'Night', 'Package2', 'None', 13200.00, 6000.00, NULL, 'CHECKOUT'),
(57, 155, '2024-01-14', '2024-01-14 11:21:00', '2024-01-16 07:00:00', NULL, 1, 0, 0, 0, 'Night', 'Package2', 'None', 23200.00, 11600.00, 32, 'CANCELLED'),
(58, 156, '2024-01-14', '2024-01-14 12:50:00', '2024-01-14 17:00:00', '2024-01-14 03:57:38', 2, 0, 0, 1, 'Day', 'Package1', 'None', 3600.00, 350.00, 32, 'CHECKOUT'),
(59, 157, '2024-01-14', '2024-01-14 11:48:00', '2024-01-14 17:00:00', NULL, 10, 5, 3, 0, 'Day', 'Package1', 'None', 4360.00, 2180.00, 32, 'CANCELLED'),
(60, 158, '2024-01-16', '2024-01-16 16:37:00', '2024-01-16 17:00:00', NULL, 2, 0, 0, 0, 'Day', 'Package2', 'None', 2000.00, 1000.00, 32, 'BOOKED'),
(61, 159, '2024-01-19', '2024-01-19 09:37:00', '2024-01-19 17:00:00', NULL, 5, 2, 1, 0, 'Day', 'Package2', 'None', 10800.00, 5400.00, 32, 'BOOKED');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `RoomID` int(11) NOT NULL,
  `RoomNum` int(11) DEFAULT NULL,
  `RoomType` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`RoomID`, `RoomNum`, `RoomType`) VALUES
(101, 2, 'Superior Room'),
(104, 5, 'Standard Room'),
(108, 9, 'Family Room'),
(112, 13, 'Barkada Room'),
(100, 1, 'Superior Room'),
(102, 3, 'Superior Room'),
(103, 4, 'Superior Room'),
(105, 6, 'Standard Room'),
(106, 7, 'Standard Room'),
(107, 8, 'Standard Room'),
(109, 10, 'Family Room'),
(110, 11, 'Family Room'),
(111, 12, 'Family Room'),
(113, 14, 'Barkada Room'),
(114, 15, 'Barkada Room'),
(115, 16, 'Barkada Room');

-- --------------------------------------------------------

--
-- Table structure for table `roomsreservation`
--

CREATE TABLE `roomsreservation` (
  `RR_ID` int(11) NOT NULL,
  `greservationID` int(11) NOT NULL,
  `Room_num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roomsreservation`
--

INSERT INTO `roomsreservation` (`RR_ID`, `greservationID`, `Room_num`) VALUES
(14, 40, 1),
(15, 40, 5),
(16, 43, 5),
(17, 47, 13),
(18, 48, 9),
(19, 49, 9),
(20, 51, 5),
(21, 51, 9),
(22, 51, 13),
(23, 53, 5),
(24, 54, 5),
(25, 55, 5),
(26, 56, 5),
(27, 56, 9),
(28, 57, 5),
(29, 57, 9),
(30, 57, 13),
(31, 58, 5),
(32, 60, 2),
(33, 61, 2),
(34, 61, 15);

-- --------------------------------------------------------

--
-- Table structure for table `roomtypes`
--

CREATE TABLE `roomtypes` (
  `id` int(11) NOT NULL,
  `RoomType` varchar(50) NOT NULL,
  `DayTimePrice` decimal(10,2) DEFAULT NULL,
  `NightTimePrice` decimal(10,2) DEFAULT NULL,
  `Hours22` decimal(10,2) DEFAULT NULL,
  `MinPeople` int(11) NOT NULL,
  `MaxPeople` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roomtypes`
--

INSERT INTO `roomtypes` (`id`, `RoomType`, `DayTimePrice`, `NightTimePrice`, `Hours22`, `MinPeople`, `MaxPeople`) VALUES
(1, 'Superior Room', 2000.00, 3000.00, 5000.00, 2, 3),
(2, 'Standard Room', 2500.00, 3500.00, 5000.00, 2, 4),
(3, 'Family Room', 5000.00, 6500.00, 10000.00, 4, 6),
(4, 'Barkada Room', 8000.00, 9000.00, 15000.00, 15, 20);

-- --------------------------------------------------------

--
-- Table structure for table `userscredentials`
--

CREATE TABLE `userscredentials` (
  `userID` int(11) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `MiddleName` varchar(50) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `PostalCode` varchar(15) DEFAULT NULL,
  `Country` varchar(50) DEFAULT NULL,
  `PhoneNumber` varchar(20) DEFAULT NULL,
  `Access` varchar(10) NOT NULL DEFAULT 'CLIENT'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userscredentials`
--

INSERT INTO `userscredentials` (`userID`, `Password`, `Email`, `FirstName`, `LastName`, `MiddleName`, `Gender`, `DateOfBirth`, `Address`, `City`, `PostalCode`, `Country`, `PhoneNumber`, `Access`) VALUES
(29, '0e7517141fb53f21ee439b355b5a1d0a', 'ruelee01@gmail.com', 'Rue Lee', 'Smigth', 'Renkaku', NULL, '2023-12-01', 'Blk 99 Lot 5 Brgy. Sinukuan', 'CITY OF DASMARIÑAS', '4114', 'PH', '09999999999', 'ADMIN'),
(35, '30bad471c8db56d0ab2cb266c58c8943', 'ericyeoj.soriano@cvsu.edu.ph', 'ERIC YEOJ', 'SORIANO', 'HORLANDA', NULL, NULL, '7 MARS ST ', 'BACOOR CITY, CAVITE', NULL, 'PH', '09387171963', 'CLIENT'),
(34, '61b558ed9dad8a97ed48ed6f97fffbdc', 'jstnabainza19@gmail.com', 'JUSTIN AYN', 'ABAINZA', 'CELIS', NULL, NULL, 'BLK 15, LOT 11, PINAGKAISA VILLAGE', 'KAWIT, CAVITE', NULL, 'PH', '09605445616', 'CLIENT'),
(32, '779a03bbfc452307267294142009f88e', 'balornazarene@gmail.com', 'NAZARENE', 'BALOR', 'DE VERA ', NULL, NULL, 'WELLINGTON PLACE ', 'GENERAL TRIAS, CAVITE', NULL, 'PH', '09978633698', 'CLIENT'),
(33, '8db530de196531de90a6b2320e55af20', 'noncre123@gmail.com', 'ROLLY', 'MIGRINO', 'LAMPARAS', NULL, NULL, 'BLK 16 LOT 9 ACACIA HOMES', 'CITY OF DASMARIÑAS, CAVITE', NULL, 'PH', '09991570900', 'CLIENT'),
(36, 'c86880beffa7ad172abd52559c90e4ff', 'jbbypngndn07@gmail.com', 'JOLLIBEE', 'PANGINDIAN', 'ESPIRITU', NULL, NULL, 'SALINAS', 'BACOOR CITY, CAVITE', NULL, 'PH', '09683220957', 'CLIENT'),
(37, 'd2701327fb994c9c7c2caed5afc3a935', 'princesdianne.buagas@gmail.com', 'DIANNE', 'BUAGAS', 'D', NULL, NULL, 'ANABU ', 'IMUS CITY, CAVITE', NULL, 'PH', '09677130950', 'CLIENT'),
(38, '50ed2f134db3c8fb6bb8de69f53995e1', 'princesdianne.buagas@cvsu.edu.ph', 'DANICE', 'DELA CRUZ', 'CUTIE', NULL, NULL, 'SOMEWHERE SA LAS PIÑAS', 'IMUS CITY, CAVITE', NULL, 'PH', '09677130950', 'CLIENT'),
(39, 'ab16093b672d19f777e17e61c54f0dd5', 'roelbalot@gmail.com', 'ROEL', 'BALOR', 'BIANITO', NULL, NULL, 'BLK 98 LOT 49 PHS 12A', 'GENERAL TRIAS CITY, CAVITE', NULL, 'PH', '09757071408', 'CLIENT'),
(40, '3f5a2b0bbcaf9443cb1cc1d5b8e415c6', 'abbypngbtn07@gmail.com', 'VENICE', 'PANIGBATAN', 'V', NULL, NULL, 'GREEN ESTATE', 'IMUS CITY, CAVITE', NULL, 'PH', '09958669588', 'CLIENT'),
(41, 'df26fb80d3b0d57bdf88e957f167ccc1', 'rhonamigrino@gmail.com', 'RHONA', 'MIGZ', 'LAM', NULL, NULL, 'BLK 16 LOT 9 ', 'BATO, CAMARINES SUR', NULL, 'PH', '09606954955', 'CLIENT'),
(42, '15f8e173b09ede503fd9050c30828ee4', 'kennethquirao7@gmail.com', 'SITAW', 'OREO', 'LOVES', NULL, NULL, 'HEHEH HEHEHE HXHEHEHHSHEHE ', 'GUIPOS, ZAMBUANGA DEL SUR', NULL, 'PH', '09563283199', 'CLIENT'),
(43, '25ef8dfac12a55d732a7a8d1b2ae90a9', 'ellethecattu@gmail.com', 'ELLE', 'ELLE', 'HEHE', NULL, NULL, 'BLK 16 LOT 26 BAUTISTA PROP', 'BAROTAC VIEJO, ILOILO', NULL, 'PH', '09084647512', 'CLIENT'),
(44, '24af0a21e492f7baed1b3c236573e695', 'jdhernal7@gmail.com', 'JOHN DANIEL', 'HERNAL ', 'STO, THOMAS', NULL, NULL, 'BLK P LOT 7', 'CITY OF LAS PIÑAS, NATIONAL CAPITAL REGION - FOURTH DISTRICT', NULL, 'PH', ' 639686652541', 'CLIENT'),
(45, '8db530de196531de90a6b2320e55af20', 'rolly.migrino@cvsu.edu.ph', 'ROLLY', 'MIGRINO', 'LAMPARAS', NULL, NULL, 'BLK 16 LOT 9 ACACIA HOMES', 'DASMARIÑAS CITY, CAVITE', NULL, 'PH', '09991570900', 'CLIENT'),
(46, '8db530de196531de90a6b2320e55af20', 'ferriseris1234@gmail.com', 'JAMES', 'LAZARO', 'LAZARO', NULL, NULL, 'BLK 16 LOT 9 ACACIA HOMES', 'GENERAL TRIAS CITY, CAVITE', NULL, 'PH', '09991570900', 'CLIENT'),
(47, '8db530de196531de90a6b2320e55af20', 'rolly.migrino02@gmail.com', 'MICHELINE', 'TRIKIO', 'GRANGOSA', NULL, NULL, 'BLK 99 LOT 77', 'SILANG, CAVITE', NULL, 'PH', '09999999999', 'CLIENT'),
(48, '8db530de196531de90a6b2320e55af20', 'tyler.gravador12@gmail.com', 'TYLER', 'GRAVADOR', 'EEIF', NULL, NULL, 'BLK 16 LOT 16', 'IMUS CITY, CAVITE', NULL, 'PH', '09999999999', 'CLIENT'),
(49, '0e7517141fb53f21ee439b355b5a1d0a', 'raflesio@gmail.com', 'RAFLESIO', 'KURDAPYO', 'DELA CRUZ', NULL, NULL, 'BLK 16 LOT 20', 'DASMARIÑAS CITY, CAVITE', NULL, 'PH', '09999324566', 'CLIENT'),
(50, '8db530de196531de90a6b2320e55af20', 'DANAIH@gmail.com', 'DANAIH', 'DANAIH', 'DANAIH', NULL, NULL, 'BLK 16 LOT 9 ACACIA HOMES', 'SILANG, CAVITE', NULL, 'PH', '09999999999', 'CLIENT'),
(51, '779a03bbfc452307267294142009f88e', 'michelleanne.fernandez@gmail.com', 'MICHELLE ANNE', 'FERNANDEZ', 'VERANMOUSAMANA', NULL, NULL, 'SILANGIT', 'SILANG, CAVITE', NULL, 'PH', '09605445616', 'STAFF'),
(52, '779a03bbfc452307267294142009f88e', 'angelicajames.flameno@gmail.com', 'ANGELICA JAMES', 'FLAMEÑO', 'VERS', NULL, NULL, 'SILANGIT', 'SILANG, CAVITE', NULL, 'PH', '09605445616', 'STAFF');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additionalhead`
--
ALTER TABLE `additionalhead`
  ADD PRIMARY KEY (`AH_ID`);

--
-- Indexes for table `cottage`
--
ALTER TABLE `cottage`
  ADD PRIMARY KEY (`CottageID`);

--
-- Indexes for table `cottagereservation`
--
ALTER TABLE `cottagereservation`
  ADD PRIMARY KEY (`cr_id`);

--
-- Indexes for table `cottagetypes`
--
ALTER TABLE `cottagetypes`
  ADD PRIMARY KEY (`ServiceTypeID`);

--
-- Indexes for table `eventpav`
--
ALTER TABLE `eventpav`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eventplace`
--
ALTER TABLE `eventplace`
  ADD PRIMARY KEY (`Evntid`);

--
-- Indexes for table `eventreservation`
--
ALTER TABLE `eventreservation`
  ADD PRIMARY KEY (`e_ID`);

--
-- Indexes for table `extracharges`
--
ALTER TABLE `extracharges`
  ADD PRIMARY KEY (`ExtraID`);

--
-- Indexes for table `guestextracharges`
--
ALTER TABLE `guestextracharges`
  ADD PRIMARY KEY (`ChargeID`);

--
-- Indexes for table `guestpayments`
--
ALTER TABLE `guestpayments`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `ReservationID` (`ReservationID`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`GuestID`);

--
-- Indexes for table `poolrate`
--
ALTER TABLE `poolrate`
  ADD PRIMARY KEY (`RateID`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`ReservationID`),
  ADD KEY `GuestID` (`GuestID`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`RoomID`);

--
-- Indexes for table `roomsreservation`
--
ALTER TABLE `roomsreservation`
  ADD PRIMARY KEY (`RR_ID`);

--
-- Indexes for table `roomtypes`
--
ALTER TABLE `roomtypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userscredentials`
--
ALTER TABLE `userscredentials`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additionalhead`
--
ALTER TABLE `additionalhead`
  MODIFY `AH_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cottage`
--
ALTER TABLE `cottage`
  MODIFY `CottageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;

--
-- AUTO_INCREMENT for table `cottagereservation`
--
ALTER TABLE `cottagereservation`
  MODIFY `cr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `cottagetypes`
--
ALTER TABLE `cottagetypes`
  MODIFY `ServiceTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `eventpav`
--
ALTER TABLE `eventpav`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `eventplace`
--
ALTER TABLE `eventplace`
  MODIFY `Evntid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `eventreservation`
--
ALTER TABLE `eventreservation`
  MODIFY `e_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `extracharges`
--
ALTER TABLE `extracharges`
  MODIFY `ExtraID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10043;

--
-- AUTO_INCREMENT for table `guestextracharges`
--
ALTER TABLE `guestextracharges`
  MODIFY `ChargeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `guestpayments`
--
ALTER TABLE `guestpayments`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `GuestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT for table `poolrate`
--
ALTER TABLE `poolrate`
  MODIFY `RateID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `ReservationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `RoomID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `roomsreservation`
--
ALTER TABLE `roomsreservation`
  MODIFY `RR_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `roomtypes`
--
ALTER TABLE `roomtypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `userscredentials`
--
ALTER TABLE `userscredentials`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
