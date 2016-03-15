-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 15, 2016 at 05:43 PM
-- Server version: 5.5.47-0ubuntu0.14.04.1-log
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_m140143cs`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminsettings`
--

CREATE TABLE IF NOT EXISTS `adminsettings` (
  `type` int(11) NOT NULL,
  `field` varchar(30) NOT NULL,
  `value` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adminsettings`
--

INSERT INTO `adminsettings` (`type`, `field`, `value`) VALUES
(2, 'fine', 2),
(3, 'fine', 2),
(2, 'due_days', 90),
(3, 'due_days', 60),
(2, 'books', 7),
(3, 'books', 7),
(2, 'books_res', 1),
(3, 'books_res', 5);

-- --------------------------------------------------------

--
-- Table structure for table `book_master`
--

CREATE TABLE IF NOT EXISTS `book_master` (
  `isbn` varchar(13) NOT NULL,
  `title` varchar(70) NOT NULL,
  `author` varchar(50) NOT NULL,
  `publisher` varchar(50) NOT NULL,
  `catid` int(5) DEFAULT NULL,
  `rackno` varchar(10) NOT NULL,
  `stock` int(5) NOT NULL,
  `picture` varchar(100) NOT NULL,
  `comments` text NOT NULL,
  PRIMARY KEY (`isbn`),
  KEY `catid` (`catid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `book_master`
--

INSERT INTO `book_master` (`isbn`, `title`, `author`, `publisher`, `catid`, `rackno`, `stock`, `picture`, `comments`) VALUES
('1123457810', 'Pure and Applied Mathematics Ed 3', 'Peter D Lax', 'Wiley', 27, '342', 2, '', 'Outlines the core ideas of linear algebra illustrating the theory behind matrices and vector spaces.'),
('123456789', 'Coding Interview Questions', 'Karumuranc', 'Career monk', 18, '101', 2, '', ''),
('12356987', 'Linear Integral Equations Ed 2', 'Ram P Kanwal', 'Birkauser ', 32, '190', 0, '', 'Presents a variety of techniques to solve enormous examples of Fredholm and Volterra Integral equations.'),
('1239685741', 'Insight into Wavelets from Theory to Practise Ed 2', 'K P Soman', 'Prentice Hall ', 30, '547', 1, '', 'Discusses the whole matter of wavelets for the design and implementation of various image processing applications'),
('1285744400', 'Engineering Optimization Ed 2', 'S S Rao', 'Elsevier', 23, '24', 1, '', 'Illustrates classical optimization techniques with key attention to discrete optimization.'),
('128579663', 'Combinatorial Optimization Algorithms and Complexity Ed 2', 'Papadimitriou', 'Prentice Hall ', 26, '893', 0, '', 'Presents a combination of the theory of computational complexity emphasising the design of approximation algorithms for well known NP-Complete '),
('23568974', 'Linear Algebra Ed 2', 'Kenneth Hoffman', 'Prentice Hall ', 25, '67', 1, '', 'Provides an in depth coverage of linear equations and computations with matrices with numerous problems.'),
('2365', 'Linear Algebra', 'pp', 'pp', 27, '101', 2, '', 'juhy'),
('72322004', 'Introduction to theory of computation Ed 2', 'John C Martin', 'Tata McGraw Hill ', 21, '123', 1, '', 'Very good book illustrating  theoretical computational models.'),
('741258960', 'Understanding Linux Kernel Ed 1', 'Daniel P Boet', 'O Reily', 34, '49', 0, '', 'Provides an in-depth coverage of the design and implementation of the Linux operating system.'),
('763723878', 'Introduction to Algorithms using C+ Ed 3', 'Richard Neopolitan', 'Addison Wesley ', 22, '76', 2, '', 'Emphasise the essential principles of algorithm analysis and design'),
('789456123', 'Principles of compiler design Ed 2', 'Alfred V Aho', 'Addison Wesley', 31, '127', 1, '', 'Illustrates the design and implementation of most modern compilers.');

-- --------------------------------------------------------

--
-- Table structure for table `book_trans`
--

CREATE TABLE IF NOT EXISTS `book_trans` (
  `serialno` int(5) NOT NULL AUTO_INCREMENT,
  `isbn` varchar(13) NOT NULL,
  `status` int(1) NOT NULL,
  `comments` text NOT NULL,
  PRIMARY KEY (`serialno`),
  KEY `isbn` (`isbn`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=327 ;

--
-- Dumping data for table `book_trans`
--

INSERT INTO `book_trans` (`serialno`, `isbn`, `status`, `comments`) VALUES
(311, '72322004', 2, ''),
(312, '763723878', 1, ''),
(313, '763723878', 1, ''),
(314, '1285744400', 3, ''),
(316, '1123457810', 3, ''),
(317, '1123457810', 2, ''),
(318, '23568974', 1, ''),
(319, '1239685741', 2, ''),
(320, '789456123', 3, ''),
(323, '123456789', 1, ''),
(324, '123456789', 1, ''),
(325, '2365', 1, ''),
(326, '2365', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `catid` int(5) NOT NULL AUTO_INCREMENT,
  `catname` varchar(50) NOT NULL,
  `parent` int(5) NOT NULL,
  PRIMARY KEY (`catid`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`catid`, `catname`, `parent`) VALUES
(11, 'Professional', 0),
(12, 'Literature', 0),
(13, 'Engineering', 11),
(14, 'Medicine', 11),
(15, 'Novels', 12),
(16, 'Fiction', 15),
(17, 'Computer Science', 13),
(18, 'Programming', 17),
(19, 'Algorithms', 17),
(21, 'Formal Languages and automata', 17),
(22, 'Analysis and design', 19),
(23, 'Optimisation Theory', 17),
(24, 'Mathematics', 11),
(25, 'Applied Mathematics', 24),
(26, 'Algorithms and complexity', 25),
(27, 'Linear Algebra', 24),
(28, 'physics', 11),
(29, 'Applied practical Physics', 28),
(30, 'Digital Image Processing', 29),
(31, 'Compiler Construction', 17),
(32, 'Integral Calculus', 25),
(33, 'Operating System', 17),
(34, 'Kernal Design', 33);

-- --------------------------------------------------------

--
-- Table structure for table `issues`
--

CREATE TABLE IF NOT EXISTS `issues` (
  `sno` int(10) NOT NULL AUTO_INCREMENT,
  `userid` varchar(10) NOT NULL,
  `serialno` int(5) NOT NULL,
  `issuedate` date NOT NULL,
  `duedate` date NOT NULL,
  `returndate` date NOT NULL,
  `fine` int(3) NOT NULL,
  PRIMARY KEY (`sno`),
  KEY `userid` (`userid`),
  KEY `userid_2` (`userid`),
  KEY `serialno` (`serialno`),
  KEY `serialno_2` (`serialno`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `issues`
--

INSERT INTO `issues` (`sno`, `userid`, `serialno`, `issuedate`, `duedate`, `returndate`, `fine`) VALUES
(12, 'M130155CS', 311, '2014-10-07', '2014-12-06', '2014-10-07', 0),
(13, 'M130155CS', 314, '2014-10-07', '2014-12-06', '0000-00-00', 0),
(14, 'M130155CS', 312, '2014-10-07', '2014-12-06', '2016-01-11', 802),
(15, 'M130226CS', 313, '2014-10-07', '2014-09-07', '2014-10-07', 60),
(16, 'M130226CS', 320, '2014-10-07', '2014-12-06', '0000-00-00', 0),
(17, 'FLBS01CS', 317, '2014-10-07', '2015-01-05', '2014-10-07', 0),
(18, 'M130155CS', 316, '2016-01-11', '2016-03-11', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `slno` int(10) NOT NULL AUTO_INCREMENT,
  `userid` varchar(10) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `message` text NOT NULL,
  PRIMARY KEY (`slno`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`slno`, `userid`, `time`, `message`) VALUES
(3, 'M130155CS', '2014-10-07 12:13:02', 'The books_res value has been changed from 1 to 5'),
(4, 'M130226CS', '2014-10-07 12:13:02', 'The books_res value has been changed from 1 to 5'),
(5, 'M130373CS', '2014-10-07 12:13:02', 'The books_res value has been changed from 1 to 5'),
(6, 'M130391CS', '2014-10-07 12:13:02', 'The books_res value has been changed from 1 to 5'),
(7, 'FLBS01CS', '2014-10-07 12:16:55', 'Book Introduction to theory of computation Ed 2 has been returned and is reserved for you. Please take the book within 7 days'),
(8, 'M130155CS', '2014-10-07 12:28:48', 'Book 315 has been deleted. Inconvinence regreted.'),
(9, 'M130155CS', '2014-10-07 12:37:42', 'Book Pure and Applied Mathematics Ed 3 has been returned and is reserved for you. Please take the book within 7 days');




-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE IF NOT EXISTS `reservation` (
  `slno` int(10) NOT NULL AUTO_INCREMENT,
  `userid` varchar(10) NOT NULL,
  `serialno` int(5) NOT NULL,
  `reservedon` date NOT NULL,
  PRIMARY KEY (`slno`),
  KEY `userid` (`userid`),
  KEY `serialno` (`serialno`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`slno`, `userid`, `serialno`, `reservedon`) VALUES
(5, 'M130226CS', 319, '2014-10-07'),
(6, 'FLBS01CS', 311, '2014-10-07'),
(7, 'M130155CS', 317, '2014-10-07');

-- --------------------------------------------------------

--
-- Table structure for table `table1`
--

CREATE TABLE IF NOT EXISTS `table1` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `data` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table1`
--

INSERT INTO `table1` (`id`, `user`, `data`) VALUES
(1, 11, 'aaa1'),
(2, 11, 'aaa2'),
(3, 11, 'aaa3'),
(4, 22, 'aaa4');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userid` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) DEFAULT NULL,
  `type` int(1) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `password`, `type`, `name`, `email`, `phone`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 1, NULL, NULL, NULL),
('FLBS01CS', 'f98d4e66ae7d005b55f08f9d04340b46', 2, 'FLBS01CS', 'vinodgeorge@gmail.com', '9447386534'),
('FLBS02CS', '2f13b76d850459dd71fcf4a67e03f0d9', 2, 'FLBS02CS', 'praveenkumark@gmail.com', '9447375156'),
('FLBS03CS', '3d1050d3a28a03b3d84c6dcd5d1cbae2', 2, 'FLBS03CS', 'sreejeshvk@gmail.com', '9496690222'),
('M130155CS', '39c50a792166e5abf0c1b4f43a3b81d5', 2, 'M130155CS', 'atchyut_m130155cs@nitc.ac.in', '9567034641'),
('M130226CS', 'fc2d9ff2500d484a6b8877791f966fa2', 3, 'M130226CS', 'vineethanand_m130226cs@nitc.ac.in', '8943743102'),
('M130321CS', '8d06b46d9cb78a15d0f61fcfa9071c8a', 3, 'M130321CS', 'M130321CS@nitc.in', '9645458002'),
('M130391CS', '85218e246412d0deab0284987e89bb17', 3, 'M130391CS', 'nikhil_m130391cs@nitc.ac.in', '9048801802');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book_master`
--
ALTER TABLE `book_master`
  ADD CONSTRAINT `book_master_ibfk_1` FOREIGN KEY (`catid`) REFERENCES `category` (`catid`);

--
-- Constraints for table `book_trans`
--
ALTER TABLE `book_trans`
  ADD CONSTRAINT `book_trans_ibfk_1` FOREIGN KEY (`isbn`) REFERENCES `book_master` (`isbn`);

--
-- Constraints for table `issues`
--
ALTER TABLE `issues`
  ADD CONSTRAINT `issues_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `issues_ibfk_2` FOREIGN KEY (`serialno`) REFERENCES `book_trans` (`serialno`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`serialno`) REFERENCES `book_trans` (`serialno`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`m140143cs`@`localhost` EVENT `CANCEL_RESERVATION` ON SCHEDULE EVERY 1 DAY STARTS '2014-10-06 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
        UPDATE book_trans set status=1 where serialno in (select serialno from reservation where (reservedon+7) < NOW());

DELETE from reservation where slno in (select t.slno from (select * from reservation) t where (t.reservedon+7) < NOW());
    END$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
