
USE talleresescolares;

-- PROCEDIMIENTOS USUARIO
DELIMITER //
CREATE PROCEDURE InsertarUsuario(IN p_nombre VARCHAR(100), IN p_tipo_usuario VARCHAR(50), IN p_correo VARCHAR(100), IN p_contraseña VARCHAR(100), IN p_fecha_registro DATE)
BEGIN
  INSERT INTO usuario (nombre, tipo_usuario, correo, contraseña, fecha_registro)
  VALUES (p_nombre, p_tipo_usuario, p_correo, p_contraseña, p_fecha_registro);
END //

CREATE PROCEDURE ActualizarUsuario(IN p_id_usuario INT, IN p_nombre VARCHAR(100), IN p_correo VARCHAR(100))
BEGIN
  UPDATE usuario SET nombre = p_nombre, correo = p_correo WHERE id_usuario = p_id_usuario;
END //

CREATE PROCEDURE ConsultarUsuarios()
BEGIN
  SELECT * FROM usuario;
END //

CREATE PROCEDURE EliminarUsuario(IN p_id_usuario INT)
BEGIN
  DELETE FROM notificacion WHERE id_usuario = p_id_usuario;
  DELETE FROM inscripcion WHERE id_estudiante = p_id_usuario;
  DELETE FROM talleres WHERE id_instructor = p_id_usuario;
  DELETE FROM usuario WHERE id_usuario = p_id_usuario;
END //

-- PROCEDIMIENTOS TALLERES
CREATE PROCEDURE InsertarTaller(IN p_id_instructor INT, IN p_nombre VARCHAR(100), IN p_descripcion TEXT, IN p_duracion VARCHAR(50))
BEGIN
  INSERT INTO talleres (id_instructor, nombre, descripcion, duracion)
  VALUES (p_id_instructor, p_nombre, p_descripcion, p_duracion);
END //

CREATE PROCEDURE ActualizarTallerCompleto(IN p_id_taller INT, IN p_id_instructor INT, IN p_nombre VARCHAR(100), IN p_descripcion TEXT, IN p_duracion VARCHAR(50))
BEGIN
  UPDATE talleres
  SET id_instructor = p_id_instructor, nombre = p_nombre, descripcion = p_descripcion, duracion = p_duracion
  WHERE id_talleres = p_id_taller;
END //

CREATE PROCEDURE ActualizarTallerDescripcion(IN p_id_taller INT, IN p_nombre VARCHAR(100), IN p_descripcion TEXT)
BEGIN
  UPDATE talleres SET nombre = p_nombre, descripcion = p_descripcion WHERE id_talleres = p_id_taller;
END //

CREATE PROCEDURE ConsultarTalleresPorInstructor(IN p_id_instructor INT)
BEGIN
  SELECT * FROM talleres WHERE id_instructor = p_id_instructor;
END //

CREATE PROCEDURE EliminarTaller(IN p_id_taller INT)
BEGIN
  DELETE FROM talleres WHERE id_talleres = p_id_taller;
END //

-- PROCEDIMIENTOS HORARIO
CREATE PROCEDURE InsertarHorario(IN p_dia VARCHAR(20), IN p_hora_inicio TIME, IN p_hora_fin TIME, IN p_id_taller INT)
BEGIN
  INSERT INTO horario (dia, hora_inicio, hora_fin, id_talleres)
  VALUES (p_dia, p_hora_inicio, p_hora_fin, p_id_taller);
END //

CREATE PROCEDURE ActualizarHorarioCompleto(IN p_id_horario INT, IN p_dia VARCHAR(20), IN p_hora_inicio TIME, IN p_hora_fin TIME, IN p_id_taller INT)
BEGIN
  UPDATE horario
  SET dia = p_dia, hora_inicio = p_hora_inicio, hora_fin = p_hora_fin, id_talleres = p_id_taller
  WHERE id_horario = p_id_horario;
END //

CREATE PROCEDURE ActualizarHorarioHoras(IN p_id_horario INT, IN p_hora_inicio TIME, IN p_hora_fin TIME)
BEGIN
  UPDATE horario SET hora_inicio = p_hora_inicio, hora_fin = p_hora_fin WHERE id_horario = p_id_horario;
END //

CREATE PROCEDURE ConsultarHorariosPorTaller(IN p_id_taller INT)
BEGIN
  SELECT * FROM horario WHERE id_talleres = p_id_taller;
END //

CREATE PROCEDURE EliminarHorario(IN p_id_horario INT)
BEGIN
  DELETE FROM horario WHERE id_horario = p_id_horario;
END //

-- PROCEDIMIENTOS INSCRIPCIÓN
CREATE PROCEDURE InsertarInscripcion(IN p_id_estudiante INT, IN p_id_taller INT, IN p_fecha DATE)
BEGIN
  INSERT INTO inscripcion (id_estudiante, id_talleres, fecha)
  VALUES (p_id_estudiante, p_id_taller, p_fecha);
END //

CREATE PROCEDURE ActualizarInscripcionCompleta(IN p_id_inscripcion INT, IN p_id_estudiante INT, IN p_id_taller INT, IN p_fecha DATE)
BEGIN
  UPDATE inscripcion SET id_estudiante = p_id_estudiante, id_talleres = p_id_taller, fecha = p_fecha
  WHERE id_inscripcion = p_id_inscripcion;
END //

CREATE PROCEDURE ConsultarInscripcionesPorEstudiante(IN p_id_estudiante INT)
BEGIN
  SELECT * FROM inscripcion WHERE id_estudiante = p_id_estudiante;
END //

CREATE PROCEDURE EliminarInscripcion(IN p_id_inscripcion INT)
BEGIN
  DELETE FROM inscripcion WHERE id_inscripcion = p_id_inscripcion;
END //

-- PROCEDIMIENTOS ASISTENCIA
CREATE PROCEDURE InsertarAsistencia(IN p_id_inscripcion INT, IN p_fecha DATE, IN p_presente TINYINT)
BEGIN
  INSERT INTO asistencia (id_inscripcion, fecha, presente)
  VALUES (p_id_inscripcion, p_fecha, p_presente);
END //

CREATE PROCEDURE ActualizarAsistenciaCompleta(IN p_id_asistencia INT, IN p_fecha DATE, IN p_presente TINYINT)
BEGIN
  UPDATE asistencia SET fecha = p_fecha, presente = p_presente WHERE id_asistencia = p_id_asistencia;
END //

CREATE PROCEDURE MarcarPresente(IN p_id_asistencia INT)
BEGIN
  UPDATE asistencia SET presente = 1 WHERE id_asistencia = p_id_asistencia;
END //

CREATE PROCEDURE ConsultarAsistenciaPorInscripcion(IN p_id_inscripcion INT)
BEGIN
  SELECT * FROM asistencia WHERE id_inscripcion = p_id_inscripcion;
END //

CREATE PROCEDURE EliminarAsistencia(IN p_id_asistencia INT)
BEGIN
  DELETE FROM asistencia WHERE id_asistencia = p_id_asistencia;
END //

-- PROCEDIMIENTOS CALIFICACIÓN
CREATE PROCEDURE InsertarCalificacion(IN p_id_inscripcion INT, IN p_nota DECIMAL(5,2))
BEGIN
  INSERT INTO calificacion (id_inscripcion, nota)
  VALUES (p_id_inscripcion, p_nota);
END //

CREATE PROCEDURE ActualizarCalificacion(IN p_id_calificacion INT, IN p_nota DECIMAL(5,2))
BEGIN
  UPDATE calificacion SET nota = p_nota WHERE id_calificacion = p_id_calificacion;
END //

CREATE PROCEDURE ConsultarCalificacionesPorInscripcion(IN p_id_inscripcion INT)
BEGIN
  SELECT * FROM calificacion WHERE id_inscripcion = p_id_inscripcion;
END //

CREATE PROCEDURE EliminarCalificacion(IN p_id_calificacion INT)
BEGIN
  DELETE FROM calificacion WHERE id_calificacion = p_id_calificacion;
END //

-- PROCEDIMIENTOS NOTIFICACIÓN
CREATE PROCEDURE InsertarNotificacion(IN p_mensaje TEXT, IN p_fecha DATE, IN p_id_usuario INT)
BEGIN
  INSERT INTO notificacion (mensaje, fecha, id_usuario)
  VALUES (p_mensaje, p_fecha, p_id_usuario);
END //

CREATE PROCEDURE ConsultarNotificacionesPorUsuario(IN p_id_usuario INT)
BEGIN
  SELECT * FROM notificacion WHERE id_usuario = p_id_usuario;
END //

CREATE PROCEDURE EliminarNotificacion(IN p_id_notificacion INT)
BEGIN
  DELETE FROM notificacion WHERE id_notificacion = p_id_notificacion;
END //
DELIMITER ;
