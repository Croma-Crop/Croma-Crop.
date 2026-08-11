-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-07-2026 a las 23:22:45
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
-- Base de datos: `srgsi`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE `equipo` (
  `numero_serie` varchar(50) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `estado` enum('operativo','en_reparacion','de_baja','prestado') NOT NULL DEFAULT 'operativo',
  `id_salon` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidencia`
--

CREATE TABLE `incidencia` (
  `id_incidencia` int(11) NOT NULL,
  `tipo` enum('incidencia','solicitud de software') NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `descripcion` text NOT NULL,
  `prioridad` enum('alta','media','baja') DEFAULT NULL,
  `estado` enum('Pendiente','En proceso','Resuelto') NOT NULL DEFAULT 'Pendiente',
  `fecha_limite` date DEFAULT NULL,
  `documento_solicitante` varchar(12) NOT NULL,
  `documento_tecnico` varchar(12) DEFAULT NULL,
  `numero_serie` varchar(50) DEFAULT NULL,
  `id_registro_origen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intervencion`
--

CREATE TABLE `intervencion` (
  `id_intervencion` int(11) NOT NULL,
  `numero_serie` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_diario`
--

CREATE TABLE `registro_diario` (
  `id_registro` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `documento_solicitante` varchar(12) NOT NULL,
  `id_salon` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salon`
--

CREATE TABLE `salon` (
  `id_salon` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `tipo` enum('laboratorio','taller') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicita`
--

CREATE TABLE `solicita` (
  `documento` varchar(12) NOT NULL,
  `id_salon` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `documento` varchar(12) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('solicitante','tecnico','administrador') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `verifica`
--

CREATE TABLE `verifica` (
  `id_registro` int(11) NOT NULL,
  `numero_serie` varchar(50) NOT NULL,
  `observacion_estado` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD PRIMARY KEY (`numero_serie`),
  ADD KEY `fk_equipo_salon` (`id_salon`);

--
-- Indices de la tabla `incidencia`
--
ALTER TABLE `incidencia`
  ADD PRIMARY KEY (`id_incidencia`),
  ADD KEY `fk_incidencia_solicitante` (`documento_solicitante`),
  ADD KEY `fk_incidencia_tecnico` (`documento_tecnico`),
  ADD KEY `fk_incidencia_equipo` (`numero_serie`),
  ADD KEY `fk_incidencia_registro` (`id_registro_origen`);

--
-- Indices de la tabla `intervencion`
--
ALTER TABLE `intervencion`
  ADD PRIMARY KEY (`id_intervencion`),
  ADD KEY `fk_intervencion_equipo` (`numero_serie`);

--
-- Indices de la tabla `registro_diario`
--
ALTER TABLE `registro_diario`
  ADD PRIMARY KEY (`id_registro`),
  ADD KEY `fk_registro_solicitante` (`documento_solicitante`),
  ADD KEY `fk_registro_salon` (`id_salon`);

--
-- Indices de la tabla `salon`
--
ALTER TABLE `salon`
  ADD PRIMARY KEY (`id_salon`),
  ADD UNIQUE KEY `uq_salon_nombre` (`nombre`);

--
-- Indices de la tabla `solicita`
--
ALTER TABLE `solicita`
  ADD PRIMARY KEY (`documento`,`id_salon`,`fecha`,`hora_inicio`),
  ADD KEY `fk_solicita_salon` (`id_salon`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`documento`);

--
-- Indices de la tabla `verifica`
--
ALTER TABLE `verifica`
  ADD PRIMARY KEY (`id_registro`,`numero_serie`),
  ADD KEY `fk_verifica_equipo` (`numero_serie`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `incidencia`
--
ALTER TABLE `incidencia`
  MODIFY `id_incidencia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `intervencion`
--
ALTER TABLE `intervencion`
  MODIFY `id_intervencion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro_diario`
--
ALTER TABLE `registro_diario`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `salon`
--
ALTER TABLE `salon`
  MODIFY `id_salon` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD CONSTRAINT `fk_equipo_salon` FOREIGN KEY (`id_salon`) REFERENCES `salon` (`id_salon`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `incidencia`
--
ALTER TABLE `incidencia`
  ADD CONSTRAINT `fk_incidencia_equipo` FOREIGN KEY (`numero_serie`) REFERENCES `equipo` (`numero_serie`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_incidencia_registro` FOREIGN KEY (`id_registro_origen`) REFERENCES `registro_diario` (`id_registro`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_incidencia_solicitante` FOREIGN KEY (`documento_solicitante`) REFERENCES `usuario` (`documento`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_incidencia_tecnico` FOREIGN KEY (`documento_tecnico`) REFERENCES `usuario` (`documento`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `intervencion`
--
ALTER TABLE `intervencion`
  ADD CONSTRAINT `fk_intervencion_equipo` FOREIGN KEY (`numero_serie`) REFERENCES `equipo` (`numero_serie`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `registro_diario`
--
ALTER TABLE `registro_diario`
  ADD CONSTRAINT `fk_registro_salon` FOREIGN KEY (`id_salon`) REFERENCES `salon` (`id_salon`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_registro_solicitante` FOREIGN KEY (`documento_solicitante`) REFERENCES `usuario` (`documento`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `solicita`
--
ALTER TABLE `solicita`
  ADD CONSTRAINT `fk_solicita_salon` FOREIGN KEY (`id_salon`) REFERENCES `salon` (`id_salon`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_solicita_usuario` FOREIGN KEY (`documento`) REFERENCES `usuario` (`documento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `verifica`
--
ALTER TABLE `verifica`
  ADD CONSTRAINT `fk_verifica_equipo` FOREIGN KEY (`numero_serie`) REFERENCES `equipo` (`numero_serie`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_verifica_registro` FOREIGN KEY (`id_registro`) REFERENCES `registro_diario` (`id_registro`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
