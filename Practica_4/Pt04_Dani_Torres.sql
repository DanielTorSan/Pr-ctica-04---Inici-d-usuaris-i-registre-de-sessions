-- Daniel Torres
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-10-2024 a las 12:00:00
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

DROP DATABASE IF EXISTS `pt04_dani_torres`;
CREATE DATABASE IF NOT EXISTS `pt04_dani_torres`;
USE `pt04_dani_torres`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de dades: `pt04_dani_torres`
--

-- --------------------------------------------------------

--
-- Estructura de taula per la taula `articles`
--

CREATE TABLE `articles` (
  `ID` int(10) UNSIGNED NOT NULL,
  `DNI` varchar(20) NOT NULL,
  `cos` text NOT NULL,
  `titol` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índexs per taules volcades
--

--
-- Índexs de la taula `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE (`DNI`);

--
-- AUTO_INCREMENT de les taules volcades
--

--
-- AUTO_INCREMENT de la taula `articles`
--
ALTER TABLE `articles`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- Estructura de taula per la taula `usuaris`
--

CREATE TABLE `usuaris` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `reset_token` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reset_expiration` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índexs per taules volcades
--

--
-- Índexs de la taula `usuaris`
--
ALTER TABLE `usuaris`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de les taules volcades
--

--
-- AUTO_INCREMENT de la taula `usuaris`
--
ALTER TABLE `usuaris`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
