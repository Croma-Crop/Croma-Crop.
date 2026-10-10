-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-10-2026 a las 03:45:03
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sgrsi`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestiona`
--

CREATE TABLE `gestiona` (
  `cedula_tecnico` varchar(12) NOT NULL,
  `numero_serie` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidencia`
--

CREATE TABLE `incidencia` (
  `id_incidencia` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `fecha_limite` date DEFAULT NULL,
  `turno` enum('matutino','vespertino','nocturno') DEFAULT NULL,
  `estado` enum('Pendiente','En proceso','Resuelto') NOT NULL DEFAULT 'Pendiente',
  `tipo` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `prioridad` enum('Sin asignar','Baja','Media','Alta') NOT NULL DEFAULT 'Sin asignar',
  `cedula_solicitante` varchar(12) NOT NULL,
  `cedula_tecnico` varchar(12) DEFAULT NULL,
  `id_registro_origen` int(11) DEFAULT NULL,
  `numero_serie` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `incidencia`
--

INSERT INTO `incidencia` (`id_incidencia`, `fecha`, `fecha_limite`, `turno`, `estado`, `tipo`, `descripcion`, `prioridad`, `cedula_solicitante`, `cedula_tecnico`, `id_registro_origen`, `numero_serie`) VALUES
(3, '2026-08-22', '2026-11-06', 'nocturno', 'En proceso', 'Televisor', 'wachin', 'Alta', '33333333', '22222222', NULL, '123'),
(4, '2026-08-23', NULL, 'vespertino', 'Resuelto', 'Periferico', 'se rompio mal ahi mano', 'Media', '33333333', '22222222', NULL, '123'),
(5, '2026-09-28', NULL, 'matutino', 'Pendiente', 'Computadora', 'assasa', 'Sin asignar', '66666666', NULL, NULL, '123');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intervencion`
--

CREATE TABLE `intervencion` (
  `id_intervencion` int(11) NOT NULL,
  `numero_serie` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` text NOT NULL,
  `tecnico` varchar(12) DEFAULT NULL,
  `solucion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `intervencion`
--

INSERT INTO `intervencion` (`id_intervencion`, `numero_serie`, `fecha`, `descripcion`, `tecnico`, `solucion`) VALUES
(1, '123', '2026-08-13', 'wachin', NULL, NULL),
(2, '123', '2026-09-01', 'wachin2', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `numero_serie` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `estado` enum('operativo','en_reparacion','de_baja','prestado') NOT NULL DEFAULT 'operativo',
  `numero_intervenciones` int(11) NOT NULL DEFAULT 0,
  `id_salon` int(11) NOT NULL,
  `cedula_administrador` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`numero_serie`, `nombre`, `marca`, `modelo`, `estado`, `numero_intervenciones`, `id_salon`, `cedula_administrador`) VALUES
('123', 'Computadora de escritorio', 'HP', 'ProDesk 400 G7', 'en_reparacion', 2, 5, NULL),
('123123213', 'Proyector', 'Epson', 'PowerLite E20', 'en_reparacion', 0, 2, NULL),
('1245', 'Monitor', 'Samsung', 'S24R350', 'de_baja', 0, 5, NULL),
('343', 'Televisor', 'LG', '43UR7800', 'en_reparacion', 0, 10, NULL),
('555555', 'Impresora', 'Brother', 'HL-1212W', 'de_baja', 0, 11, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_diario`
--

CREATE TABLE `registro_diario` (
  `id_registro` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora_entrada` time NOT NULL,
  `hora_salida` time NOT NULL,
  `cedula_solicitante` varchar(12) NOT NULL,
  `id_salon` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `registro_diario`
--

INSERT INTO `registro_diario` (`id_registro`, `fecha`, `hora_entrada`, `hora_salida`, `cedula_solicitante`, `id_salon`) VALUES
(1, '2026-08-06', '21:40:00', '00:42:00', '56357055', 14),
(2, '2026-08-20', '00:42:00', '22:40:00', '56357055', 5),
(3, '2026-10-11', '13:13:00', '13:23:00', '33333333', 2),
(4, '2026-10-03', '01:27:00', '04:30:00', '10101010', 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salon`
--

CREATE TABLE `salon` (
  `id_salon` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `tipo` enum('laboratorio','taller') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `salon`
--

INSERT INTO `salon` (`id_salon`, `nombre`, `tipo`) VALUES
(2, 'T1', 'taller'),
(5, 'T2', 'taller'),
(10, 'T3', 'taller'),
(11, 'T4', 'taller'),
(12, 'L1', 'laboratorio'),
(13, 'L2', 'laboratorio'),
(14, 'L3', 'laboratorio'),
(15, 'L4', 'laboratorio'),
(16, 'L5', 'laboratorio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud`
--

CREATE TABLE `solicitud` (
  `id_solicitud` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `nombre_software` varchar(100) DEFAULT NULL,
  `descripcion` text NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  `estado` enum('Pendiente','En proceso','Resuelto','Cancelada','Rechazada') NOT NULL DEFAULT 'Pendiente',
  `cedula_solicitante` varchar(12) NOT NULL,
  `cedula_tecnico` varchar(12) DEFAULT NULL,
  `id_salon` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `solicitud`
--

INSERT INTO `solicitud` (`id_solicitud`, `tipo`, `nombre_software`, `descripcion`, `fecha`, `hora_inicio`, `hora_fin`, `estado`, `cedula_solicitante`, `cedula_tecnico`, `id_salon`) VALUES
(4, 'Instalacion de Software', 'AutoCAD', 'Se necesita para la materia de dibujo tecnico', NULL, NULL, NULL, 'Pendiente', '66666666', NULL, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `documento` varchar(12) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('solicitante','tecnico','administrador') NOT NULL,
  `estado` enum('pendiente','aprobado','inactivo','rechazado') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`documento`, `nombre`, `apellido`, `contrasena`, `rol`, `estado`) VALUES
('10101010', 'wachin', 'putito', '$2y$10$kned0SrJQxZ7K0j.OObwquVEMlYIXPV4cQyIxa.orH5Cia80jgy4i', 'solicitante', 'aprobado'),
('12312313', 'asdasd', 'asdasd', '$2y$10$w8vlbg6FW1E.5LSJD26wPuv/hZMijDQdyDdU41QkPLeidSg53Uyoq', 'tecnico', 'aprobado'),
('12312322', 'as', 'ElEnseñador', '$2y$10$IRg3eBMbriJZlq/ey5kdfe/ZPjBd.ns7ByxD10sj675IVjlThx476', 'tecnico', 'pendiente'),
('22222222', 'as', 'ffffffffffffffffffffffffff', '$2y$10$n6RwiFPOxLL5O4fBVH3Or.cCL0E29lp7ViUUzHdKdcwWgemvXKTeG', 'tecnico', 'aprobado'),
('23232323', 'asasaasas', 'asassa', '$2y$10$I64sUpp.YmJpc/q4ogn4pugKLAjvVKJa2yXDZZQbm/QNstSV28UrS', 'tecnico', 'aprobado'),
('32801287', 'asduhadhuidaihuasdhuis', 'oñashuashuilad', '$2y$10$HDka4wufQS77K90xwxRJ.OA7LMM1/7DGazYwdQiuncNx3TfeUIDLu', 'solicitante', 'aprobado'),
('33333333', 'asd', 'fffffffffffffffffffffffffffffffffffffff', '$2y$10$GMCVFN7HoZBUTQ67nRYHWOPrbyEXDpwwuk1ZR2P2q5Wbpe4Ys37he', 'solicitante', 'aprobado'),
('44444444', 'asdasd', 'fa', '$2y$10$22v8A13FThdgC8DdAdF48eT4dRP7X8jmUeqOEymr27vUAXnc8Ohlm', 'solicitante', 'aprobado'),
('44444445', 'asdasd', 'asd', '$2y$10$42mAottiCA3Ffdsmv4B9MOVNdYn80aKMRHYCD6Bs9N1WyveVnxU8y', 'tecnico', 'aprobado'),
('56357055', 'Juan', 'ElPROFE', '$2y$10$oBB4QN2HIOO.ptHn4d9A9OMu1wQChPN1DW014Cxg4/OPMFJ.ip/V2', 'solicitante', 'aprobado'),
('66666666', 'a', 'Profesor', '$2y$10$egHmOTuLrlVAalI0KMeUw./ueo.bdjbsCm4N1fpyNJfHvklACj6GO', 'administrador', 'aprobado'),
('67676767', 'asasas', 'asdasdasd', '$2y$10$jEeziqlhBSRqWPkrf.0dMOb0txtyONdZ0.rxED6VejxavtQQk5mpa', 'administrador', 'aprobado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarioextranjero`
--

CREATE TABLE `usuarioextranjero` (
  `documento` varchar(12) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('solicitante','tecnico','administrador') NOT NULL,
  `estado` enum('pendiente','aprobado','inactivo','rechazado') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarioextranjero`
--

INSERT INTO `usuarioextranjero` (`documento`, `nombre`, `apellido`, `contrasena`, `rol`, `estado`) VALUES
('A1111111', 'estoesun', 'ejemplo', '$2y$10$vQkxOIVwr6bhLVfP66ndQ.x84u0zLkKgnNN3qFTVbQ9LTsheDajzi', 'solicitante', 'aprobado'),
('A3333333', 'as', 'asdad', '$2y$10$3JaF4.Kw.9eywu2nOG6qFOj7pbGKSKlix.T3AUsYq16p3p8HXyCuy', 'tecnico', 'aprobado'),
('a8888888', 'asdasd', 'asdasd', '$2y$10$1xlCI2zFLPTZBKvxvhBkGutUzoTyEWIfhS8M7QWGqEoxt9p9dJcAi', 'tecnico', 'aprobado'),
('A1010101', 'jjjjj', 'asdasd', '$2y$10$SMDVZUxZLYKP/N0pK7FuBe6FKMJKs5Q471aUlAyxjioFoM9YnTfHa', 'tecnico', 'aprobado'),
('A3232323', 'asdasd', 'asdas', '$2y$10$oDRfR1YtXGkFfTkLlVTS2.Qb7XZqnQDMgY7xxSeRb4cTpIf.jClvS', 'administrador', 'aprobado'),
('A7878787', 'asdasd', 'ElEnseñador', '$2y$10$x9SSzrjYgspQDlstKARuy.c/P5qE6GCvpHMH6bDxNl5BbXYsqDhBW', 'administrador', 'aprobado'),
('P6666666', 'sivesesto', 'medebesunalfajor', '$2y$10$WnBm7mtGNZ2swviz5nD0Qu0ZpY/zUwz5n4FqZLtziXwOmr8P7buXG', 'administrador', 'pendiente');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `gestiona`
--
ALTER TABLE `gestiona`
  ADD PRIMARY KEY (`cedula_tecnico`,`numero_serie`),
  ADD KEY `fk_gestiona_inventario` (`numero_serie`);

--
-- Indices de la tabla `incidencia`
--
ALTER TABLE `incidencia`
  ADD PRIMARY KEY (`id_incidencia`),
  ADD KEY `fk_incidencia_solicitante` (`cedula_solicitante`),
  ADD KEY `fk_incidencia_tecnico` (`cedula_tecnico`),
  ADD KEY `fk_incidencia_registro` (`id_registro_origen`),
  ADD KEY `fk_incidencia_inventario` (`numero_serie`);

--
-- Indices de la tabla `intervencion`
--
ALTER TABLE `intervencion`
  ADD PRIMARY KEY (`id_intervencion`),
  ADD KEY `numero_serie` (`numero_serie`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`numero_serie`),
  ADD KEY `fk_inventario_espacio` (`id_salon`),
  ADD KEY `fk_inventario_administrador` (`cedula_administrador`);

--
-- Indices de la tabla `registro_diario`
--
ALTER TABLE `registro_diario`
  ADD PRIMARY KEY (`id_registro`),
  ADD KEY `fk_registro_solicitante` (`cedula_solicitante`),
  ADD KEY `fk_registro_espacio` (`id_salon`);

--
-- Indices de la tabla `salon`
--
ALTER TABLE `salon`
  ADD PRIMARY KEY (`id_salon`),
  ADD UNIQUE KEY `uq_espacio_nombre` (`nombre`);

--
-- Indices de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD PRIMARY KEY (`id_solicitud`),
  ADD KEY `fk_solicitud_solicitante` (`cedula_solicitante`),
  ADD KEY `fk_solicitud_tecnico` (`cedula_tecnico`),
  ADD KEY `fk_solicitud_espacio` (`id_salon`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`documento`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `incidencia`
--
ALTER TABLE `incidencia`
  MODIFY `id_incidencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `intervencion`
--
ALTER TABLE `intervencion`
  MODIFY `id_intervencion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `registro_diario`
--
ALTER TABLE `registro_diario`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `salon`
--
ALTER TABLE `salon`
  MODIFY `id_salon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `gestiona`
--
ALTER TABLE `gestiona`
  ADD CONSTRAINT `fk_gestiona_inventario` FOREIGN KEY (`numero_serie`) REFERENCES `inventario` (`numero_serie`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gestiona_tecnico` FOREIGN KEY (`cedula_tecnico`) REFERENCES `usuario` (`documento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `incidencia`
--
ALTER TABLE `incidencia`
  ADD CONSTRAINT `fk_incidencia_inventario` FOREIGN KEY (`numero_serie`) REFERENCES `inventario` (`numero_serie`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_incidencia_registro` FOREIGN KEY (`id_registro_origen`) REFERENCES `registro_diario` (`id_registro`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_incidencia_solicitante` FOREIGN KEY (`cedula_solicitante`) REFERENCES `usuario` (`documento`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_incidencia_tecnico` FOREIGN KEY (`cedula_tecnico`) REFERENCES `usuario` (`documento`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `intervencion`
--
ALTER TABLE `intervencion`
  ADD CONSTRAINT `intervencion_ibfk_1` FOREIGN KEY (`numero_serie`) REFERENCES `inventario` (`numero_serie`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `fk_inventario_administrador` FOREIGN KEY (`cedula_administrador`) REFERENCES `usuario` (`documento`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inventario_espacio` FOREIGN KEY (`id_salon`) REFERENCES `salon` (`id_salon`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `registro_diario`
--
ALTER TABLE `registro_diario`
  ADD CONSTRAINT `fk_registro_espacio` FOREIGN KEY (`id_salon`) REFERENCES `salon` (`id_salon`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_registro_solicitante` FOREIGN KEY (`cedula_solicitante`) REFERENCES `usuario` (`documento`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD CONSTRAINT `fk_solicitud_espacio` FOREIGN KEY (`id_salon`) REFERENCES `salon` (`id_salon`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_solicitud_solicitante` FOREIGN KEY (`cedula_solicitante`) REFERENCES `usuario` (`documento`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_solicitud_tecnico` FOREIGN KEY (`cedula_tecnico`) REFERENCES `usuario` (`documento`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
