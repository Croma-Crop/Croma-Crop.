-- MariaDB dump 10.19  Distrib 10.4.34-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: sgrsi
-- ------------------------------------------------------
-- Server version	10.4.34-MariaDB-1:10.4.34+maria~ubu2004

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `incidencia`
--

DROP TABLE IF EXISTS `incidencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incidencia` (
  `id_incidencia` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `fecha_limite` date DEFAULT NULL,
  `turno` enum('matutino','vespertino','nocturno') DEFAULT NULL,
  `estado` enum('Pendiente','En proceso','Resuelto') NOT NULL DEFAULT 'Pendiente',
  `descripcion` text NOT NULL,
  `prioridad` enum('Sin asignar','Baja','Media','Alta') NOT NULL DEFAULT 'Sin asignar',
  `cedula_solicitante` varchar(12) NOT NULL,
  `cedula_tecnico` varchar(12) DEFAULT NULL,
  `numero_serie` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_incidencia`),
  KEY `fk_incidencia_solicitante` (`cedula_solicitante`),
  KEY `fk_incidencia_tecnico` (`cedula_tecnico`),
  KEY `fk_incidencia_inventario` (`numero_serie`),
  CONSTRAINT `fk_incidencia_inventario` FOREIGN KEY (`numero_serie`) REFERENCES `inventario` (`numero_serie`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incidencia`
--

LOCK TABLES `incidencia` WRITE;
/*!40000 ALTER TABLE `incidencia` DISABLE KEYS */;
INSERT INTO `incidencia` VALUES (16,'2026-10-11',NULL,'matutino','En proceso','UOJOJOJOY NOOOO MI MILANESA','Sin asignar','66666666','A2222222','1332784'),(17,'2026-10-11',NULL,'matutino','Pendiente','Carlos se hizo el que sabia de programar y rompio el kernel','Alta','66666666',NULL,'1332784'),(20,'2026-10-12',NULL,'matutino','Resuelto','UDWFHQOFHQWOFQWFQ','Sin asignar','A2222222',NULL,'60S3X54'),(21,'2026-10-19',NULL,'matutino','Pendiente','Alguien puso la compu en arabe','Sin asignar','33333333',NULL,'9R12B18'),(22,'2026-10-21',NULL,'matutino','Pendiente','Exploto el cable de alimentacion','Sin asignar','33333333',NULL,'9R12B18');
/*!40000 ALTER TABLE `incidencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `intervencion`
--

DROP TABLE IF EXISTS `intervencion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `intervencion` (
  `id_intervencion` int(11) NOT NULL AUTO_INCREMENT,
  `numero_serie` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` text NOT NULL,
  `tecnico` varchar(12) DEFAULT NULL,
  `solucion` text DEFAULT NULL,
  PRIMARY KEY (`id_intervencion`),
  KEY `numero_serie` (`numero_serie`),
  CONSTRAINT `intervencion_ibfk_1` FOREIGN KEY (`numero_serie`) REFERENCES `inventario` (`numero_serie`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `intervencion`
--

LOCK TABLES `intervencion` WRITE;
/*!40000 ALTER TABLE `intervencion` DISABLE KEYS */;
INSERT INTO `intervencion` VALUES (1,'123','2026-08-13','wachin',NULL,NULL),(2,'123','2026-09-01','wachin2',NULL,NULL),(3,'60S3X54','2026-10-12','Incidencia #20 (Computadora): UDWFHQOFHQWOFQWFQ',NULL,NULL);
/*!40000 ALTER TABLE `intervencion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventario`
--

DROP TABLE IF EXISTS `inventario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventario` (
  `numero_serie` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `estado` enum('operativo','en_reparacion','de_baja','prestado') NOT NULL DEFAULT 'operativo',
  `numero_intervenciones` int(11) NOT NULL DEFAULT 0,
  `id_salon` int(11) NOT NULL,
  `cedula_administrador` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`numero_serie`),
  KEY `fk_inventario_espacio` (`id_salon`),
  KEY `fk_inventario_administrador` (`cedula_administrador`),
  CONSTRAINT `fk_inventario_espacio` FOREIGN KEY (`id_salon`) REFERENCES `salon` (`id_salon`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventario`
--

LOCK TABLES `inventario` WRITE;
/*!40000 ALTER TABLE `inventario` DISABLE KEYS */;
INSERT INTO `inventario` VALUES ('123','PC 1','HP','ProDesk 400 G7','en_reparacion',0,5,NULL),('123123213','PC 2','Raspberry PI','Raspberry','en_reparacion',0,2,NULL),('12FYU53','PC 8','Xiaomi','Sokolov','en_reparacion',0,16,NULL),('1332784','PC 8','Acme','Hp250','operativo',0,2,NULL),('138U75H','PC 5','Lenovo','Raspberry','operativo',0,15,NULL),('19UR80','PC 3','Croma','MOS17','de_baja',0,12,NULL),('43UR790','PC 1','LG','Meconium','operativo',0,10,NULL),('60S3X54','PC 10','Mac','incubus','operativo',1,15,NULL),('87UI90','PC 6','Panavox','Abaddon','operativo',0,10,NULL),('9R12B18','PC 7','Raspberry PI','Ipecac','operativo',0,11,NULL),('RX2074C','PC 4','Acme','GBD8','operativo',0,12,NULL);
/*!40000 ALTER TABLE `inventario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registro_diario`
--

DROP TABLE IF EXISTS `registro_diario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registro_diario` (
  `id_registro` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `hora_entrada` time NOT NULL,
  `hora_salida` time NOT NULL,
  `cedula_solicitante` varchar(12) NOT NULL,
  `id_salon` int(11) NOT NULL,
  PRIMARY KEY (`id_registro`),
  KEY `fk_registro_solicitante` (`cedula_solicitante`),
  KEY `fk_registro_espacio` (`id_salon`),
  CONSTRAINT `fk_registro_espacio` FOREIGN KEY (`id_salon`) REFERENCES `salon` (`id_salon`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro_diario`
--

LOCK TABLES `registro_diario` WRITE;
/*!40000 ALTER TABLE `registro_diario` DISABLE KEYS */;
INSERT INTO `registro_diario` VALUES (1,'2026-08-06','21:40:00','00:42:00','56357055',14),(2,'2026-08-20','00:42:00','22:40:00','56357055',5),(3,'2026-10-11','13:13:00','13:23:00','33333333',2),(4,'2026-10-03','01:27:00','04:30:00','10101010',13),(5,'2026-10-09','02:28:00','04:28:00','33333333',10),(6,'2026-10-13','19:16:00','21:18:00','A3333333',10),(7,'2026-10-21','09:25:00','11:50:00','33333333',11);
/*!40000 ALTER TABLE `registro_diario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salon`
--

DROP TABLE IF EXISTS `salon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salon` (
  `id_salon` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `tipo` enum('laboratorio','taller') NOT NULL,
  PRIMARY KEY (`id_salon`),
  UNIQUE KEY `uq_espacio_nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salon`
--

LOCK TABLES `salon` WRITE;
/*!40000 ALTER TABLE `salon` DISABLE KEYS */;
INSERT INTO `salon` VALUES (2,'Taller 1','taller'),(5,'Taller 2','taller'),(10,'Taller 3','taller'),(11,'Taller 4','taller'),(12,'Laboratorio 1','laboratorio'),(13,'Laboratorio 2','laboratorio'),(14,'Laboratorio 3','laboratorio'),(15,'Laboratorio 4','laboratorio'),(16,'Laboratorio 5','laboratorio');
/*!40000 ALTER TABLE `salon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solicitud`
--

DROP TABLE IF EXISTS `solicitud`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `solicitud` (
  `id_solicitud` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) NOT NULL,
  `nombre_software` varchar(100) DEFAULT NULL,
  `descripcion` text NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  `estado` enum('Pendiente','En proceso','Resuelto','Cancelada','Rechazada') NOT NULL DEFAULT 'Pendiente',
  `cedula_solicitante` varchar(12) NOT NULL,
  `cedula_tecnico` varchar(12) DEFAULT NULL,
  `id_salon` int(11) NOT NULL,
  PRIMARY KEY (`id_solicitud`),
  KEY `fk_solicitud_solicitante` (`cedula_solicitante`),
  KEY `fk_solicitud_tecnico` (`cedula_tecnico`),
  KEY `fk_solicitud_espacio` (`id_salon`),
  CONSTRAINT `fk_solicitud_espacio` FOREIGN KEY (`id_salon`) REFERENCES `salon` (`id_salon`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitud`
--

LOCK TABLES `solicitud` WRITE;
/*!40000 ALTER TABLE `solicitud` DISABLE KEYS */;
INSERT INTO `solicitud` VALUES (7,'Instalacion de Software','tux','Che le pueden poner, no se, Arch o fedora?',NULL,NULL,NULL,'Resuelto','66666666','22222222',2),(8,'Instalacion de Software','HM Linux','Me gustaria tener un equipo con este sistema',NULL,NULL,NULL,'Pendiente','33333333',NULL,2),(9,'Reserva de Salon',NULL,'Tienen prueba de sociología','2026-10-23','07:00:00','08:30:00','Pendiente','33333333',NULL,5);
/*!40000 ALTER TABLE `solicitud` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `documento` varchar(12) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('solicitante','tecnico','administrador') NOT NULL,
  `estado` enum('pendiente','aprobado','inactivo','rechazado') DEFAULT 'pendiente',
  PRIMARY KEY (`documento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES ('11111111','Admin','Prueba','$2y$10$vFPWp40ou9JX8PZgPn.pUOKIBc3hS9u.5paetrhp9uIaNNBzyqtmG','administrador','aprobado'),('22222222','Tecnico','Prueba','$2y$10$cgAqA4wcamW3Os9TIz0O0uO4YlZPHb0GGXFvk232QAdMh9rXuLZbO','tecnico','aprobado'),('33333333','Solicitante','Prueba','$2y$10$YJHfrv.tuRD8/rpcCNZRBuOUL90za4Wdcnq6aQnV.EwMMssJUlCKe','solicitante','aprobado');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarioextranjero`
--

DROP TABLE IF EXISTS `usuarioextranjero`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarioextranjero` (
  `documento` varchar(12) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('solicitante','tecnico','administrador') NOT NULL,
  `estado` enum('pendiente','aprobado','inactivo','rechazado') DEFAULT 'pendiente',
  PRIMARY KEY (`documento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarioextranjero`
--

LOCK TABLES `usuarioextranjero` WRITE;
/*!40000 ALTER TABLE `usuarioextranjero` DISABLE KEYS */;
INSERT INTO `usuarioextranjero` VALUES ('A1111111','Admin','Extranjero','$2y$10$h33AxHb87.ULDz0gdG83bO6k61ZPGAN5fO6lksjJFCzAvP4Ra5nze','administrador','aprobado'),('A2222222','Tecnico','Extranjero','$2y$10$ozYdcebLoVzSk/paECXElecmieGJ2unbYBLMJj/LEegKTGuiOkjS2','tecnico','aprobado'),('A3333333','Solicitante','Extranjero','$2y$10$Ix4I849y5KFq7giIFYD8zOBY28Q1yg7m2w5zRNUmqKfIUOXoM0Ka2','solicitante','aprobado');
/*!40000 ALTER TABLE `usuarioextranjero` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-20  3:56:55
