
CREATE DATABASE IF NOT EXISTS `sgrsi`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE `sgrsi`;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-10-2026 a las 20:17:39
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
-- Base de datos: `sgrsi`
--

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
  `descripcion` text NOT NULL,
  `prioridad` enum('Sin asignar','Baja','Media','Alta') NOT NULL DEFAULT 'Sin asignar',
  `cedula_solicitante` varchar(12) NOT NULL,
  `cedula_tecnico` varchar(12) DEFAULT NULL,
  `numero_serie` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `incidencia`
--

INSERT INTO `incidencia` (`id_incidencia`, `fecha`, `fecha_limite`, `turno`, `estado`, `descripcion`, `prioridad`, `cedula_solicitante`, `cedula_tecnico`, `numero_serie`) VALUES
(16, '2026-10-11', NULL, 'matutino', 'En proceso', 'UOJOJOJOY NOOOO MI MILANESA', 'Sin asignar', '66666666', 'A2222222', '1332784'),
(17, '2026-10-11', NULL, 'matutino', 'Pendiente', 'Carlos se hizo el que sabia de programar y rompio el kernel', 'Alta', '66666666', NULL, '1332784'),
(20, '2026-10-12', NULL, 'matutino', 'Resuelto', 'UDWFHQOFHQWOFQWFQ', 'Sin asignar', 'A2222222', NULL, '60S3X54'),
(21, '2026-10-19', NULL, 'matutino', 'Pendiente', 'Alguien puso la compu en arabe', 'Sin asignar', '33333333', NULL, '9R12B18'),
(22, '2026-10-21', NULL, 'matutino', 'Pendiente', 'Exploto el cable de alimentacion', 'Sin asignar', '33333333', NULL, '9R12B18');

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
(2, '123', '2026-09-01', 'wachin2', NULL, NULL),
(3, '60S3X54', '2026-10-12', 'Incidencia #20 (Computadora): UDWFHQOFHQWOFQWFQ', NULL, NULL);

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
('123', 'PC 1', 'HP', 'ProDesk 400 G7', 'en_reparacion', 0, 5, NULL),
('123123213', 'PC 2', 'Raspberry PI', 'Raspberry', 'en_reparacion', 0, 2, NULL),
('12FYU53', 'PC 8', 'Xiaomi', 'Sokolov', 'en_reparacion', 0, 16, NULL),
('1332784', 'PC 8', 'Acme', 'Hp250', 'operativo', 0, 2, NULL),
('138U75H', 'PC 5', 'Lenovo', 'Raspberry', 'operativo', 0, 15, NULL),
('19UR80', 'PC 3', 'Croma', 'MOS17', 'de_baja', 0, 12, NULL),
('43UR790', 'PC 1', 'LG', 'Meconium', 'operativo', 0, 10, NULL),
('60S3X54', 'PC 10', 'Mac', 'incubus', 'operativo', 1, 15, NULL),
('87UI90', 'PC 6', 'Panavox', 'Abaddon', 'operativo', 0, 10, NULL),
('9R12B18', 'PC 7', 'Raspberry PI', 'Ipecac', 'operativo', 0, 11, NULL),
('RX2074C', 'PC 4', 'Acme', 'GBD8', 'operativo', 0, 12, NULL);

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
(4, '2026-10-03', '01:27:00', '04:30:00', '10101010', 13),
(5, '2026-10-09', '02:28:00', '04:28:00', '33333333', 10),
(6, '2026-10-13', '19:16:00', '21:18:00', 'A3333333', 10),
(7, '2026-10-21', '09:25:00', '11:50:00', '33333333', 11);

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
(2, 'Taller 1', 'taller'),
(5, 'Taller 2', 'taller'),
(10, 'Taller 3', 'taller'),
(11, 'Taller 4', 'taller'),
(12, 'Laboratorio 1', 'laboratorio'),
(13, 'Laboratorio 2', 'laboratorio'),
(14, 'Laboratorio 3', 'laboratorio'),
(15, 'Laboratorio 4', 'laboratorio'),
(16, 'Laboratorio 5', 'laboratorio');

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
(7, 'Instalacion de Software', 'tux', 'Che le pueden poner, no se, Arch o fedora?', NULL, NULL, NULL, 'Resuelto', '66666666', '22222222', 2),
(8, 'Instalacion de Software', 'HM Linux', 'Me gustaria tener un equipo con este sistema', NULL, NULL, NULL, 'Pendiente', '33333333', NULL, 2),
(9, 'Reserva de Salon', NULL, 'Tienen prueba de sociología', '2026-10-23', '07:00:00', '08:30:00', 'Pendiente', '33333333', NULL, 5);

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
('11111111', 'Admin', 'Prueba', '$2y$10$vFPWp40ou9JX8PZgPn.pUOKIBc3hS9u.5paetrhp9uIaNNBzyqtmG', 'administrador', 'aprobado'),
('22222222', 'Tecnico', 'Prueba', '$2y$10$cgAqA4wcamW3Os9TIz0O0uO4YlZPHb0GGXFvk232QAdMh9rXuLZbO', 'tecnico', 'aprobado'),
('33333333', 'Solicitante', 'Prueba', '$2y$10$YJHfrv.tuRD8/rpcCNZRBuOUL90za4Wdcnq6aQnV.EwMMssJUlCKe', 'solicitante', 'aprobado');

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
('A1111111', 'Admin', 'Extranjero', '$2y$10$h33AxHb87.ULDz0gdG83bO6k61ZPGAN5fO6lksjJFCzAvP4Ra5nze', 'administrador', 'aprobado'),
('A2222222', 'Tecnico', 'Extranjero', '$2y$10$ozYdcebLoVzSk/paECXElecmieGJ2unbYBLMJj/LEegKTGuiOkjS2', 'tecnico', 'aprobado'),
('A3333333', 'Solicitante', 'Extranjero', '$2y$10$Ix4I849y5KFq7giIFYD8zOBY28Q1yg7m2w5zRNUmqKfIUOXoM0Ka2', 'solicitante', 'aprobado');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `incidencia`
--
ALTER TABLE `incidencia`
  ADD PRIMARY KEY (`id_incidencia`),
  ADD KEY `fk_incidencia_solicitante` (`cedula_solicitante`),
  ADD KEY `fk_incidencia_tecnico` (`cedula_tecnico`),
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
-- Indices de la tabla `usuarioextranjero`
--
ALTER TABLE `usuarioextranjero`
  ADD PRIMARY KEY (`documento`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `incidencia`
--
ALTER TABLE `incidencia`
  MODIFY `id_incidencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `intervencion`
--
ALTER TABLE `intervencion`
  MODIFY `id_intervencion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `registro_diario`
--
ALTER TABLE `registro_diario`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `salon`
--
ALTER TABLE `salon`
  MODIFY `id_salon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `incidencia`
--
ALTER TABLE `incidencia`
  ADD CONSTRAINT `fk_incidencia_inventario` FOREIGN KEY (`numero_serie`) REFERENCES `inventario` (`numero_serie`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `intervencion`
--
ALTER TABLE `intervencion`
  ADD CONSTRAINT `intervencion_ibfk_1` FOREIGN KEY (`numero_serie`) REFERENCES `inventario` (`numero_serie`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `fk_inventario_espacio` FOREIGN KEY (`id_salon`) REFERENCES `salon` (`id_salon`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `registro_diario`
--
ALTER TABLE `registro_diario`
  ADD CONSTRAINT `fk_registro_espacio` FOREIGN KEY (`id_salon`) REFERENCES `salon` (`id_salon`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD CONSTRAINT `fk_solicitud_espacio` FOREIGN KEY (`id_salon`) REFERENCES `salon` (`id_salon`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
