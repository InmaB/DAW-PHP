-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-11-2022 a las 13:34:24
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `morosos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anunciantes`
--

CREATE TABLE `anunciantes` (
  `login` varchar(20) NOT NULL,
  `password` varchar(30) NOT NULL,
  `bloqueado` tinyint(1) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `anunciantes`
--

INSERT INTO `anunciantes` (`login`, `password`, `bloqueado`, `email`) VALUES
('dwes', 'XCl85ymn4frKo', 1, 'dwes@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anuncios`
--

CREATE TABLE `anuncios` (
  `autor` varchar(40) NOT NULL,
  `moroso` varchar(40) NOT NULL,
  `localidad` varchar(50) NOT NULL,
  `descripcion` varchar(60) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anunciantes`
--
ALTER TABLE `anunciantes`
  ADD PRIMARY KEY (`login`);

--
-- Indices de la tabla `anuncios`
--
ALTER TABLE `anuncios`
  ADD PRIMARY KEY (`autor`,`moroso`,`fecha`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
