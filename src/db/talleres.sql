-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-07-2025 a las 06:48:22
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `talleres`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `id_asistencia` int(11) NOT NULL,
  `id_inscripcion` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `presente` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asistencia`
--

INSERT INTO `asistencia` (`id_asistencia`, `id_inscripcion`, `fecha`, `presente`) VALUES
(1, 1, '2025-07-15', 1),
(2, 1, '2025-07-17', 0),
(3, 2, '2025-07-17', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacion`
--

CREATE TABLE `calificacion` (
  `id_calificacion` int(11) NOT NULL,
  `id_inscripcion` int(11) DEFAULT NULL,
  `nota` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `calificacion`
--

INSERT INTO `calificacion` (`id_calificacion`, `id_inscripcion`, `nota`) VALUES
(1, 1, 87.50),
(2, 2, 91.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `id_horario` int(11) NOT NULL,
  `id_talleres` int(11) DEFAULT NULL,
  `dia` varchar(20) DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` (`id_horario`, `id_talleres`, `dia`, `hora_inicio`, `hora_fin`) VALUES
(1, 1, 'Lunes', '14:00:00', '16:00:00'),
(2, 2, 'Miércoles', '10:00:00', '12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion`
--

CREATE TABLE `inscripcion` (
  `id_inscripcion` int(11) NOT NULL,
  `id_estudiante` int(11) DEFAULT NULL,
  `id_talleres` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inscripcion`
--

INSERT INTO `inscripcion` (`id_inscripcion`, `id_estudiante`, `id_talleres`, `fecha`) VALUES
(1, 4, 1, '2025-07-08'),
(2, 5, 2, '2025-07-10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion`
--

CREATE TABLE `notificacion` (
  `id_notificacion` int(11) NOT NULL,
  `mensaje` text DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `tipo` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notificacion`
--

INSERT INTO `notificacion` (`id_notificacion`, `mensaje`, `fecha`, `tipo`) VALUES
(1, 'El taller de pintura tendrá una sesión adicional el viernes.', '2025-07-12', 'informativa'),
(2, 'Recuerda que la clase de robótica inicia este miércoles.', '2025-07-13', 'recordatorio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `padre_estudiante`
--

CREATE TABLE `padre_estudiante` (
  `id_padre` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `padre_estudiante`
--

INSERT INTO `padre_estudiante` (`id_padre`, `id_estudiante`) VALUES
(2, 4),
(3, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `talleres`
--

CREATE TABLE `talleres` (
  `id_talleres` int(11) NOT NULL,
  `id_instructor` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `talleres`
--

INSERT INTO `talleres` (`id_talleres`, `id_instructor`, `nombre`, `descripcion`, `fecha_inicio`, `fecha_fin`) VALUES
(1, 6, 'Taller de Pintura Creativa', 'Explora técnicas de pintura modernas', '2025-07-10', '2025-08-10'),
(2, 7, 'Taller de Robótica Infantil', 'Aprende robótica con kits educativos', '2025-07-15', '2025-08-20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contraseña` varchar(100) NOT NULL,
  `rol` int(11) NOT NULL,
  `fecha_registro` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `correo`, `contraseña`, `rol`, `fecha_registro`) VALUES
(1, 'Admin Principal', 'admin@edutalleres.com', 'admin123', 4, '2025-07-15'),
(2, 'Benito Gómez', 'benito@correo.com', 'padre123', 1, '2025-07-15'),
(3, 'Roberto Carías', 'roberto@correo.com', 'padre123', 1, '2025-07-15'),
(4, 'Itzel Andrade', 'itzel@correo.com', 'estu123', 2, '2025-07-15'),
(5, 'Gael Navarro', 'gael@correo.com', 'estu123', 2, '2025-07-15'),
(6, 'Leticia Ruiz', 'leticia@correo.com', 'instructor123', 3, '2025-07-15'),
(7, 'Héctor Duarte', 'hector@correo.com', 'instructor123', 3, '2025-07-15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_notificacion`
--

CREATE TABLE `usuario_notificacion` (
  `id_usuario` int(11) NOT NULL,
  `id_notificacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_notificacion`
--

INSERT INTO `usuario_notificacion` (`id_usuario`, `id_notificacion`) VALUES
(2, 1),
(3, 2),
(4, 1),
(5, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`id_asistencia`),
  ADD KEY `id_inscripcion` (`id_inscripcion`);

--
-- Indices de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  ADD PRIMARY KEY (`id_calificacion`),
  ADD KEY `id_inscripcion` (`id_inscripcion`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id_horario`),
  ADD KEY `id_talleres` (`id_talleres`);

--
-- Indices de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD PRIMARY KEY (`id_inscripcion`),
  ADD KEY `id_estudiante` (`id_estudiante`),
  ADD KEY `id_talleres` (`id_talleres`);

--
-- Indices de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD PRIMARY KEY (`id_notificacion`);

--
-- Indices de la tabla `padre_estudiante`
--
ALTER TABLE `padre_estudiante`
  ADD PRIMARY KEY (`id_padre`,`id_estudiante`),
  ADD KEY `id_estudiante` (`id_estudiante`);

--
-- Indices de la tabla `talleres`
--
ALTER TABLE `talleres`
  ADD PRIMARY KEY (`id_talleres`),
  ADD KEY `id_instructor` (`id_instructor`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `usuario_notificacion`
--
ALTER TABLE `usuario_notificacion`
  ADD PRIMARY KEY (`id_usuario`,`id_notificacion`),
  ADD KEY `id_notificacion` (`id_notificacion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `id_asistencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  MODIFY `id_calificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `id_inscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `talleres`
--
ALTER TABLE `talleres`
  MODIFY `id_talleres` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD CONSTRAINT `asistencia_ibfk_1` FOREIGN KEY (`id_inscripcion`) REFERENCES `inscripcion` (`id_inscripcion`);

--
-- Filtros para la tabla `calificacion`
--
ALTER TABLE `calificacion`
  ADD CONSTRAINT `calificacion_ibfk_1` FOREIGN KEY (`id_inscripcion`) REFERENCES `inscripcion` (`id_inscripcion`);

--
-- Filtros para la tabla `horario`
--
ALTER TABLE `horario`
  ADD CONSTRAINT `horario_ibfk_1` FOREIGN KEY (`id_talleres`) REFERENCES `talleres` (`id_talleres`);

--
-- Filtros para la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD CONSTRAINT `inscripcion_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `inscripcion_ibfk_2` FOREIGN KEY (`id_talleres`) REFERENCES `talleres` (`id_talleres`);

--
-- Filtros para la tabla `padre_estudiante`
--
ALTER TABLE `padre_estudiante`
  ADD CONSTRAINT `padre_estudiante_ibfk_1` FOREIGN KEY (`id_padre`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `padre_estudiante_ibfk_2` FOREIGN KEY (`id_estudiante`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `talleres`
--
ALTER TABLE `talleres`
  ADD CONSTRAINT `talleres_ibfk_1` FOREIGN KEY (`id_instructor`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `usuario_notificacion`
--
ALTER TABLE `usuario_notificacion`
  ADD CONSTRAINT `usuario_notificacion_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `usuario_notificacion_ibfk_2` FOREIGN KEY (`id_notificacion`) REFERENCES `notificacion` (`id_notificacion`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
