-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-11-2024 a las 15:09:25
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdtalleres`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE `alumno` (
  `idAlumno` int(11) NOT NULL,
  `nombreAlumno` varchar(100) NOT NULL,
  `apellidoAlumno` varchar(100) NOT NULL,
  `correoAlumno` varchar(100) NOT NULL,
  `generoAlumno` enum('M','F') NOT NULL,
  `celularAlumno` varchar(15) DEFAULT NULL,
  `idTaller` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `idAsistencia` int(11) NOT NULL,
  `inicioAsist` time NOT NULL,
  `finAsist` time NOT NULL,
  `observación` text DEFAULT NULL,
  `fechaAsist` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encargadoevento`
--

CREATE TABLE `encargadoevento` (
  `idEncarEvento` int(11) NOT NULL,
  `nombreEncarEvento` varchar(100) NOT NULL,
  `emailEncarEvento` varchar(100) NOT NULL,
  `celularEncarEvento` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encargadotaller`
--

CREATE TABLE `encargadotaller` (
  `idEncarTaller` int(11) NOT NULL,
  `nombreEncarTaller` varchar(100) NOT NULL,
  `apellidoEncarTaller` varchar(100) NOT NULL,
  `emailEncarTaller` varchar(100) NOT NULL,
  `celularEncarTaller` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ensayo`
--

CREATE TABLE `ensayo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `encargado` varchar(100) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `lugar` varchar(100) DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_culminacion` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ensayo`
--

INSERT INTO `ensayo` (`id`, `nombre`, `descripcion`, `encargado`, `fecha`, `lugar`, `hora_inicio`, `hora_culminacion`) VALUES
(8, 'Ensayo1', 'aaaaaaaa', 'docente@uandina.edu.pe', '2024-11-22', 'Primavera', '14:33:00', '16:33:00'),
(9, 'Ensayo2', 'bbbbbbbb', 'docente@uandina.edu.pe', '2024-11-29', 'Primavera', '17:00:00', '18:00:00'),
(10, 'Ensayo3', 'ccccccccccc', 'docente@uandina.edu.pe', '2024-11-20', 'Primavera', '22:31:00', '01:31:00'),
(11, 'Ensayo4', 'ewde', 'docente@uandina.edu.pe', '2024-11-22', 'Primavera', '03:26:00', '04:26:00'),
(12, 'Ensayo4', 'ewde', 'docente@uandina.edu.pe', '2024-11-22', 'Primavera', '03:26:00', '04:26:00'),
(13, 'Ensayo5', 'aaaa', 'docente@uandina.edu.pe', '2024-11-29', 'Primavera', '22:15:00', '03:10:00'),
(14, 'Ensayo6', 'aaaaaaa', 'docente@uandina.edu.pe', '2024-11-21', 'Primavera', '03:33:00', '04:33:00'),
(15, 'Ensayo7', 'ewde', 'docente@uandina.edu.pe', '2024-12-05', 'Primavera', '03:22:00', '03:22:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE `evento` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `encargado` varchar(100) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `lugar` varchar(100) DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_culminacion` time DEFAULT NULL,
  `imagen` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro`
--

CREATE TABLE `registro` (
  `idRegistro` int(11) NOT NULL,
  `idAlumno` int(11) DEFAULT NULL,
  `idAsistencia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taller`
--

CREATE TABLE `taller` (
  `idTaller` int(11) NOT NULL,
  `nombreTaller` varchar(100) NOT NULL,
  `horarioTaller` varchar(100) NOT NULL,
  `idEncarTaller` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `contrasenia` varchar(255) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `correo`, `contrasenia`, `role`) VALUES
(1, 'alumno@uandina.edu.pe', 'alumno', 'alumno'),
(2, 'docente@uandina.edu.pe', 'docente', 'docente');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`idAlumno`),
  ADD KEY `idTaller` (`idTaller`);

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`idAsistencia`);

--
-- Indices de la tabla `encargadoevento`
--
ALTER TABLE `encargadoevento`
  ADD PRIMARY KEY (`idEncarEvento`);

--
-- Indices de la tabla `encargadotaller`
--
ALTER TABLE `encargadotaller`
  ADD PRIMARY KEY (`idEncarTaller`);

--
-- Indices de la tabla `ensayo`
--
ALTER TABLE `ensayo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `registro`
--
ALTER TABLE `registro`
  ADD PRIMARY KEY (`idRegistro`),
  ADD KEY `idAlumno` (`idAlumno`),
  ADD KEY `idAsistencia` (`idAsistencia`);

--
-- Indices de la tabla `taller`
--
ALTER TABLE `taller`
  ADD PRIMARY KEY (`idTaller`),
  ADD KEY `idEncarTaller` (`idEncarTaller`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumno`
--
ALTER TABLE `alumno`
  MODIFY `idAlumno` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `idAsistencia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `encargadoevento`
--
ALTER TABLE `encargadoevento`
  MODIFY `idEncarEvento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `encargadotaller`
--
ALTER TABLE `encargadotaller`
  MODIFY `idEncarTaller` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ensayo`
--
ALTER TABLE `ensayo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro`
--
ALTER TABLE `registro`
  MODIFY `idRegistro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `taller`
--
ALTER TABLE `taller`
  MODIFY `idTaller` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD CONSTRAINT `alumno_ibfk_1` FOREIGN KEY (`idTaller`) REFERENCES `taller` (`idTaller`);

--
-- Filtros para la tabla `registro`
--
ALTER TABLE `registro`
  ADD CONSTRAINT `registro_ibfk_1` FOREIGN KEY (`idAlumno`) REFERENCES `alumno` (`idAlumno`),
  ADD CONSTRAINT `registro_ibfk_2` FOREIGN KEY (`idAsistencia`) REFERENCES `asistencia` (`idAsistencia`);

--
-- Filtros para la tabla `taller`
--
ALTER TABLE `taller`
  ADD CONSTRAINT `taller_ibfk_1` FOREIGN KEY (`idEncarTaller`) REFERENCES `encargadotaller` (`idEncarTaller`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
