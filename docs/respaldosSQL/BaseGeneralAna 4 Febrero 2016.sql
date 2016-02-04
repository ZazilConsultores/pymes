CREATE DATABASE  IF NOT EXISTS `generaldos` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `generaldos`;
-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: localhost    Database: generaldos
-- ------------------------------------------------------
-- Server version	5.7.10-log

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
-- Table structure for table `banco`
--

DROP TABLE IF EXISTS `banco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banco` (
  `idBanco` int(11) NOT NULL AUTO_INCREMENT,
  `idDivisa` int(11) NOT NULL,
  `banco` varchar(200) NOT NULL,
  `cuenta` varchar(60) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `saldo` decimal(10,0) NOT NULL,
  PRIMARY KEY (`idBanco`),
  KEY `fk_Banco_Divisa1_idx` (`idDivisa`),
  CONSTRAINT `fk_Banco_Divisa1` FOREIGN KEY (`idDivisa`) REFERENCES `divisa` (`idDivisa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banco`
--

LOCK TABLES `banco` WRITE;
/*!40000 ALTER TABLE `banco` DISABLE KEYS */;
/*!40000 ALTER TABLE `banco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `capas`
--

DROP TABLE IF EXISTS `capas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `capas` (
  `idCapas` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` int(11) NOT NULL,
  `secuencial` int(11) DEFAULT NULL,
  `entrada` double DEFAULT NULL,
  `fechaEntrada` datetime DEFAULT NULL,
  `costoUnitario` decimal(10,0) DEFAULT NULL,
  `costoTotal` decimal(10,0) DEFAULT NULL,
  `idDivisa` int(11) NOT NULL,
  PRIMARY KEY (`idCapas`),
  KEY `fk_Capas_Divisa1_idx` (`idDivisa`),
  KEY `fk_Capas_Producto1_idx` (`idProducto`),
  CONSTRAINT `fk_Capas_Divisa1` FOREIGN KEY (`idDivisa`) REFERENCES `divisa` (`idDivisa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Capas_Producto1` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `capas`
--

LOCK TABLES `capas` WRITE;
/*!40000 ALTER TABLE `capas` DISABLE KEYS */;
/*!40000 ALTER TABLE `capas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cardex`
--

DROP TABLE IF EXISTS `cardex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cardex` (
  `idCardex` int(11) NOT NULL AUTO_INCREMENT,
  `secuencialEntrada` int(11) NOT NULL,
  `fechaEntrada` datetime NOT NULL,
  `idProducto` int(11) NOT NULL,
  `secuencialSalida` int(11) DEFAULT NULL,
  `fechaSalida` datetime DEFAULT NULL,
  `cantidad` float DEFAULT NULL,
  `costo` decimal(10,0) DEFAULT NULL,
  `costoSalida` decimal(10,0) DEFAULT NULL,
  `idFactura` int(11) NOT NULL,
  `utilidad` decimal(10,0) DEFAULT NULL,
  `idDivisa` int(11) NOT NULL,
  `idPoliza` int(11) NOT NULL,
  `estatus` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`idCardex`),
  KEY `fk_Cardex_Producto1_idx` (`idProducto`),
  KEY `fk_Cardex_Factura1_idx` (`idFactura`),
  KEY `fk_Cardex_Divisa1_idx` (`idDivisa`),
  KEY `fk_Cardex_Poliza1_idx` (`idPoliza`),
  CONSTRAINT `fk_Cardex_Divisa1` FOREIGN KEY (`idDivisa`) REFERENCES `divisa` (`idDivisa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cardex_Factura1` FOREIGN KEY (`idFactura`) REFERENCES `factura` (`idFactura`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cardex_Poliza1` FOREIGN KEY (`idPoliza`) REFERENCES `poliza` (`idPoliza`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cardex_Producto1` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cardex`
--

LOCK TABLES `cardex` WRITE;
/*!40000 ALTER TABLE `cardex` DISABLE KEYS */;
/*!40000 ALTER TABLE `cardex` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` text NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` datetime NOT NULL,
  `hash` varchar(45) NOT NULL,
  PRIMARY KEY (`idCategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'Frecuencia','','2016-01-29 20:40:47','0dd44710435dfb2d29c5242a3c81d332'),(2,'Escala de Evaluación ','Escala de Evaluación MARGINAL a EXCELENTE','2016-02-04 11:37:44','f9bedb6b5637f6a35ffc538623180a0f');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `computadora`
--

DROP TABLE IF EXISTS `computadora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `computadora` (
  `idComputadora` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `numeroSerie` varchar(45) DEFAULT NULL,
  `nodoPuerto` varchar(30) DEFAULT NULL,
  `sistemaOperativo` varchar(45) DEFAULT NULL,
  `procesador` varchar(45) DEFAULT NULL,
  `discoDuro` varchar(30) DEFAULT NULL,
  `monitor` varchar(30) DEFAULT NULL,
  `teclado` varchar(30) DEFAULT NULL,
  `mouse` varchar(30) DEFAULT NULL,
  `bocina` varchar(30) DEFAULT NULL,
  `direccionIP` varchar(30) DEFAULT NULL,
  `direccionMAC` varchar(45) DEFAULT NULL,
  `ubicacion` varchar(150) DEFAULT NULL,
  `fechaCompra` datetime DEFAULT NULL,
  `garantia` varchar(1) DEFAULT NULL,
  `fechaGarantia` datetime DEFAULT NULL,
  `fechaAsignacion` datetime DEFAULT NULL,
  PRIMARY KEY (`idComputadora`),
  KEY `fk_Computadora_Producto1_idx` (`idProducto`),
  KEY `fk_Computadora_Usuario1_idx` (`idUsuario`),
  CONSTRAINT `fk_Computadora_Producto1` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Computadora_Usuario1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `computadora`
--

LOCK TABLES `computadora` WRITE;
/*!40000 ALTER TABLE `computadora` DISABLE KEYS */;
/*!40000 ALTER TABLE `computadora` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cuentasxc`
--

DROP TABLE IF EXISTS `cuentasxc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cuentasxc` (
  `idCuentasxc` int(11) NOT NULL AUTO_INCREMENT,
  `idEmpresa` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `idFactura` int(11) NOT NULL,
  `idTipoMovimiento` int(11) NOT NULL,
  `idProyecto` int(11) NOT NULL,
  `secuencial` int(11) NOT NULL,
  `numeroReferencia` varchar(100) NOT NULL,
  `descripcion` text,
  `estatus` varchar(2) DEFAULT NULL,
  `conceptoPago` varchar(10) DEFAULT NULL,
  `formaLiquidar` varchar(15) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `fechaCaptura` datetime DEFAULT NULL,
  `subtotal` decimal(10,0) DEFAULT NULL,
  `total` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`idCuentasxc`),
  KEY `fk_Cuentasxc_Proyecto1_idx` (`idProyecto`),
  KEY `fk_Cuentasxc_Factura1_idx` (`idFactura`),
  KEY `fk_Cuentasxc_TipoMovimiento1_idx` (`idTipoMovimiento`),
  CONSTRAINT `fk_Cuentasxc_Factura1` FOREIGN KEY (`idFactura`) REFERENCES `factura` (`idFactura`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxc_Proyecto1` FOREIGN KEY (`idProyecto`) REFERENCES `proyecto` (`idProyecto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxc_TipoMovimiento1` FOREIGN KEY (`idTipoMovimiento`) REFERENCES `tipomovimiento` (`idTipoMovimiento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuentasxc`
--

LOCK TABLES `cuentasxc` WRITE;
/*!40000 ALTER TABLE `cuentasxc` DISABLE KEYS */;
/*!40000 ALTER TABLE `cuentasxc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cuentasxp`
--

DROP TABLE IF EXISTS `cuentasxp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cuentasxp` (
  `idCuentasxp` int(11) NOT NULL AUTO_INCREMENT,
  `idEmpresa` int(11) NOT NULL,
  `idProveedor` int(11) NOT NULL,
  `idFactura` int(11) NOT NULL,
  `idTipoMovimiento` int(11) NOT NULL,
  `idProyecto` int(11) NOT NULL,
  `fechaCaptura` datetime DEFAULT NULL,
  `secuencial` int(11) DEFAULT NULL,
  `descripcion` text,
  `estatus` varchar(1) DEFAULT NULL,
  `conceptoPago` varchar(2) DEFAULT NULL,
  `formaLiquidar` varchar(15) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `subtotal` decimal(10,0) DEFAULT NULL,
  `total` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`idCuentasxp`),
  KEY `fk_Cuentasxp_Proyecto1_idx` (`idProyecto`),
  KEY `fk_Cuentasxp_Factura1_idx` (`idFactura`),
  KEY `fk_Cuentasxp_TipoMovimiento1_idx` (`idTipoMovimiento`),
  CONSTRAINT `fk_Cuentasxp_Factura1` FOREIGN KEY (`idFactura`) REFERENCES `factura` (`idFactura`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxp_Proyecto1` FOREIGN KEY (`idProyecto`) REFERENCES `proyecto` (`idProyecto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxp_TipoMovimiento1` FOREIGN KEY (`idTipoMovimiento`) REFERENCES `tipomovimiento` (`idTipoMovimiento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuentasxp`
--

LOCK TABLES `cuentasxp` WRITE;
/*!40000 ALTER TABLE `cuentasxp` DISABLE KEYS */;
/*!40000 ALTER TABLE `cuentasxp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `divisa`
--

DROP TABLE IF EXISTS `divisa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `divisa` (
  `idDivisa` int(11) NOT NULL AUTO_INCREMENT,
  `divisa` varchar(200) NOT NULL,
  `claveDivisa` varchar(10) NOT NULL,
  `descripcion` text NOT NULL,
  `tipoCambio` float NOT NULL,
  PRIMARY KEY (`idDivisa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `divisa`
--

LOCK TABLES `divisa` WRITE;
/*!40000 ALTER TABLE `divisa` DISABLE KEYS */;
/*!40000 ALTER TABLE `divisa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `domicilio`
--

DROP TABLE IF EXISTS `domicilio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `domicilio` (
  `idDomicilio` int(11) NOT NULL AUTO_INCREMENT,
  `idMunicipio` int(11) NOT NULL,
  `calle` varchar(60) NOT NULL,
  `colonia` varchar(60) NOT NULL,
  `codigoPostal` varchar(5) NOT NULL,
  `numeroInterior` varchar(60) NOT NULL,
  `numeroExterior` varchar(60) NOT NULL,
  `hash` varchar(45) NOT NULL,
  PRIMARY KEY (`idDomicilio`),
  KEY `fk_Domicilio_Municipio1_idx` (`idMunicipio`),
  CONSTRAINT `fk_Domicilio_Municipio1` FOREIGN KEY (`idMunicipio`) REFERENCES `municipio` (`idMunicipio`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `domicilio`
--

LOCK TABLES `domicilio` WRITE;
/*!40000 ALTER TABLE `domicilio` DISABLE KEYS */;
/*!40000 ALTER TABLE `domicilio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email`
--

DROP TABLE IF EXISTS `email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email` (
  `idEmail` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(60) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `hash` varchar(45) NOT NULL,
  PRIMARY KEY (`idEmail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email`
--

LOCK TABLES `email` WRITE;
/*!40000 ALTER TABLE `email` DISABLE KEYS */;
/*!40000 ALTER TABLE `email` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empresa` (
  `idEmpresa` int(11) NOT NULL AUTO_INCREMENT,
  `idFiscales` int(11) NOT NULL,
  `esEmpresa` varchar(1) DEFAULT 'N',
  `esCliente` varchar(1) DEFAULT 'N',
  `esProveedor` varchar(1) DEFAULT 'N',
  `idsBancos` text,
  `hash` varchar(45) NOT NULL,
  PRIMARY KEY (`idEmpresa`),
  KEY `fk_Empresa_Fiscales1_idx` (`idFiscales`),
  CONSTRAINT `fk_Empresa_Fiscales1` FOREIGN KEY (`idFiscales`) REFERENCES `fiscales` (`idFiscales`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
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
  `nombreClave` varchar(30) NOT NULL,
  `descripcion` text NOT NULL,
  `estatus` varchar(1) NOT NULL,
  `fecha` datetime NOT NULL,
  `fechaInicio` datetime NOT NULL,
  `fechaFin` datetime NOT NULL,
  `hash` varchar(45) NOT NULL,
  PRIMARY KEY (`idEncuesta`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `encuesta`
--

LOCK TABLES `encuesta` WRITE;
/*!40000 ALTER TABLE `encuesta` DISABLE KEYS */;
INSERT INTO `encuesta` VALUES (1,'Evaluacion Profesores','EVAL2016-2','Evaluar las habilidades que el maestro desarrolla en las alumnas.','0','2016-01-29 20:40:12','2016-01-01 12:00:00','2016-01-31 12:00:00','0cb5f4411562475457e038d0c042267a'),(2,'ejemplo','Ejempl','bla bla bla','0','2016-02-04 09:53:23','2016-02-14 12:00:00','2016-02-14 12:00:00','f516cb7368b6c0877a8df799c9ea594b'),(3,'Clima En Salon De Clases PRIMARIA','Encuesta Clima Alumnas Chicas','Evaluar el clima en salones de clases, en el area de Primaria','0','2016-02-04 10:04:17','2016-02-04 12:00:00','2016-02-04 12:00:00','77d0e00ae721707aa08dadae44fee78f'),(4,'Clima En Salon de Clases SECUNDARIA Y PREPARATORIA','Encuesta Clima Alumnas Grandes','Evalúa al maestro con respecto al tipo de condiciones que genera para el aprendizaje en el salón de clases','0','2016-02-04 10:06:44','2016-02-04 12:00:00','2016-02-04 12:00:00','8910c1ebfb0f0dd80df2a2e6148c739f'),(5,'Habilidades Técnico-Pedagóicas','Encuestas Habilidades Tecnicas','Evaluar al maestro con respecto a las hablidades técnico-pedagóicas que demuestra cuando da clases','0','2016-02-04 10:08:52','2016-02-04 12:00:00','2016-02-04 12:00:00','344445a7c3d1a88bf8036eadb914f010');
/*!40000 ALTER TABLE `encuesta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado`
--

DROP TABLE IF EXISTS `estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estado` (
  `idEstado` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(100) NOT NULL,
  `capital` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idEstado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado`
--

LOCK TABLES `estado` WRITE;
/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
/*!40000 ALTER TABLE `estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factura`
--

DROP TABLE IF EXISTS `factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factura` (
  `idFactura` int(11) NOT NULL AUTO_INCREMENT,
  `factura` varchar(150) NOT NULL,
  `idEmpresa` int(11) NOT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `idProveedor` int(11) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `subtotal` decimal(10,0) NOT NULL,
  `total` decimal(10,0) NOT NULL,
  `hash` varchar(45) NOT NULL,
  PRIMARY KEY (`idFactura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura`
--

LOCK TABLES `factura` WRITE;
/*!40000 ALTER TABLE `factura` DISABLE KEYS */;
/*!40000 ALTER TABLE `factura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facturadetalle`
--

DROP TABLE IF EXISTS `facturadetalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `facturadetalle` (
  `idFactura` int(11) NOT NULL,
  `idMultiplos` int(11) NOT NULL,
  `secuencial` int(11) NOT NULL,
  `cantidad` float NOT NULL,
  `descripcion` text NOT NULL,
  `precioUnitario` decimal(10,0) NOT NULL,
  `importe` decimal(10,0) NOT NULL,
  PRIMARY KEY (`idFactura`),
  KEY `fk_FacturaDetalle_Factura1_idx` (`idFactura`),
  KEY `fk_FacturaDetalle_Multiplos1_idx` (`idMultiplos`),
  CONSTRAINT `fk_FacturaDetalle_Factura1` FOREIGN KEY (`idFactura`) REFERENCES `factura` (`idFactura`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_FacturaDetalle_Multiplos1` FOREIGN KEY (`idMultiplos`) REFERENCES `multiplos` (`idMultiplos`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facturadetalle`
--

LOCK TABLES `facturadetalle` WRITE;
/*!40000 ALTER TABLE `facturadetalle` DISABLE KEYS */;
/*!40000 ALTER TABLE `facturadetalle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fiscales`
--

DROP TABLE IF EXISTS `fiscales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fiscales` (
  `idFiscales` int(11) NOT NULL AUTO_INCREMENT,
  `rfc` varchar(13) NOT NULL,
  `razonSocial` varchar(200) NOT NULL,
  `idDomicilio` int(11) DEFAULT NULL,
  `idsTelefonos` text,
  `idsEmails` text,
  `fecha` datetime NOT NULL,
  `hash` varchar(45) NOT NULL,
  PRIMARY KEY (`idFiscales`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fiscales`
--

LOCK TABLES `fiscales` WRITE;
/*!40000 ALTER TABLE `fiscales` DISABLE KEYS */;
/*!40000 ALTER TABLE `fiscales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo`
--

DROP TABLE IF EXISTS `grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo` (
  `idGrupo` int(11) NOT NULL AUTO_INCREMENT,
  `idSeccion` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `tipo` varchar(2) NOT NULL,
  `opciones` text,
  `orden` int(11) NOT NULL,
  `elementos` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `hash` varchar(45) NOT NULL,
  PRIMARY KEY (`idGrupo`),
  KEY `fk_Grupo_Seccion1_idx` (`idSeccion`),
  CONSTRAINT `fk_Grupo_Seccion1` FOREIGN KEY (`idSeccion`) REFERENCES `seccion` (`idSeccion`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo`
--

LOCK TABLES `grupo` WRITE;
/*!40000 ALTER TABLE `grupo` DISABLE KEYS */;
INSERT INTO `grupo` VALUES (1,1,'Claridad','SS','1,2,3,4,5',1,2,'2016-01-29 20:45:30','4823146c63df792b24c0c5482e58f67b'),(2,1,'Orden','SS','1,2,3,4,5',2,2,'2016-01-30 09:30:01','f1e14a541b28e5ffa239bad196cf0780'),(3,1,'Reto','SS','1,2,3,4,5',3,2,'2016-01-30 09:30:56','9aa0294cac34cc974f2cc6745cf2b410'),(4,1,'Justicia','SS','1,2,3,4,5',4,2,'2016-01-30 09:31:45','5311fa909f65db8655a2c24f9a5e1431'),(6,1,'Participación','SS','1,2,3,4,5',6,2,'2016-01-30 09:33:36','f1111760d2c49bebaf19ad91114c8c76'),(7,1,'Apoyo','SS','1,2,3,4,5',7,2,'2016-01-30 09:34:31','0421defb40714ea13ffcf29246f727b3'),(8,1,'Respeto e inclusión ','SS','1,2,3,4,5',8,2,'2016-01-30 09:35:48','36197095eb89fd04ed410da59de57085'),(9,2,'semanales','AB',NULL,1,2,'2016-02-04 09:55:24','80ff5e4569856c75ce1b45c7a16c4596'),(10,3,'Claridad','SS','1,2,3,4,5',1,2,'2016-02-04 10:19:43','869a6fbe9c17a5011b8358d6346232c6'),(11,4,'Orden','SS','1,2,3,4,5',1,2,'2016-02-04 10:29:15','b65b8da97bd9ef6b83b20d5ff246b1e7'),(12,5,'Reto','SS','1,2,3,4,5',1,2,'2016-02-04 10:33:04','f2e3499575fec2283f0bc8a5e6e1fd7a'),(13,6,'Apoyo','SS','1,2,3,4,5',1,2,'2016-02-04 10:35:23','5c781cb9681689abf9774c06e188ed9a'),(14,7,'Respeto e inclusión ','SS','1,2,3,4,5',1,2,'2016-02-04 10:38:10','ff797a9cea07ebd69c3ea60c5c51898b'),(15,8,'Motivación e interés','SS','1,2,3,4,5',1,2,'2016-02-04 10:40:35','11a42b2208c3d4a58a683b8a48870aed'),(16,9,'Espacio físico','SS','1,2,3,4,5',1,2,'2016-02-04 10:42:52','3459f03c594c81abecbe392b3d65250d'),(17,10,'Claridad','SS','1,2,3,4,5',1,2,'2016-02-04 10:46:46','6119b9de1eedc41119c0c0b39671fa24'),(18,11,'Orden','SS','1,2,3,4,5',1,4,'2016-02-04 10:51:02','beeda9b9dd6e7e88f33c12dfee34c47d'),(19,12,'Reto','SS','1,2,3,4,5',1,2,'2016-02-04 11:12:37','4c1791c54a9a365f77494e4e11df4ce1'),(20,13,'Justicia','SS','1,2,3,4,5',1,2,'2016-02-04 11:14:10','cba2e6eea0fbefeddee41c2c55a6c857'),(21,14,'Participación','SS','1,2,3,4,5',1,2,'2016-02-04 11:15:22','59e6a4e472b14cae519cafe8cfea390b'),(22,15,'Apoyo','SS','1,2,3,4,5',1,2,'2016-02-04 11:19:08','e2d247a87ddc1fa84033af000155ecb9'),(23,16,'Respeto e inclusión ','SS','1,2,3,4,5',1,3,'2016-02-04 11:24:26','97149f8e423037ed0764d0aba03a9ea4'),(24,17,'Motivación e interés','SS','1,2,3,4,5',1,2,'2016-02-04 11:31:47','40796cac00dda82b25dab0be2939ec35'),(25,18,'Espacio físico','SS','1,2,3,4,5',1,2,'2016-02-04 11:33:39','082c1a532665a75cb8abe98084611478'),(26,19,'Planeación','SS','6,7,8,9,10',1,3,'2016-02-04 11:38:51','dd20d86c594e23a061201a7312f05771'),(27,19,'Expectativas','SS','6,7,8,9,10',2,2,'2016-02-04 11:42:36','60d559debd6585e0ceb03d2a6e23b6c1'),(28,19,'Métodos y estrategias','SS','6,7,8,9,10',3,3,'2016-02-04 11:45:47','40ebfce89383fb219592c7d9996f2e56'),(29,19,'Manejo de alumnos y diciplina','SS','6,7,8,9,10',4,3,'2016-02-04 11:48:49','ca60348eaf98315de2a0fdb5df06c6dd'),(30,19,'Administración del tiempo y recursos','SS','6,7,8,9,10',5,3,'2016-02-04 11:50:49','af86f0a71d23b7e870a6b94f2bdf26dc'),(31,19,'Evaluación','SS','6,7,8,9,10',6,2,'2016-02-04 11:53:09','63e8a826f75798230eeb4f364f5cd60c'),(32,19,'Tareas','SS','6,7,8,9,10',7,2,'2016-02-04 11:54:53','7ed2b46ae6d7e50d7a7bfde40c3096d1'),(33,19,'Flujo de clase','SS','6,7,8,9,10',8,5,'2016-02-04 11:56:34','91a2c8a550a97c6300ffb5227becda4d');
/*!40000 ALTER TABLE `grupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `impuesto`
--

DROP TABLE IF EXISTS `impuesto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `impuesto` (
  `idImpuesto` int(11) NOT NULL AUTO_INCREMENT,
  `impuesto` varchar(60) NOT NULL,
  `abreviatura` varchar(15) NOT NULL,
  `descripcion` text NOT NULL,
  `porcentaje` float NOT NULL,
  `estatus` varchar(1) NOT NULL,
  `fechaPublicacion` datetime NOT NULL,
  PRIMARY KEY (`idImpuesto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `impuesto`
--

LOCK TABLES `impuesto` WRITE;
/*!40000 ALTER TABLE `impuesto` DISABLE KEYS */;
/*!40000 ALTER TABLE `impuesto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventario`
--

DROP TABLE IF EXISTS `inventario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventario` (
  `idInventario` int(11) NOT NULL AUTO_INCREMENT,
  `idEmpresa` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `idDivisa` int(11) NOT NULL,
  `existencia` decimal(10,0) NOT NULL,
  `apartado` decimal(10,0) NOT NULL,
  `existenciaReal` decimal(10,0) NOT NULL,
  `maximo` decimal(10,0) NOT NULL,
  `minimo` decimal(10,0) NOT NULL,
  `fecha` datetime NOT NULL,
  `costoUnitario` decimal(10,0) NOT NULL,
  `porcentajeGanancia` decimal(10,0) NOT NULL,
  `cantidadGanancia` decimal(10,0) NOT NULL,
  `costoCliente` decimal(10,0) NOT NULL,
  PRIMARY KEY (`idInventario`),
  KEY `fk_Inventario_Producto1_idx` (`idProducto`),
  KEY `fk_Inventario_Divisa1_idx` (`idDivisa`),
  CONSTRAINT `fk_Inventario_Divisa1` FOREIGN KEY (`idDivisa`) REFERENCES `divisa` (`idDivisa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Inventario_Producto1` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventario`
--

LOCK TABLES `inventario` WRITE;
/*!40000 ALTER TABLE `inventario` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantenimiento`
--

DROP TABLE IF EXISTS `mantenimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantenimiento` (
  `idMantenimiento` int(11) NOT NULL AUTO_INCREMENT,
  `idComputadora` int(11) NOT NULL,
  `tipo` varchar(2) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `descripcion` text,
  `archivo` text,
  PRIMARY KEY (`idMantenimiento`),
  KEY `fk_Mantenimiento_Computadora1_idx` (`idComputadora`),
  CONSTRAINT `fk_Mantenimiento_Computadora1` FOREIGN KEY (`idComputadora`) REFERENCES `computadora` (`idComputadora`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mantenimiento`
--

LOCK TABLES `mantenimiento` WRITE;
/*!40000 ALTER TABLE `mantenimiento` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantenimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movimientos`
--

DROP TABLE IF EXISTS `movimientos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `movimientos` (
  `idMovimientos` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` int(11) NOT NULL,
  `idTipoMovimiento` int(11) NOT NULL,
  `idFactura` int(11) NOT NULL,
  `idProyecto` int(11) NOT NULL,
  `idPoliza` int(11) NOT NULL,
  `cantidad` decimal(10,0) NOT NULL,
  `fecha` datetime NOT NULL,
  `secuencial` int(11) NOT NULL,
  `estatus` varchar(1) NOT NULL,
  `costoUnitario` decimal(10,0) NOT NULL,
  `esOrigen` varchar(1) NOT NULL,
  PRIMARY KEY (`idMovimientos`),
  KEY `fk_Movimientos_Producto1_idx` (`idProducto`),
  KEY `fk_Movimientos_TipoMovimiento1_idx` (`idTipoMovimiento`),
  KEY `fk_Movimientos_Factura1_idx` (`idFactura`),
  KEY `fk_Movimientos_Proyecto1_idx` (`idProyecto`),
  KEY `fk_Movimientos_Poliza1_idx` (`idPoliza`),
  CONSTRAINT `fk_Movimientos_Factura1` FOREIGN KEY (`idFactura`) REFERENCES `factura` (`idFactura`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Movimientos_Poliza1` FOREIGN KEY (`idPoliza`) REFERENCES `poliza` (`idPoliza`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Movimientos_Producto1` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Movimientos_Proyecto1` FOREIGN KEY (`idProyecto`) REFERENCES `proyecto` (`idProyecto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Movimientos_TipoMovimiento1` FOREIGN KEY (`idTipoMovimiento`) REFERENCES `tipomovimiento` (`idTipoMovimiento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movimientos`
--

LOCK TABLES `movimientos` WRITE;
/*!40000 ALTER TABLE `movimientos` DISABLE KEYS */;
/*!40000 ALTER TABLE `movimientos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `multiplos`
--

DROP TABLE IF EXISTS `multiplos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `multiplos` (
  `idMultiplos` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` int(11) NOT NULL,
  `cantidad` float NOT NULL,
  `unidad` varchar(20) NOT NULL,
  `abreviatura` varchar(20) NOT NULL,
  PRIMARY KEY (`idMultiplos`),
  KEY `fk_Multiplos_Producto1_idx` (`idProducto`),
  CONSTRAINT `fk_Multiplos_Producto1` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `multiplos`
--

LOCK TABLES `multiplos` WRITE;
/*!40000 ALTER TABLE `multiplos` DISABLE KEYS */;
/*!40000 ALTER TABLE `multiplos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `municipio`
--

DROP TABLE IF EXISTS `municipio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `municipio` (
  `idMunicipio` int(11) NOT NULL AUTO_INCREMENT,
  `idEstado` int(11) NOT NULL,
  `municipio` varchar(100) NOT NULL,
  PRIMARY KEY (`idMunicipio`),
  KEY `fk_Municipio_Estado_idx` (`idEstado`),
  CONSTRAINT `fk_Municipio_Estado` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`idEstado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `municipio`
--

LOCK TABLES `municipio` WRITE;
/*!40000 ALTER TABLE `municipio` DISABLE KEYS */;
/*!40000 ALTER TABLE `municipio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opcion`
--

DROP TABLE IF EXISTS `opcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opcion` (
  `idOpcion` int(11) NOT NULL AUTO_INCREMENT,
  `idCategoria` int(11) NOT NULL,
  `opcion` text NOT NULL,
  `orden` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `hash` varchar(45) NOT NULL,
  PRIMARY KEY (`idOpcion`),
  KEY `fk_Opcion_Categoria1_idx` (`idCategoria`),
  CONSTRAINT `fk_Opcion_Categoria1` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opcion`
--

LOCK TABLES `opcion` WRITE;
/*!40000 ALTER TABLE `opcion` DISABLE KEYS */;
INSERT INTO `opcion` VALUES (1,1,'nunca',1,'2016-01-29 20:41:03','d76649d882ed9ccbf87208516981f422'),(2,1,'casi nunca',2,'2016-01-29 20:41:08','1e61ceb5ec742496b6413e78cca87624'),(3,1,'en ocasiones',3,'2016-01-29 20:41:18','84c7a4c397cc753d45bfdd0fed790550'),(4,1,'casi siempre',4,'2016-01-29 20:41:26','fafaed1ede7c5c263b495f77cdcf6566'),(5,1,'siempre',5,'2016-01-29 20:41:29','b6b1423fa7dc251d0eb06dd606081b69'),(6,2,'Marginal',1,'2016-02-04 11:38:02','4ee86589659cc12e413dc1bcdc20de0b'),(7,2,'Insuficiente',2,'2016-02-04 11:38:07','cc596bde521ac152eda35bc28870b975'),(8,2,'Adecuado',3,'2016-02-04 11:38:13','c2e3a38ad65657a8ac8cc1d1715d3fa0'),(9,2,'Superior',4,'2016-02-04 11:38:20','f5be6289f5446f7e9eb13577c12fc3ce'),(10,2,'Excelente',5,'2016-02-04 11:38:27','615a90338ce48f9c773ed92b6e4bb861');
/*!40000 ALTER TABLE `opcion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parametro`
--

DROP TABLE IF EXISTS `parametro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parametro` (
  `idParametro` int(11) NOT NULL AUTO_INCREMENT,
  `parametro` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` datetime NOT NULL,
  `hash` varchar(45) NOT NULL,
  PRIMARY KEY (`idParametro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parametro`
--

LOCK TABLES `parametro` WRITE;
/*!40000 ALTER TABLE `parametro` DISABLE KEYS */;
/*!40000 ALTER TABLE `parametro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poliza`
--

DROP TABLE IF EXISTS `poliza`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poliza` (
  `idPoliza` int(11) NOT NULL AUTO_INCREMENT,
  `idEmpresa` int(11) NOT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `idProveedor` varchar(45) DEFAULT NULL,
  `tipo` varchar(2) NOT NULL,
  `poliza` varchar(100) NOT NULL,
  `fecha` datetime NOT NULL,
  `tipoPoliza` varchar(2) NOT NULL,
  `origen` varchar(45) NOT NULL,
  PRIMARY KEY (`idPoliza`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poliza`
--

LOCK TABLES `poliza` WRITE;
/*!40000 ALTER TABLE `poliza` DISABLE KEYS */;
/*!40000 ALTER TABLE `poliza` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preferenciasimple`
--

DROP TABLE IF EXISTS `preferenciasimple`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `preferenciasimple` (
  `idPregunta` int(11) NOT NULL,
  `idOpcion` int(11) NOT NULL,
  `preferencia` int(11) NOT NULL,
  PRIMARY KEY (`idPregunta`,`idOpcion`),
  KEY `fk_PreferenciaSimple_Pregunta1_idx` (`idPregunta`),
  KEY `fk_PreferenciaSimple_Opcion1_idx` (`idOpcion`),
  CONSTRAINT `fk_PreferenciaSimple_Opcion1` FOREIGN KEY (`idOpcion`) REFERENCES `opcion` (`idOpcion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_PreferenciaSimple_Pregunta1` FOREIGN KEY (`idPregunta`) REFERENCES `pregunta` (`idPregunta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preferenciasimple`
--

LOCK TABLES `preferenciasimple` WRITE;
/*!40000 ALTER TABLE `preferenciasimple` DISABLE KEYS */;
INSERT INTO `preferenciasimple` VALUES (1,1,0),(1,2,0),(1,3,1),(1,4,1),(1,5,1),(2,1,0),(2,2,1),(2,3,1),(2,4,0),(2,5,1),(3,1,0),(3,2,0),(3,3,0),(3,4,1),(3,5,2),(4,1,0),(4,2,0),(4,3,0),(4,4,2),(4,5,1),(5,1,0),(5,2,0),(5,3,1),(5,4,1),(5,5,1),(6,1,0),(6,2,0),(6,3,0),(6,4,1),(6,5,2),(7,1,0),(7,2,0),(7,3,0),(7,4,1),(7,5,2),(8,1,0),(8,2,0),(8,3,1),(8,4,1),(8,5,1),(9,1,0),(9,2,1),(9,3,0),(9,4,1),(9,5,1),(10,1,0),(10,2,0),(10,3,0),(10,4,1),(10,5,2),(11,1,0),(11,2,0),(11,3,0),(11,4,0),(11,5,3),(12,1,0),(12,2,0),(12,3,1),(12,4,0),(12,5,2),(13,1,0),(13,2,0),(13,3,1),(13,4,1),(13,5,1),(14,1,0),(14,2,1),(14,3,1),(14,4,0),(14,5,1),(17,1,1),(17,2,0),(17,3,5),(17,4,3),(17,5,0),(18,1,0),(18,2,2),(18,3,2),(18,4,4),(18,5,1),(19,1,0),(19,2,0),(19,3,2),(19,4,2),(19,5,5),(20,1,0),(20,2,0),(20,3,3),(20,4,4),(20,5,2),(21,1,0),(21,2,0),(21,3,3),(21,4,4),(21,5,1),(22,1,0),(22,2,0),(22,3,2),(22,4,2),(22,5,4),(23,1,0),(23,2,1),(23,3,7),(23,4,1),(23,5,0),(24,1,0),(24,2,0),(24,3,6),(24,4,2),(24,5,1),(25,1,0),(25,2,1),(25,3,2),(25,4,2),(25,5,4),(26,1,0),(26,2,1),(26,3,3),(26,4,3),(26,5,2),(27,1,0),(27,2,0),(27,3,1),(27,4,4),(27,5,4),(28,1,0),(28,2,0),(28,3,3),(28,4,3),(28,5,3),(29,1,1),(29,2,0),(29,3,5),(29,4,2),(29,5,1),(30,1,2),(30,2,2),(30,3,3),(30,4,1),(30,5,1),(31,1,0),(31,2,0),(31,3,1),(31,4,0),(31,5,0),(32,1,0),(32,2,0),(32,3,0),(32,4,0),(32,5,1),(35,1,0),(35,2,0),(35,3,0),(35,4,0),(35,5,1),(36,1,0),(36,2,0),(36,3,0),(36,4,1),(36,5,0),(37,1,0),(37,2,0),(37,3,0),(37,4,1),(37,5,0),(38,1,0),(38,2,0),(38,3,0),(38,4,1),(38,5,0),(39,1,0),(39,2,0),(39,3,1),(39,4,0),(39,5,0),(40,1,0),(40,2,0),(40,3,1),(40,4,0),(40,5,0),(41,1,0),(41,2,0),(41,3,0),(41,4,1),(41,5,0),(42,1,0),(42,2,0),(42,3,0),(42,4,0),(42,5,0),(43,1,0),(43,2,1),(43,3,0),(43,4,0),(43,5,0),(44,1,0),(44,2,0),(44,3,1),(44,4,0),(44,5,0),(45,1,0),(45,2,0),(45,3,0),(45,4,1),(45,5,0),(46,1,0),(46,2,0),(46,3,0),(46,4,0),(46,5,1),(47,1,0),(47,2,0),(47,3,0),(47,4,0),(47,5,1),(48,1,0),(48,2,0),(48,3,0),(48,4,1),(48,5,0),(49,1,0),(49,2,0),(49,3,0),(49,4,1),(49,5,0),(50,1,0),(50,2,0),(50,3,0),(50,4,1),(50,5,0),(51,1,0),(51,2,0),(51,3,0),(51,4,1),(51,5,0),(52,6,0),(52,7,0),(52,8,4),(52,9,4),(52,10,1),(53,6,0),(53,7,2),(53,8,4),(53,9,3),(53,10,0),(54,6,0),(54,7,3),(54,8,4),(54,9,1),(54,10,1),(55,6,0),(55,7,1),(55,8,5),(55,9,3),(55,10,0),(56,6,1),(56,7,2),(56,8,4),(56,9,1),(56,10,1),(57,6,0),(57,7,0),(57,8,4),(57,9,2),(57,10,2),(58,6,0),(58,7,1),(58,8,4),(58,9,2),(58,10,2),(59,6,1),(59,7,1),(59,8,4),(59,9,2),(59,10,1),(60,6,0),(60,7,0),(60,8,4),(60,9,4),(60,10,1),(61,6,0),(61,7,1),(61,8,3),(61,9,2),(61,10,3),(62,6,0),(62,7,0),(62,8,5),(62,9,3),(62,10,1),(63,6,0),(63,7,1),(63,8,5),(63,9,1),(63,10,2),(64,6,0),(64,7,0),(64,8,3),(64,9,4),(64,10,1),(65,6,0),(65,7,1),(65,8,3),(65,9,2),(65,10,3),(66,6,0),(66,7,0),(66,8,5),(66,9,2),(66,10,2),(67,6,0),(67,7,1),(67,8,4),(67,9,3),(67,10,1),(68,6,1),(68,7,0),(68,8,2),(68,9,3),(68,10,3),(69,6,0),(69,7,1),(69,8,4),(69,9,1),(69,10,3),(70,6,0),(70,7,0),(70,8,4),(70,9,3),(70,10,2),(71,6,0),(71,7,0),(71,8,4),(71,9,3),(71,10,2),(72,6,0),(72,7,1),(72,8,4),(72,9,4),(72,10,0),(73,6,0),(73,7,1),(73,8,5),(73,9,1),(73,10,2),(74,6,0),(74,7,1),(74,8,2),(74,9,4),(74,10,2);
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
  `pregunta` text NOT NULL,
  `origen` varchar(1) NOT NULL,
  `idOrigen` varchar(20) NOT NULL,
  `tipo` varchar(2) NOT NULL,
  `opciones` text,
  `orden` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `hash` varchar(45) NOT NULL,
  PRIMARY KEY (`idPregunta`),
  KEY `fk_Pregunta_Encuesta1_idx` (`idEncuesta`),
  CONSTRAINT `fk_Pregunta_Encuesta1` FOREIGN KEY (`idEncuesta`) REFERENCES `encuesta` (`idEncuesta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pregunta`
--

LOCK TABLES `pregunta` WRITE;
/*!40000 ALTER TABLE `pregunta` DISABLE KEYS */;
INSERT INTO `pregunta` VALUES (1,1,'¿Es importante lo que estás aprendiendo y comprendes cómo se relaciona con otras materias y temas?','G','1','SS','1,2,3,4,5',1,'2016-01-29 20:45:57','93606223302833ff478d310ff7822de0'),(2,1,'¿En esta materia fue clara la forma de evaluación?','G','1','SS','1,2,3,4,5',2,'2016-01-29 20:46:27','1f926ab6b48be91ee6a1d2fd734391de'),(3,1,'¿Conoces las reglas de comportamiento dentro del salón de clases?','G','2','SS','1,2,3,4,5',1,'2016-01-30 09:30:24','3fde53e1ad011b9b76db37293233df41'),(4,1,'¿Las reglas de comportamiento son aplicadas cuando es necesario? ','G','2','SS','1,2,3,4,5',2,'2016-01-30 09:30:33','0d961852c5d3f3e3eb3aaa68cebf1560'),(5,1,'¿El maestro las motiva constantemente para tener un mejor desempeño? ','G','3','SS','1,2,3,4,5',1,'2016-01-30 09:31:12','ddf6546731ef9307f03d2317e78a8e96'),(6,1,'¿Las metas que pone el maestro son retadoras pero al mismo tiempo alcanzables? ','G','3','SS','1,2,3,4,5',2,'2016-01-30 09:31:24','7b5c7e92f8bff34c864bf6e179212722'),(7,1,'¿En el salón de clases se atienden las necesidades de cada una de las alumnas? ','G','4','SS','1,2,3,4,5',1,'2016-01-30 09:32:00','dc00cf7331fe20e24000116eb627b631'),(8,1,'¿Sientes que el maestro reconoce tus logros y tus dificultades? ','G','4','SS','1,2,3,4,5',2,'2016-01-30 09:32:14','37f989d2eb18ce03d26a5fdb867477d7'),(9,1,'¿El maestro fomenta la participación y eres escuchada y tomada en cuenta? ','G','6','SS','1,2,3,4,5',1,'2016-01-30 09:34:02','7db0d0eb992faf1beb83e60937f20138'),(10,1,'¿El maestro genera experiencias para colaborar y trabajar en equipo durante el curso? ','G','6','SS','1,2,3,4,5',2,'2016-01-30 09:34:13','5cf5437e23c713377711c9d376ffc8f2'),(11,1,'¿Le tienes confianza al maestro para expresarle tus dudas, preguntas y sugerencias?','G','7','SS','1,2,3,4,5',1,'2016-01-30 09:34:46','9dd9e8d9bf9240900b19ec018b0f298b'),(12,1,'¿Cuándo tienes una dificultad el maestro te apoya? ','G','7','SS','1,2,3,4,5',2,'2016-01-30 09:34:56','f875ce6776bfb1591759d29f3e9403ba'),(13,1,'¿El salón de clases es un espacio seguro donde no son permitidas las agresiones de ningún tipo?','G','8','SS','1,2,3,4,5',1,'2016-01-30 09:36:48','a21990d09d52ee030af2a2daef4aff5f'),(14,1,'¿En el salón de clases te sientes respetada por el maestro? ','G','8','SS','1,2,3,4,5',2,'2016-01-30 09:37:00','545613b6298bca8000d76faadc4d9f81'),(15,2,'primea','G','9','AB',NULL,1,'2016-02-04 09:55:58','5d973144edebe96036fb5319525c9d68'),(16,2,'primera','G','9','AB',NULL,2,'2016-02-04 09:56:20','d594056f04c0e7743c7813f5b63911ef'),(17,3,'¿Entiendes a la maestra cuando explica un tema?','G','10','SS','1,2,3,4,5',1,'2016-02-04 10:27:52','7eb555c6d6e8ef713fab529a1c3b8a26'),(18,3,'¿Sabes por qué es importante el tema que están viendo? ','G','10','SS','1,2,3,4,5',2,'2016-02-04 10:28:11','ac6e19c86b13582fcb28929e50c70c0d'),(19,3,'¿Conoces las reglas de comportamiento dentro del salón de clases?','G','11','SS','1,2,3,4,5',1,'2016-02-04 10:30:23','9febe0b6c3bb3fd2d7d98d8b27f62e92'),(20,3,'¿Tu maestra aplica las reglas cuando alguien no se está portando bien?','G','11','SS','1,2,3,4,5',2,'2016-02-04 10:31:04','bb578e6c9b3565d85067f5be3743a6c8'),(21,3,'¿Tu maestra te motiva para esforzarte al máximo?','G','12','SS','1,2,3,4,5',1,'2016-02-04 10:33:48','e0d20617441138faef5f4be700ee69a3'),(22,3,'¿Tu maestra te pone retos para cada vez lo hagas mejor?','G','12','SS','1,2,3,4,5',2,'2016-02-04 10:34:21','773e1538ace01a0d50d9c4bc6f249da0'),(23,3,'¿Te sientes en confianza en clases para hacer preguntas a la maestra?','G','13','SS','1,2,3,4,5',1,'2016-02-04 10:36:21','93135b30975cfb9a6aedfff9a909a78b'),(24,3,'¿Tu maestra esta cerca de ti cuando tienes un logro importante o cuando fallas en algo?','G','13','SS','1,2,3,4,5',2,'2016-02-04 10:36:59','33215ce3661ba892423d60fac1db0b3a'),(25,3,'¿Te sientes segura en el salón de clases por que sabes que nadie te va a molestar o lastimar?','G','14','SS','1,2,3,4,5',1,'2016-02-04 10:39:26','9d3f557bcd9be21ebce219b459405ffc'),(26,3,'¿Tu maestra y tus compañeras te respetan?','G','14','SS','1,2,3,4,5',2,'2016-02-04 10:39:44','5ffca2e03245281c9fe65117151766ae'),(27,3,'¿Te gusta lo que aprendes en la escuela?','G','15','SS','1,2,3,4,5',1,'2016-02-04 10:41:20','e72f0a2afe24b1e87a0333b16b4bcf30'),(28,3,'¿Crees que tu maestra explica los temas de manera interesante y atractiva?','G','15','SS','1,2,3,4,5',2,'2016-02-04 10:42:01','9733dc5b481c4ab79e7c5da4c98604cd'),(29,3,'¿Tu maestra mantiene el salón de cases limpio y ordenado, para que todas nos sintamos a gusto para trabajar mejor?','G','16','SS','1,2,3,4,5',1,'2016-02-04 10:44:17','b3a2847002fcef826d3b1268b535099b'),(30,3,'¿Tu maestra hace cambios al salón - mueve bancas, abre ventanas, ilumina, utiliza las paredes para pegar cosas- para favorecer el aprendizaje?','G','16','SS','1,2,3,4,5',2,'2016-02-04 10:45:11','330c547515266d579cd22bee5dfe3452'),(31,4,'¿Es importante lo que estas aprendiendo y comprendes como se relaciona con otras materias  y temas?','G','17','SS','1,2,3,4,5',1,'2016-02-04 10:47:48','feca3611e80d23f7b994c1567ec83473'),(32,4,'¿En esta materia fue clara la forma de evaluación?','G','17','SS','1,2,3,4,5',2,'2016-02-04 10:48:58','d538a623da5af1d65fdd4f716853212a'),(35,4,'¿El maestro las motiva constantemente para tener un mejor desempeño? ','G','19','SS','1,2,3,4,5',1,'2016-02-04 11:13:05','0d3fcb3fe1ed3187c6c38968db717cdc'),(36,4,'¿Las metas que pone el maestro son retadoras pero al mismo tiempo alcanzables? ','G','19','SS','1,2,3,4,5',2,'2016-02-04 11:13:26','2adef4ddda55d70f423fc469b23150d5'),(37,4,'¿En el salón de clases se atienden las necesidades de cada una de las alumnas? ','G','20','SS','1,2,3,4,5',1,'2016-02-04 11:14:38','f8eb8e0e9fd1e4fcbc2aa6600d347fb0'),(38,4,'¿Sientes que el maestro reconoce tus logros y tus dificultades? ','G','20','SS','1,2,3,4,5',2,'2016-02-04 11:14:55','8d234304ad8a8988624ccb13e3a31fc5'),(39,4,'¿El maestro fomenta la participación y eres escuchada y tomada en cuenta? ','G','21','SS','1,2,3,4,5',1,'2016-02-04 11:16:37','8bc1aa05333639965bdd1661ed8da38a'),(40,4,'¿El maestro genera experiencias para colaborar y trabajar en equipo durante el curso? ','G','21','SS','1,2,3,4,5',2,'2016-02-04 11:16:55','195f01c5c99ec34a70be4fb9459a9ace'),(41,4,'¿Le tienes confianza al maestro para expresarle tus dudas, preguntas y sugerencias?','G','22','SS','1,2,3,4,5',1,'2016-02-04 11:20:04','2ba8b824d59e88c380526d8d2a5a99a7'),(42,4,'¿Cuándo tienes una dificultad el maestro te apoya? ','G','22','SS','1,2,3,4,5',2,'2016-02-04 11:20:17','58b7caa71ba5b24967389f466c106108'),(43,4,'¿El salón de clases es un espacio seguro donde no son permitidas las agresiones de ningún tipo?','G','23','SS','1,2,3,4,5',1,'2016-02-04 11:25:17','48239013dc3e21c7e48d9019ddcc7767'),(44,4,'¿En el salón de clases te sientes respetada por el maestro? ','G','23','SS','1,2,3,4,5',2,'2016-02-04 11:26:19','26057aea2b1ad5db9b3c566b652ac8c5'),(45,4,'¿Formas parte del grupo y te sientes integrada?','G','23','SS','1,2,3,4,5',3,'2016-02-04 11:26:44','fe3c164f991006ffa363f14498932bf4'),(46,4,'¿Conoces las reglas de comportamiento dentro del salón de clases?','G','18','SS','1,2,3,4,5',3,'2016-02-04 11:31:02','e941b2cd3bbf7d8ac33320c6544c3973'),(47,4,'¿Las reglas de comportamiento son aplicadas cuando es necesario?','G','18','SS','1,2,3,4,5',4,'2016-02-04 11:31:13','812c071728e906aa574da454c5c71017'),(48,4,'¿El maestro consigue que esta materia te interese?','G','24','SS','1,2,3,4,5',1,'2016-02-04 11:32:33','9804356e7c3d5916f3277270d6dd38d0'),(49,4,'¿El maestro es entusiasta y emprendedor con respecto a su materia?','G','24','SS','1,2,3,4,5',2,'2016-02-04 11:32:59','a0e600d51fb66ae5d0ccfab171832a4c'),(50,4,'¿El maestro contribuye con la limpieza y orden del salón?','G','25','SS','1,2,3,4,5',1,'2016-02-04 11:34:16','382aaf745268b1d862552424119cb3db'),(51,4,'¿El maestro optimiza los espacios - mueve las bancas, abre ventanas, ilumina, utiliza las paredes para pegar cosas- para favorecer el aprendizaje?','G','25','SS','1,2,3,4,5',2,'2016-02-04 11:35:43','659642173784f6e2f1faf1f58344e8cf'),(52,5,'El maestro planea su curso con base al momento de desarrollo de las alumnas, al mapa de contenidos, el programa de estudios y transversalidad','G','26','SS','6,7,8,9,10',1,'2016-02-04 11:39:59','fb7cdfa5eea9cf7e15f870ec86877e8d'),(53,5,'El maestro planea e imparte las clases de manera estructurada, de acuerdo a la metodología Clase Sagrado Corazón incluyendo un encuadre inicial y brindando instrucciones claras para cada actividad','G','26','SS','6,7,8,9,10',2,'2016-02-04 11:41:36','8b4fc0b2c067890d718ed948177e56b0'),(54,5,'El maestro ajusta el programa y las lecciones al reto que cada grupo requiere para sentirse motivado','G','27','SS','6,7,8,9,10',1,'2016-02-04 11:43:28','8a46ecd51395b1b3439587186b204ad0'),(55,5,'El maestro revisa conocimientos previos y ajusta el punto de partida de cada nueva lección de acuerdo al nivel del grupo','G','27','SS','6,7,8,9,10',2,'2016-02-04 11:44:12','11f1f091e2348355acc545ba57b80cd0'),(56,5,'El maestro es intencional en el desarrollo de los macro procesos de pensamiento en el diseño de sus clases','G','26','SS','6,7,8,9,10',3,'2016-02-04 11:45:21','774632ab25fb628d6f917c6ab3d90de7'),(57,5,'El maestro utiliza una variedad de estrategias de enseñanza para favorecer la comprensión y mantener a las alumnas involucradas en la tarea','G','28','SS','6,7,8,9,10',1,'2016-02-04 11:47:27','a07be2e11c9e5513611dbf161b1447ca'),(58,5,'El maestro utiliza la mediación para promover un aprendizaje significativo','G','28','SS','6,7,8,9,10',2,'2016-02-04 11:48:01','b6b745111cf455597141a9f2471811fb'),(59,5,'EL maestro maneja el error como fuente de aprendizaje','G','28','SS','6,7,8,9,10',3,'2016-02-04 11:48:18','c6673c79f21cc8c5dc8e30090b22a24a'),(60,5,'El maestro establece limites claros y consecuencias de comportamiento','G','29','SS','6,7,8,9,10',1,'2016-02-04 11:49:30','9f2fff68abb8c015f71eb73d33e36456'),(61,5,'El maestro regula la conducta y resuelve los conflictos que se presentan en el grupo','G','29','SS','6,7,8,9,10',2,'2016-02-04 11:49:56','a7358d41843131a650f48db6fb9f355a'),(62,5,'El maestro reconoce y refuerza el  buen comportamiento','G','29','SS','6,7,8,9,10',3,'2016-02-04 11:50:16','a5b26846df5cd7ad82f0c20a834f29a9'),(63,5,'El maestro inicia y termina cada clase de manera puntual, utilizando el tiempo de manera efectiva','G','30','SS','6,7,8,9,10',1,'2016-02-04 11:51:36','a0ca975b9e910dd98e0a5c97059a97b4'),(64,5,'El maestro atiende de manera equitativa a todas las alumnas','G','30','SS','6,7,8,9,10',2,'2016-02-04 11:51:56','44986ed40fa55459354e40939b9c01e8'),(65,5,'El maestro utiliza de manera efectiva distintos recursos didácticos, incluyendo el uso de las TIC','G','30','SS','6,7,8,9,10',3,'2016-02-04 11:52:43','e6d74b5168629f568e83a91bac06a00e'),(66,5,'El maestro aplica una variedad de estrategias de evaluación (Incluyendo la autoevaluación y coevaluación)','G','31','SS','6,7,8,9,10',1,'2016-02-04 11:54:08','cca8fcffb9d64d77df670d44c5f7d2c6'),(67,5,'El maestro brinda retroalimentación objetiva y oportuna al grupo de alumnas','G','31','SS','6,7,8,9,10',2,'2016-02-04 11:54:37','6044b85b1a08ba894bbdbefccdd1eae5'),(68,5,'El maestro solicita tareas pertinentes para el proceso de apredizaje','G','32','SS','6,7,8,9,10',1,'2016-02-04 11:55:34','c223297dbc9ca6081eaf081e85356bd6'),(69,5,'El maestro revisa las tareas de manera consistente y oportuna para construir el aprendizaje','G','32','SS','6,7,8,9,10',2,'2016-02-04 11:56:17','e880a01d857ce93052654f1ca9f594a7'),(70,5,'El maestro aplica en cada clase la secuencia de entrada, elaboración y salida','G','33','SS','6,7,8,9,10',1,'2016-02-04 11:57:12','62e07189dcb089129ae3a826b8d0dde3'),(71,5,'El maestro consigue que la clase sea fluida y equilibrada en cuanto al tipo de actividades','G','33','SS','6,7,8,9,10',2,'2016-02-04 11:58:02','8da998904332b843478e91b9239d47aa'),(72,5,'El profesor propicia la elaboración de síntesis, conclusiones y principios','G','33','SS','6,7,8,9,10',3,'2016-02-04 11:58:43','7a953ea3c0eefbf632ef480eb26f21cd'),(73,5,'El profesor verifica la comprensión de conceptos y transferencia a la vida real','G','33','SS','6,7,8,9,10',4,'2016-02-04 11:59:16','9195451798fab3a997f2ea7a7a7b22ab'),(74,5,'El profesor revisa el proceso metacognitivo','G','33','SS','6,7,8,9,10',5,'2016-02-04 11:59:36','c9049f6f143adb23e08b737980752442');
/*!40000 ALTER TABLE `pregunta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto` (
  `idProducto` int(11) NOT NULL AUTO_INCREMENT,
  `producto` varchar(150) NOT NULL,
  `claveProducto` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productocompuesto`
--

DROP TABLE IF EXISTS `productocompuesto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productocompuesto` (
  `idProductoCompuesto` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` int(11) NOT NULL,
  `productoEnlazado` varchar(20) DEFAULT NULL,
  `cantidad` float DEFAULT NULL,
  PRIMARY KEY (`idProductoCompuesto`),
  KEY `fk_ProductoCompuesto_Producto1_idx` (`idProducto`),
  CONSTRAINT `fk_ProductoCompuesto_Producto1` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productocompuesto`
--

LOCK TABLES `productocompuesto` WRITE;
/*!40000 ALTER TABLE `productocompuesto` DISABLE KEYS */;
/*!40000 ALTER TABLE `productocompuesto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyecto`
--

DROP TABLE IF EXISTS `proyecto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proyecto` (
  `idProyecto` int(11) NOT NULL AUTO_INCREMENT,
  `proyecto` varchar(60) NOT NULL,
  `descripcion` text NOT NULL,
  `costo` decimal(10,0) NOT NULL,
  `ganancia` decimal(10,0) NOT NULL,
  `fechaApertura` datetime NOT NULL,
  `fechaCierre` datetime NOT NULL,
  PRIMARY KEY (`idProyecto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyecto`
--

LOCK TABLES `proyecto` WRITE;
/*!40000 ALTER TABLE `proyecto` DISABLE KEYS */;
/*!40000 ALTER TABLE `proyecto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registro`
--

DROP TABLE IF EXISTS `registro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registro` (
  `idRegistro` int(11) NOT NULL AUTO_INCREMENT,
  `referencia` text NOT NULL,
  `tipo` varchar(5) NOT NULL,
  `nombres` varchar(200) NOT NULL,
  `apellidos` varchar(200) NOT NULL,
  `fecha` datetime NOT NULL,
  `hash` varchar(45) NOT NULL,
  PRIMARY KEY (`idRegistro`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro`
--

LOCK TABLES `registro` WRITE;
/*!40000 ALTER TABLE `registro` DISABLE KEYS */;
INSERT INTO `registro` VALUES (1,'20160129DAMM','AL','Dalia Asucena','Martínez Martínez','2016-01-29 20:42:30','d729d0d865aa593767c33037b42f2eb7'),(2,'20160129ACMM','AL','Ana Carolina','Martínez Martínez','2016-01-29 20:42:48','9d5e8a2d9f32fb2ab0564b2986ef76f5'),(3,'20160129ARMP','AL','Areli','Morales Palma','2016-01-29 20:43:17','cffe65f988cf705c111ede08b241fa73'),(4,'20160129TOMT','AL','Tonantzin','Martínez Trujillo','2016-01-29 20:43:47','5bde0810268417fc3f444daaa726f788'),(5,'20160129CAML','AL','Carmen','Martínez Lagunes','2016-01-29 20:44:50','307f4afdcc1acd900749c56537db44d4'),(6,'20160204ALSG','AL','Alejandra','Sanchez Garcia','2016-02-04 12:08:11','65a852689f308f92c57c59a7a4dd0fd9'),(7,'20160204ISD','AL','Isela','Diaz','2016-02-04 12:11:05','a48c9dfcc5e98da09673a64d067661b7'),(8,'20160204JED','AL','Yessica','Diaz','2016-02-04 12:11:22','f53a20a9915edefe231b43eb112b51eb'),(9,'20160204ADMM','AL','Adolfo','Martinez Martinez','2016-02-04 12:11:41','833fcff49f8bbc207bb3014cb9804bb7'),(10,'20160204MIRM','AL','Miguel','Rodriguez Machain','2016-02-04 12:12:08','63efb0d6b01caee79ff8e4b9289a6ed8');
/*!40000 ALTER TABLE `registro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `respuesta`
--

DROP TABLE IF EXISTS `respuesta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `respuesta` (
  `idEncuesta` int(11) NOT NULL,
  `idRegistro` int(11) NOT NULL,
  `idPregunta` int(11) NOT NULL,
  `respuesta` text NOT NULL,
  `fecha` datetime NOT NULL,
  `hash` varchar(45) NOT NULL,
  PRIMARY KEY (`idEncuesta`,`idRegistro`,`idPregunta`),
  KEY `fk_Respuesta_Pregunta1_idx` (`idPregunta`),
  KEY `fk_Respuesta_Registro1_idx` (`idRegistro`),
  KEY `fk_Respuesta_Encuesta1_idx` (`idEncuesta`),
  CONSTRAINT `fk_Respuesta_Encuesta1` FOREIGN KEY (`idEncuesta`) REFERENCES `encuesta` (`idEncuesta`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Respuesta_Pregunta1` FOREIGN KEY (`idPregunta`) REFERENCES `pregunta` (`idPregunta`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Respuesta_Registro1` FOREIGN KEY (`idRegistro`) REFERENCES `registro` (`idRegistro`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `respuesta`
--

LOCK TABLES `respuesta` WRITE;
/*!40000 ALTER TABLE `respuesta` DISABLE KEYS */;
INSERT INTO `respuesta` VALUES (1,1,1,'4','2016-01-30 09:39:13','363ddda6c08f85fa5984f449e3ba80dd'),(1,1,2,'3','2016-01-30 09:39:13','0b164d1cc9b825dfb07bf1ca2e32e9ad'),(1,1,3,'5','2016-01-30 09:39:14','4b883bd386d4ab746090dbd001cac7d4'),(1,1,4,'4','2016-01-30 09:39:14','a7ebe537569769366c5bd9854f34b312'),(1,1,5,'4','2016-01-30 09:39:14','b4d18a6a807a048bf3ba0553b1d07128'),(1,1,6,'5','2016-01-30 09:39:14','a752d237a22e7bcf81be2aa4eeed92ba'),(1,1,7,'5','2016-01-30 09:39:14','974785e6f9b0e994722d3d8bcb2b7be1'),(1,1,8,'4','2016-01-30 09:39:14','5aab376d6966293d309c8b61390f01b4'),(1,1,9,'4','2016-01-30 09:39:14','9a2762c1a7277af782223d991c778543'),(1,1,10,'5','2016-01-30 09:39:14','66883fe6645617e57065af6be64056bc'),(1,1,11,'5','2016-01-30 09:39:14','72a531460a5dc5a1721f8827600b4423'),(1,1,12,'3','2016-01-30 09:39:14','63070990599cf6d17f878b58f94eb394'),(1,1,13,'3','2016-01-30 09:39:14','530b76b6e11f920b42069bc2e7a8647c'),(1,1,14,'2','2016-01-30 09:39:14','b3680529912d3246ab18f3beaee7cb9b'),(1,3,1,'3','2016-01-30 10:05:15','df1143ce438a2e4b7f3c61a434ca9b59'),(1,3,2,'2','2016-01-30 10:05:15','58719b97e027fc72e0a27d40d1c8ecc9'),(1,3,3,'4','2016-01-30 10:05:15','f8dc1f50a7a0d96142daacf962764e8d'),(1,3,4,'4','2016-01-30 10:05:15','6d06bb50f5bec005911edf6c40342fbb'),(1,3,5,'3','2016-01-30 10:05:16','dd6bcf7f40bf99062c2287616f847d52'),(1,3,6,'4','2016-01-30 10:05:16','e0744278166d3e71a84718c8ef90ff12'),(1,3,7,'4','2016-01-30 10:05:16','68afe1d9501c1c230ba1e38a048e37e7'),(1,3,8,'3','2016-01-30 10:05:16','206481f6c32247d16e6637e0ed4d4085'),(1,3,9,'2','2016-01-30 10:05:16','331e625534b0bb3342f282e09eefd4ae'),(1,3,10,'4','2016-01-30 10:05:16','214329a3f13a38fa837df77425157bdd'),(1,3,11,'5','2016-01-30 10:05:16','03f7f0b7e160301eb2df55580c2d245f'),(1,3,12,'5','2016-01-30 10:05:16','3e1daee55fd1c180fd0c1bbcd4009be8'),(1,3,13,'4','2016-01-30 10:05:16','9124bd1bea9507fecda65e1ee6b90691'),(1,3,14,'3','2016-01-30 10:05:16','9825445a855f815fc17dba7f39ae3a1d'),(1,5,1,'5','2016-01-30 11:51:27','02cf65802ead5db31d715336e52c3215'),(1,5,2,'5','2016-01-30 11:51:27','6377c323ce21db9378751f7d63106a43'),(1,5,3,'5','2016-01-30 11:51:27','b1f4321f99ea6aaa2557d8a3a18fc609'),(1,5,4,'5','2016-01-30 11:51:27','56b0481d2c80fa8cfa9d8679d2874f3b'),(1,5,5,'5','2016-01-30 11:51:27','a5317d4ceab85579ff9a23345b4876a2'),(1,5,6,'5','2016-01-30 11:51:27','81ab4e9e57b6563fc804d891d60edf33'),(1,5,7,'5','2016-01-30 11:51:27','88d650bd870bf0b73d87a4a5946f6c30'),(1,5,8,'5','2016-01-30 11:51:27','6535936882f8492674e0d6c3b8dbf71a'),(1,5,9,'5','2016-01-30 11:51:27','25feeab63a858dd71c466c16c72ab7e3'),(1,5,10,'5','2016-01-30 11:51:28','2bfcc25263709c84076d6e63e4dc4834'),(1,5,11,'5','2016-01-30 11:51:28','87f60c1c99dcd7b91b9484347fb77da8'),(1,5,12,'5','2016-01-30 11:51:28','4ea51e3daecc78e1969af60d5e31a237'),(1,5,13,'5','2016-01-30 11:51:28','aa5f66ec9e05fa210c70a1716e675e59'),(1,5,14,'5','2016-01-30 11:51:28','f81f779eb2d2233188f04e7974b3422b'),(3,1,17,'3','2016-02-04 12:30:43','7c13d5eabbbedbd9c8d27eab253c2790'),(3,1,18,'4','2016-02-04 12:30:44','e9c2fdcf316467112dec242c554d29ba'),(3,1,19,'5','2016-02-04 12:30:44','3eb80f2022124365f06744c51a8ba2d4'),(3,1,20,'5','2016-02-04 12:30:44','b9caefeca874ad29282526d28005507f'),(3,1,21,'4','2016-02-04 12:30:44','419480fa9fc5fc2fb5c15c281a395a89'),(3,1,22,'5','2016-02-04 12:30:44','75aaca74a3e1a09e82ec80385862f0e0'),(3,1,23,'3','2016-02-04 12:30:44','75e8e82e665539258c68c2c80abecd50'),(3,1,24,'4','2016-02-04 12:30:44','8b29e1d74fb88f595fb62fcfad791a81'),(3,1,25,'4','2016-02-04 12:30:45','a4be8bfd6ae88bce44887343af454d11'),(3,1,26,'4','2016-02-04 12:30:45','1e3eef70d9830a99c23f9b3519eec700'),(3,1,27,'5','2016-02-04 12:30:45','e2d384050b2974ed1af5ef861a7ef19e'),(3,1,28,'5','2016-02-04 12:30:45','f9b67b3ac61766e9f8f8934e09c64850'),(3,1,29,'3','2016-02-04 12:30:45','49485a67e2171728510c9ea21a0069c8'),(3,1,30,'5','2016-02-04 12:30:45','dd8a9bf4f8ca6efae6dec4604acef896'),(3,2,17,'3','2016-02-04 12:30:43','649e0be890697ef5720f16186992ab27'),(3,2,18,'3','2016-02-04 12:30:43','3eb442abea4863897396bb5f3729aa78'),(3,2,19,'4','2016-02-04 12:30:43','77db2a52b94514b996828cf7ba31b018'),(3,2,20,'5','2016-02-04 12:30:43','17886a963ae4e824c5ccb6e82e1dd2f7'),(3,2,21,'4','2016-02-04 12:30:43','2e8256b8d6e3a3ee8d92e3395eaa771a'),(3,2,22,'5','2016-02-04 12:30:44','d76fe86b3531b2e1b75eb9c0a6f29fc0'),(3,2,23,'3','2016-02-04 12:30:44','2412f364e068468151cef014933ab489'),(3,2,24,'3','2016-02-04 12:30:44','6affa466df2d9dd1f1c2e901c6a5dd9e'),(3,2,25,'5','2016-02-04 12:30:44','2fc81849cff25be6996a702cbf36c9f6'),(3,2,26,'5','2016-02-04 12:30:44','89462f0f1a423dea445217494b19e1cb'),(3,2,27,'4','2016-02-04 12:30:44','65f984c8ae121b4869d92cc37df1e0da'),(3,2,28,'3','2016-02-04 12:30:44','e52c9b66050256340b769ca8b44c808a'),(3,2,29,'3','2016-02-04 12:30:45','3f5dbb37e1ed73f550d1ce7bec3c5c83'),(3,2,30,'3','2016-02-04 12:30:45','010c71e521c313d9824c74f50dda49f5'),(3,3,17,'3','2016-02-04 12:30:44','6da592746401a39cdff2ca9a1f11c283'),(3,3,18,'2','2016-02-04 12:30:44','5232fb16c3591bfce193f3c83165639b'),(3,3,19,'5','2016-02-04 12:30:44','8700c79bc19dcc613f95f95b4dfd3b38'),(3,3,20,'4','2016-02-04 12:30:44','6674c93299718ddc035f5c24fc2c2bb1'),(3,3,21,'3','2016-02-04 12:30:44','96cb2ab8df9528070b7a1280f621a8d6'),(3,3,22,'4','2016-02-04 12:30:44','7d000b405d40bf96a39a9650a449af70'),(3,3,23,'3','2016-02-04 12:30:45','d6eef0363cb240bd87733b0ac7d4c614'),(3,3,24,'4','2016-02-04 12:30:45','fddbb4adc4129bdd7aed5493b3ce4a17'),(3,3,25,'5','2016-02-04 12:30:45','12cefdba586a512577418c71ac84b6b0'),(3,3,26,'4','2016-02-04 12:30:45','c6f92290213c39ebc84d9c3605ee8e98'),(3,3,27,'5','2016-02-04 12:30:45','a4519558286cbbcaf4ba95c70424a8ae'),(3,3,28,'3','2016-02-04 12:30:45','a04ef9014438399760af9b16f209f611'),(3,3,29,'3','2016-02-04 12:30:45','f43f4302af1f435d2fc535311b97dccb'),(3,3,30,'2','2016-02-04 12:30:45','b45498ec3c9aeeb9e1de4526080539f6'),(3,4,17,'1','2016-02-04 12:30:44','94d63ee66e6f78583a94563a8a685639'),(3,4,18,'2','2016-02-04 12:30:44','81a5dd83cd543cdd6d3bc8b40e400ae5'),(3,4,19,'3','2016-02-04 12:30:44','0e5d0b3236af690520e081d328ad3a74'),(3,4,20,'3','2016-02-04 12:30:44','edd127e5b6881fe6c165a4cedcda305f'),(3,4,21,'4','2016-02-04 12:30:44','8694e6a5d11ab021ffde161d2a5940d4'),(3,4,22,'4','2016-02-04 12:30:45','20008517f021d9481575dde9cddb3577'),(3,4,23,'3','2016-02-04 12:30:45','f33543043deb6013dd80c4642d9d6b89'),(3,4,24,'3','2016-02-04 12:30:45','3c33c37a2ef36f7cd3c5acbdb4040a1a'),(3,4,25,'3','2016-02-04 12:30:45','44c35424f511265de47397461698ec82'),(3,4,26,'3','2016-02-04 12:30:45','47039e4132281033eea92ab2272ed92f'),(3,4,27,'5','2016-02-04 12:30:45','b56163a725a4c108ea1ef093374e092e'),(3,4,28,'5','2016-02-04 12:30:45','e12984a34eda70cef9c03f436f1b70e2'),(3,4,29,'1','2016-02-04 12:30:45','b2329690a9fa77a9ba4c036d4288af6c'),(3,4,30,'1','2016-02-04 12:30:45','b04b5721dec62a27dc195cc5fa66de03'),(3,6,17,'4','2016-02-04 12:30:44','cd4377f580d808be22080f2e86563c6b'),(3,6,18,'4','2016-02-04 12:30:44','21dc4ddcf5919b502612c1f50cf81ede'),(3,6,19,'5','2016-02-04 12:30:44','d48d83685c57d555c1958d554c721c1c'),(3,6,20,'4','2016-02-04 12:30:44','a47b635c5cde5f8be567477052780554'),(3,6,21,'5','2016-02-04 12:30:44','41ad6794764b445bb9fb2f8b855b0a08'),(3,6,22,'5','2016-02-04 12:30:44','0d8d1af85a7dd87f15e4b595f1433ce4'),(3,6,23,'4','2016-02-04 12:30:44','a7f7658cd06fda2ebf872c2d6046cd79'),(3,6,24,'5','2016-02-04 12:30:45','4df92f8eb385c44015202dc6c370019a'),(3,6,25,'5','2016-02-04 12:30:45','a4b6879d4f3dbe40c5875c05a76d9a5e'),(3,6,26,'5','2016-02-04 12:30:45','e23d385a0bac27a3b5b3a65cfb21c78f'),(3,6,27,'5','2016-02-04 12:30:45','ad0dc544ee135d35f299753da1374aee'),(3,6,28,'5','2016-02-04 12:30:45','e5d858e32502ee051482ab85b054022b'),(3,6,29,'5','2016-02-04 12:30:45','d4c4c48b70af7d1a4dbd1f86e31e49db'),(3,6,30,'4','2016-02-04 12:30:45','e42665e3073604465c77ffce923b366a'),(3,7,17,'3','2016-02-04 12:30:43','66b646f706b59514efe4984e16ff7062'),(3,7,18,'4','2016-02-04 12:30:43','6da51b4279cd3b5e41a383d958d67464'),(3,7,19,'5','2016-02-04 12:30:43','380833ed853aa90a0ad54544baddfe1b'),(3,7,20,'3','2016-02-04 12:30:44','33bc8f41aa70f17d8a764c3bdda23b0b'),(3,7,21,'3','2016-02-04 12:30:44','498310c5bd3c9812d52476eb2faee430'),(3,7,22,'3','2016-02-04 12:30:44','a75d96d18b919873dce81712556b48d9'),(3,7,23,'3','2016-02-04 12:30:44','4cd4b85b8f759c70f6349962c91a0bb1'),(3,7,24,'3','2016-02-04 12:30:44','b133aa4eb83b95db944b0484d1c36401'),(3,7,25,'3','2016-02-04 12:30:44','8053567874241727a62ccac70ad7ed72'),(3,7,26,'3','2016-02-04 12:30:44','46cd7927b105972bf828ca6618a26422'),(3,7,27,'3','2016-02-04 12:30:44','aa23b4fcbc9656b445ca8475ea34c11b'),(3,7,28,'3','2016-02-04 12:30:44','f1e9ea863a0962818d70a0291f15472a'),(3,7,29,'3','2016-02-04 12:30:45','8308368eedd93c54f1bd668abc902e5f'),(3,7,30,'1','2016-02-04 12:30:45','abacefbba95c4b4cf927df5eeca208db'),(3,8,17,'4','2016-02-04 12:30:44','09157b96efc9e8de0dfcb3ade24190e6'),(3,8,18,'4','2016-02-04 12:30:44','67f89e59217c2ea45121da2c04886220'),(3,8,19,'3','2016-02-04 12:30:44','aa43eefcd1076bb7b75ecbfa96eae1ad'),(3,8,20,'4','2016-02-04 12:30:44','710d8f3cde95401a9e80601e63c0492a'),(3,8,21,'3','2016-02-04 12:30:45','bcaa125fd9f8e8fce164ca66d7ce1188'),(3,8,22,'3','2016-02-04 12:30:45','0cefd9e3f66e6b0314b3d239c209839b'),(3,8,23,'3','2016-02-04 12:30:45','e845c5408467b233295886f4094f81cf'),(3,8,24,'3','2016-02-04 12:30:45','1c6c93774873ed65a021ee41e5ac2e1c'),(3,8,25,'4','2016-02-04 12:30:45','8df8868e40e33bac902ce265e2002ba4'),(3,8,26,'4','2016-02-04 12:30:45','22d4db52856965929bfe030b67b3b245'),(3,8,27,'4','2016-02-04 12:30:45','bdd1b7ca078acced41c621926db7210d'),(3,8,28,'4','2016-02-04 12:30:45','8465b13f7bcd9d23b0808710a9ed1201'),(3,8,29,'4','2016-02-04 12:30:45','bf91f341acda18cf68e88f1e9db55add'),(3,8,30,'2','2016-02-04 12:30:45','b0f589b235fd535287e90ed3e7fe724e'),(3,9,17,'4','2016-02-04 12:30:44','0df53506b656935badb1bbcf10813c03'),(3,9,18,'5','2016-02-04 12:30:44','743621772b494fad3518ecfc33f5b8db'),(3,9,19,'5','2016-02-04 12:30:44','eee0fbe284798b98aa50e4bae5f5270e'),(3,9,20,'4','2016-02-04 12:30:44','0572af313d446c1670314e8d87e22966'),(3,9,23,'2','2016-02-04 12:30:44','e8e0f002d2b0a9721a27b96c0e44e7f1'),(3,9,24,'3','2016-02-04 12:30:44','7fab829286ad180315f702fbedfb77fb'),(3,9,25,'5','2016-02-04 12:30:45','e1f132b09e46b5b092feec5a788855c9'),(3,9,26,'3','2016-02-04 12:30:45','6835377dc8ee3b461d0b03e5d03a86e5'),(3,9,27,'4','2016-02-04 12:30:45','1e9c36cfca03a7b664d0ae8ba4b20acf'),(3,9,28,'4','2016-02-04 12:30:45','b9fb9dddaf15f5d3bc4ae1f1d8314a4d'),(3,9,29,'3','2016-02-04 12:30:45','4af0074f2d12f2d9d1ed49077eeae56d'),(3,9,30,'3','2016-02-04 12:30:45','087d9857c1740323045135a598cda380'),(3,10,17,'3','2016-02-04 12:30:43','39f002b738c12b48d29fcceb77dfd577'),(3,10,18,'3','2016-02-04 12:30:43','84a00f94ba41f9cb3793d7bfe38ccab2'),(3,10,19,'4','2016-02-04 12:30:43','389c30b4551bd903e917ee102e7276e0'),(3,10,20,'3','2016-02-04 12:30:43','8ab8f8795a49d4e528bd880a91164a30'),(3,10,21,'4','2016-02-04 12:30:43','9153b72587a0667a67defb1e40bb2626'),(3,10,22,'5','2016-02-04 12:30:44','db74405f176e4c37a6fae9fdf9c982bf'),(3,10,23,'3','2016-02-04 12:30:44','80bb45b186430542688d14df82675457'),(3,10,24,'3','2016-02-04 12:30:44','34f035ae9c51eb90dfa9fb2247cef948'),(3,10,25,'2','2016-02-04 12:30:44','c192b1b137b4e056ffc437ecac8da6a3'),(3,10,26,'2','2016-02-04 12:30:44','536f90f0287b27386553416aa5fc7be0'),(3,10,27,'4','2016-02-04 12:30:44','e3255423c4ea80f8ffbb9458cab49e77'),(3,10,28,'4','2016-02-04 12:30:44','44499b03b45ad51dcebcac8a6a05dbbb'),(3,10,29,'4','2016-02-04 12:30:44','b91bced5c0a5fe3974a972ab4f9fbc42'),(3,10,30,'3','2016-02-04 12:30:44','336d468a27301c6edb9197d255056fb6'),(4,10,31,'3','2016-02-04 15:01:47','2662a992bebd143823f8ab782bc3e3ea'),(4,10,32,'5','2016-02-04 15:01:47','6cebea940807395704f1f88cdcbeb499'),(4,10,35,'5','2016-02-04 15:01:47','244dc05d98806f7eb200462976a24f7e'),(4,10,36,'4','2016-02-04 15:01:47','df63dc14ff597bf73b52c7b78a630d94'),(4,10,37,'4','2016-02-04 15:01:47','bd12e2f60ba4b2d23941d2857174212a'),(4,10,38,'4','2016-02-04 15:01:47','699828a5e17dded3b4bdbe3421d171f2'),(4,10,39,'3','2016-02-04 15:01:47','cf0dcbeef824ce8ec22679f5570d82d9'),(4,10,40,'3','2016-02-04 15:01:47','4d37847fbc62b49dec70ada3d0c233b4'),(4,10,41,'4','2016-02-04 15:01:47','9d392f7c45405bfda215fe9457a6c7a4'),(4,10,43,'2','2016-02-04 15:01:47','c66a9ccfd5efe67594dc876af3fa4446'),(4,10,44,'3','2016-02-04 15:01:47','2bed8ecca9879c3f68780d9b72c97e0a'),(4,10,45,'4','2016-02-04 15:01:47','7201e3fe65d9ace08cf582f1f48ea130'),(4,10,46,'5','2016-02-04 15:01:47','c0d3edbd53013d8bd88a4499a49d9c28'),(4,10,47,'5','2016-02-04 15:01:47','7a009666dd0b0f22754b5bfaf64c9bc7'),(4,10,48,'4','2016-02-04 15:01:47','55f05120e2669d3452a97cd7959a94a5'),(4,10,49,'4','2016-02-04 15:01:47','e1521c6e051471e3a0582ce3dded9204'),(4,10,50,'4','2016-02-04 15:01:47','901cc8e0846a1ff459e6e493c0fe4a44'),(4,10,51,'4','2016-02-04 15:01:47','5732a153a9ea8b1e689ac0e43d508816'),(5,1,52,'10','2016-02-04 12:42:30','fc6cebc47d96209e9646dc40c98f3297'),(5,1,53,'9','2016-02-04 12:42:30','0ee3608f3c732e20238f8be467eef37e'),(5,1,54,'10','2016-02-04 12:42:30','015be34146633be7c0e5e0c41ac7aeac'),(5,1,55,'9','2016-02-04 12:42:30','de4d3cf052c2e92f912fa5231bef7368'),(5,1,56,'8','2016-02-04 12:42:30','798054849860bfb04bc5f1994986c639'),(5,1,57,'8','2016-02-04 12:42:30','0d74575cbf7b885a9e65bcdc750678be'),(5,1,58,'10','2016-02-04 12:42:30','4c22b45a17d1121d089334b68756fc12'),(5,1,59,'9','2016-02-04 12:42:31','bedbe07c0edf1fce9d11544db0628fdd'),(5,1,60,'9','2016-02-04 12:42:31','3f76531f5402b0dab3d11bd698025050'),(5,1,61,'10','2016-02-04 12:42:31','db8f011fa8946aea9b335a468ceae08b'),(5,1,62,'8','2016-02-04 12:42:31','f299777168a41cbb9c1ec47094b95b8e'),(5,1,63,'8','2016-02-04 12:42:31','fbec1fcdaa920cc5259f59a22f70c7cf'),(5,1,64,'9','2016-02-04 12:42:31','052aaedc76393cd78bba5e0e91697d81'),(5,1,65,'10','2016-02-04 12:42:31','dce86161f74ee5ba0935e2a2bef1af05'),(5,1,66,'10','2016-02-04 12:42:31','6c055137a8a8c45198db9d047b8ac810'),(5,1,67,'9','2016-02-04 12:42:31','737f536ea1ac723c347e9a3fb05b869f'),(5,1,68,'9','2016-02-04 12:42:31','883c627c4181b216dab56b1d9d04b911'),(5,1,69,'8','2016-02-04 12:42:31','29ac8a622d2eecd51b4b27883b44ae77'),(5,1,70,'10','2016-02-04 12:42:32','3c52cdb7fe9f26a6848703485ea47c1f'),(5,1,71,'8','2016-02-04 12:42:32','086c18021422596355d71ad861006c5f'),(5,1,72,'9','2016-02-04 12:42:32','3afdc003784df6d3433f5977de917c14'),(5,1,73,'7','2016-02-04 12:42:32','bc29262111970b371d18460f85cd3e80'),(5,1,74,'10','2016-02-04 12:42:32','c7219a959adeba956465e98951efc8dd'),(5,2,52,'9','2016-02-04 12:42:30','f029331cac44da8a4a7c8230772f3564'),(5,2,53,'8','2016-02-04 12:42:30','47f63555f2a7b2195d61de85d9531750'),(5,2,54,'8','2016-02-04 12:42:30','aaa00ff85fdd654498814634b593bb3f'),(5,2,55,'8','2016-02-04 12:42:30','54e7f497a4e803836ffc6000a26c2d90'),(5,2,56,'7','2016-02-04 12:42:30','50127b51ec5632be5a7dd4c7c2ae8254'),(5,2,57,'8','2016-02-04 12:42:30','04e476cb844dfaef26e0e3a1b54deb79'),(5,2,58,'8','2016-02-04 12:42:30','cd66b8d4172015d032299cc4274f2a89'),(5,2,59,'8','2016-02-04 12:42:30','62b1e26a9974b1acc01541eea284e8ff'),(5,2,60,'9','2016-02-04 12:42:31','cefbd0ac2a9044d4f73dade5508f79b8'),(5,2,61,'8','2016-02-04 12:42:31','14d0ea9c3479484f1c5922959a8bfb01'),(5,2,62,'8','2016-02-04 12:42:31','e8df140fe2a32053f7dd89ac7e422b9c'),(5,2,63,'8','2016-02-04 12:42:31','a3ae0beb9263fdc4f10a1c0060303a07'),(5,2,64,'8','2016-02-04 12:42:31','32f0f6e98aa3cf9b76d9ea804b4c7dd0'),(5,2,65,'8','2016-02-04 12:42:31','d7833f287802478131098454b8dcea25'),(5,2,66,'8','2016-02-04 12:42:31','4bb9db0342bb131be7dba4a39c885a62'),(5,2,67,'8','2016-02-04 12:42:31','88f8d1f11c5db18cf2e52ace40e53f61'),(5,2,68,'8','2016-02-04 12:42:31','09e7efab483c54de9e43f248e8c14e8c'),(5,2,69,'8','2016-02-04 12:42:31','ab4fd6fa89f4704f341b4d54564d2863'),(5,2,70,'8','2016-02-04 12:42:31','7dc2461b67faf57c40d4f7862faa809a'),(5,2,71,'8','2016-02-04 12:42:32','78a95e0598d24ac43636572da1124554'),(5,2,72,'8','2016-02-04 12:42:32','5c0dbe2674e986cb6767b88509752ce4'),(5,2,73,'8','2016-02-04 12:42:32','a7a860e857af1cc888d67db1912e4106'),(5,2,74,'8','2016-02-04 12:42:32','0f80d94969aee9089d31299b67e11a3b'),(5,3,52,'9','2016-02-04 12:42:30','73597179209adce7f51993929db8b89b'),(5,3,53,'8','2016-02-04 12:42:31','46a4599dbc2d46e1acc6d4cae1901bbb'),(5,3,54,'7','2016-02-04 12:42:31','deb9093da95303be8acf67b01ebccd61'),(5,3,55,'9','2016-02-04 12:42:31','cde86456b4b26c32ea60084fd16f3f3d'),(5,3,56,'6','2016-02-04 12:42:31','cfe0c75380cbe157e106c7825cb9639f'),(5,3,57,'9','2016-02-04 12:42:31','24a6cdf4a3bbb4882d2da93ccc585d52'),(5,3,58,'9','2016-02-04 12:42:31','c91049ed4de3d30c844c86d30b23db5b'),(5,3,59,'8','2016-02-04 12:42:31','e2dfa1e4056d92f0c2786ecff1c2d22c'),(5,3,60,'8','2016-02-04 12:42:31','be9569c1bea61a25ad706a256402bfe2'),(5,3,61,'8','2016-02-04 12:42:31','4815b4ae47f4af16a929efc35a7cd423'),(5,3,62,'9','2016-02-04 12:42:31','d9e376b703baefe4aa71186ba8e98ac3'),(5,3,63,'10','2016-02-04 12:42:32','ee0746b5a21ec7827dd8a245ea2c6279'),(5,3,64,'9','2016-02-04 12:42:32','dd0e7b0e83e82b25e5c43cc046b9c4db'),(5,3,65,'10','2016-02-04 12:42:32','c5ff263481ad6417e2e585deb99311b6'),(5,3,66,'8','2016-02-04 12:42:32','172adaf3cc0eabacfafb0fe7e91439cf'),(5,3,67,'7','2016-02-04 12:42:32','5999fae5887834e5ded66ba61e5357c9'),(5,3,68,'10','2016-02-04 12:42:32','0be1f3b6c017405dfca84cfa008e744c'),(5,3,69,'8','2016-02-04 12:42:32','e41d034da84cd554f7b7bd50c649bab3'),(5,3,70,'10','2016-02-04 12:42:32','e0424caaa19b78c8b24be8de49120c31'),(5,3,71,'8','2016-02-04 12:42:32','3640df4dde3c228927d43fca5de51e16'),(5,3,72,'9','2016-02-04 12:42:32','dd394091ee758b982f170570e28c0a2e'),(5,3,73,'8','2016-02-04 12:42:32','a1572ac8009a924ad743a903628faafe'),(5,3,74,'9','2016-02-04 12:42:32','e944068c51ef0f6947f3fc6c50748a4c'),(5,4,52,'9','2016-02-04 12:42:30','b3de70d807b54b0aa9121ad9e3bd4f97'),(5,4,53,'9','2016-02-04 12:42:30','ff0d7dc3cedf723c9f04ba0e1426e3c9'),(5,4,54,'8','2016-02-04 12:42:31','7a9fd587e85d380212df6592a816b32d'),(5,4,55,'8','2016-02-04 12:42:31','c1045b34efcd0807ca799d2ec0b16282'),(5,4,56,'9','2016-02-04 12:42:30','7e9ea0257a61785a35c5150184859b95'),(5,4,57,'10','2016-02-04 12:42:31','c259b606d3809ad77baca3d2bdf12a6e'),(5,4,58,'10','2016-02-04 12:42:31','57e213551e36ca7c1d4b916a4d0ac8af'),(5,4,59,'10','2016-02-04 12:42:31','019991a29ec841310c03d806f63d49d5'),(5,4,60,'8','2016-02-04 12:42:31','1a674094bcb02203138f5fc20406784d'),(5,4,61,'10','2016-02-04 12:42:31','6ef8024d62b9cda301b42376426ec964'),(5,4,62,'9','2016-02-04 12:42:31','f78ee0f301b1de6012cec62389a77d43'),(5,4,63,'10','2016-02-04 12:42:31','790abb72d6df0bf0671c87c2b1183722'),(5,4,64,'10','2016-02-04 12:42:31','e29efc6cac53b619b24c7771716b39d8'),(5,4,65,'10','2016-02-04 12:42:32','75edc0255838f59eedfaea46f2e9d998'),(5,4,66,'10','2016-02-04 12:42:32','4cfa2a22413b60bc94d7c18d87aa2562'),(5,4,67,'10','2016-02-04 12:42:32','10695cf61ec86b9a7fb0100d36e6079e'),(5,4,68,'9','2016-02-04 12:42:32','3f1a99f88cce57f032a163dfbaa2d902'),(5,4,69,'10','2016-02-04 12:42:32','990e92d2175c6790a2d7adc8cbdf59b1'),(5,4,70,'9','2016-02-04 12:42:32','a7e96a9971e042a653eaea52248cf4ac'),(5,4,71,'9','2016-02-04 12:42:32','10c11c8f21a520c573ff1eaa519e6a79'),(5,4,72,'9','2016-02-04 12:42:32','ee8a44f337aad22ac003ea0f200d3b6f'),(5,4,73,'10','2016-02-04 12:42:32','f3a7b9c34df40f2c6f4f7dc1c1faccd8'),(5,4,74,'10','2016-02-04 12:42:32','f819a34609ee956ccafbc64f3e87ce2b'),(5,6,52,'8','2016-02-04 12:42:30','d6477b970d2e180da52bbc9195e006a5'),(5,6,53,'8','2016-02-04 12:42:30','6da85f2b3ef880837c6c6b6e41cc5245'),(5,6,54,'9','2016-02-04 12:42:31','c5f201d18359ab3aa6fe028468b946cd'),(5,6,55,'8','2016-02-04 12:42:31','e518e7b975c3e8399d56f07f57070705'),(5,6,56,'8','2016-02-04 12:42:31','0051f98f9ca7886c52a93e6c7f57e73c'),(5,6,57,'9','2016-02-04 12:42:31','90b1dfc12ac07fa97ccb8af54a5b00a9'),(5,6,58,'9','2016-02-04 12:42:31','b7fb030e9072b4fd726a6452a9c92a66'),(5,6,59,'9','2016-02-04 12:42:31','df54af9dc3bbad23e7c7256d5d9e8412'),(5,6,60,'9','2016-02-04 12:42:31','39ad72135d20beece51ef1520598d31b'),(5,6,61,'9','2016-02-04 12:42:31','184454587502301e41e38f9c0c37c5a6'),(5,6,62,'9','2016-02-04 12:42:31','43bd49b361a5b7c5ac1757a4bf080826'),(5,6,63,'8','2016-02-04 12:42:31','2f13cf4faf7defbc7b42b12a60e3a8f2'),(5,6,64,'9','2016-02-04 12:42:31','682657899e37033ac17e238a1df18be5'),(5,6,65,'9','2016-02-04 12:42:32','f76d7652c1901cd0e39e61f57d358e8c'),(5,6,66,'9','2016-02-04 12:42:32','6f5297fb7b7d59523761c3b11090e385'),(5,6,67,'9','2016-02-04 12:42:32','39ba447104fb55f51939410ac0cf05be'),(5,6,68,'10','2016-02-04 12:42:32','1c2920dc78aa9ba3ffb9d796cf74dda6'),(5,6,69,'10','2016-02-04 12:42:32','39234c0317e0269aec907dd665e31e74'),(5,6,70,'8','2016-02-04 12:42:32','5ff94a9fdd9952c6819de829d2819d7d'),(5,6,71,'10','2016-02-04 12:42:32','8556363e439c65e4b5616e1ba6bbff6d'),(5,6,72,'8','2016-02-04 12:42:32','521fc394ce8eff01e94c37b81926f981'),(5,6,73,'8','2016-02-04 12:42:32','59806941c6231c34247a6d9ee6d146a7'),(5,6,74,'9','2016-02-04 12:42:32','0ed6fea274eac895013deb8c8922fcd7'),(5,7,52,'8','2016-02-04 12:42:30','ec70e4f1e0cae98a84be2497a4987bb3'),(5,7,53,'8','2016-02-04 12:42:30','7a9950000629ec545c3e4e042673792a'),(5,7,54,'8','2016-02-04 12:42:30','10be24bd4a3863b8079b6dedd3fae538'),(5,7,55,'8','2016-02-04 12:42:30','33a0a2fb40b524c0c4fae8d32cc3ad63'),(5,7,56,'8','2016-02-04 12:42:30','d0a33704ded6a73898425e105d49b6aa'),(5,7,57,'8','2016-02-04 12:42:30','ea3fc6c5c8d8973339ca6959dcf0fe74'),(5,7,58,'8','2016-02-04 12:42:30','171759403addd4118b38b507bf627801'),(5,7,59,'7','2016-02-04 12:42:31','6f674a27e63516bdfa25a646c2d42071'),(5,7,60,'8','2016-02-04 12:42:31','1cd2ef8c551f4a0c198003fc7bab421b'),(5,7,61,'7','2016-02-04 12:42:31','e9180178c8838e4bb37484d3f07564e2'),(5,7,62,'8','2016-02-04 12:42:31','ba0d9eab1139996411a55aa7512d9696'),(5,7,63,'8','2016-02-04 12:42:31','9603e947b34accb19e2995b93118500b'),(5,7,64,'8','2016-02-04 12:42:31','8e748cd29b6c4e3f000890188f47c11c'),(5,7,65,'8','2016-02-04 12:42:31','60bf71b56f38ea91fb8bb7816c4957e6'),(5,7,66,'8','2016-02-04 12:42:31','a85c2e4afd452c3e2b131c0039ed9e41'),(5,7,67,'8','2016-02-04 12:42:31','73e4907328120fbe09ddedd314121240'),(5,7,68,'8','2016-02-04 12:42:31','8e2f3e74e7d9aacf6443a64a065862e2'),(5,7,69,'8','2016-02-04 12:42:31','2a939e9a8c4c37447c63d2077b2a5d90'),(5,7,70,'8','2016-02-04 12:42:32','b57978ddaf3d1aa88c78731f6ae9efaf'),(5,7,71,'8','2016-02-04 12:42:32','6b7ce9f6ba23f9026cf48d6730731c06'),(5,7,72,'8','2016-02-04 12:42:32','059a580364df23d8fcaf52610a6779d4'),(5,7,73,'8','2016-02-04 12:42:32','12b627ad5de19276160e55813bb9c8cb'),(5,7,74,'8','2016-02-04 12:42:32','7a5d09951ad44ce8557a7f5b1804c59a'),(5,8,52,'8','2016-02-04 12:42:30','9a2e89aaa149419c784b106e724e4f83'),(5,8,53,'7','2016-02-04 12:42:30','5094017f4b7dd94cc0284c740a164cda'),(5,8,54,'7','2016-02-04 12:42:31','a5d6ba2221656e5248ce4655478937ae'),(5,8,55,'8','2016-02-04 12:42:31','e4320cf143bdebc7d2c69cb1c9f663d6'),(5,8,56,'8','2016-02-04 12:42:30','8903b7397387b932ee1366ce05214cdb'),(5,8,57,'8','2016-02-04 12:42:31','7f679a94d7b47f742e2b0567d14a085d'),(5,8,58,'8','2016-02-04 12:42:31','603904366103fd9f5ee3d9e90cb32da6'),(5,8,59,'8','2016-02-04 12:42:31','9cff031101ed925cbecec3850405817f'),(5,8,60,'9','2016-02-04 12:42:31','e547c4629100c3bcf57b8962aae12c37'),(5,8,61,'9','2016-02-04 12:42:31','2b83424832f47179f740d729aa802277'),(5,8,62,'8','2016-02-04 12:42:31','624fb5583a1cba70349776b75b7994f5'),(5,8,63,'9','2016-02-04 12:42:31','8a0794fb70d741a90d9de9ec710fa977'),(5,8,64,'9','2016-02-04 12:42:31','c680db151fa944daa5e04a68d038abb8'),(5,8,65,'9','2016-02-04 12:42:32','a3fc2bb7646455b92337189d45fde759'),(5,8,66,'8','2016-02-04 12:42:32','b7034d81b2b03a15b92a35041711a9db'),(5,8,67,'9','2016-02-04 12:42:32','b57be17a7d4e6ec632dc75f2949e2409'),(5,8,68,'9','2016-02-04 12:42:32','81e8b1805b8b61f1454a16aa33eb214c'),(5,8,69,'9','2016-02-04 12:42:32','2d12458cf727bfcca8795ba8fcbccc07'),(5,8,70,'9','2016-02-04 12:42:32','f637caa104b2cd98f9a76736eba2f8b8'),(5,8,71,'9','2016-02-04 12:42:32','7c0d9a839d5cbbb2cedd1d5e6f4ddcc6'),(5,8,72,'8','2016-02-04 12:42:32','1d6f9516043d617fb2b87a2db93d67b5'),(5,8,73,'8','2016-02-04 12:42:32','0df8ea741c90ec6c4bad8b0119038289'),(5,8,74,'9','2016-02-04 12:42:32','37f09e8f7b3c18184417d934d549e13c'),(5,9,52,'8','2016-02-04 12:42:30','497094f4fbc16901012189ced203173a'),(5,9,53,'7','2016-02-04 12:42:30','9a2206b567848bd323e1e6016c892ab7'),(5,9,54,'8','2016-02-04 12:42:30','9e52e2a3fcf87df1ce8f38ab7ed0e04f'),(5,9,55,'9','2016-02-04 12:42:30','8bc1071ddb405ceb1972eef6472e8340'),(5,9,56,'7','2016-02-04 12:42:30','536abf62e6256267f43aa29d9027a960'),(5,9,57,'10','2016-02-04 12:42:30','921d9b346f5f93007d4d6081ef3edc06'),(5,9,58,'7','2016-02-04 12:42:30','c7148a17a73561d99ebd300bb7e55215'),(5,9,59,'6','2016-02-04 12:42:30','fc0807b11db2d46f6c367d30c58b1a68'),(5,9,60,'10','2016-02-04 12:42:30','65fce5eb15bf536054aa22460c4ed057'),(5,9,61,'10','2016-02-04 12:42:31','682f8edec1934df87dbcf382580ea73d'),(5,9,62,'10','2016-02-04 12:42:31','0dc7b6ef4987558a0953f52ebab8b2ae'),(5,9,63,'7','2016-02-04 12:42:31','9e278c5a9b58b4ef7aba852d77175466'),(5,9,65,'7','2016-02-04 12:42:31','1597b3ba338bdac718dbe897ce52f9ee'),(5,9,66,'9','2016-02-04 12:42:31','4b27b76afc24514c1d98bcabfb3f18b8'),(5,9,67,'8','2016-02-04 12:42:31','ee0627e66f9b08c6e521c5dc26db5e56'),(5,9,68,'6','2016-02-04 12:42:31','7f3fce2b8a93b2103c31942d1efbb1fe'),(5,9,69,'7','2016-02-04 12:42:31','fec467a85efbba6314cf59244c62f1bc'),(5,9,70,'8','2016-02-04 12:42:31','810a93bdc72f402dcb443098e37f464f'),(5,9,71,'10','2016-02-04 12:42:31','75d1aa4d660fadc53b381c3a2f536130'),(5,9,72,'7','2016-02-04 12:42:31','8a7f3e3b253c415a9ba927710cf68b47'),(5,9,73,'10','2016-02-04 12:42:32','f8c0d2212269425afe4634cbaee2ff5c'),(5,9,74,'7','2016-02-04 12:42:32','b735ea823db457889c08eb6d3f50a965'),(5,10,52,'9','2016-02-04 12:42:30','180d73f15b4d68811d617058d669a292'),(5,10,53,'9','2016-02-04 12:42:30','8a4b6467bff44c474a1c243eda770651'),(5,10,54,'7','2016-02-04 12:42:31','cf7c09ae1eb92f22785ce127d02fc853'),(5,10,55,'7','2016-02-04 12:42:31','8490d513bb5029d1cad07959e9259ff5'),(5,10,56,'10','2016-02-04 12:42:31','274e50dd774eb6a1ead026cf3d8b5731'),(5,10,58,'8','2016-02-04 12:42:31','5ced79281e0e3b590757acf36d3f1227'),(5,10,59,'8','2016-02-04 12:42:31','3a9291e41acc616f9136f0730f0f3994'),(5,10,60,'8','2016-02-04 12:42:31','02bf125ba666c9aac84352d1312f1767'),(5,10,61,'8','2016-02-04 12:42:31','a1a59567bf2196d7a71745f7ee2060d6'),(5,10,62,'8','2016-02-04 12:42:31','00b69c782aa81daa2b49e6008dc2f22d'),(5,10,63,'8','2016-02-04 12:42:31','4f2a9670cc73ec4ed8120de40d3a9649'),(5,10,64,'8','2016-02-04 12:42:32','029ccc94ce6bf6ea64e431442d8e7045'),(5,10,65,'8','2016-02-04 12:42:32','5bd1a2b7d6f11da74fee18f4773c06a9'),(5,10,66,'8','2016-02-04 12:42:32','9d599cb5357d1dc9d1657d527ecf358c'),(5,10,67,'8','2016-02-04 12:42:32','2fb1b6c9027c893ec4eed2af41ff0640'),(5,10,68,'10','2016-02-04 12:42:32','7ab8be6d79d20e196cac3db84ab78405'),(5,10,69,'10','2016-02-04 12:42:32','8af4d8d8c4e043d67c73d1e115cae8fc'),(5,10,70,'9','2016-02-04 12:42:32','943e062f1dfbff8df05392f45ac0da91'),(5,10,71,'9','2016-02-04 12:42:32','4fc584c2fe3567ca165816b84f06e461'),(5,10,72,'9','2016-02-04 12:42:32','5716dd942f9a05cce4a2b9749f16362f'),(5,10,73,'9','2016-02-04 12:42:32','40fc2220160040cc632fe370ca81c903'),(5,10,74,'9','2016-02-04 12:42:32','bf3c3ff25e348c715b135b9c0fbc9a0d');
/*!40000 ALTER TABLE `respuesta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol` (
  `idRol` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(200) NOT NULL,
  `fecha` datetime NOT NULL,
  `hash` varchar(45) NOT NULL,
  PRIMARY KEY (`idRol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seccion`
--

DROP TABLE IF EXISTS `seccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seccion` (
  `idSeccion` int(11) NOT NULL AUTO_INCREMENT,
  `idEncuesta` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `orden` int(11) NOT NULL,
  `elementos` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `hash` varchar(45) NOT NULL,
  PRIMARY KEY (`idSeccion`),
  KEY `fk_Seccion_Encuesta1_idx` (`idEncuesta`),
  CONSTRAINT `fk_Seccion_Encuesta1` FOREIGN KEY (`idEncuesta`) REFERENCES `encuesta` (`idEncuesta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seccion`
--

LOCK TABLES `seccion` WRITE;
/*!40000 ALTER TABLE `seccion` DISABLE KEYS */;
INSERT INTO `seccion` VALUES (1,1,'Habilidades',1,8,'2016-01-29 20:40:25','29a678f1db486c67082b196bb05f8d40'),(2,2,'educacion',1,1,'2016-02-04 09:55:03','2392645adc2b5e1c50dba85c461f90cb'),(3,3,'Claridad',1,1,'2016-02-04 10:17:08','31811a892ba9ca8122f8b31a5be79fa1'),(4,3,'Orden',2,1,'2016-02-04 10:28:51','60d586ae7a31681e122c1f5853f77d5e'),(5,3,'Reto',3,1,'2016-02-04 10:32:53','35abe5aef0ef8d14f0a69a82d74546be'),(6,3,'Apoyo',4,1,'2016-02-04 10:35:02','4401fbf48db63a1c35b8c755262e9060'),(7,3,'Respeto e inclusión ',5,1,'2016-02-04 10:37:56','61cd1fe0c03f05145526360850472288'),(8,3,'Motivación e interés',6,1,'2016-02-04 10:40:25','d09d3563f51181796451adf7e998a0b1'),(9,3,'Espacio físico',7,1,'2016-02-04 10:42:34','495a8c3bdc57aaf01c11c84ee3f0b967'),(10,4,'Claridad',1,1,'2016-02-04 10:46:29','56be7aa15b6719ed76166464eb05be2a'),(11,4,'Orden',2,1,'2016-02-04 10:50:49','44b44b410a724ce16a447694f57dcd23'),(12,4,'Reto',3,1,'2016-02-04 11:12:26','7296d7582f8dd409b430abc1f43a91c2'),(13,4,'Justicia',4,1,'2016-02-04 11:13:55','bc724b33cc648a2586ad6ea235790375'),(14,4,'Participación',5,1,'2016-02-04 11:15:07','f015aaf4170e18534a5298bdaf80db6a'),(15,4,'Apoyo',6,1,'2016-02-04 11:18:57','44db2be8c8816878cda0e688838c3d32'),(16,4,'Respeto e inclusión ',7,1,'2016-02-04 11:20:37','01b9c2626d6c468ae2b145968afdcdd7'),(17,4,'Motivación e interés',8,1,'2016-02-04 11:31:36','a1a2c1a275d5e3698ab8d03e69f8ea56'),(18,4,'Espacio físico',9,1,'2016-02-04 11:33:18','cf9ddc2a3856887b90aea528543bbe7b'),(19,5,'Habilidades Técnico-Pedagóicas',1,8,'2016-02-04 11:36:24','9d3ab9a94349abb518af5c737dab1f9f');
/*!40000 ALTER TABLE `seccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subparametro`
--

DROP TABLE IF EXISTS `subparametro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subparametro` (
  `idSubparametro` int(11) NOT NULL AUTO_INCREMENT,
  `idParametro` int(11) NOT NULL,
  `subparametro` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` datetime NOT NULL,
  `hash` varchar(45) NOT NULL,
  PRIMARY KEY (`idSubparametro`),
  KEY `fk_Subparametro_Parametro1_idx` (`idParametro`),
  CONSTRAINT `fk_Subparametro_Parametro1` FOREIGN KEY (`idParametro`) REFERENCES `parametro` (`idParametro`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subparametro`
--

LOCK TABLES `subparametro` WRITE;
/*!40000 ALTER TABLE `subparametro` DISABLE KEYS */;
/*!40000 ALTER TABLE `subparametro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telefono`
--

DROP TABLE IF EXISTS `telefono`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telefono` (
  `idTelefono` int(11) NOT NULL AUTO_INCREMENT,
  `lada` varchar(7) DEFAULT NULL,
  `tipo` varchar(2) NOT NULL,
  `telefono` varchar(16) NOT NULL,
  `extensiones` varchar(30) DEFAULT NULL,
  `descripcion` text,
  `fecha` datetime NOT NULL,
  `hash` varchar(45) NOT NULL,
  PRIMARY KEY (`idTelefono`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telefono`
--

LOCK TABLES `telefono` WRITE;
/*!40000 ALTER TABLE `telefono` DISABLE KEYS */;
/*!40000 ALTER TABLE `telefono` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipomovimiento`
--

DROP TABLE IF EXISTS `tipomovimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipomovimiento` (
  `idTipoMovimiento` int(11) NOT NULL AUTO_INCREMENT,
  `tipoMovimiento` varchar(2) NOT NULL,
  `descripcion` text NOT NULL,
  `afectaInventario` varchar(1) NOT NULL,
  `afectaSaldo` varchar(1) NOT NULL,
  PRIMARY KEY (`idTipoMovimiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipomovimiento`
--

LOCK TABLES `tipomovimiento` WRITE;
/*!40000 ALTER TABLE `tipomovimiento` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipomovimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipoproveedor`
--

DROP TABLE IF EXISTS `tipoproveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipoproveedor` (
  `idTipoProveedor` int(11) NOT NULL AUTO_INCREMENT,
  `clave` varchar(2) NOT NULL,
  `descripcion` text,
  PRIMARY KEY (`idTipoProveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoproveedor`
--

LOCK TABLES `tipoproveedor` WRITE;
/*!40000 ALTER TABLE `tipoproveedor` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipoproveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `idRol` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `nombres` varchar(150) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `fecha` datetime NOT NULL,
  `hash` varchar(45) NOT NULL,
  PRIMARY KEY (`idUsuario`),
  KEY `fk_Usuario_Rol1_idx` (`idRol`),
  CONSTRAINT `fk_Usuario_Rol1` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendedor`
--

DROP TABLE IF EXISTS `vendedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vendedor` (
  `idVendedor` int(11) NOT NULL AUTO_INCREMENT,
  `claveVendedor` varchar(20) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `idDomicilio` int(11) NOT NULL,
  `estatus` varchar(1) NOT NULL,
  `fechaAlta` datetime NOT NULL,
  `comision` decimal(10,0) NOT NULL,
  PRIMARY KEY (`idVendedor`),
  KEY `fk_Vendedor_Domicilio1_idx` (`idDomicilio`),
  CONSTRAINT `fk_Vendedor_Domicilio1` FOREIGN KEY (`idDomicilio`) REFERENCES `domicilio` (`idDomicilio`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendedor`
--

LOCK TABLES `vendedor` WRITE;
/*!40000 ALTER TABLE `vendedor` DISABLE KEYS */;
/*!40000 ALTER TABLE `vendedor` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-04 15:40:09
