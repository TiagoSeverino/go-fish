-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 31-Maio-2019 às 10:45
-- Versão do servidor: 5.7.24
-- versão do PHP: 7.0.33

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
-- Estrutura da tabela `utilizadores`
--

DROP TABLE IF EXISTS `utilizadores`;
CREATE TABLE IF NOT EXISTS `utilizadores` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(250) COLLATE utf8_bin NOT NULL,
  `password` varchar(250) COLLATE utf8_bin NOT NULL,
  `nome` varchar(250) COLLATE utf8_bin NOT NULL,
  `datanascimento` varchar(10) COLLATE utf8_bin NOT NULL,
  `email` varchar(250) COLLATE utf8_bin NOT NULL,
  `numerojogos` int(11) NOT NULL DEFAULT '0',
  `numerovitorias` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `utilizadores`
--

INSERT INTO `utilizadores` (`id`, `username`, `password`, `nome`, `datanascimento`, `email`, `numerojogos`, `numerovitorias`) VALUES
(3, 'Nelsan', 'admin', 'Nelsan Pereira', '2010-09-27', 'nelsanpereira@myemail.com', 0, 10),
(4, 'hnojy', '123', 'hghcnhcgnhghn', '1111-02-22', 'johnyhirms@myemail.com', 0, 2),
(5, 'amilcar', 'amil', 'amilcar', '2011-03-31', 'amil@mail', 0, 3),
(6, 'jota', 'jota', 'joao', '', 'jota@mail.pt', 0, 4),
(7, 'qwer', 'qwer', 'qwer', 'qwer', 'qwer', 0, 1),
(8, 'asd', 'asd', 'asd', 'asd', 'asd', 0, 5),
(9, 'zxc', 'zxc', 'zxc', 'zxc', 'zxc', 0, 6),
(10, 'rfv', 'rfv', 'rfv', 'rfv', 'rfv', 0, 3),
(11, 'ghfgj', 'fgj', 'fgjfgj', 'ghj', 'jgfj', 0, 2),
(12, 'gtf', 'bgdfda', 'asdf', 'asdfds', 'bsd', 0, 1),
(13, 'sdfgsd', 'sdfgsdf', 'gsdfgsdf', 'sdfg', 'sdfg', 0, 7),
(14, 'frito', 'frito', 'frito', 'frito', 'frito', 0, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
