-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-01-2023 a las 11:51:01
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
-- Base de datos: `conta2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `codigoMov` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `loginUsu` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `concepto` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`codigoMov`, `loginUsu`, `fecha`, `concepto`, `cantidad`) VALUES
('0f32', 'Vanesa', '2022-12-06', 'lampara', -99),
('1', 'Maria', '0000-00-00', 'Inicial Presupuesto', 100),
('1', 'Thalia', '0000-00-00', 'Inicial Presupuesto', 666),
('1', 'Vanesa', '0000-00-00', 'Inicial Presupuesto', 777),
('2ef0', 'vanesa', '2022-12-10', 'pruebafech', 11),
('34ac', 'Vanesa', '2022-12-01', 'libro', -88),
('538d', 'Vanesa', '2022-12-01', 'verde', 55),
('6766', 'Vanesa', '2022-11-16', 'Alquiler', -2),
('6f8e', 'vanesa', '2022-12-10', 'pruebafech', 11),
('7519', 'vanesa', '2022-12-06', 'Ingreso1', 22),
('7cfb', 'vanesa', '2022-11-29', 'asdfsdfdsf', 11),
('c146', 'Vanesa', '2022-12-07', 'Gasto1', -100),
('cddc', 'vanesa', '2011-11-11', 'Ingreso3', 33),
('ec11', 'vanesa', '2022-11-29', 'pruebafech', 11),
('f077', 'vanesa', '0000-00-00', 'Ingreso2', 65),
('face', 'vanesa', '2011-11-11', 'Ingreso3', 33);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `login` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `fNacimiento` date NOT NULL,
  `presupuesto` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`login`, `password`, `nombre`, `fNacimiento`, `presupuesto`) VALUES
('Maria', 'XCTU.34uar17.', 'Maria', '1991-12-12', 100),
('Thalia', 'XC1kSkpJLdQkI', 'Thalia', '0000-00-00', 666),
('Vanesa', 'XCAM6P5aA.sUE', 'Vanesa', '0000-00-00', 777);

--
-- Disparadores `usuarios`
--
DELIMITER $$
CREATE TRIGGER `borrar_usuario` BEFORE DELETE ON `usuarios` FOR EACH ROW begin delete from movimientos where loginUsu=old.login; end
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`codigoMov`,`loginUsu`),
  ADD KEY `loginUsu` (`loginUsu`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`login`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `movimientos_ibfk_1` FOREIGN KEY (`loginUsu`) REFERENCES `usuarios` (`login`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
