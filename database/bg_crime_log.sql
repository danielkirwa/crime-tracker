-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 04, 2022 at 10:20 AM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bg_crime_log`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblconstituency`
--

CREATE TABLE IF NOT EXISTS `tblconstituency` (
  `constituencyID` int(12) NOT NULL AUTO_INCREMENT,
  `constituencyname` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `dateadded` date NOT NULL,
  `dateupdated` date NOT NULL,
  `status` int(1) NOT NULL,
  `countyID` int(12) NOT NULL,
  PRIMARY KEY (`constituencyID`),
  KEY `cscn` (`countyID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tblconstituency`
--

INSERT INTO `tblconstituency` (`constituencyID`, `constituencyname`, `description`, `dateadded`, `dateupdated`, `status`, `countyID`) VALUES
(1, 'Kanduyi', 'Kanduyi kibabii     	\r\n\r\n     ', '2022-07-15', '2022-07-15', 1, 1),
(2, 'Bungoma south', 'South of bungoma\r\n     ', '2022-07-16', '2022-07-16', 1, 1),
(3, 'Bungoma north', 'North of bungoma     	\r\n\r\n     ', '2022-07-16', '2022-07-16', 1, 1),
(4, 'Tongaren', 'tongaren constituency, bungoma North\r\n\r\n     ', '2022-07-26', '2022-07-26', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblcounty`
--

CREATE TABLE IF NOT EXISTS `tblcounty` (
  `countyID` int(12) NOT NULL AUTO_INCREMENT,
  `countyname` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `dateadded` date NOT NULL,
  `dateupdated` date NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`countyID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tblcounty`
--

INSERT INTO `tblcounty` (`countyID`, `countyname`, `description`, `dateadded`, `dateupdated`, `status`) VALUES
(1, 'Bungoma', 'wester region county', '2022-07-15', '2022-07-15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblcrime`
--

CREATE TABLE IF NOT EXISTS `tblcrime` (
  `crimeID` int(12) NOT NULL AUTO_INCREMENT,
  `sectionID` int(12) NOT NULL,
  `complainerID` int(12) NOT NULL,
  `description` varchar(255) NOT NULL,
  `countyID` int(12) NOT NULL,
  `constituencyID` int(12) NOT NULL,
  `wardID` int(12) NOT NULL,
  `dateofoffence` date NOT NULL,
  `timeofoffence` time NOT NULL,
  `dateadded` date NOT NULL,
  `dateupdated` date NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`crimeID`),
  KEY `crseec` (`sectionID`),
  KEY `crcan` (`countyID`),
  KEY `crcon` (`complainerID`),
  KEY `crcos` (`constituencyID`),
  KEY `ward` (`wardID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tblcrime`
--

INSERT INTO `tblcrime` (`crimeID`, `sectionID`, `complainerID`, `description`, `countyID`, `constituencyID`, `wardID`, `dateofoffence`, `timeofoffence`, `dateadded`, `dateupdated`, `status`) VALUES
(1, 1, 1, 'reporting', 1, 1, 1, '2022-07-06', '04:04:00', '2022-07-15', '2022-07-15', 1),
(3, 2, 1, ' driver give bribe', 1, 4, 4, '2022-07-28', '18:47:00', '2022-07-28', '2022-07-28', 1),
(4, 1, 1, ' Class 8 girl', 1, 4, 4, '2022-07-28', '16:06:00', '2022-07-29', '2022-07-29', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbldepartment`
--

CREATE TABLE IF NOT EXISTS `tbldepartment` (
  `departmentId` int(12) NOT NULL AUTO_INCREMENT,
  `departmentName` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `dateadded` date NOT NULL,
  `dateupdated` date NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`departmentId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbldepartment`
--

INSERT INTO `tbldepartment` (`departmentId`, `departmentName`, `description`, `dateadded`, `dateupdated`, `status`) VALUES
(1, 'CIA', 'Criminal investigation authority', '2022-07-15', '2022-07-15', 1),
(2, 'CIA', 'Criminal investigation authority', '2022-07-15', '2022-07-15', 0),
(3, 'Police', 'Police posts', '2022-07-15', '2022-07-15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblofficers`
--

CREATE TABLE IF NOT EXISTS `tblofficers` (
  `officerID` int(12) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `othername` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `officernumber` int(12) NOT NULL,
  `departmentID` int(12) NOT NULL,
  `workstationID` int(12) NOT NULL,
  `dateadded` date NOT NULL,
  `dateupdated` date NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`officerID`),
  KEY `derp` (`departmentID`),
  KEY `station` (`workstationID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tblofficers`
--

INSERT INTO `tblofficers` (`officerID`, `firstname`, `othername`, `phone`, `email`, `gender`, `officernumber`, `departmentID`, `workstationID`, `dateadded`, `dateupdated`, `status`) VALUES
(1, 'Dan', 'kirwa', '0789652341', 'kirwa@gmail.com', 'MALE', 12854698, 1, 1, '2022-07-15', '2022-07-15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblresidence`
--

CREATE TABLE IF NOT EXISTS `tblresidence` (
  `residenceID` int(12) NOT NULL AUTO_INCREMENT,
  `residenceIdNumber` varchar(12) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `othername` varchar(255) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `countyID` int(12) NOT NULL,
  `consituencyID` int(12) NOT NULL,
  `wardID` int(12) NOT NULL,
  `village` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `datecreated` date NOT NULL,
  `dateupdated` date NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`residenceID`),
  UNIQUE KEY `email` (`email`),
  KEY `wardres` (`wardID`),
  KEY `countyres` (`countyID`),
  KEY `constres` (`consituencyID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tblresidence`
--

INSERT INTO `tblresidence` (`residenceID`, `residenceIdNumber`, `firstname`, `othername`, `gender`, `phone`, `email`, `countyID`, `consituencyID`, `wardID`, `village`, `photo`, `datecreated`, `dateupdated`, `status`) VALUES
(1, '987456321', 'Dan', 'Daniel', 'MALE', '0785236541', 'kirwa@gmail.com', 1, 1, 1, 'Tutii', '0', '2022-07-15', '2022-07-15', 1),
(2, '25963', 'Adminstrator', 'Admin', 'FEMALE', '0785236941', 'admin@gmail.com', 1, 4, 4, 'Bungoma', '0', '2022-08-02', '2022-08-02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblsection`
--

CREATE TABLE IF NOT EXISTS `tblsection` (
  `sectionID` int(12) NOT NULL AUTO_INCREMENT,
  `sectionnmae` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `dateadded` date NOT NULL,
  `dateupdated` date NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`sectionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tblsection`
--

INSERT INTO `tblsection` (`sectionID`, `sectionnmae`, `description`, `dateadded`, `dateupdated`, `status`) VALUES
(1, 'Rape', 'Rape    case       	\r\n         ', '2022-07-15', '2022-07-15', 1),
(2, 'Corruption', 'Any kind of bribe given        	\r\n         ', '2022-07-26', '2022-07-26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblsuspect`
--

CREATE TABLE IF NOT EXISTS `tblsuspect` (
  `crimeID` int(12) NOT NULL,
  `suspectID` int(12) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `othername` varchar(255) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `age` int(3) NOT NULL,
  `decription` varchar(255) NOT NULL,
  `countyID` int(12) NOT NULL,
  `consituencyID` int(12) NOT NULL,
  `wardID` int(12) NOT NULL,
  `dateadded` date NOT NULL,
  `dateupdated` date NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`suspectID`),
  KEY `sucounty` (`countyID`),
  KEY `suconsti` (`consituencyID`),
  KEY `suward` (`wardID`),
  KEY `crimesuspet` (`crimeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tblsuspect`
--

INSERT INTO `tblsuspect` (`crimeID`, `suspectID`, `firstname`, `othername`, `gender`, `age`, `decription`, `countyID`, `consituencyID`, `wardID`, `dateadded`, `dateupdated`, `status`) VALUES
(1, 2, 'Ben', 'Ben', 'MALE', 45, 'Was the only one around         \r\n       ', 1, 4, 4, '2022-07-28', '2022-07-28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblsuspectcrime`
--

CREATE TABLE IF NOT EXISTS `tblsuspectcrime` (
  `suspectcrimeID` int(12) NOT NULL AUTO_INCREMENT,
  `crimeID` int(12) NOT NULL,
  `suspectID` int(12) NOT NULL,
  PRIMARY KEY (`suspectcrimeID`),
  KEY `crimesus` (`crimeID`),
  KEY `suscrime` (`suspectID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE IF NOT EXISTS `tblusers` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `privillage` varchar(255) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`username`, `password`, `privillage`) VALUES
('admin@gmail.com', '12345', 'admin'),
('kirwa@gmail.com', '1234', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `tblvictim`
--

CREATE TABLE IF NOT EXISTS `tblvictim` (
  `crimeID` int(12) NOT NULL,
  `victimID` int(12) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `othername` varchar(255) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `idnumber` int(12) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `countyid` int(12) NOT NULL,
  `constituencyid` int(12) NOT NULL,
  `wardid` int(12) NOT NULL,
  `dateadded` date NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`victimID`),
  KEY `viward` (`wardid`),
  KEY `viccounrt` (`countyid`),
  KEY `viconst` (`constituencyid`),
  KEY `crimvictime` (`crimeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tblvictim`
--

INSERT INTO `tblvictim` (`crimeID`, `victimID`, `firstname`, `othername`, `gender`, `idnumber`, `phone`, `description`, `countyid`, `constituencyid`, `wardid`, `dateadded`, `status`) VALUES
(1, 2, 'willium', 'willy', 'MALE', 12345, '0789652341', ' Was raped         \r\n        ', 1, 4, 4, '2022-07-28', 1),
(3, 3, 'alice', 'alicia', 'FEMALE', 2344, '9999955', 'coned thousands of cash money', 1, 4, 4, '2022-07-28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblvictimcrime`
--

CREATE TABLE IF NOT EXISTS `tblvictimcrime` (
  `victimecrimeID` int(12) NOT NULL AUTO_INCREMENT,
  `victimID` int(12) NOT NULL,
  `crimeID` int(12) NOT NULL,
  PRIMARY KEY (`victimecrimeID`),
  KEY `vicir` (`crimeID`),
  KEY `vicvic` (`victimID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblward`
--

CREATE TABLE IF NOT EXISTS `tblward` (
  `wardID` int(12) NOT NULL AUTO_INCREMENT,
  `wardname` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `dateadded` date NOT NULL,
  `dateupdated` date NOT NULL,
  `status` int(1) NOT NULL,
  `constituemcyID` int(12) NOT NULL,
  PRIMARY KEY (`wardID`),
  KEY `constit` (`constituemcyID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tblward`
--

INSERT INTO `tblward` (`wardID`, `wardname`, `description`, `dateadded`, `dateupdated`, `status`, `constituemcyID`) VALUES
(1, 'Tutii', 'Around kibabii      \r\n        ', '2022-07-15', '2022-07-15', 1, 1),
(2, 'Mayanja', 'Mayanja region\r\n        ', '2022-07-16', '2022-07-16', 1, 1),
(3, 'Bumula', 'Bumula in bungoma north          \r\n        ', '2022-07-16', '2022-07-16', 1, 2),
(4, 'Ndengela', 'Found in bungoma south          \r\n        ', '2022-07-16', '2022-07-16', 1, 3),
(5, 'sds', 'sdfs          \r\n        ', '2022-07-16', '2022-07-16', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblwitness`
--

CREATE TABLE IF NOT EXISTS `tblwitness` (
  `crimeID` int(12) NOT NULL,
  `witnessID` int(12) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `othername` varchar(255) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `countyid` int(12) NOT NULL,
  `constituencyid` int(12) NOT NULL,
  `wardid` int(12) NOT NULL,
  `dateadded` date NOT NULL,
  PRIMARY KEY (`witnessID`),
  KEY `wward` (`wardid`),
  KEY `wcounty` (`countyid`),
  KEY `wconst` (`constituencyid`),
  KEY `crimwtin` (`crimeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tblwitness`
--

INSERT INTO `tblwitness` (`crimeID`, `witnessID`, `firstname`, `othername`, `gender`, `phone`, `email`, `countyid`, `constituencyid`, `wardid`, `dateadded`) VALUES
(1, 2, 'Dan', 'Daniel', 'MALE', '59', 'kirwadan03@gmail.com', 1, 4, 4, '2022-07-28');

-- --------------------------------------------------------

--
-- Table structure for table `tblwitnesscrime`
--

CREATE TABLE IF NOT EXISTS `tblwitnesscrime` (
  `witnesscrime` int(12) NOT NULL AUTO_INCREMENT,
  `crimeID` int(12) NOT NULL,
  `witnessID` int(12) NOT NULL,
  PRIMARY KEY (`witnesscrime`),
  KEY `withwith` (`witnessID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblworkstation`
--

CREATE TABLE IF NOT EXISTS `tblworkstation` (
  `workstationID` int(12) NOT NULL AUTO_INCREMENT,
  `workstation` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `dateadded` date NOT NULL,
  `dateupdated` date NOT NULL,
  `departmentID` int(12) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`workstationID`),
  KEY `depwrok` (`departmentID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tblworkstation`
--

INSERT INTO `tblworkstation` (`workstationID`, `workstation`, `description`, `dateadded`, `dateupdated`, `departmentID`, `status`) VALUES
(1, 'Tutii', 'Police post      	\r\n      ', '2022-07-15', '2022-07-15', 1, 1),
(2, 'Kanduyi', 'Kanduyi police post      	\r\n      ', '2022-07-15', '2022-07-15', 3, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblconstituency`
--
ALTER TABLE `tblconstituency`
  ADD CONSTRAINT `cscn` FOREIGN KEY (`countyID`) REFERENCES `tblcounty` (`countyID`) ON UPDATE CASCADE;

--
-- Constraints for table `tblcrime`
--
ALTER TABLE `tblcrime`
  ADD CONSTRAINT `ward` FOREIGN KEY (`wardID`) REFERENCES `tblward` (`wardID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `crcan` FOREIGN KEY (`countyID`) REFERENCES `tblcounty` (`countyID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `crcon` FOREIGN KEY (`complainerID`) REFERENCES `tblresidence` (`residenceID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `crcos` FOREIGN KEY (`constituencyID`) REFERENCES `tblconstituency` (`constituencyID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `crseec` FOREIGN KEY (`sectionID`) REFERENCES `tblsection` (`sectionID`) ON UPDATE CASCADE;

--
-- Constraints for table `tblofficers`
--
ALTER TABLE `tblofficers`
  ADD CONSTRAINT `derp` FOREIGN KEY (`departmentID`) REFERENCES `tbldepartment` (`departmentId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `station` FOREIGN KEY (`workstationID`) REFERENCES `tblworkstation` (`workstationID`) ON UPDATE CASCADE;

--
-- Constraints for table `tblresidence`
--
ALTER TABLE `tblresidence`
  ADD CONSTRAINT `constres` FOREIGN KEY (`consituencyID`) REFERENCES `tblconstituency` (`constituencyID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `countyres` FOREIGN KEY (`countyID`) REFERENCES `tblcounty` (`countyID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `wardres` FOREIGN KEY (`wardID`) REFERENCES `tblward` (`wardID`) ON UPDATE CASCADE;

--
-- Constraints for table `tblsuspect`
--
ALTER TABLE `tblsuspect`
  ADD CONSTRAINT `crimesuspet` FOREIGN KEY (`crimeID`) REFERENCES `tblcrime` (`crimeID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `suconsti` FOREIGN KEY (`consituencyID`) REFERENCES `tblconstituency` (`constituencyID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `sucounty` FOREIGN KEY (`countyID`) REFERENCES `tblcounty` (`countyID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `suward` FOREIGN KEY (`wardID`) REFERENCES `tblward` (`wardID`) ON UPDATE CASCADE;

--
-- Constraints for table `tblsuspectcrime`
--
ALTER TABLE `tblsuspectcrime`
  ADD CONSTRAINT `suscrime` FOREIGN KEY (`suspectID`) REFERENCES `tblsuspect` (`suspectID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `crimesus` FOREIGN KEY (`crimeID`) REFERENCES `tblcrime` (`crimeID`) ON UPDATE CASCADE;

--
-- Constraints for table `tblvictim`
--
ALTER TABLE `tblvictim`
  ADD CONSTRAINT `crimvictime` FOREIGN KEY (`crimeID`) REFERENCES `tblcrime` (`crimeID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `viccounrt` FOREIGN KEY (`countyid`) REFERENCES `tblcounty` (`countyID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `viconst` FOREIGN KEY (`constituencyid`) REFERENCES `tblconstituency` (`constituencyID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `viward` FOREIGN KEY (`wardid`) REFERENCES `tblward` (`wardID`) ON UPDATE CASCADE;

--
-- Constraints for table `tblvictimcrime`
--
ALTER TABLE `tblvictimcrime`
  ADD CONSTRAINT `vicvic` FOREIGN KEY (`victimID`) REFERENCES `tblvictim` (`victimID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `vicir` FOREIGN KEY (`crimeID`) REFERENCES `tblcrime` (`crimeID`) ON UPDATE CASCADE;

--
-- Constraints for table `tblward`
--
ALTER TABLE `tblward`
  ADD CONSTRAINT `constit` FOREIGN KEY (`constituemcyID`) REFERENCES `tblconstituency` (`constituencyID`) ON UPDATE CASCADE;

--
-- Constraints for table `tblwitness`
--
ALTER TABLE `tblwitness`
  ADD CONSTRAINT `crimwtin` FOREIGN KEY (`crimeID`) REFERENCES `tblcrime` (`crimeID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `wconst` FOREIGN KEY (`constituencyid`) REFERENCES `tblconstituency` (`constituencyID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `wcounty` FOREIGN KEY (`countyid`) REFERENCES `tblcounty` (`countyID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `wward` FOREIGN KEY (`wardid`) REFERENCES `tblward` (`wardID`) ON UPDATE CASCADE;

--
-- Constraints for table `tblwitnesscrime`
--
ALTER TABLE `tblwitnesscrime`
  ADD CONSTRAINT `withwith` FOREIGN KEY (`witnessID`) REFERENCES `tblwitness` (`witnessID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `criwith` FOREIGN KEY (`witnessID`) REFERENCES `tblcrime` (`crimeID`) ON UPDATE CASCADE;

--
-- Constraints for table `tblworkstation`
--
ALTER TABLE `tblworkstation`
  ADD CONSTRAINT `depwrok` FOREIGN KEY (`departmentID`) REFERENCES `tbldepartment` (`departmentId`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
