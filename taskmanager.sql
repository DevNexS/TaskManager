-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 22, 2024 at 03:47 PM
-- Server version: 5.7.39
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `taskmanager`
--

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(3) NOT NULL,
  `Full name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Short name` varchar(20) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `Full name`, `Short name`) VALUES
(1, 'Project ILUMA', 'IL');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(3) NOT NULL,
  `project_short_name` varchar(4) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `project_task_num` int(3) NOT NULL,
  `task_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `task_desc` varchar(1000) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `state` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `project_short_name`, `project_task_num`, `task_name`, `task_desc`, `state`) VALUES
(1, 'IL', 1, 'Design development', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur faucibus tortor nec eros efficitur, vel condimentum ipsum vehicula. Etiam mattis orci rhoncus nulla lacinia porttitor. Nullam semper eros a mi pretium tempor. Fusce ac augue ultrices, fringilla mauris nec, auctor tellus. Etiam tempor egestas nisi, vel vestibulum nulla consectetur ac. Nunc dapibus sagittis quam et tempor. Phasellus eget gravida libero. ', 4),
(2, 'IL', 2, 'Using the React Framework', 'Ut non libero a magna efficitur viverra tempor sed nibh. Cras faucibus, dolor nec tempor ultricies, purus eros mattis mi, vel facilisis dolor mauris non tellus. Nullam feugiat varius ligula, varius dictum velit posuere ac. Aliquam vehicula risus vitae aliquet auctor. Nulla tempor diam arcu, in convallis justo facilisis ut. Sed lacus ligula, egestas sit amet euismod in, vulputate sollicitudin neque. In gravida ac elit sed elementum. Praesent dapibus bibendum dui, sit amet eleifend nisl viverra vitae. ', 2),
(3, 'IL', 3, 'Writing documentation', 'Nullam vitae finibus velit. Praesent augue leo, varius sed neque eu, accumsan hendrerit nunc. Fusce volutpat nibh ultricies bibendum pellentesque. Duis tincidunt faucibus arcu nec auctor. Quisque sit amet purus et mauris commodo egestas eget a libero. Mauris ac felis a diam egestas porta non sed neque. Nullam blandit dapibus lorem non ullamcorper. In sed dui at nunc sollicitudin accumsan ut ut neque.', 1),
(4, 'IL', 4, 'Authorization form', 'Morbi mattis elit vitae ipsum blandit fermentum nec in elit. Vestibulum fermentum commodo metus, vitae sagittis purus convallis id. Proin interdum id odio a porta. Nam sit amet sem eget metus pellentesque ultricies.', 3),
(5, 'IL', 5, 'Admin panel functionality', 'Fusce vitae elit nec risus dignissim cursus a in sapien. Fusce dictum sapien nisi, vitae molestie libero vehicula nec. Proin feugiat semper hendrerit. Nullam sed iaculis felis, quis finibus nisl. Nullam sed convallis nisl. Nulla ligula ligula, feugiat vitae odio eu, consectetur consectetur odio. Sed imperdiet ultricies nisi, quis imperdiet lacus auctor sed.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(1, 'DevNex', '46f94c8de14fb36680850768ff1b7f2a'),
(2, 'admin', '21232f297a57a5a743894a0e4a801fc3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
