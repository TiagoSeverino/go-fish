-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2019 at 12:26 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gofish`
--

-- --------------------------------------------------------

--
-- Table structure for table `utilizadores`
--

CREATE TABLE `utilizadores` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(250) COLLATE utf8_bin NOT NULL,
  `password` varchar(250) COLLATE utf8_bin NOT NULL,
  `nome` varchar(250) COLLATE utf8_bin NOT NULL,
  `datanascimento` varchar(10) COLLATE utf8_bin NOT NULL,
  `email` varchar(250) COLLATE utf8_bin NOT NULL,
  `numerojogos` int(11) NOT NULL DEFAULT '0',
  `numerovitorias` int(11) NOT NULL DEFAULT '0',
  `isadmin` tinyint(1) NOT NULL DEFAULT '0',
  `isbanned` tinyint(1) NOT NULL DEFAULT '0',
  `cartasiniciais` int(11) NOT NULL DEFAULT '4'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `utilizadores`
--

INSERT INTO `utilizadores` (`id`, `username`, `password`, `nome`, `datanascimento`, `email`, `numerojogos`, `numerovitorias`, `isadmin`, `isbanned`, `cartasiniciais`) VALUES
(3, 'Nelsan', 'admin', 'Nelsan Pereira1', '2010-11-29', 'nelsanpereira@myemail.com', 29, 666, 1, 0, 7),
(4, 'hnojy', '12344', 'hghcnhcgnhghn', '1111-02-22', 'johnyhirms@myemail.com', 0, 286, 0, 0, 4),
(5, 'amilcar', 'amil', 'amilcar', '2011-03-31', 'amil@mail', 0, 3, 0, 0, 4),
(6, 'jota', 'jota', 'joao', '2011-03-31', 'jota@mail.pt', 0, 4, 0, 1, 4),
(7, 'qwer', 'qwer', 'qwer', '2011-03-31', 'jota@mail.pt', 0, 1, 0, 0, 4),
(8, 'asd', 'asd', 'asd', '2011-03-31', 'jota@mail.pt', 0, 5, 0, 0, 4),
(9, 'zxc', 'zxc', 'zxc', '2011-03-31', 'jota@mail.pt', 0, 6, 0, 0, 4),
(10, 'rfv', 'rfv', 'rfv', '2011-03-31', 'jota@mail.pt', 0, 3, 0, 0, 4),
(11, 'ghfgj', 'fgj', 'fgjfgj', '2011-03-31', 'jota@mail.pt', 0, 2, 0, 0, 4),
(12, 'gtf', 'bgdfda', 'asdf', '2011-03-31', 'jota@mail.pt', 0, 1, 0, 0, 4),
(13, 'sdfgsd', 'sdfgsdf', 'gsdfgsdf', '2011-03-31', 'jota@mail.pt', 0, 7, 0, 0, 4),
(14, 'frito', 'frito', 'frito', '2011-03-31', 'jota@mail.pt', 0, 0, 0, 0, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
