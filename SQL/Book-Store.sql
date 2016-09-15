-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2016 at 01:30 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `book_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `book_store_books`
--

CREATE TABLE IF NOT EXISTS `book_store_books` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_title` varchar(150) NOT NULL,
  `book_content` longtext NOT NULL,
  `book_photo` varchar(150) NOT NULL,
  `book_file` varchar(150) NOT NULL,
  `book_cost` int(11) NOT NULL,
  `book_category_id` int(11) NOT NULL,
  `book_author_id` int(11) NOT NULL,
  `book_downloads_num` int(11) NOT NULL,
  `book_created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `book_modified_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`book_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `book_store_books`
--

INSERT INTO `book_store_books` (`book_id`, `book_title`, `book_content`, `book_photo`, `book_file`, `book_cost`, `book_category_id`, `book_author_id`, `book_downloads_num`, `book_created_date`, `book_modified_date`) VALUES
  (22, 'Badr', 'Badr test boook for every on', '', '../uploads/989989159.pdf', 0, 1, 27, 0, '2016-09-15 22:26:25', '0000-00-00 00:00:00'),
  (23, 'Badr', 'Badr test boook for every on', '', '../uploads/989989159.pdf', 0, 1, 27, 0, '2016-09-15 22:26:25', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `book_store_books_reviews`
--

CREATE TABLE IF NOT EXISTS `book_store_books_reviews` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `review_percent` int(11) NOT NULL,
  `review_content` text NOT NULL,
  `review_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `review_book_id` int(11) NOT NULL,
  `review_user_id` int(11) NOT NULL,
  PRIMARY KEY (`review_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `book_store_categories`
--

CREATE TABLE IF NOT EXISTS `book_store_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_title` varchar(100) NOT NULL,
  `category_content` text NOT NULL,
  `category_user_id` int(11) NOT NULL,
  `category_photo` varchar(150) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `book_store_categories`
--

INSERT INTO `book_store_categories` (`category_id`, `category_title`, `category_content`, `category_user_id`, `category_photo`) VALUES
  (1, 'Test Cat', 'sdfsdf', 0, 'dsdfsdf');

-- --------------------------------------------------------

--
-- Table structure for table `book_store_users_meta`
--

CREATE TABLE IF NOT EXISTS `book_store_users_meta` (
  `meta_id` int(11) NOT NULL AUTO_INCREMENT,
  `meta_book_id` int(11) NOT NULL,
  `meta_user_id` int(11) NOT NULL,
  `meta_type` int(11) NOT NULL,
  PRIMARY KEY (`meta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `adddate` varchar(30) NOT NULL,
  `job` varchar(50) NOT NULL,
  `about` varchar(250) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `name`, `username`, `password`, `email`, `is_admin`, `adddate`, `job`, `about`) VALUES
  (27, 'Moustafa admin', 'admin', '6481a8cce9862c14c4f9b35bbddc0cba23f923d47fb249b334e14513ed7824e14d0541f9195b3234', 'moustafa_algammal@yahoo.com', 1, '12-09-2016', 'admin', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
