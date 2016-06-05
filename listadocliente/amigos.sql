-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-10-2015 a las 19:57:11
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `ejemplo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `amigos`
--

CREATE TABLE IF NOT EXISTS `amigos` (
  `claveAmigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombreAmigo` varchar(40) COLLATE utf8_spanish2_ci NOT NULL,
  `direccionAmigo` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `edadAmigo` int(2) NOT NULL,
  `telefonoAmigo` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`claveAmigo`),
  UNIQUE KEY `claveAmigo` (`claveAmigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `amigos`
--

INSERT INTO `amigos` (`claveAmigo`, `nombreAmigo`, `direccionAmigo`, `edadAmigo`, `telefonoAmigo`) VALUES
(1, 'Arnulfo', 'Cholula privada #30', 17, '2441135229'),
(2, 'Lorena', 'Privada matamoros s/n', 17, '2227807743'),
(3, 'Alejandra', '4 oriente #29', 17, '2441024308');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `nombreUsuario` varchar(8) COLLATE utf8_spanish2_ci NOT NULL,
  `passwordUsuario` varchar(32) COLLATE utf8_spanish2_ci NOT NULL,
  UNIQUE KEY `nombreUsuario` (`nombreUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`nombreUsuario`, `passwordUsuario`) VALUES
('betorb15', '1a2367edbd6babe54a67c92d102a0ee8');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
