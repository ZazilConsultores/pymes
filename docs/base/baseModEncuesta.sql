CREATE DATABASE  IF NOT EXISTS `dospesos_mod_encuesta` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `dospesos_mod_encuesta`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win64 (x86_64)
--
-- Host: localhost    Database: dospesos_mod_encuesta
-- ------------------------------------------------------
-- Server version	5.6.21-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `asignaciongrupo`
--

DROP TABLE IF EXISTS `asignaciongrupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asignaciongrupo` (
  `idAsignacionGrupo` int(11) NOT NULL AUTO_INCREMENT,
  `idGrupoEscolar` int(11) NOT NULL,
  `idMateriaEscolar` int(11) NOT NULL,
  `idRegistro` int(11) NOT NULL,
  PRIMARY KEY (`idAsignacionGrupo`),
  KEY `fk_AsignacionGrupo_GrupoEscolar1_idx` (`idGrupoEscolar`),
  KEY `fk_AsignacionGrupo_MateriaEscolar1_idx` (`idMateriaEscolar`),
  KEY `fk_AsignacionGrupo_Registro1_idx` (`idRegistro`),
  CONSTRAINT `fk_AsignacionGrupo_GrupoEscolar1` FOREIGN KEY (`idGrupoEscolar`) REFERENCES `grupoescolar` (`idGrupoEscolar`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_AsignacionGrupo_MateriaEscolar1` FOREIGN KEY (`idMateriaEscolar`) REFERENCES `materiaescolar` (`idMateriaEscolar`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_AsignacionGrupo_Registro1` FOREIGN KEY (`idRegistro`) REFERENCES `registro` (`idRegistro`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asignaciongrupo`
--

LOCK TABLES `asignaciongrupo` WRITE;
/*!40000 ALTER TABLE `asignaciongrupo` DISABLE KEYS */;
/*!40000 ALTER TABLE `asignaciongrupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoriasrespuesta`
--

DROP TABLE IF EXISTS `categoriasrespuesta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoriasrespuesta` (
  `idCategoriasRespuesta` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(200) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idCategoriasRespuesta`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoriasrespuesta`
--

LOCK TABLES `categoriasrespuesta` WRITE;
/*!40000 ALTER TABLE `categoriasrespuesta` DISABLE KEYS */;
INSERT INTO `categoriasrespuesta` VALUES (1,'Clima Escolar','Opciones básicas evaluativas','2016-03-07 14:46:40'),(2,'Técnico-pedagógicas','Habilidades','2016-05-27 10:17:12');
/*!40000 ALTER TABLE `categoriasrespuesta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cicloescolar`
--

DROP TABLE IF EXISTS `cicloescolar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cicloescolar` (
  `idCicloEscolar` int(11) NOT NULL AUTO_INCREMENT,
  `idPlanEducativo` int(11) NOT NULL,
  `ciclo` varchar(45) NOT NULL,
  `vigente` varchar(1) NOT NULL,
  `inicio` datetime NOT NULL,
  `termino` datetime NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idCicloEscolar`),
  KEY `fk_CicloEscolar_PlanEducativo1_idx` (`idPlanEducativo`),
  CONSTRAINT `fk_CicloEscolar_PlanEducativo1` FOREIGN KEY (`idPlanEducativo`) REFERENCES `planeducativo` (`idPlanEducativo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cicloescolar`
--

LOCK TABLES `cicloescolar` WRITE;
/*!40000 ALTER TABLE `cicloescolar` DISABLE KEYS */;
INSERT INTO `cicloescolar` VALUES (1,1,'2015 - 2016','1','2015-08-10 12:00:00','2016-06-24 12:00:00','Una descripcion','2016-09-29 18:36:52');
/*!40000 ALTER TABLE `cicloescolar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `encuesta`
--

DROP TABLE IF EXISTS `encuesta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `encuesta` (
  `idEncuesta` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `nombreClave` varchar(20) DEFAULT NULL,
  `estatus` varchar(1) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idEncuesta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `encuesta`
--

LOCK TABLES `encuesta` WRITE;
/*!40000 ALTER TABLE `encuesta` DISABLE KEYS */;
/*!40000 ALTER TABLE `encuesta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `encuestasrealizadas`
--

DROP TABLE IF EXISTS `encuestasrealizadas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `encuestasrealizadas` (
  `idEncuesta` int(11) NOT NULL,
  `idAsignacionGrupo` int(11) NOT NULL,
  `realizadas` int(11) NOT NULL,
  PRIMARY KEY (`idEncuesta`,`idAsignacionGrupo`),
  KEY `fk_EncuestasRealizadas_AsignacionGrupo1_idx` (`idAsignacionGrupo`),
  CONSTRAINT `fk_EncuestasRealizadas_AsignacionGrupo1` FOREIGN KEY (`idAsignacionGrupo`) REFERENCES `asignaciongrupo` (`idAsignacionGrupo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_EncuestasRealizadas_Encuesta1` FOREIGN KEY (`idEncuesta`) REFERENCES `encuesta` (`idEncuesta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `encuestasrealizadas`
--

LOCK TABLES `encuestasrealizadas` WRITE;
/*!40000 ALTER TABLE `encuestasrealizadas` DISABLE KEYS */;
/*!40000 ALTER TABLE `encuestasrealizadas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gradoeducativo`
--

DROP TABLE IF EXISTS `gradoeducativo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gradoeducativo` (
  `idGradoEducativo` int(11) NOT NULL AUTO_INCREMENT,
  `idNivelEducativo` int(11) NOT NULL,
  `gradoEducativo` varchar(100) NOT NULL,
  `abreviatura` varchar(45) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idGradoEducativo`),
  KEY `fk_GradoEducativo_NivelEducativo_idx` (`idNivelEducativo`),
  CONSTRAINT `fk_GradoEducativo_NivelEducativo` FOREIGN KEY (`idNivelEducativo`) REFERENCES `niveleducativo` (`idNivelEducativo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gradoeducativo`
--

LOCK TABLES `gradoeducativo` WRITE;
/*!40000 ALTER TABLE `gradoeducativo` DISABLE KEYS */;
INSERT INTO `gradoeducativo` VALUES (1,1,'Primer Grado Escolar','1','Se cursa de los 4 a los 5 años de edad','2016-09-29 18:46:11'),(2,1,'Segundo Grado Escolar','2','Se cursa de los 5 a los 6 años de edad','2016-09-29 18:46:11'),(3,2,'Primer Grado Escolar','1','Se cursa de los 6 a los 7 años de edad.','2016-09-29 18:46:11'),(4,2,'Segundo Grado Escolar','2','Se cursa de los 7 a los 8 años de edad.','2016-09-29 18:46:11'),(5,2,'Tercer Grado Escolar','3','Se cursa de los 8 a los 9 años de edad.','2016-09-29 18:46:11'),(6,2,'Cuarto Grado Escolar','4','Se cursa de los 9 a los 10 años de edad.','2016-09-29 18:46:11'),(7,2,'Quinto Grado Escolar','5','Se cursa de los 10 a los 11 años de edad.','2016-09-29 18:46:11'),(8,2,'Sexto Grado Escolar','6','Se cursa de los 11 a los 12 años de edad.','2016-09-29 18:46:11'),(9,3,'Primer Grado Escolar','1','Se cursa de los 12 a los 13 años de edad.','2016-09-29 18:46:11'),(10,3,'Segundo Grado Escolar','2','Se cursa de los 13 a los 14 años de edad.','2016-09-29 18:46:11'),(11,3,'Tercer Grado Escolar','3','Se cursa de los 14 a los 15 años de edad.','2016-09-29 18:46:11'),(12,4,'Primer Semestre Escolar','1','Se cursa en medio año.','2016-09-29 18:46:11'),(13,4,'Segundo Semestre Escolar','2','Se cursa en medio año.','2016-09-29 18:46:11'),(14,4,'Tercer Semestre Escolar','3','Se cursa en medio año.','2016-09-29 18:46:11'),(15,4,'Cuarto Semestre Escolar','4','Se cursa en medio año.','2016-09-29 18:46:11'),(16,4,'Quinto Semestre Escolar','5','Se cursa en medio año.','2016-09-29 18:46:11'),(17,4,'Sexto Semestre Escolar','6','Se cursa en medio año.','2016-09-29 18:46:11'),(18,4,'Preparatoria','1','0','2016-09-29 18:46:11'),(19,3,'Docente','1','Docentes','2016-09-29 18:46:11'),(20,1,'Docentes','1','Docentes de primer grado','2016-09-29 18:46:11'),(21,2,'Docentes','1','','2016-09-29 18:46:11');
/*!40000 ALTER TABLE `gradoeducativo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupoescolar`
--

DROP TABLE IF EXISTS `grupoescolar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupoescolar` (
  `idGrupoEscolar` int(11) NOT NULL AUTO_INCREMENT,
  `idGradoEducativo` int(11) NOT NULL,
  `idCicloEscolar` int(11) NOT NULL,
  `grupoEscolar` varchar(45) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idGrupoEscolar`),
  KEY `fk_GrupoEscolar_GradoEducativo1_idx` (`idGradoEducativo`),
  KEY `fk_GrupoEscolar_CicloEscolar1_idx` (`idCicloEscolar`),
  CONSTRAINT `fk_GrupoEscolar_CicloEscolar1` FOREIGN KEY (`idCicloEscolar`) REFERENCES `cicloescolar` (`idCicloEscolar`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_GrupoEscolar_GradoEducativo1` FOREIGN KEY (`idGradoEducativo`) REFERENCES `gradoeducativo` (`idGradoEducativo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupoescolar`
--

LOCK TABLES `grupoescolar` WRITE;
/*!40000 ALTER TABLE `grupoescolar` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupoescolar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gruposeccion`
--

DROP TABLE IF EXISTS `gruposeccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gruposeccion` (
  `idGrupoSeccion` int(11) NOT NULL AUTO_INCREMENT,
  `idSeccionEncuesta` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `tipo` varchar(2) NOT NULL,
  `opciones` text,
  `orden` int(11) NOT NULL,
  `elementos` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idGrupoSeccion`),
  KEY `fk_GrupoEncuesta_SeccionEncuesta1_idx` (`idSeccionEncuesta`),
  CONSTRAINT `fk_GrupoEncuesta_SeccionEncuesta1` FOREIGN KEY (`idSeccionEncuesta`) REFERENCES `seccionencuesta` (`idSeccionEncuesta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gruposeccion`
--

LOCK TABLES `gruposeccion` WRITE;
/*!40000 ALTER TABLE `gruposeccion` DISABLE KEYS */;
/*!40000 ALTER TABLE `gruposeccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materiaescolar`
--

DROP TABLE IF EXISTS `materiaescolar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `materiaescolar` (
  `idMateriaEscolar` int(11) NOT NULL AUTO_INCREMENT,
  `idGradoEducativo` int(11) NOT NULL,
  `idCicloEscolar` int(11) NOT NULL,
  `materiaEscolar` varchar(100) NOT NULL,
  `creditos` varchar(45) DEFAULT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idMateriaEscolar`),
  KEY `fk_MateriaEscolar_GradoEducativo1_idx` (`idGradoEducativo`),
  KEY `fk_MateriaEscolar_CicloEscolar1_idx` (`idCicloEscolar`),
  CONSTRAINT `fk_MateriaEscolar_CicloEscolar1` FOREIGN KEY (`idCicloEscolar`) REFERENCES `cicloescolar` (`idCicloEscolar`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_MateriaEscolar_GradoEducativo1` FOREIGN KEY (`idGradoEducativo`) REFERENCES `gradoeducativo` (`idGradoEducativo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materiaescolar`
--

LOCK TABLES `materiaescolar` WRITE;
/*!40000 ALTER TABLE `materiaescolar` DISABLE KEYS */;
/*!40000 ALTER TABLE `materiaescolar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `niveleducativo`
--

DROP TABLE IF EXISTS `niveleducativo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `niveleducativo` (
  `idNivelEducativo` int(11) NOT NULL AUTO_INCREMENT,
  `nivelEducativo` varchar(100) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idNivelEducativo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `niveleducativo`
--

LOCK TABLES `niveleducativo` WRITE;
/*!40000 ALTER TABLE `niveleducativo` DISABLE KEYS */;
INSERT INTO `niveleducativo` VALUES (1,'Preescolar','Nivel educativo que se cursa en 2 años desde los 4 a 6 años de edad','2016-09-29 18:39:17'),(2,'Primaria','Nivel educativo que se cursa en 6 años desde los 6 a 12 años de edad','2016-09-29 18:39:17'),(3,'Secundaria','Nivel educativo que se cursa en 3 años desde los 12 a 15 años de edad','2016-09-29 18:39:17'),(4,'Preparatoria','Nivel educativo que se cursa en 3 años desde los 15 a 18 años de edad','2016-09-29 18:39:17');
/*!40000 ALTER TABLE `niveleducativo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opcioncategoria`
--

DROP TABLE IF EXISTS `opcioncategoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opcioncategoria` (
  `idOpcionCategoria` int(11) NOT NULL AUTO_INCREMENT,
  `idCategoriasRespuesta` int(11) NOT NULL,
  `nombreOpcion` varchar(45) NOT NULL,
  `tipoValor` varchar(2) NOT NULL,
  `valorEntero` int(11) DEFAULT NULL,
  `valorTexto` varchar(200) DEFAULT NULL,
  `valorDecimal` decimal(10,2) DEFAULT NULL,
  `orden` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idOpcionCategoria`),
  KEY `fk_OpcionCategoria_CategoriasRespuesta1_idx` (`idCategoriasRespuesta`),
  CONSTRAINT `fk_OpcionCategoria_CategoriasRespuesta1` FOREIGN KEY (`idCategoriasRespuesta`) REFERENCES `categoriasrespuesta` (`idCategoriasRespuesta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opcioncategoria`
--

LOCK TABLES `opcioncategoria` WRITE;
/*!40000 ALTER TABLE `opcioncategoria` DISABLE KEYS */;
INSERT INTO `opcioncategoria` VALUES (1,1,'Nunca','EN',1,NULL,NULL,1,'2016-03-07 14:51:37'),(2,1,'Casi Nunca','EN',2,NULL,NULL,2,'2016-03-07 14:51:44'),(3,1,'En ocasiones','EN',3,NULL,NULL,3,'2016-03-07 14:51:49'),(4,1,'Casi siempre','EN',4,NULL,NULL,4,'2016-03-07 14:51:59'),(5,1,'Siempre','EN',5,NULL,NULL,5,'2016-03-07 14:55:44'),(6,2,'Marginal','EN',1,NULL,NULL,1,'2016-05-27 10:17:36'),(7,2,'Insuficiente ','EN',2,NULL,NULL,2,'2016-05-27 10:19:30'),(8,2,'Adecuado','EN',3,NULL,NULL,3,'2016-05-27 10:21:04'),(9,2,'Superior','EN',4,NULL,NULL,4,'2016-05-27 10:21:26'),(10,2,'Excelente','EN',5,NULL,NULL,5,'2016-05-27 10:21:43');
/*!40000 ALTER TABLE `opcioncategoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `planeducativo`
--

DROP TABLE IF EXISTS `planeducativo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `planeducativo` (
  `idPlanEducativo` int(11) NOT NULL AUTO_INCREMENT,
  `planEducativo` varchar(100) NOT NULL,
  `vigente` varchar(1) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idPlanEducativo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `planeducativo`
--

LOCK TABLES `planeducativo` WRITE;
/*!40000 ALTER TABLE `planeducativo` DISABLE KEYS */;
INSERT INTO `planeducativo` VALUES (1,'2015','1','Plan de estudios que cubre los ciclos escolares 2015B, 2016A, 2016B, 2017A, 2017B, 2018A','2016-09-29 18:27:41');
/*!40000 ALTER TABLE `planeducativo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preferenciasimple`
--

DROP TABLE IF EXISTS `preferenciasimple`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `preferenciasimple` (
  `idAsignacionGrupo` int(11) NOT NULL,
  `idPregunta` int(11) NOT NULL,
  `idOpcionCategoria` int(11) NOT NULL,
  `preferencia` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  PRIMARY KEY (`idAsignacionGrupo`,`idPregunta`,`idOpcionCategoria`),
  KEY `fk_PreferenciaSimple_Pregunta1_idx` (`idPregunta`),
  KEY `fk_PreferenciaSimple_OpcionCategoria1_idx` (`idOpcionCategoria`),
  KEY `fk_PreferenciaSimple_AsignacionGrupo1_idx` (`idAsignacionGrupo`),
  CONSTRAINT `fk_PreferenciaSimple_AsignacionGrupo1` FOREIGN KEY (`idAsignacionGrupo`) REFERENCES `asignaciongrupo` (`idAsignacionGrupo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_PreferenciaSimple_OpcionCategoria1` FOREIGN KEY (`idOpcionCategoria`) REFERENCES `opcioncategoria` (`idOpcionCategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_PreferenciaSimple_Pregunta1` FOREIGN KEY (`idPregunta`) REFERENCES `pregunta` (`idPregunta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preferenciasimple`
--

LOCK TABLES `preferenciasimple` WRITE;
/*!40000 ALTER TABLE `preferenciasimple` DISABLE KEYS */;
/*!40000 ALTER TABLE `preferenciasimple` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pregunta`
--

DROP TABLE IF EXISTS `pregunta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pregunta` (
  `idPregunta` int(11) NOT NULL AUTO_INCREMENT,
  `idEncuesta` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `origen` varchar(1) NOT NULL,
  `idOrigen` int(11) NOT NULL,
  `tipo` varchar(2) NOT NULL,
  `opciones` text,
  `orden` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idPregunta`),
  KEY `fk_Pregunta_Encuesta1_idx` (`idEncuesta`),
  CONSTRAINT `fk_Pregunta_Encuesta1` FOREIGN KEY (`idEncuesta`) REFERENCES `encuesta` (`idEncuesta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pregunta`
--

LOCK TABLES `pregunta` WRITE;
/*!40000 ALTER TABLE `pregunta` DISABLE KEYS */;
/*!40000 ALTER TABLE `pregunta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registro`
--

DROP TABLE IF EXISTS `registro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registro` (
  `idRegistro` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(5) NOT NULL,
  `referencia` varchar(45) NOT NULL,
  `nombres` varchar(200) NOT NULL,
  `apellidos` varchar(200) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idRegistro`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro`
--

LOCK TABLES `registro` WRITE;
/*!40000 ALTER TABLE `registro` DISABLE KEYS */;
INSERT INTO `registro` VALUES (1,'DO','20160303001','Sandra Erika','Arcos Lozano','2016-03-03 20:19:18'),(2,'DO','20160303002','Maria Elena','Amador Aguilar','2016-03-03 20:20:09'),(3,'DO','20160303003','María del Carmen','Fonseca De la Rosa','2016-03-03 20:20:59'),(4,'DO','20160303004','Armando','Hernandez Rodríguez','2016-03-03 20:22:17'),(5,'DO','20160303005','Norma Alicia','Hernandez Rodríguez','2016-03-03 20:22:55'),(6,'DO','20160303006','Erik Alejandro','Pérez Rodríguez','2016-03-03 20:23:31'),(7,'DO','20160303007','Denisse','Barber Silva','2016-03-03 20:24:37'),(8,'DO','20160303008','María Dolores','Soto Hernandez','2016-03-03 20:29:08'),(9,'DO','20160303009','Shaque','Vartougian Carrillo','2016-03-03 20:29:48'),(10,'DO','20160303010','Alberto','Cajas Torres','2016-03-03 20:30:17'),(11,'DO','20160303011','María','Mijares Fernández','2016-03-03 20:31:34'),(12,'DO','20160303012','María Elena','Senties Laborde','2016-03-03 20:32:43'),(13,'DO','20160303013','Mónica','Gallastegui Brambilla','2016-03-03 20:33:42'),(14,'DO','20160303014','María Cristina','Cortés Izquierdo','2016-03-03 20:34:18'),(15,'DO','','Maria','De la Pesa','2016-03-09 11:29:05'),(16,'DO','','Guadalupe','Carrillo','2016-03-09 11:30:49'),(17,'DO','20160303017','Maria Elena','Molina','2016-03-09 11:33:38'),(18,'DO','20160416EBZ','Elizabeth','Bernal Zavala','2016-04-16 11:36:04'),(19,'DO','20160416FCC','Francisco Emmanuel','Calderón Camarena','2016-04-16 11:48:13'),(20,'DO','','Paloma','Cardona Cuevas','2016-04-16 11:51:16'),(21,'DO','20160416PCL','Patricia','Castañeda López ','2016-04-16 11:54:04'),(22,'DO','20160416LMC','Lucero Esmeralda','Moreno Castilla','2016-04-16 11:55:48'),(23,'DO','20160416TIG','Tomas Alberto','Ibarra Gonzalez','2016-04-16 11:57:18'),(24,'DO','20160416GMC','Graciela Guadalupe','Mainero Del Castillo','2016-04-16 11:59:31'),(25,'DO','20160416HPM','Hairam Asereht','Pérez Martínez ','2016-04-16 12:04:49'),(26,'DO','20160416ETV','Eduardo','Trejo Vargas','2016-04-16 12:10:56'),(27,'DO','20160416JVG','Javier Arturo','Velázquez Galvan','2016-04-16 12:22:43'),(28,'DO','20160416IGS','Irma Alicia','Guzmán Sánchez','2016-04-16 12:24:50'),(29,'DO','20160416MCA','María Teresa','Covarrubias Azuela','2016-04-16 12:30:33'),(30,'DO','20160416PIR','Patricia','Illoldi Rangel','2016-04-16 12:31:33'),(31,'DO','20160416MRG','Manuel','Ramos Gurrola','2016-04-16 12:32:33'),(32,'DO','20160416MRA','María del Carmen','Rodríguez Alvarez','2016-04-16 12:34:11'),(33,'DO','20160416CRR','Claudia','Ruíz Rojo','2016-04-16 12:35:13'),(34,'DO','20160416JJM','Juan Pablo','Jauregui Magriña','2016-04-16 12:36:30'),(35,'DO','','Claudia Virginia','Guerra Rosete','2016-04-20 07:50:53'),(36,'DO','','Blanca','Fortoul','2016-04-20 07:52:07'),(37,'DO','','Saúl','Perez Herrera','2016-04-20 07:53:11'),(38,'DO','','Dulce','Olvera','2016-04-20 08:42:50'),(39,'DO','','Juan Carlos','González Gutierrez','2016-04-20 08:48:39'),(40,'DO','','Diana Carolina','Gomez Sánchez','2016-04-20 20:33:06'),(41,'DO','','Juan Manuel','Rios Figueroa','2016-04-20 20:36:48'),(42,'DO','','Guillermo Patricio','Newmann Coto','2016-04-20 20:37:53'),(43,'DO','','Beatriz','Alessio Robles','2016-04-22 21:12:15'),(44,'DO','','Veronica','','2016-04-22 22:50:38'),(45,'DO','','Ricardo','Khalil Jalil','2016-04-23 00:46:17'),(46,'DO','','Veronica','Pardinez Graue','2016-04-27 09:42:44'),(49,'DO','20160227MAYO','Mayo','','2016-04-27 15:43:45'),(50,'DO','','Marianella','Garrido Rangel','2016-05-18 10:07:15'),(51,'DO','','Ana Paula','Armida Verea','2016-05-18 10:11:13'),(52,'DO','','Gabriela','Landarte Limon','2016-05-18 10:11:41'),(53,'DO','','Maria Eugenia','Aguirre Calderon','2016-05-18 10:13:04'),(54,'DO','','Ma. Ignacia','Castillo Rodriguez','2016-05-18 10:13:47'),(55,'DO','','Maria del Rosario','Merodio Chávez','2016-05-18 10:15:40'),(56,'DO','','Ma. Angeles','Perdigon Castañeda','2016-05-18 10:16:20'),(57,'DO','','Zuleica','Zavala Arredondo','2016-05-18 10:16:46'),(58,'DO','','Zobeida','Rodriguez Hernandez','2016-05-18 10:17:25'),(59,'DO','','Carlos Augusto','Gonzalez Cid','2016-05-18 10:18:00'),(60,'DO','','Martha','Miranda Guasti','2016-05-18 10:18:40'),(61,'DO','','Ma. Elena','Canales Suarez','2016-05-18 10:19:28'),(62,'DO','','Hector Giovanni','Rodriguez Ramos','2016-05-23 01:09:20'),(63,'DO','20160523EMO','Elena','Montes de Oca','2016-05-23 09:16:34'),(64,'DO','20160523SS','Sandra','Serrano','2016-05-23 09:20:39'),(65,'DO','20160523AK','Ana Teresa','Kaiser','2016-05-23 09:21:45'),(66,'DO','','Elvia','González Soto','2016-06-14 13:14:57'),(67,'DO','','Ma. Carmen ','Sotelo Nava','2016-06-14 13:16:44'),(68,'DO','','Ma.del Rocio ','Jiménez González','2016-06-14 13:17:52'),(69,'DO','','Ma. Eugenia ','Aldrete Contreras','2016-06-14 13:18:15'),(70,'DO','','Virginia ','García Mendoza','2016-06-14 13:18:54'),(71,'DO','','Mariel ','Patiño Cárdenas','2016-06-14 13:19:25'),(72,'DO','','Guadalupe ','Díaz Alonso','2016-06-14 13:19:47'),(73,'DO','','Marcela ','Bustos Rodriguez','2016-06-14 13:20:08'),(74,'DO','','Lilia Marcela ','Rovelo Velázquez','2016-06-14 13:20:51'),(75,'DO','','Tania ','Moreno Ramos','2016-06-14 13:21:26'),(76,'DO','','Adriana ','Trejo Veytia','2016-06-14 13:21:49'),(77,'DO','','Susana Elizabeth',' Téllez Tapia','2016-06-14 13:22:13'),(78,'DO','','Sonia Josefina ','Valery Lobo','2016-06-14 13:22:58'),(79,'DO','','Micaela ','Patricia Rodríguez','2016-06-14 13:23:42'),(80,'DO','',' Alma ','Yolanda Carranza','2016-06-14 13:24:12'),(81,'DO','','Martha Beatriz ','Murillo','2016-06-14 13:25:04'),(82,'DO','','Miriam ','Zarco Alguera','2016-06-14 13:25:31'),(83,'DO','',' María ','Mijares Fernández','2016-06-14 13:26:08'),(84,'DO','','Angelina','Méndez Meza','2016-06-27 11:44:03'),(85,'DO','','Gizeh ','Juárez Salas','2016-06-27 11:44:34'),(86,'DO','','Elena','del Valle y Álvarez','2016-06-27 11:45:14'),(87,'DO','','Lourdes','Ortega Mccullough','2016-06-27 11:46:20'),(88,'DO','','Barbara','Gomez López','2016-06-27 11:46:59'),(89,'DO','','Patricia','Aguilar Morita','2016-06-27 11:47:58'),(90,'DO','','Alexandra','Zertuche','2016-06-27 11:50:31'),(91,'DO','','Maribel','Ambás Brother','2016-06-27 11:51:12'),(92,'DO','','Elena','León de la Vega','2016-06-27 11:51:54'),(93,'DO','','Cristina','Romero Alva','2016-06-27 11:52:37'),(94,'DO','','Susana ','Reyna Zuñiga','2016-06-27 11:53:20'),(95,'DO','','Patricia','Rodríguez Dávila','2016-06-27 11:54:11'),(96,'DO','','Ma. del Carmen ','Roiz Pruneda','2016-06-27 11:54:47'),(97,'DO','','Cristina','Guereña Gándara','2016-06-27 11:55:19'),(98,'DO','','Nancy','Martínez Limón','2016-06-27 11:56:04'),(99,'DO','','Teresita','Jiménez Gómez','2016-06-27 11:56:38'),(100,'DO','','Susana','Oaxaca','2016-06-27 13:42:50');
/*!40000 ALTER TABLE `registro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reportesencuesta`
--

DROP TABLE IF EXISTS `reportesencuesta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reportesencuesta` (
  `idReporte` int(11) NOT NULL AUTO_INCREMENT,
  `nombreReporte` varchar(200) NOT NULL,
  `tipoReporte` varchar(2) NOT NULL,
  `rutaReporte` varchar(200) NOT NULL,
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idReporte`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reportesencuesta`
--

LOCK TABLES `reportesencuesta` WRITE;
/*!40000 ALTER TABLE `reportesencuesta` DISABLE KEYS */;
/*!40000 ALTER TABLE `reportesencuesta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `respuesta`
--

DROP TABLE IF EXISTS `respuesta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `respuesta` (
  `idRespuesta` int(11) NOT NULL AUTO_INCREMENT,
  `idPregunta` int(11) NOT NULL,
  `idEncuesta` int(11) NOT NULL,
  `idAsignacionGrupo` int(11) NOT NULL,
  `respuesta` text NOT NULL,
  `tipo` varchar(2) NOT NULL,
  `conjunto` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idRespuesta`),
  KEY `fk_Respuesta_Pregunta1_idx` (`idPregunta`),
  KEY `fk_Respuesta_Encuesta1_idx` (`idEncuesta`),
  KEY `fk_Respuesta_AsignacionGrupo1_idx` (`idAsignacionGrupo`),
  CONSTRAINT `fk_Respuesta_AsignacionGrupo1` FOREIGN KEY (`idAsignacionGrupo`) REFERENCES `asignaciongrupo` (`idAsignacionGrupo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Respuesta_Encuesta1` FOREIGN KEY (`idEncuesta`) REFERENCES `encuesta` (`idEncuesta`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Respuesta_Pregunta1` FOREIGN KEY (`idPregunta`) REFERENCES `pregunta` (`idPregunta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `respuesta`
--

LOCK TABLES `respuesta` WRITE;
/*!40000 ALTER TABLE `respuesta` DISABLE KEYS */;
/*!40000 ALTER TABLE `respuesta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seccionencuesta`
--

DROP TABLE IF EXISTS `seccionencuesta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seccionencuesta` (
  `idSeccionEncuesta` int(11) NOT NULL AUTO_INCREMENT,
  `idEncuesta` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `orden` int(11) NOT NULL,
  `elementos` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idSeccionEncuesta`),
  KEY `fk_SeccionEncuesta_Encuesta1_idx` (`idEncuesta`),
  CONSTRAINT `fk_SeccionEncuesta_Encuesta1` FOREIGN KEY (`idEncuesta`) REFERENCES `encuesta` (`idEncuesta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seccionencuesta`
--

LOCK TABLES `seccionencuesta` WRITE;
/*!40000 ALTER TABLE `seccionencuesta` DISABLE KEYS */;
/*!40000 ALTER TABLE `seccionencuesta` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-09-29 19:42:07
