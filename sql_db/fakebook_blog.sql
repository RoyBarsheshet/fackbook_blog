-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2017 at 12:47 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fakebook_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `article` text NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `article`, `date`, `user_id`) VALUES
(1, 'Roy first post', 'This is my first post', '2017-08-07 22:48:17', 1),
(3, 'roys another post', 'bla bla bla number 34', '2017-08-07 23:24:17', 1),
(6, 'only love', 'love you roy', '2017-08-10 22:12:28', 2),
(7, 'Hello World', 'ron first post', '2017-08-11 22:38:59', 3),
(9, 'Hello fackbook', 'hello there !!', '2017-08-12 20:57:42', 4),
(10, 'Hiiiii', 'yooooooo', '2017-08-29 17:42:39', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `avatar`, `created_at`) VALUES
(1, 'Avi', 'Lerner', 'Avi@gmail.com', '$2y$10$pv6GlqRoh4zkLI4K1exvj.VPvMW.IYOeQQARdDlA8RQcSE0XzWP9W', '2017.08.30.10.33.26-DSCF3398.JPG', '2017-08-04 00:00:00'),
(2, 'Ortal', 'Gozlan', 'Ortal@gmail.com', '$2y$10$pv6GlqRoh4zkLI4K1exvj.VPvMW.IYOeQQARdDlA8RQcSE0XzWP9W', 'ortal.jpg', '2017-08-04 00:00:00'),
(3, 'Ron', 'Cohon', 'Ron@gmail.com', '$2y$10$8iPC4HkAyP/KHQW9FQpAvOcKmyDHw77B4OHDFGOMsnlqBgwsL2IE2', '2017.08.12.15.55.42-2016-08-04_22.06.18.jpg', '2017-08-11 21:07:11'),
(4, 'dodo', 'ahron', 'dodo@gmail.com', '$2y$10$aNOcnrKaO/34BGRn6c/zheWQUA.JiJg.BuiKFR8Z.juKZbGmlEV0C', 'default.jpg', '2017-08-12 20:56:23'),
(5, 'Roy', 'Barsheshet', 'roy.barsheshet@galacoral.com', '$2y$10$cOWGL67zxinLoZgkDRDyWebYZ3waMy.qBbVbCemMYTapHTHgtjQom', 'default.jpg', '2017-08-29 17:34:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
