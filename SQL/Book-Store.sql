-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2016 at 12:01 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `book_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `book_store_books`
--

CREATE TABLE `book_store_books` (
  `book_id` int(11) NOT NULL,
  `book_title` varchar(150) NOT NULL,
  `book_content` longtext NOT NULL,
  `book_photo` varchar(150) NOT NULL,
  `book_file` varchar(150) NOT NULL,
  `book_cost` int(11) NOT NULL,
  `book_category_id` int(11) NOT NULL,
  `book_author_id` int(11) NOT NULL,
  `book_downloads_num` int(11) NOT NULL,
  `book_created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `book_modified_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book_store_books`
--

INSERT INTO `book_store_books` (`book_id`, `book_title`, `book_content`, `book_photo`, `book_file`, `book_cost`, `book_category_id`, `book_author_id`, `book_downloads_num`, `book_created_date`, `book_modified_date`) VALUES
(38, 'jsdbjfsdbj fb', 'nbfnsdbnf bsn fsnfbnsd fbnmsdbf nsdbf nmsdb nsd bnmsd b', '../uploads/886282566.png', '../uploads/810933917.pdf', 0, 4, 27, 0, '2016-09-24 11:24:29', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `book_store_books_reviews`
--

CREATE TABLE `book_store_books_reviews` (
  `review_id` int(11) NOT NULL,
  `review_percent` int(11) NOT NULL,
  `review_content` text NOT NULL,
  `review_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `review_book_id` int(11) NOT NULL,
  `review_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book_store_books_reviews`
--

INSERT INTO `book_store_books_reviews` (`review_id`, `review_percent`, `review_content`, `review_date`, `review_book_id`, `review_user_id`) VALUES
(27, 3, 'nbfsdfvsdjh', '2016-09-26 21:41:07', 38, 27);

-- --------------------------------------------------------

--
-- Table structure for table `book_store_categories`
--

CREATE TABLE `book_store_categories` (
  `category_id` int(11) NOT NULL,
  `category_title` varchar(100) NOT NULL,
  `category_content` text NOT NULL,
  `category_user_id` int(11) NOT NULL,
  `category_photo` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book_store_categories`
--

INSERT INTO `book_store_categories` (`category_id`, `category_title`, `category_content`, `category_user_id`, `category_photo`) VALUES
(4, 'Bats', 'Bats books is good category which has new and modern content ', 27, '../uploads/92303170.png'),
(5, 'GOT Category 3', 'GOT Category Books of Tc show GOT Category Books of Tc show GOT Category Books of Tc show GOT Category Books of Tc show GOT Category Books of Tc show GOT Category Books of Tc show GOT Category Books of Tc show ', 27, '../uploads/422787250.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `book_store_users_meta`
--

CREATE TABLE `book_store_users_meta` (
  `meta_id` int(11) NOT NULL,
  `meta_book_id` int(11) NOT NULL,
  `meta_user_id` int(11) NOT NULL,
  `meta_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book_store_users_meta`
--

INSERT INTO `book_store_users_meta` (`meta_id`, `meta_book_id`, `meta_user_id`, `meta_type`) VALUES
(1, 38, 27, 1),
(2, 38, 27, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `adddate` varchar(30) NOT NULL,
  `job` varchar(50) NOT NULL,
  `about` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `name`, `username`, `password`, `email`, `is_admin`, `adddate`, `job`, `about`) VALUES
(27, 'Moustafa admin', 'admin', '6481a8cce9862c14c4f9b35bbddc0cba23f923d47fb249b334e14513ed7824e14d0541f9195b3234', 'moustafa_algammal@yahoo.com', 1, '12-09-2016', 'admin', ''),
(37, 'Moustafa Mack', 'mack', '6481a8cce9862c14c4f9b35bbddc0cba23f923d47fb249b334e14513ed7824e14d0541f9195b3234', 'mack@gmail.com', 2, '22-09-2016', 'Author', ''),
(36, 'Moustafa Elgammal', 'maxxi', '6481a8cce9862c14c4f9b35bbddc0cba23f923d47fb249b334e14513ed7824e14d0541f9195b3234', 'maxxi.mack@gmail.com', 0, '17-09-2016', 'subscribers', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book_store_books`
--
ALTER TABLE `book_store_books`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `book_store_books_reviews`
--
ALTER TABLE `book_store_books_reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `book_store_categories`
--
ALTER TABLE `book_store_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `book_store_users_meta`
--
ALTER TABLE `book_store_users_meta`
  ADD PRIMARY KEY (`meta_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book_store_books`
--
ALTER TABLE `book_store_books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `book_store_books_reviews`
--
ALTER TABLE `book_store_books_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `book_store_categories`
--
ALTER TABLE `book_store_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `book_store_users_meta`
--
ALTER TABLE `book_store_users_meta`
  MODIFY `meta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
