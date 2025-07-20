-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-07-2025 a las 06:58:27
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
-- Base de datos: `talleresescolares`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarAsistenciaCompleta` (IN `p_id_asistencia` INT, IN `p_fecha` DATE, IN `p_presente` TINYINT)   BEGIN
  UPDATE asistencia SET fecha = p_fecha, presente = p_presente WHERE id_asistencia = p_id_asistencia;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarCalificacion` (IN `p_id_calificacion` INT, IN `p_nota` DECIMAL(5,2))   BEGIN
  UPDATE calificacion SET nota = p_nota WHERE id_calificacion = p_id_calificacion;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarHorarioCompleto` (IN `p_id_horario` INT, IN `p_dia` VARCHAR(20), IN `p_hora_inicio` TIME, IN `p_hora_fin` TIME, IN `p_id_taller` INT)   BEGIN
  UPDATE horario
  SET dia = p_dia, hora_inicio = p_hora_inicio, hora_fin = p_hora_fin, id_talleres = p_id_taller
  WHERE id_horario = p_id_horario;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarHorarioHoras` (IN `p_id_horario` INT, IN `p_hora_inicio` TIME, IN `p_hora_fin` TIME)   BEGIN
  UPDATE horario SET hora_inicio = p_hora_inicio, hora_fin = p_hora_fin WHERE id_horario = p_id_horario;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarInscripcionCompleta` (IN `p_id_inscripcion` INT, IN `p_id_estudiante` INT, IN `p_id_taller` INT, IN `p_fecha` DATE)   BEGIN
  UPDATE inscripcion SET id_estudiante = p_id_estudiante, id_talleres = p_id_taller, fecha = p_fecha
  WHERE id_inscripcion = p_id_inscripcion;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarTallerCompleto` (IN `p_id_taller` INT, IN `p_id_instructor` INT, IN `p_nombre` VARCHAR(100), IN `p_descripcion` TEXT, IN `p_duracion` VARCHAR(50))   BEGIN
  UPDATE talleres
  SET id_instructor = p_id_instructor, nombre = p_nombre, descripcion = p_descripcion, duracion = p_duracion
  WHERE id_talleres = p_id_taller;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarTallerDescripcion` (IN `p_id_taller` INT, IN `p_nombre` VARCHAR(100), IN `p_descripcion` TEXT)   BEGIN
  UPDATE talleres SET nombre = p_nombre, descripcion = p_descripcion WHERE id_talleres = p_id_taller;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarUsuario` (IN `p_id_usuario` INT, IN `p_nombre` VARCHAR(100), IN `p_correo` VARCHAR(100))   BEGIN
  UPDATE usuario SET nombre = p_nombre, correo = p_correo WHERE id_usuario = p_id_usuario;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarAsistenciaPorInscripcion` (IN `p_id_inscripcion` INT)   BEGIN
  SELECT * FROM asistencia WHERE id_inscripcion = p_id_inscripcion;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarCalificacionesPorInscripcion` (IN `p_id_inscripcion` INT)   BEGIN
  SELECT * FROM calificacion WHERE id_inscripcion = p_id_inscripcion;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarHorariosPorTaller` (IN `p_id_taller` INT)   BEGIN
  SELECT * FROM horario WHERE id_talleres = p_id_taller;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarInscripcionesPorEstudiante` (IN `p_id_estudiante` INT)   BEGIN
  SELECT * FROM inscripcion WHERE id_estudiante = p_id_estudiante;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarNotificacionesPorUsuario` (IN `p_id_usuario` INT)   BEGIN
  SELECT * FROM notificacion WHERE id_usuario = p_id_usuario;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarTalleresPorInstructor` (IN `p_id_instructor` INT)   BEGIN
  SELECT * FROM talleres WHERE id_instructor = p_id_instructor;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarUsuarios` ()   BEGIN
  SELECT * FROM usuario;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarAsistencia` (IN `p_id_asistencia` INT)   BEGIN
  DELETE FROM asistencia WHERE id_asistencia = p_id_asistencia;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarCalificacion` (IN `p_id_calificacion` INT)   BEGIN
  DELETE FROM calificacion WHERE id_calificacion = p_id_calificacion;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarHorario` (IN `p_id_horario` INT)   BEGIN
  DELETE FROM horario WHERE id_horario = p_id_horario;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarInscripcion` (IN `p_id_inscripcion` INT)   BEGIN
  DELETE FROM inscripcion WHERE id_inscripcion = p_id_inscripcion;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarNotificacion` (IN `p_id_notificacion` INT)   BEGIN
  DELETE FROM notificacion WHERE id_notificacion = p_id_notificacion;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarTaller` (IN `p_id_taller` INT)   BEGIN
  DELETE FROM talleres WHERE id_talleres = p_id_taller;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarUsuario` (IN `p_id_usuario` INT)   BEGIN
  DELETE FROM notificacion WHERE id_usuario = p_id_usuario;
  DELETE FROM inscripcion WHERE id_estudiante = p_id_usuario;
  DELETE FROM talleres WHERE id_instructor = p_id_usuario;
  DELETE FROM usuario WHERE id_usuario = p_id_usuario;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarAsistencia` (IN `p_id_inscripcion` INT, IN `p_fecha` DATE, IN `p_presente` TINYINT)   BEGIN
  INSERT INTO asistencia (id_inscripcion, fecha, presente)
  VALUES (p_id_inscripcion, p_fecha, p_presente);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarCalificacion` (IN `p_id_inscripcion` INT, IN `p_nota` DECIMAL(5,2))   BEGIN
  INSERT INTO calificacion (id_inscripcion, nota)
  VALUES (p_id_inscripcion, p_nota);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarHorario` (IN `p_dia` VARCHAR(20), IN `p_hora_inicio` TIME, IN `p_hora_fin` TIME, IN `p_id_taller` INT)   BEGIN
  INSERT INTO horario (dia, hora_inicio, hora_fin, id_talleres)
  VALUES (p_dia, p_hora_inicio, p_hora_fin, p_id_taller);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarInscripcion` (IN `p_id_estudiante` INT, IN `p_id_taller` INT, IN `p_fecha` DATE)   BEGIN
  INSERT INTO inscripcion (id_estudiante, id_talleres, fecha)
  VALUES (p_id_estudiante, p_id_taller, p_fecha);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarNotificacion` (IN `p_mensaje` TEXT, IN `p_fecha` DATE, IN `p_id_usuario` INT)   BEGIN
  INSERT INTO notificacion (mensaje, fecha, id_usuario)
  VALUES (p_mensaje, p_fecha, p_id_usuario);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarTaller` (IN `p_id_instructor` INT, IN `p_nombre` VARCHAR(100), IN `p_descripcion` TEXT, IN `p_duracion` VARCHAR(50))   BEGIN
  INSERT INTO talleres (id_instructor, nombre, descripcion, duracion)
  VALUES (p_id_instructor, p_nombre, p_descripcion, p_duracion);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarUsuario` (IN `p_nombre` VARCHAR(100), IN `p_tipo_usuario` VARCHAR(50), IN `p_correo` VARCHAR(100), IN `p_contraseña` VARCHAR(100), IN `p_fecha_registro` DATE)   BEGIN
  INSERT INTO usuario (nombre, tipo_usuario, correo, contraseña, fecha_registro)
  VALUES (p_nombre, p_tipo_usuario, p_correo, p_contraseña, p_fecha_registro);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Login` (IN `p_correo` VARCHAR(100))   BEGIN
  SELECT 
    id_usuario,
    nombre,
    tipo_usuario AS rol,
    correo,
    contraseña,
    SHA2(CONCAT(id_usuario, correo), 512) AS IDToken
  FROM usuario
  WHERE correo = p_correo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MarcarPresente` (IN `p_id_asistencia` INT)   BEGIN
  UPDATE asistencia SET presente = 1 WHERE id_asistencia = p_id_asistencia;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `id_asistencia` int(11) NOT NULL,
  `id_inscripcion` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `presente` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacion`
--

CREATE TABLE `calificacion` (
  `id_calificacion` int(11) NOT NULL,
  `id_inscripcion` int(11) NOT NULL,
  `nota` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `id_horario` int(11) NOT NULL,
  `dia` varchar(20) NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `id_talleres` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion`
--

CREATE TABLE `inscripcion` (
  `id_inscripcion` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL,
  `id_talleres` int(11) NOT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion`
--

CREATE TABLE `notificacion` (
  `id_notificacion` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha` date DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `talleres`
--

CREATE TABLE `talleres` (
  `id_talleres` int(11) NOT NULL,
  `id_instructor` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `duracion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo_usuario` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contraseña` varchar(100) NOT NULL,
  `fecha_registro` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD PRIMARY KEY (`id_notificacion`),
  ADD KEY `id_usuario` (`id_usuario`);

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
  ADD UNIQUE KEY `correo_UNIQUE` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `id_asistencia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  MODIFY `id_calificacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `id_inscripcion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `talleres`
--
ALTER TABLE `talleres`
  MODIFY `id_talleres` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- Filtros para la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD CONSTRAINT `notificacion_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `talleres`
--
ALTER TABLE `talleres`
  ADD CONSTRAINT `talleres_ibfk_1` FOREIGN KEY (`id_instructor`) REFERENCES `usuario` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
