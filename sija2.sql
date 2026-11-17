-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2026 at 12:53 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `datapikrul`
--

-- --------------------------------------------------------

--
-- Table structure for table `sija2`
--

CREATE TABLE `sija2` (
  `no` int(4) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `website` varchar(30) NOT NULL,
  `komen` text NOT NULL,
  `gender` varchar(10) NOT NULL,
  `File` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sija2`
--

INSERT INTO `sija2` (`no`, `nama`, `email`, `website`, `komen`, `gender`, `File`) VALUES
(2, 'izy', '@mwsnjw', 'make.com', 'pikrul ganteng', 'ytta', ''),
(3, 'banyu', 'banyu@', 'ayomake.com', 'pikrul ko kamu keren', 'gatau', ''),
(13, 'anto', 'anto@gmail.com', 'sdmtinggi.com', 'pikrul hebat', 'gay(ganten', ''),
(14, 'anto', 'anto@gmail.com', 'sdmtinggi.com', 'pikrul hebat', 'gay(ganten', ''),
(15, 'anto', 'anto@gmail.com', 'sdmtinggi.com', 'pikrul hebat', 'gay(ganten', ''),
(16, 'anto', 'anto@gmail.com', 'sdmtinggi.com', 'pikrul hebat', 'gay(ganten', ''),
(40, '', '', '', '', '', ''),
(41, 'x', 'x', '', '', '', ''),
(42, 'cc', '', '', '', '', ''),
(43, 'cc', '', '', '', '', ''),
(44, '', '', '', '', '', ''),
(45, 'ewf', 'efw', '', '', '', ''),
(46, 'we', 'ff', '', '', '', ''),
(47, '', '', '', '', '', ''),
(48, '', '', '', '', '', ''),
(49, '', '', '', '', '', ''),
(50, '', '', '', '', '', ''),
(51, '', '', '', '', '', ''),
(52, '', '', '', '', '', ''),
(53, '', '', '', '', '', ''),
(54, 'qsq', 'sqqs', '', '', '', ''),
(55, 'tes', 'fiqrulshafwaan@gmail.com', '', '', '', ''),
(56, '', '', '', '', '', ''),
(57, '', '', '', '', '', ''),
(58, 'wwwtt', 'ff', '', '', '', ''),
(59, '', '', '', '', '', ''),
(60, 'bi', 'ba', '', '', '', ''),
(61, '', '', '', '', '', ''),
(62, '', '', '', '', '', ''),
(63, '', 'sdcv', '', '', '', ''),
(64, '', 'sdcv', '', '', '', ''),
(85, 'oaoo', 'asasas', '', '', '', '0a66c893ef835a4ff8d08e5ad08625ec.png'),
(86, 'oaoo', 'asasas', '', '', '', '7a8ca47da24df1d94d4033e68748e967.png'),
(87, 'moi', 'asd', '', '', '', 'ef2edf9395035c96ece047e6b5557a38.png'),
(88, 'moi', 'asd', '', '', '', 'a1ad49b0df8672efb136459802b8c74b.png'),
(89, 'dfsdc', 'nnng', 'reeg', 'erfdsfsd', 'female', '6af414a217810_Screenshot 2026-09-07 045901.png'),
(90, 'moke', 'nnng', 'reeg', 'azaa', 'male', '6af41b9e989a5_Screenshot 2026-09-06 195146.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sija2`
--
ALTER TABLE `sija2`
  ADD PRIMARY KEY (`no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sija2`
--
ALTER TABLE `sija2`
  MODIFY `no` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
