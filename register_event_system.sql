SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `register_event_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admins`
--

DROP TABLE IF EXISTS `Admins`;
CREATE TABLE IF NOT EXISTS `Admins` (
  `AdminID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  PRIMARY KEY (`AdminID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Admins`
--

INSERT INTO `Admins` (`AdminID`, `Username`, `Password`) VALUES
(1, 'admin', '$2y$10$3f8x9z2y7w6v5u4t3r2q1p0o9i8u7y6t5r4e3w2q1z0x9c8v7b6n5m');

-- --------------------------------------------------------

--
-- Table structure for table `Categories`
--

DROP TABLE IF EXISTS `Categories`;
CREATE TABLE IF NOT EXISTS `Categories` (
  `CategoryID` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(255) NOT NULL,
  PRIMARY KEY (`CategoryID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Categories`
--

INSERT INTO `Categories` (`CategoryID`, `CategoryName`) VALUES
(1, 'Student Events'),
(2, 'Practical Workshops'),
(3, 'Sports Activities'),
(4, 'Cultural Outings');

-- --------------------------------------------------------

--
-- Table structure for table `Events`
--

DROP TABLE IF EXISTS `Events`;
CREATE TABLE IF NOT EXISTS `Events` (
  `EventID` int(11) NOT NULL AUTO_INCREMENT,
  `EventName` varchar(255) NOT NULL,
  `Date` date NOT NULL,
  `Location` varchar(255) DEFAULT NULL,
  `LocationID` int(11) DEFAULT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  PRIMARY KEY (`EventID`),
  KEY `LocationID` (`LocationID`),
  KEY `CategoryID` (`CategoryID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Events`
--

INSERT INTO `Events` (`EventID`, `EventName`, `Date`, `Location`, `LocationID`, `CategoryID`, `Description`) VALUES
(1, 'Atelier de Technologie', '2025-05-10', 'Auditorium Principal', 1, 1, 'Un atelier pratique sur les dernières tendances en technologie.'),
(2, 'Séminaire sur l\'entrepreneuriat', '2025-06-15', 'Salle 101', 2, 2, 'Un séminaire sur la gestion des affaires et l\'entrepreneuriat.'),
(3, 'Conférence Santé', '2025-07-20', 'En Ligne', 3, 3, 'Une conférence sur la santé et le bien-être.'),
(4, 'Webinaire Marketing Digital', '2025-08-01', 'En Ligne', 3, 4, 'Un webinaire sur les stratégies de marketing digital.');

-- --------------------------------------------------------

--
-- Table structure for table `Locations`
--

DROP TABLE IF EXISTS `Locations`;
CREATE TABLE IF NOT EXISTS `Locations` (
  `LocationID` int(11) NOT NULL AUTO_INCREMENT,
  `LocationName` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  PRIMARY KEY (`LocationID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Locations`
--

INSERT INTO `Locations` (`LocationID`, `LocationName`, `Address`) VALUES
(1, 'Auditorium Principal', 'Rue 1, Alger'),
(2, 'Salle 101', 'Rue 2, Alger'),
(3, 'En Ligne', 'N/A');

-- --------------------------------------------------------

--
-- Table structure for table `Registrations`
--

DROP TABLE IF EXISTS `Registrations`;
CREATE TABLE IF NOT EXISTS `Registrations` (
  `RegistrationID` int(11) NOT NULL AUTO_INCREMENT,
  `EventID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  PRIMARY KEY (`RegistrationID`),
  KEY `idx_eventid` (`EventID`),
  KEY `idx_userid` (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Registrations`
--

INSERT INTO `Registrations` (`RegistrationID`, `EventID`, `UserID`) VALUES
(1, 1, 2),
(2, 1, 3),
(3, 2, 4),
(4, 3, 2),
(5, 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
CREATE TABLE IF NOT EXISTS `Users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`UserID`, `Username`, `Password`, `Phone`, `Email`) VALUES
(1, 'admin', '$2y$10$1x2y3z4w5v6u7t8s9r0q1p2o3i4u5y6t7r8e9w0q1z2x3c4v5b6n7m', '0555123456', 'admin@events.dz'),
(2, 'youssef', '$2y$10$2a3b4c5d6e7f8g9h0i1j2k3l4m5n6o7p8q9r0s1t2u3v4w5x6y7z8', '0776543210', 'youssef@example.dz'),
(3, 'sarah', '$2y$10$3c4d5e6f7g8h9i0j1k2l3m4n5o6p7q8r9s0t1u2v3w4x5y6z7a8b9', '0665432109', 'sarah@example.dz'),
(4, 'amine', '$2y$10$4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1v2w3x4y5z6a7b8c9d0', '0556987456', 'amine@example.dz');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Events`
--
ALTER TABLE `Events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`LocationID`) REFERENCES `Locations` (`LocationID`),
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`CategoryID`) REFERENCES `Categories` (`CategoryID`);

--
-- Constraints for table `Registrations`
--
ALTER TABLE `Registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`EventID`) REFERENCES `Events` (`EventID`),
  ADD CONSTRAINT `registrations_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`);
COMMIT;