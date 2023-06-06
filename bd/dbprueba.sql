-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2023 at 07:30 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbprueba`
--

-- --------------------------------------------------------

--
-- Table structure for table `login_logs`
--

CREATE TABLE `login_logs` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `fecha_hora` datetime(6) NOT NULL,
  `navegador` varchar(100) NOT NULL,
  `sistema_operativo` varchar(100) NOT NULL,
  `validation` varchar(100) NOT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login_logs`
--

INSERT INTO `login_logs` (`id`, `email`, `ip`, `fecha_hora`, `navegador`, `sistema_operativo`, `validation`, `estado`) VALUES
(1, 'asq@gmail.com', '127.0.0.1', '2023-05-23 22:47:15.000000', 'Mozilla/5.0 (Windows NT 10.0; rv:112.0) Gecko/20100101 Firefox/112.0', 'Windows 10', 'Login Exitoso', 1),
(2, 'asq@gmail.com', '127.0.0.1', '2023-05-23 22:48:59.000000', 'Mozilla/5.0 (Windows NT 10.0; rv:112.0) Gecko/20100101 Firefox/112.0', 'Windows 10', 'Login Exitoso', 1),
(3, 'carlos@gmail.com', '127.0.0.1', '2023-05-23 22:55:39.000000', 'Mozilla/5.0 (Windows NT 10.0; rv:112.0) Gecko/20100101 Firefox/112.0', 'Windows 10', 'Login Exitoso', 1),
(4, 'carlos@gmail.com', '127.0.0.1', '2023-05-23 23:08:48.000000', 'Mozilla/5.0 (Windows NT 10.0; rv:112.0) Gecko/20100101 Firefox/112.0', 'Windows 10', 'Login Exitoso', 1),
(5, 'carlos@gmail.com', '127.0.0.1', '2023-05-23 23:13:20.000000', 'Mozilla/5.0 (Windows NT 10.0; rv:112.0) Gecko/20100101 Firefox/112.0', 'Windows 10', 'Login Exitoso', 1),
(11, 'carlos@gmail.com', '127.0.0.1', '2023-05-23 23:19:35.000000', 'Mozilla/5.0 (Windows NT 10.0; rv:112.0) Gecko/20100101 Firefox/112.0', 'Windows 10', 'Login Exitoso', 1),
(13, 'carlos@gmail.com', '127.0.0.1', '2023-05-23 23:20:48.000000', 'Mozilla/5.0 (Windows NT 10.0; rv:112.0) Gecko/20100101 Firefox/112.0', 'Windows 10', 'Login Exitoso', 1),
(14, 'carlos@gmai.com', '127.0.0.1', '2023-05-23 23:21:04.000000', 'Mozilla/5.0 (Windows NT 10.0; rv:112.0) Gecko/20100101 Firefox/112.0', 'Windows 10', 'Usuario no encontrado', 0),
(15, 'asda@gmail.com', '127.0.0.1', '2023-05-23 23:21:10.000000', 'Mozilla/5.0 (Windows NT 10.0; rv:112.0) Gecko/20100101 Firefox/112.0', 'Windows 10', 'Captcha inválido', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(7, 'asd', 'asq@gmail.com', '$2y$10$ap2ltLnGsHDm95EFEXrwx.Tn3FrWn3.t3k2lllXh/BS1i7abobhS2'),
(8, 'Carlos', 'carlos@gmail.com', '$2y$10$.r.kgna2xoI2oLOTjjVDaeNUGeptk1oPTukOPIY4zXAPKzJ2K49.2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login_logs`
--
ALTER TABLE `login_logs`
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
-- AUTO_INCREMENT for table `login_logs`
--
ALTER TABLE `login_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
