-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2017 at 02:01 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `his_word_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages_comments`
--

CREATE TABLE `messages_comments` (
  `id` int(11) NOT NULL,
  `channel_id` int(11) NOT NULL,
  `sermon_id` int(11) NOT NULL,
  `commenter_name` varchar(255) NOT NULL,
  `commenter_id` varchar(255) NOT NULL,
  `comment_time` varchar(32) NOT NULL,
  `comment` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages_comments`
--

INSERT INTO `messages_comments` (`id`, `channel_id`, `sermon_id`, `commenter_name`, `commenter_id`, `comment_time`, `comment`) VALUES
(1, 2, 1, ' dhfjhd djfdhhfd', '43354534', '3543', 'dvkjjfnf bnfnb fbnf bd bn bfdn fdgnfkldglkf gfdlkg fdgnfdg lkdfngl kfdnkgnflkgnfd gnfdgk fdlkgn');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages_comments`
--
ALTER TABLE `messages_comments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages_comments`
--
ALTER TABLE `messages_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
