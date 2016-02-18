CREATE DATABASE  IF NOT EXISTS `generaldos` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `generaldos`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: localhost    Database: generaldos
-- ------------------------------------------------------
-- Server version	5.6.22-log

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
-- Table structure for table `bancosempresa`
--

DROP TABLE IF EXISTS `bancosempresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bancosempresa` (
  `idBancosEmpresa` int(11) NOT NULL AUTO_INCREMENT,
  `idEmpresa` int(11) NOT NULL,
  `idBanco` int(11) NOT NULL,
  PRIMARY KEY (`idBancosEmpresa`),
  KEY `fk_BancosEmpresa_Empresa1_idx` (`idEmpresa`),
  KEY `fk_BancosEmpresa_Banco1_idx` (`idBanco`),
  CONSTRAINT `fk_BancosEmpresa_Banco1` FOREIGN KEY (`idBanco`) REFERENCES `banco` (`idBanco`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_BancosEmpresa_Empresa1` FOREIGN KEY (`idEmpresa`) REFERENCES `empresa` (`idEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bancosempresa`
--

LOCK TABLES `bancosempresa` WRITE;
/*!40000 ALTER TABLE `bancosempresa` DISABLE KEYS */;
/*!40000 ALTER TABLE `bancosempresa` ENABLE KEYS */;
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
  `hash` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idCategoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes` (
  `idCliente` int(11) NOT NULL AUTO_INCREMENT,
  `idEmpresa` int(11) NOT NULL,
  PRIMARY KEY (`idCliente`),
  KEY `fk_Clientes_Empresa1_idx` (`idEmpresa`),
  CONSTRAINT `fk_Clientes_Empresa1` FOREIGN KEY (`idEmpresa`) REFERENCES `empresa` (`idEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
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
  `idEmpresas` int(11) NOT NULL,
  `idEmpresa` int(11) NOT NULL,
  `idProyecto` int(11) NOT NULL,
  `idFactura` int(11) NOT NULL,
  `idTipoMovimiento` int(11) NOT NULL,
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
  KEY `fk_Cuentasxc_Empresa1_idx` (`idEmpresa`),
  KEY `fk_Cuentasxc_Empresas1_idx` (`idEmpresas`),
  KEY `fk_Cuentasxc_Proyecto1_idx` (`idProyecto`),
  KEY `fk_Cuentasxc_Factura1_idx` (`idFactura`),
  KEY `fk_Cuentasxc_TipoMovimiento1_idx` (`idTipoMovimiento`),
  CONSTRAINT `fk_Cuentasxc_Empresa1` FOREIGN KEY (`idEmpresa`) REFERENCES `empresa` (`idEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxc_Empresas1` FOREIGN KEY (`idEmpresas`) REFERENCES `empresas` (`idEmpresas`) ON DELETE NO ACTION ON UPDATE NO ACTION,
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
  `idEmpresas` int(11) NOT NULL,
  `idEmpresa` int(11) NOT NULL,
  `idProyecto` int(11) NOT NULL,
  `idFactura` int(11) NOT NULL,
  `idTipoMovimiento` int(11) NOT NULL,
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
  KEY `fk_Cuentasxp_Empresa1_idx` (`idEmpresa`),
  KEY `fk_Cuentasxp_Empresas1_idx` (`idEmpresas`),
  KEY `fk_Cuentasxp_Proyecto1_idx` (`idProyecto`),
  KEY `fk_Cuentasxp_Factura1_idx` (`idFactura`),
  KEY `fk_Cuentasxp_TipoMovimiento1_idx` (`idTipoMovimiento`),
  CONSTRAINT `fk_Cuentasxp_Empresa1` FOREIGN KEY (`idEmpresa`) REFERENCES `empresa` (`idEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxp_Empresas1` FOREIGN KEY (`idEmpresas`) REFERENCES `empresas` (`idEmpresas`) ON DELETE NO ACTION ON UPDATE NO ACTION,
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
  `hash` varchar(45) DEFAULT NULL,
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
  `hash` varchar(45) DEFAULT NULL,
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
  `hash` varchar(45) DEFAULT NULL,
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
-- Table structure for table `empresas`
--

DROP TABLE IF EXISTS `empresas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empresas` (
  `idEmpresas` int(11) NOT NULL AUTO_INCREMENT,
  `idEmpresa` int(11) NOT NULL,
  PRIMARY KEY (`idEmpresas`),
  KEY `fk_Empresas_Empresa1_idx` (`idEmpresa`),
  CONSTRAINT `fk_Empresas_Empresa1` FOREIGN KEY (`idEmpresa`) REFERENCES `empresa` (`idEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresas`
--

LOCK TABLES `empresas` WRITE;
/*!40000 ALTER TABLE `empresas` DISABLE KEYS */;
/*!40000 ALTER TABLE `empresas` ENABLE KEYS */;
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
  `nombreClave` varchar(20) NOT NULL,
  `descripcion` text NOT NULL,
  `estatus` varchar(1) NOT NULL,
  `fecha` datetime NOT NULL,
  `hash` varchar(45) DEFAULT NULL,
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
-- Table structure for table `estado`
--

DROP TABLE IF EXISTS `estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estado` (
  `idEstado` int(11) NOT NULL AUTO_INCREMENT,
  `claveEstado` varchar(20) DEFAULT NULL,
  `estado` varchar(100) NOT NULL,
  `capital` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado`
--

LOCK TABLES `estado` WRITE;
/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
INSERT INTO `estado` VALUES (1,'1','Aguascalientes','Aguascalientes'),(2,'2','Baja California','Mexicali'),(3,'3','Baja California Sur','La Paz'),(4,'4','Campeche','Campeche'),(5,'5','Coahuila de Zaragoza','Saltillo'),(6,'6','Colima','Colima'),(7,'7','Chiapas','Tuxtla Gutiérrez'),(8,'8','Chihuahua','Chihuahua'),(9,'9','Distrito Federal','Ciudad de México'),(10,'10','Durango','Durango'),(11,'11','Guanajuato','Guanajuato'),(12,'12','Guerrero','Chilpancingo'),(13,'13','Hidalgo','Pachuca'),(14,'14','Jalisco','Guadalajara'),(15,'15','México','Toluca'),(16,'16','Michoacán de Ocampo','Morelia'),(17,'17','Morelos','Cuernavaca'),(18,'18','Nayarit','Tepic'),(19,'19','Nuevo León','Monterrey'),(20,'20','Oaxaca','Oaxaca'),(21,'21','Puebla','Puebla'),(22,'22','Querétaro','Querétaro'),(23,'23','Quintana Roo','Chetumal'),(24,'24','San Luis Potosí','San Luis Potosí'),(25,'25','Sinaloa','Culiacán'),(26,'26','Sonora','Hermosillo'),(27,'27','Tabasco','Villahermosa'),(28,'28','Tamaulipas','Ciudad Victoria'),(29,'29','Tlaxcala','Tlaxcala'),(30,'30','Veracruz de Ignacio de la Llave','Xalapa'),(31,'31','Yucatán','Mérida'),(32,'32','Zacatecas','Zacatecas');
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
  `idEmpresa` int(11) NOT NULL,
  `idEmpresas` int(11) NOT NULL,
  `tipo` varchar(2) NOT NULL,
  `factura` varchar(60) NOT NULL,
  `fecha` datetime NOT NULL,
  `subtotal` decimal(10,0) NOT NULL,
  `total` decimal(10,0) NOT NULL,
  PRIMARY KEY (`idFactura`),
  KEY `fk_Factura_Empresas1_idx` (`idEmpresas`),
  KEY `fk_Factura_Empresa1_idx` (`idEmpresa`),
  CONSTRAINT `fk_Factura_Empresa1` FOREIGN KEY (`idEmpresa`) REFERENCES `empresa` (`idEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Factura_Empresas1` FOREIGN KEY (`idEmpresas`) REFERENCES `empresas` (`idEmpresas`) ON DELETE NO ACTION ON UPDATE NO ACTION
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
  `idFacturaDetalle` int(11) NOT NULL AUTO_INCREMENT,
  `idFactura` int(11) NOT NULL,
  `idMultiplos` int(11) NOT NULL,
  `secuencial` int(11) NOT NULL,
  `cantidad` float NOT NULL,
  `descripcion` text NOT NULL,
  `precioUnitario` decimal(10,0) NOT NULL,
  `importe` decimal(10,0) NOT NULL,
  PRIMARY KEY (`idFacturaDetalle`),
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
  `idFiscales` int(11) NOT NULL,
  `rfc` varchar(13) NOT NULL,
  `razonSocial` varchar(200) NOT NULL,
  `hash` varchar(45) DEFAULT NULL,
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
-- Table structure for table `fiscalesdomicilios`
--

DROP TABLE IF EXISTS `fiscalesdomicilios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fiscalesdomicilios` (
  `idFiscalesDomicilios` int(11) NOT NULL AUTO_INCREMENT,
  `idDomicilio` int(11) NOT NULL,
  `idFiscales` int(11) NOT NULL,
  `esSucursal` varchar(1) NOT NULL,
  PRIMARY KEY (`idFiscalesDomicilios`),
  KEY `fk_FiscalesDomicilios_Domicilio1_idx` (`idDomicilio`),
  KEY `fk_FiscalesDomicilios_Fiscales1_idx` (`idFiscales`),
  CONSTRAINT `fk_FiscalesDomicilios_Domicilio1` FOREIGN KEY (`idDomicilio`) REFERENCES `domicilio` (`idDomicilio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_FiscalesDomicilios_Fiscales1` FOREIGN KEY (`idFiscales`) REFERENCES `fiscales` (`idFiscales`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fiscalesdomicilios`
--

LOCK TABLES `fiscalesdomicilios` WRITE;
/*!40000 ALTER TABLE `fiscalesdomicilios` DISABLE KEYS */;
/*!40000 ALTER TABLE `fiscalesdomicilios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fiscalesemail`
--

DROP TABLE IF EXISTS `fiscalesemail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fiscalesemail` (
  `idFiscalesEmail` int(11) NOT NULL AUTO_INCREMENT,
  `idEmail` int(11) NOT NULL,
  `idFiscales` int(11) NOT NULL,
  PRIMARY KEY (`idFiscalesEmail`),
  KEY `fk_FiscalesEmail_Email1_idx` (`idEmail`),
  KEY `fk_FiscalesEmail_Fiscales1_idx` (`idFiscales`),
  CONSTRAINT `fk_FiscalesEmail_Email1` FOREIGN KEY (`idEmail`) REFERENCES `email` (`idEmail`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_FiscalesEmail_Fiscales1` FOREIGN KEY (`idFiscales`) REFERENCES `fiscales` (`idFiscales`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fiscalesemail`
--

LOCK TABLES `fiscalesemail` WRITE;
/*!40000 ALTER TABLE `fiscalesemail` DISABLE KEYS */;
/*!40000 ALTER TABLE `fiscalesemail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fiscalestelefonos`
--

DROP TABLE IF EXISTS `fiscalestelefonos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fiscalestelefonos` (
  `idFiscalesTelefonos` int(11) NOT NULL,
  `idFiscales` int(11) NOT NULL,
  `idTelefono` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idFiscalesTelefonos`),
  KEY `fk_FiscalesTelefonos_Telefono1_idx` (`idTelefono`),
  KEY `fk_FiscalesTelefonos_Fiscales1_idx` (`idFiscales`),
  CONSTRAINT `fk_FiscalesTelefonos_Fiscales1` FOREIGN KEY (`idFiscales`) REFERENCES `fiscales` (`idFiscales`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_FiscalesTelefonos_Telefono1` FOREIGN KEY (`idTelefono`) REFERENCES `telefono` (`idTelefono`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fiscalestelefonos`
--

LOCK TABLES `fiscalestelefonos` WRITE;
/*!40000 ALTER TABLE `fiscalestelefonos` DISABLE KEYS */;
/*!40000 ALTER TABLE `fiscalestelefonos` ENABLE KEYS */;
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
  `hash` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idGrupo`),
  KEY `fk_Grupo_Seccion1_idx` (`idSeccion`),
  CONSTRAINT `fk_Grupo_Seccion1` FOREIGN KEY (`idSeccion`) REFERENCES `seccion` (`idSeccion`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo`
--

LOCK TABLES `grupo` WRITE;
/*!40000 ALTER TABLE `grupo` DISABLE KEYS */;
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
  `idProducto` int(11) NOT NULL,
  `idDivisa` int(11) NOT NULL,
  `idEmpresas` int(11) NOT NULL,
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
  KEY `fk_Inventario_Empresas1_idx` (`idEmpresas`),
  CONSTRAINT `fk_Inventario_Divisa1` FOREIGN KEY (`idDivisa`) REFERENCES `divisa` (`idDivisa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Inventario_Empresas1` FOREIGN KEY (`idEmpresas`) REFERENCES `empresas` (`idEmpresas`) ON DELETE NO ACTION ON UPDATE NO ACTION,
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
-- Table structure for table `mantenimientoantivirus`
--

DROP TABLE IF EXISTS `mantenimientoantivirus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantenimientoantivirus` (
  `idMantenimientoAntivirus` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `idComputadora` int(11) NOT NULL,
  PRIMARY KEY (`idMantenimientoAntivirus`),
  KEY `fk_MantenimientoAntivirus_Computadora1_idx` (`idComputadora`),
  CONSTRAINT `fk_MantenimientoAntivirus_Computadora1` FOREIGN KEY (`idComputadora`) REFERENCES `computadora` (`idComputadora`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mantenimientoantivirus`
--

LOCK TABLES `mantenimientoantivirus` WRITE;
/*!40000 ALTER TABLE `mantenimientoantivirus` DISABLE KEYS */;
/*!40000 ALTER TABLE `mantenimientoantivirus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `megrupoc`
--

DROP TABLE IF EXISTS `megrupoc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `megrupoc` (
  `idGrupo` int(11) NOT NULL AUTO_INCREMENT,
  `grupo` varchar(40) NOT NULL,
  `hash` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idGrupo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `megrupoc`
--

LOCK TABLES `megrupoc` WRITE;
/*!40000 ALTER TABLE `megrupoc` DISABLE KEYS */;
/*!40000 ALTER TABLE `megrupoc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `megruposprofesorc`
--

DROP TABLE IF EXISTS `megruposprofesorc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `megruposprofesorc` (
  `idProfesor` int(11) NOT NULL,
  `idGrupo` int(11) NOT NULL,
  `idMateria` int(11) NOT NULL,
  PRIMARY KEY (`idProfesor`,`idGrupo`,`idMateria`),
  KEY `fk_meGruposProfesor_meGrupoC1_idx` (`idGrupo`),
  KEY `fk_meGruposProfesor_meMateriaC1_idx` (`idMateria`),
  CONSTRAINT `fk_meGruposProfesor_meGrupoC1` FOREIGN KEY (`idGrupo`) REFERENCES `megrupoc` (`idGrupo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_meGruposProfesor_meMateriaC1` FOREIGN KEY (`idMateria`) REFERENCES `memateriac` (`idMateria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_meGruposProfesor_meProfesorC1` FOREIGN KEY (`idProfesor`) REFERENCES `meprofesorc` (`idProfesor`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `megruposprofesorc`
--

LOCK TABLES `megruposprofesorc` WRITE;
/*!40000 ALTER TABLE `megruposprofesorc` DISABLE KEYS */;
/*!40000 ALTER TABLE `megruposprofesorc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `memateriac`
--

DROP TABLE IF EXISTS `memateriac`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `memateriac` (
  `idMateria` int(11) NOT NULL AUTO_INCREMENT,
  `materia` varchar(100) NOT NULL,
  `creditos` float DEFAULT NULL,
  `hash` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idMateria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `memateriac`
--

LOCK TABLES `memateriac` WRITE;
/*!40000 ALTER TABLE `memateriac` DISABLE KEYS */;
/*!40000 ALTER TABLE `memateriac` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `memateriasgrupoc`
--

DROP TABLE IF EXISTS `memateriasgrupoc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `memateriasgrupoc` (
  `idGrupo` int(11) NOT NULL,
  `idMateria` int(11) NOT NULL,
  PRIMARY KEY (`idGrupo`,`idMateria`),
  KEY `fk_meMateriasGrupoC_meMateriaC1_idx` (`idMateria`),
  CONSTRAINT `fk_meMateriasGrupoC_meGrupoC1` FOREIGN KEY (`idGrupo`) REFERENCES `megrupoc` (`idGrupo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_meMateriasGrupoC_meMateriaC1` FOREIGN KEY (`idMateria`) REFERENCES `memateriac` (`idMateria`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `memateriasgrupoc`
--

LOCK TABLES `memateriasgrupoc` WRITE;
/*!40000 ALTER TABLE `memateriasgrupoc` DISABLE KEYS */;
/*!40000 ALTER TABLE `memateriasgrupoc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menivel`
--

DROP TABLE IF EXISTS `menivel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menivel` (
  `idNivel` int(11) NOT NULL AUTO_INCREMENT,
  `nivel` varchar(20) NOT NULL,
  `hash` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idNivel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menivel`
--

LOCK TABLES `menivel` WRITE;
/*!40000 ALTER TABLE `menivel` DISABLE KEYS */;
/*!40000 ALTER TABLE `menivel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meperiodo`
--

DROP TABLE IF EXISTS `meperiodo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meperiodo` (
  `idPeriodo` int(11) NOT NULL AUTO_INCREMENT,
  `periodo` varchar(5) NOT NULL,
  `hash` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idPeriodo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meperiodo`
--

LOCK TABLES `meperiodo` WRITE;
/*!40000 ALTER TABLE `meperiodo` DISABLE KEYS */;
/*!40000 ALTER TABLE `meperiodo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meprofesorc`
--

DROP TABLE IF EXISTS `meprofesorc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meprofesorc` (
  `idProfesor` int(11) NOT NULL AUTO_INCREMENT,
  `idRegistro` int(11) NOT NULL,
  `activo` varchar(1) NOT NULL,
  PRIMARY KEY (`idProfesor`,`idRegistro`),
  KEY `fk_meProfesorC_Registro1_idx` (`idRegistro`),
  CONSTRAINT `fk_meProfesorC_Registro1` FOREIGN KEY (`idRegistro`) REFERENCES `meregistro` (`idRegistro`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='	';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meprofesorc`
--

LOCK TABLES `meprofesorc` WRITE;
/*!40000 ALTER TABLE `meprofesorc` DISABLE KEYS */;
/*!40000 ALTER TABLE `meprofesorc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meregistro`
--

DROP TABLE IF EXISTS `meregistro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meregistro` (
  `idRegistro` int(11) NOT NULL AUTO_INCREMENT,
  `referencia` text NOT NULL,
  `tipo` varchar(5) NOT NULL,
  `nombres` varchar(200) NOT NULL,
  `apellidos` varchar(200) NOT NULL,
  `fechaRegistro` datetime NOT NULL,
  `hash` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idRegistro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meregistro`
--

LOCK TABLES `meregistro` WRITE;
/*!40000 ALTER TABLE `meregistro` DISABLE KEYS */;
/*!40000 ALTER TABLE `meregistro` ENABLE KEYS */;
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
  `claveMunicipio` varchar(20) DEFAULT NULL,
  `municipio` varchar(100) NOT NULL,
  PRIMARY KEY (`idMunicipio`),
  KEY `fk_Municipio_Estado_idx` (`idEstado`),
  CONSTRAINT `fk_Municipio_Estado` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`idEstado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2461 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `municipio`
--

LOCK TABLES `municipio` WRITE;
/*!40000 ALTER TABLE `municipio` DISABLE KEYS */;
INSERT INTO `municipio` VALUES (1,1,'1','Aguascalientes'),(2,1,'2','Asientos'),(3,1,'3','Calvillo'),(4,1,'4','Cosío'),(5,1,'5','Jesús María'),(6,1,'6','Pabellón de Arteaga'),(7,1,'7','Rincón de Romos'),(8,1,'8','San José de Gracia'),(9,1,'9','Tepezalá'),(10,1,'10','El Llano'),(11,1,'11','San Francisco de los Romo'),(12,2,'1','Ensenada'),(13,2,'2','Mexicali'),(14,2,'3','Tecate'),(15,2,'4','Tijuana'),(16,2,'5','Playas de Rosarito'),(17,3,'1','Comondú'),(18,3,'2','Mulegé'),(19,3,'3','La Paz'),(20,3,'8','Los Cabos'),(21,3,'9','Loreto'),(22,4,'1','Calkiní'),(23,4,'2','Campeche'),(24,4,'3','Carmen'),(25,4,'4','Champotón'),(26,4,'5','Hecelchakán'),(27,4,'6','Hopelchén'),(28,4,'7','Palizada'),(29,4,'8','Tenabo'),(30,4,'9','Escárcega'),(31,4,'10','Calakmul'),(32,4,'11','Candelaria'),(33,5,'1','Abasolo'),(34,5,'2','Acuña'),(35,5,'3','Allende'),(36,5,'4','Arteaga'),(37,5,'5','Candela'),(38,5,'6','Castaños'),(39,5,'7','Cuatro Ciénegas'),(40,5,'8','Escobedo'),(41,5,'9','Francisco I. Madero'),(42,5,'10','Frontera'),(43,5,'11','General Cepeda'),(44,5,'12','Guerrero'),(45,5,'13','Hidalgo'),(46,5,'14','Jiménez'),(47,5,'15','Juárez'),(48,5,'16','Lamadrid'),(49,5,'17','Matamoros'),(50,5,'18','Monclova'),(51,5,'19','Morelos'),(52,5,'20','Múzquiz'),(53,5,'21','Nadadores'),(54,5,'22','Nava'),(55,5,'23','Ocampo'),(56,5,'24','Parras'),(57,5,'25','Piedras Negras'),(58,5,'26','Progreso'),(59,5,'27','Ramos Arizpe'),(60,5,'28','Sabinas'),(61,5,'29','Sacramento'),(62,5,'30','Saltillo'),(63,5,'31','San Buenaventura'),(64,5,'32','San Juan de Sabinas'),(65,5,'33','San Pedro'),(66,5,'34','Sierra Mojada'),(67,5,'35','Torreón'),(68,5,'36','Viesca'),(69,5,'37','Villa Unión'),(70,5,'38','Zaragoza'),(71,6,'1','Armería'),(72,6,'2','Colima'),(73,6,'3','Comala'),(74,6,'4','Coquimatlán'),(75,6,'5','Cuauhtémoc'),(76,6,'6','Ixtlahuacán'),(77,6,'7','Manzanillo'),(78,6,'8','Minatitlán'),(79,6,'9','Tecomán'),(80,6,'10','Villa de Álvarez'),(81,7,'1','Acacoyagua'),(82,7,'2','Acala'),(83,7,'3','Acapetahua'),(84,7,'4','Altamirano'),(85,7,'5','Amatán'),(86,7,'6','Amatenango de la Frontera'),(87,7,'7','Amatenango del Valle'),(88,7,'8','Angel Albino Corzo'),(89,7,'9','Arriaga'),(90,7,'10','Bejucal de Ocampo'),(91,7,'11','Bella Vista'),(92,7,'12','Berriozábal'),(93,7,'13','Bochil'),(94,7,'14','El Bosque'),(95,7,'15','Cacahoatán'),(96,7,'16','Catazajá'),(97,7,'17','Cintalapa'),(98,7,'18','Coapilla'),(99,7,'19','Comitán de Domínguez'),(100,7,'20','La Concordia'),(101,7,'21','Copainalá'),(102,7,'22','Chalchihuitán'),(103,7,'23','Chamula'),(104,7,'24','Chanal'),(105,7,'25','Chapultenango'),(106,7,'26','Chenalhó'),(107,7,'27','Chiapa de Corzo'),(108,7,'28','Chiapilla'),(109,7,'29','Chicoasén'),(110,7,'30','Chicomuselo'),(111,7,'31','Chilón'),(112,7,'32','Escuintla'),(113,7,'33','Francisco León'),(114,7,'34','Frontera Comalapa'),(115,7,'35','Frontera Hidalgo'),(116,7,'36','La Grandeza'),(117,7,'37','Huehuetán'),(118,7,'38','Huixtán'),(119,7,'39','Huitiupán'),(120,7,'40','Huixtla'),(121,7,'41','La Independencia'),(122,7,'42','Ixhuatán'),(123,7,'43','Ixtacomitán'),(124,7,'44','Ixtapa'),(125,7,'45','Ixtapangajoya'),(126,7,'46','Jiquipilas'),(127,7,'47','Jitotol'),(128,7,'48','Juárez'),(129,7,'49','Larráinzar'),(130,7,'50','La Libertad'),(131,7,'51','Mapastepec'),(132,7,'52','Las Margaritas'),(133,7,'53','Mazapa de Madero'),(134,7,'54','Mazatán'),(135,7,'55','Metapa'),(136,7,'56','Mitontic'),(137,7,'57','Motozintla'),(138,7,'58','Nicolás Ruíz'),(139,7,'59','Ocosingo'),(140,7,'60','Ocotepec'),(141,7,'61','Ocozocoautla de Espinosa'),(142,7,'62','Ostuacán'),(143,7,'63','Osumacinta'),(144,7,'64','Oxchuc'),(145,7,'65','Palenque'),(146,7,'66','Pantelhó'),(147,7,'67','Pantepec'),(148,7,'68','Pichucalco'),(149,7,'69','Pijijiapan'),(150,7,'70','El Porvenir'),(151,7,'71','Villa Comaltitlán'),(152,7,'72','Pueblo Nuevo Solistahuacán'),(153,7,'73','Rayón'),(154,7,'74','Reforma'),(155,7,'75','Las Rosas'),(156,7,'76','Sabanilla'),(157,7,'77','Salto de Agua'),(158,7,'78','San Cristóbal de las Casas'),(159,7,'79','San Fernando'),(160,7,'80','Siltepec'),(161,7,'81','Simojovel'),(162,7,'82','Sitalá'),(163,7,'83','Socoltenango'),(164,7,'84','Solosuchiapa'),(165,7,'85','Soyaló'),(166,7,'86','Suchiapa'),(167,7,'87','Suchiate'),(168,7,'88','Sunuapa'),(169,7,'89','Tapachula'),(170,7,'90','Tapalapa'),(171,7,'91','Tapilula'),(172,7,'92','Tecpatán'),(173,7,'93','Tenejapa'),(174,7,'94','Teopisca'),(175,7,'96','Tila'),(176,7,'97','Tonalá'),(177,7,'98','Totolapa'),(178,7,'99','La Trinitaria'),(179,7,'100','Tumbalá'),(180,7,'101','Tuxtla Gutiérrez'),(181,7,'102','Tuxtla Chico'),(182,7,'103','Tuzantán'),(183,7,'104','Tzimol'),(184,7,'105','Unión Juárez'),(185,7,'106','Venustiano Carranza'),(186,7,'107','Villa Corzo'),(187,7,'108','Villaflores'),(188,7,'109','Yajalón'),(189,7,'110','San Lucas'),(190,7,'111','Zinacantán'),(191,7,'112','San Juan Cancuc'),(192,7,'113','Aldama'),(193,7,'114','Benemérito de las Américas'),(194,7,'115','Maravilla Tenejapa'),(195,7,'116','Marqués de Comillas'),(196,7,'117','Montecristo de Guerrero'),(197,7,'118','San Andrés Duraznal'),(198,7,'119','Santiago el Pinar'),(199,7,'120','Belisario Domínguez'),(200,7,'121','Emiliano Zapata'),(201,7,'122','El Parral'),(202,7,'123','Mezcalapa'),(203,8,'1','Ahumada'),(204,8,'2','Aldama'),(205,8,'3','Allende'),(206,8,'4','Aquiles Serdán'),(207,8,'5','Ascensión'),(208,8,'6','Bachíniva'),(209,8,'7','Balleza'),(210,8,'8','Batopilas'),(211,8,'9','Bocoyna'),(212,8,'10','Buenaventura'),(213,8,'11','Camargo'),(214,8,'12','Carichí'),(215,8,'13','Casas Grandes'),(216,8,'14','Coronado'),(217,8,'15','Coyame del Sotol'),(218,8,'16','La Cruz'),(219,8,'17','Cuauhtémoc'),(220,8,'18','Cusihuiriachi'),(221,8,'19','Chihuahua'),(222,8,'20','Chínipas'),(223,8,'21','Delicias'),(224,8,'22','Dr. Belisario Domínguez'),(225,8,'23','Galeana'),(226,8,'24','Santa Isabel'),(227,8,'25','Gómez Farías'),(228,8,'26','Gran Morelos'),(229,8,'27','Guachochi'),(230,8,'28','Guadalupe'),(231,8,'29','Guadalupe y Calvo'),(232,8,'30','Guazapares'),(233,8,'31','Guerrero'),(234,8,'32','Hidalgo del Parral'),(235,8,'33','Huejotitán'),(236,8,'34','Ignacio Zaragoza'),(237,8,'35','Janos'),(238,8,'36','Jiménez'),(239,8,'37','Juárez'),(240,8,'38','Julimes'),(241,8,'39','López'),(242,8,'40','Madera'),(243,8,'41','Maguarichi'),(244,8,'42','Manuel Benavides'),(245,8,'43','Matachí'),(246,8,'44','Matamoros'),(247,8,'45','Meoqui'),(248,8,'46','Morelos'),(249,8,'47','Moris'),(250,8,'48','Namiquipa'),(251,8,'49','Nonoava'),(252,8,'50','Nuevo Casas Grandes'),(253,8,'51','Ocampo'),(254,8,'52','Ojinaga'),(255,8,'53','Praxedis G. Guerrero'),(256,8,'54','Riva Palacio'),(257,8,'55','Rosales'),(258,8,'56','Rosario'),(259,8,'57','San Francisco de Borja'),(260,8,'58','San Francisco de Conchos'),(261,8,'59','San Francisco del Oro'),(262,8,'60','Santa Bárbara'),(263,8,'61','Satevó'),(264,8,'62','Saucillo'),(265,8,'63','Temósachic'),(266,8,'64','El Tule'),(267,8,'65','Urique'),(268,8,'66','Uruachi'),(269,8,'67','Valle de Zaragoza'),(270,9,'1','Azcapotzalco'),(271,9,'2','Coyoacán'),(272,9,'3','Cuajimalpa de Morelos'),(273,9,'4','Gustavo A. Madero'),(274,9,'5','Iztacalco'),(275,9,'6','Iztapalapa'),(276,9,'7','La Magdalena Contreras'),(277,9,'8','Milpa Alta'),(278,9,'9','Álvaro Obregón'),(279,9,'10','Tláhuac'),(280,9,'11','Tlalpan'),(281,9,'12','Xochimilco'),(282,9,'13','Benito Juárez'),(283,9,'14','Cuauhtémoc'),(284,9,'15','Miguel Hidalgo'),(285,9,'16','Venustiano Carranza'),(286,10,'1','Canatlán'),(287,10,'2','Canelas'),(288,10,'3','Coneto de Comonfort'),(289,10,'4','Cuencamé'),(290,10,'5','Durango'),(291,10,'6','General Simón Bolívar'),(292,10,'7','Gómez Palacio'),(293,10,'8','Guadalupe Victoria'),(294,10,'9','Guanaceví'),(295,10,'10','Hidalgo'),(296,10,'11','Indé'),(297,10,'12','Lerdo'),(298,10,'13','Mapimí'),(299,10,'14','Mezquital'),(300,10,'15','Nazas'),(301,10,'16','Nombre de Dios'),(302,10,'17','Ocampo'),(303,10,'18','El Oro'),(304,10,'19','Otáez'),(305,10,'20','Pánuco de Coronado'),(306,10,'21','Peñón Blanco'),(307,10,'22','Poanas'),(308,10,'23','Pueblo Nuevo'),(309,10,'24','Rodeo'),(310,10,'25','San Bernardo'),(311,10,'26','San Dimas'),(312,10,'27','San Juan de Guadalupe'),(313,10,'28','San Juan del Río'),(314,10,'29','San Luis del Cordero'),(315,10,'30','San Pedro del Gallo'),(316,10,'31','Santa Clara'),(317,10,'32','Santiago Papasquiaro'),(318,10,'33','Súchil'),(319,10,'34','Tamazula'),(320,10,'35','Tepehuanes'),(321,10,'36','Tlahualilo'),(322,10,'37','Topia'),(323,10,'38','Vicente Guerrero'),(324,10,'39','Nuevo Ideal'),(325,11,'1','Abasolo'),(326,11,'2','Acámbaro'),(327,11,'3','San Miguel de Allende'),(328,11,'4','Apaseo el Alto'),(329,11,'5','Apaseo el Grande'),(330,11,'6','Atarjea'),(331,11,'7','Celaya'),(332,11,'8','Manuel Doblado'),(333,11,'9','Comonfort'),(334,11,'10','Coroneo'),(335,11,'11','Cortazar'),(336,11,'12','Cuerámaro'),(337,11,'13','Doctor Mora'),(338,11,'14','Dolores Hidalgo Cuna de la Independencia Nacional'),(339,11,'15','Guanajuato'),(340,11,'16','Huanímaro'),(341,11,'17','Irapuato'),(342,11,'18','Jaral del Progreso'),(343,11,'19','Jerécuaro'),(344,11,'20','León'),(345,11,'21','Moroleón'),(346,11,'22','Ocampo'),(347,11,'23','Pénjamo'),(348,11,'24','Pueblo Nuevo'),(349,11,'25','Purísima del Rincón'),(350,11,'26','Romita'),(351,11,'27','Salamanca'),(352,11,'28','Salvatierra'),(353,11,'29','San Diego de la Unión'),(354,11,'30','San Felipe'),(355,11,'31','San Francisco del Rincón'),(356,11,'32','San José Iturbide'),(357,11,'33','San Luis de la Paz'),(358,11,'34','Santa Catarina'),(359,11,'35','Santa Cruz de Juventino Rosas'),(360,11,'36','Santiago Maravatío'),(361,11,'37','Silao'),(362,11,'38','Tarandacuao'),(363,11,'39','Tarimoro'),(364,11,'40','Tierra Blanca'),(365,11,'41','Uriangato'),(366,11,'42','Valle de Santiago'),(367,11,'43','Victoria'),(368,11,'44','Villagrán'),(369,11,'45','Xichú'),(370,11,'46','Yuriria'),(371,12,'1','Acapulco de Juárez'),(372,12,'2','Ahuacuotzingo'),(373,12,'3','Ajuchitlán del Progreso'),(374,12,'4','Alcozauca de Guerrero'),(375,12,'5','Alpoyeca'),(376,12,'6','Apaxtla'),(377,12,'7','Arcelia'),(378,12,'8','Atenango del Río'),(379,12,'9','Atlamajalcingo del Monte'),(380,12,'10','Atlixtac'),(381,12,'11','Atoyac de Álvarez'),(382,12,'12','Ayutla de los Libres'),(383,12,'13','Azoyú'),(384,12,'14','Benito Juárez'),(385,12,'15','Buenavista de Cuéllar'),(386,12,'16','Coahuayutla de José María Izazaga'),(387,12,'17','Cocula'),(388,12,'18','Copala'),(389,12,'19','Copalillo'),(390,12,'20','Copanatoyac'),(391,12,'21','Coyuca de Benítez'),(392,12,'22','Coyuca de Catalán'),(393,12,'23','Cuajinicuilapa'),(394,12,'24','Cualác'),(395,12,'25','Cuautepec'),(396,12,'26','Cuetzala del Progreso'),(397,12,'27','Cutzamala de Pinzón'),(398,12,'28','Chilapa de Álvarez'),(399,12,'29','Chilpancingo de los Bravo'),(400,12,'30','Florencio Villarreal'),(401,12,'31','General Canuto A. Neri'),(402,12,'32','General Heliodoro Castillo'),(403,12,'33','Huamuxtitlán'),(404,12,'34','Huitzuco de los Figueroa'),(405,12,'35','Iguala de la Independencia'),(406,12,'36','Igualapa'),(407,12,'37','Ixcateopan de Cuauhtémoc'),(408,12,'38','Zihuatanejo de Azueta'),(409,12,'39','Juan R. Escudero'),(410,12,'40','Leonardo Bravo'),(411,12,'41','Malinaltepec'),(412,12,'42','Mártir de Cuilapan'),(413,12,'43','Metlatónoc'),(414,12,'44','Mochitlán'),(415,12,'45','Olinalá'),(416,12,'46','Ometepec'),(417,12,'47','Pedro Ascencio Alquisiras'),(418,12,'48','Petatlán'),(419,12,'49','Pilcaya'),(420,12,'50','Pungarabato'),(421,12,'51','Quechultenango'),(422,12,'52','San Luis Acatlán'),(423,12,'53','San Marcos'),(424,12,'54','San Miguel Totolapan'),(425,12,'55','Taxco de Alarcón'),(426,12,'56','Tecoanapa'),(427,12,'57','Técpan de Galeana'),(428,12,'58','Teloloapan'),(429,12,'59','Tepecoacuilco de Trujano'),(430,12,'60','Tetipac'),(431,12,'61','Tixtla de Guerrero'),(432,12,'62','Tlacoachistlahuaca'),(433,12,'63','Tlacoapa'),(434,12,'64','Tlalchapa'),(435,12,'65','Tlalixtaquilla de Maldonado'),(436,12,'66','Tlapa de Comonfort'),(437,12,'67','Tlapehuala'),(438,12,'68','La Unión de Isidoro Montes de Oca'),(439,12,'69','Xalpatláhuac'),(440,12,'70','Xochihuehuetlán'),(441,12,'71','Xochistlahuaca'),(442,12,'72','Zapotitlán Tablas'),(443,12,'73','Zirándaro'),(444,12,'74','Zitlala'),(445,12,'75','Eduardo Neri'),(446,12,'76','Acatepec'),(447,12,'77','Marquelia'),(448,12,'78','Cochoapa el Grande'),(449,12,'79','José Joaquin de Herrera'),(450,12,'80','Juchitán'),(451,12,'81','Iliatenco'),(452,13,'1','Acatlán'),(453,13,'2','Acaxochitlán'),(454,13,'3','Actopan'),(455,13,'4','Agua Blanca de Iturbide'),(456,13,'5','Ajacuba'),(457,13,'6','Alfajayucan'),(458,13,'7','Almoloya'),(459,13,'8','Apan'),(460,13,'9','El Arenal'),(461,13,'10','Atitalaquia'),(462,13,'11','Atlapexco'),(463,13,'12','Atotonilco el Grande'),(464,13,'13','Atotonilco de Tula'),(465,13,'14','Calnali'),(466,13,'15','Cardonal'),(467,13,'16','Cuautepec de Hinojosa'),(468,13,'17','Chapantongo'),(469,13,'18','Chapulhuacán'),(470,13,'19','Chilcuautla'),(471,13,'20','Eloxochitlán'),(472,13,'21','Emiliano Zapata'),(473,13,'22','Epazoyucan'),(474,13,'23','Francisco I. Madero'),(475,13,'24','Huasca de Ocampo'),(476,13,'25','Huautla'),(477,13,'26','Huazalingo'),(478,13,'27','Huehuetla'),(479,13,'28','Huejutla de Reyes'),(480,13,'29','Huichapan'),(481,13,'30','Ixmiquilpan'),(482,13,'31','Jacala de Ledezma'),(483,13,'32','Jaltocán'),(484,13,'33','Juárez Hidalgo'),(485,13,'34','Lolotla'),(486,13,'35','Metepec'),(487,13,'36','San Agustín Metzquititlán'),(488,13,'37','Metztitlán'),(489,13,'38','Mineral del Chico'),(490,13,'39','Mineral del Monte'),(491,13,'40','La Misión'),(492,13,'41','Mixquiahuala de Juárez'),(493,13,'42','Molango de Escamilla'),(494,13,'43','Nicolás Flores'),(495,13,'44','Nopala de Villagrán'),(496,13,'45','Omitlán de Juárez'),(497,13,'46','San Felipe Orizatlán'),(498,13,'47','Pacula'),(499,13,'48','Pachuca de Soto'),(500,13,'49','Pisaflores'),(501,13,'50','Progreso de Obregón'),(502,13,'51','Mineral de la Reforma'),(503,13,'52','San Agustín Tlaxiaca'),(504,13,'53','San Bartolo Tutotepec'),(505,13,'54','San Salvador'),(506,13,'55','Santiago de Anaya'),(507,13,'56','Santiago Tulantepec de Lugo Guerrero'),(508,13,'57','Singuilucan'),(509,13,'58','Tasquillo'),(510,13,'59','Tecozautla'),(511,13,'60','Tenango de Doria'),(512,13,'61','Tepeapulco'),(513,13,'62','Tepehuacán de Guerrero'),(514,13,'63','Tepeji del Río de Ocampo'),(515,13,'64','Tepetitlán'),(516,13,'65','Tetepango'),(517,13,'66','Villa de Tezontepec'),(518,13,'67','Tezontepec de Aldama'),(519,13,'68','Tianguistengo'),(520,13,'69','Tizayuca'),(521,13,'70','Tlahuelilpan'),(522,13,'71','Tlahuiltepa'),(523,13,'72','Tlanalapa'),(524,13,'73','Tlanchinol'),(525,13,'74','Tlaxcoapan'),(526,13,'75','Tolcayuca'),(527,13,'76','Tula de Allende'),(528,13,'77','Tulancingo de Bravo'),(529,13,'78','Xochiatipan'),(530,13,'79','Xochicoatlán'),(531,13,'80','Yahualica'),(532,13,'81','Zacualtipán de Ángeles'),(533,13,'82','Zapotlán de Juárez'),(534,13,'83','Zempoala'),(535,13,'84','Zimapán'),(536,14,'1','Acatic'),(537,14,'2','Acatlán de Juárez'),(538,14,'3','Ahualulco de Mercado'),(539,14,'4','Amacueca'),(540,14,'5','Amatitán'),(541,14,'6','Ameca'),(542,14,'7','San Juanito de Escobedo'),(543,14,'8','Arandas'),(544,14,'9','El Arenal'),(545,14,'10','Atemajac de Brizuela'),(546,14,'11','Atengo'),(547,14,'12','Atenguillo'),(548,14,'13','Atotonilco el Alto'),(549,14,'14','Atoyac'),(550,14,'15','Autlán de Navarro'),(551,14,'16','Ayotlán'),(552,14,'17','Ayutla'),(553,14,'18','La Barca'),(554,14,'19','Bolaños'),(555,14,'20','Cabo Corrientes'),(556,14,'21','Casimiro Castillo'),(557,14,'22','Cihuatlán'),(558,14,'23','Zapotlán el Grande'),(559,14,'24','Cocula'),(560,14,'25','Colotlán'),(561,14,'26','Concepción de Buenos Aires'),(562,14,'27','Cuautitlán de García Barragán'),(563,14,'28','Cuautla'),(564,14,'29','Cuquío'),(565,14,'30','Chapala'),(566,14,'31','Chimaltitán'),(567,14,'32','Chiquilistlán'),(568,14,'33','Degollado'),(569,14,'34','Ejutla'),(570,14,'35','Encarnación de Díaz'),(571,14,'36','Etzatlán'),(572,14,'37','El Grullo'),(573,14,'38','Guachinango'),(574,14,'39','Guadalajara'),(575,14,'40','Hostotipaquillo'),(576,14,'41','Huejúcar'),(577,14,'42','Huejuquilla el Alto'),(578,14,'43','La Huerta'),(579,14,'44','Ixtlahuacán de los Membrillos'),(580,14,'45','Ixtlahuacán del Río'),(581,14,'46','Jalostotitlán'),(582,14,'47','Jamay'),(583,14,'48','Jesús María'),(584,14,'49','Jilotlán de los Dolores'),(585,14,'50','Jocotepec'),(586,14,'51','Juanacatlán'),(587,14,'52','Juchitlán'),(588,14,'53','Lagos de Moreno'),(589,14,'54','El Limón'),(590,14,'55','Magdalena'),(591,14,'56','Santa María del Oro'),(592,14,'57','La Manzanilla de la Paz'),(593,14,'58','Mascota'),(594,14,'59','Mazamitla'),(595,14,'60','Mexticacán'),(596,14,'61','Mezquitic'),(597,14,'62','Mixtlán'),(598,14,'63','Ocotlán'),(599,14,'64','Ojuelos de Jalisco'),(600,14,'65','Pihuamo'),(601,14,'66','Poncitlán'),(602,14,'67','Puerto Vallarta'),(603,14,'68','Villa Purificación'),(604,14,'69','Quitupan'),(605,14,'70','El Salto'),(606,14,'71','San Cristóbal de la Barranca'),(607,14,'72','San Diego de Alejandría'),(608,14,'73','San Juan de los Lagos'),(609,14,'74','San Julián'),(610,14,'75','San Marcos'),(611,14,'76','San Martín de Bolaños'),(612,14,'77','San Martín Hidalgo'),(613,14,'78','San Miguel el Alto'),(614,14,'79','Gómez Farías'),(615,14,'80','San Sebastián del Oeste'),(616,14,'81','Santa María de los Ángeles'),(617,14,'82','Sayula'),(618,14,'83','Tala'),(619,14,'84','Talpa de Allende'),(620,14,'85','Tamazula de Gordiano'),(621,14,'86','Tapalpa'),(622,14,'87','Tecalitlán'),(623,14,'88','Tecolotlán'),(624,14,'89','Techaluta de Montenegro'),(625,14,'90','Tenamaxtlán'),(626,14,'91','Teocaltiche'),(627,14,'92','Teocuitatlán de Corona'),(628,14,'93','Tepatitlán de Morelos'),(629,14,'94','Tequila'),(630,14,'95','Teuchitlán'),(631,14,'96','Tizapán el Alto'),(632,14,'97','Tlajomulco de Zúñiga'),(633,14,'98','Tlaquepaque'),(634,14,'99','Tolimán'),(635,14,'100','Tomatlán'),(636,14,'101','Tonalá'),(637,14,'102','Tonaya'),(638,14,'103','Tonila'),(639,14,'104','Totatiche'),(640,14,'105','Tototlán'),(641,14,'106','Tuxcacuesco'),(642,14,'107','Tuxcueca'),(643,14,'108','Tuxpan'),(644,14,'109','Unión de San Antonio'),(645,14,'110','Unión de Tula'),(646,14,'111','Valle de Guadalupe'),(647,14,'112','Valle de Juárez'),(648,14,'113','San Gabriel'),(649,14,'114','Villa Corona'),(650,14,'115','Villa Guerrero'),(651,14,'116','Villa Hidalgo'),(652,14,'117','Cañadas de Obregón'),(653,14,'118','Yahualica de González Gallo'),(654,14,'119','Zacoalco de Torres'),(655,14,'120','Zapopan'),(656,14,'121','Zapotiltic'),(657,14,'122','Zapotitlán de Vadillo'),(658,14,'123','Zapotlán del Rey'),(659,14,'124','Zapotlanejo'),(660,14,'125','San Ignacio Cerro Gordo'),(661,15,'1','Acambay'),(662,15,'2','Acolman'),(663,15,'3','Aculco'),(664,15,'4','Almoloya de Alquisiras'),(665,15,'5','Almoloya de Juárez'),(666,15,'6','Almoloya del Río'),(667,15,'7','Amanalco'),(668,15,'8','Amatepec'),(669,15,'9','Amecameca'),(670,15,'10','Apaxco'),(671,15,'11','Atenco'),(672,15,'12','Atizapán'),(673,15,'13','Atizapán de Zaragoza'),(674,15,'14','Atlacomulco'),(675,15,'15','Atlautla'),(676,15,'16','Axapusco'),(677,15,'17','Ayapango'),(678,15,'18','Calimaya'),(679,15,'19','Capulhuac'),(680,15,'20','Coacalco de Berriozábal'),(681,15,'21','Coatepec Harinas'),(682,15,'22','Cocotitlán'),(683,15,'23','Coyotepec'),(684,15,'24','Cuautitlán'),(685,15,'25','Chalco'),(686,15,'26','Chapa de Mota'),(687,15,'27','Chapultepec'),(688,15,'28','Chiautla'),(689,15,'29','Chicoloapan'),(690,15,'30','Chiconcuac'),(691,15,'31','Chimalhuacán'),(692,15,'32','Donato Guerra'),(693,15,'33','Ecatepec de Morelos'),(694,15,'34','Ecatzingo'),(695,15,'35','Huehuetoca'),(696,15,'36','Hueypoxtla'),(697,15,'37','Huixquilucan'),(698,15,'38','Isidro Fabela'),(699,15,'39','Ixtapaluca'),(700,15,'40','Ixtapan de la Sal'),(701,15,'41','Ixtapan del Oro'),(702,15,'42','Ixtlahuaca'),(703,15,'43','Xalatlaco'),(704,15,'44','Jaltenco'),(705,15,'45','Jilotepec'),(706,15,'46','Jilotzingo'),(707,15,'47','Jiquipilco'),(708,15,'48','Jocotitlán'),(709,15,'49','Joquicingo'),(710,15,'50','Juchitepec'),(711,15,'51','Lerma'),(712,15,'52','Malinalco'),(713,15,'53','Melchor Ocampo'),(714,15,'54','Metepec'),(715,15,'55','Mexicaltzingo'),(716,15,'56','Morelos'),(717,15,'57','Naucalpan de Juárez'),(718,15,'58','Nezahualcóyotl'),(719,15,'59','Nextlalpan'),(720,15,'60','Nicolás Romero'),(721,15,'61','Nopaltepec'),(722,15,'62','Ocoyoacac'),(723,15,'63','Ocuilan'),(724,15,'64','El Oro'),(725,15,'65','Otumba'),(726,15,'66','Otzoloapan'),(727,15,'67','Otzolotepec'),(728,15,'68','Ozumba'),(729,15,'69','Papalotla'),(730,15,'70','La Paz'),(731,15,'71','Polotitlán'),(732,15,'72','Rayón'),(733,15,'73','San Antonio la Isla'),(734,15,'74','San Felipe del Progreso'),(735,15,'75','San Martín de las Pirámides'),(736,15,'76','San Mateo Atenco'),(737,15,'77','San Simón de Guerrero'),(738,15,'78','Santo Tomás'),(739,15,'79','Soyaniquilpan de Juárez'),(740,15,'80','Sultepec'),(741,15,'81','Tecámac'),(742,15,'82','Tejupilco'),(743,15,'83','Temamatla'),(744,15,'84','Temascalapa'),(745,15,'85','Temascalcingo'),(746,15,'86','Temascaltepec'),(747,15,'87','Temascaltepec'),(748,15,'88','Tenancingo'),(749,15,'89','Tenango del Aire'),(750,15,'90','Tenango del Valle'),(751,15,'91','Teoloyucan'),(752,15,'92','Teotihuacán'),(753,15,'93','Tepetlaoxtoc'),(754,15,'94','Tepetlixpa'),(755,15,'95','Tepotzotlán'),(756,15,'96','Tequixquiac'),(757,15,'97','Texcaltitlán'),(758,15,'98','Texcalyacac'),(759,15,'99','Texcoco'),(760,15,'100','Tezoyuca'),(761,15,'101','Tianguistenco'),(762,15,'102','Timilpan'),(763,15,'103','Tlalmanalco'),(764,15,'104','Tlalnepantla de Baz'),(765,15,'105','Tlatlaya'),(766,15,'106','Toluca'),(767,15,'107','Tonatico'),(768,15,'108','Tultepec'),(769,15,'109','Tultitlán'),(770,15,'110','Valle de Bravo'),(771,15,'111','Villa de Allende'),(772,15,'112','Villa del Carbón'),(773,15,'113','Villa Guerrero'),(774,15,'114','Villa Victoria'),(775,15,'115','Xonacatlán'),(776,15,'116','Zacazonapan'),(777,15,'117','Zacualpan'),(778,15,'118','Zinacantepec'),(779,15,'119','Zumpahuacán'),(780,15,'120','Zumpango'),(781,15,'121','Cuautitlán Izcalli'),(782,15,'122','Valle de Chalco Solidaridad'),(783,15,'123','Luvianos'),(784,15,'124','San José del Rincón'),(785,15,'125','Tonanitla'),(786,16,'1','Acuitzio'),(787,16,'2','Aguililla'),(788,16,'3','Álvaro Obregón'),(789,16,'4','Angamacutiro'),(790,16,'5','Angangueo'),(791,16,'6','Apatzingán'),(792,16,'7','Aporo'),(793,16,'8','Aquila'),(794,16,'9','Ario'),(795,16,'10','Arteaga'),(796,16,'11','Briseñas'),(797,16,'12','Buenavista'),(798,16,'13','Carácuaro'),(799,16,'14','Coahuayana'),(800,16,'15','Coalcomán de Vázquez Pallares'),(801,16,'16','Coeneo'),(802,16,'17','Contepec'),(803,16,'18','Copándaro'),(804,16,'19','Cotija'),(805,16,'20','Cuitzeo'),(806,16,'21','Charapan'),(807,16,'22','Charo'),(808,16,'23','Chavinda'),(809,16,'24','Cherán'),(810,16,'25','Chilchota'),(811,16,'26','Chinicuila'),(812,16,'27','Chucándiro'),(813,16,'28','Churintzio'),(814,16,'29','Churumuco'),(815,16,'30','Ecuandureo'),(816,16,'31','Epitacio Huerta'),(817,16,'32','Erongarícuaro'),(818,16,'33','Gabriel Zamora'),(819,16,'34','Gabriel Zamora'),(820,16,'35','La Huacana'),(821,16,'36','Huandacareo'),(822,16,'37','Huaniqueo'),(823,16,'38','Huetamo'),(824,16,'39','Huiramba'),(825,16,'40','Indaparapeo'),(826,16,'41','Irimbo'),(827,16,'42','Ixtlán'),(828,16,'43','Jacona'),(829,16,'44','Jiménez'),(830,16,'45','Jiquilpan'),(831,16,'46','Juárez'),(832,16,'47','Jungapeo'),(833,16,'48','Lagunillas'),(834,16,'49','Madero'),(835,16,'50','Maravatío'),(836,16,'51','Marcos Castellanos'),(837,16,'52','Lázaro Cárdenas'),(838,16,'53','Morelia'),(839,16,'54','Morelos'),(840,16,'55','Múgica'),(841,16,'56','Nahuatzen'),(842,16,'57','Nocupétaro'),(843,16,'58','Nuevo Parangaricutiro'),(844,16,'59','Nuevo Urecho'),(845,16,'60','Numarán'),(846,16,'61','Ocampo'),(847,16,'62','Pajacuarán'),(848,16,'63','Panindícuaro'),(849,16,'64','Parácuaro'),(850,16,'65','Paracho'),(851,16,'66','Pátzcuaro'),(852,16,'67','Penjamillo'),(853,16,'68','Peribán'),(854,16,'69','La Piedad'),(855,16,'70','Purépero'),(856,16,'71','Puruándiro'),(857,16,'72','Queréndaro'),(858,16,'73','Quiroga'),(859,16,'74','Cojumatlán de Régules'),(860,16,'75','Los Reyes'),(861,16,'76','Sahuayo'),(862,16,'77','San Lucas'),(863,16,'78','Santa Ana Maya'),(864,16,'79','Salvador Escalante'),(865,16,'80','Senguio'),(866,16,'81','Susupuato'),(867,16,'82','Tacámbaro'),(868,16,'83','Tancítaro'),(869,16,'84','Tangamandapio'),(870,16,'85','Tangancícuaro'),(871,16,'86','Tanhuato'),(872,16,'87','Taretan'),(873,16,'88','Tarímbaro'),(874,16,'89','Tepalcatepec'),(875,16,'90','Tingambato'),(876,16,'91','Tingüindín'),(877,16,'92','Tiquicheo de Nicolás Romero'),(878,16,'93','Tlalpujahua'),(879,16,'94','Tlazazalca'),(880,16,'95','Tocumbo'),(881,16,'96','Tumbiscatío'),(882,16,'97','Turicato'),(883,16,'98','Tuxpan'),(884,16,'99','Tuzantla'),(885,16,'100','Tzintzuntzan'),(886,16,'101','Tzitzio'),(887,16,'102','Uruapan'),(888,16,'103','Venustiano Carranza'),(889,16,'104','Villamar'),(890,16,'105','Vista Hermosa'),(891,16,'106','Yurécuaro'),(892,16,'107','Zacapu'),(893,16,'108','Zamora'),(894,16,'109','Zináparo'),(895,16,'110','Zinapécuaro'),(896,16,'111','Zinapécuaro'),(897,16,'112','Zitácuaro'),(898,16,'113','José Sixto Verduzco'),(899,17,'1','Amacuzac'),(900,17,'2','Atlatlahucan'),(901,17,'3','Axochiapan'),(902,17,'4','Ayala'),(903,17,'5','Coatlán del Río'),(904,17,'6','Cuautla'),(905,17,'7','Cuernavaca'),(906,17,'8','Emiliano Zapata'),(907,17,'9','Huitzilac'),(908,17,'10','Jantetelco'),(909,17,'11','Jiutepec'),(910,17,'12','Jojutla'),(911,17,'13','Jonacatepec'),(912,17,'14','Mazatepec'),(913,17,'15','Miacatlán'),(914,17,'16','Ocuituco'),(915,17,'17','Puente de Ixtla'),(916,17,'18','Temixco'),(917,17,'19','Tepalcingo'),(918,17,'20','Tepoztlán'),(919,17,'21','Tetecala'),(920,17,'22','Tetela del Volcán'),(921,17,'23','Tlalnepantla'),(922,17,'24','Tlaltizapán'),(923,17,'25','Tlaquiltenango'),(924,17,'26','Tlayacapan'),(925,17,'27','Totolapan'),(926,17,'28','Xochitepec'),(927,17,'29','Yautepec'),(928,17,'30','Yecapixtla'),(929,17,'31','Zacatepec'),(930,17,'32','Zacualpan'),(931,17,'33','Temoac'),(932,18,'1','Acaponeta'),(933,18,'2','Ahuacatlán'),(934,18,'3','Amatlán de Cañas'),(935,18,'4','Compostela'),(936,18,'5','Huajicori'),(937,18,'6','Ixtlán del Río'),(938,18,'7','Jala'),(939,18,'8','Xalisco'),(940,18,'9','Del Nayar'),(941,18,'10','Rosamorada'),(942,18,'11','Ruíz'),(943,18,'12','San Blas'),(944,18,'13','San Pedro Lagunillas'),(945,18,'14','Santa María del Oro'),(946,18,'15','Santiago Ixcuintla'),(947,18,'16','Tecuala'),(948,18,'17','Tepic'),(949,18,'18','Tuxpan'),(950,18,'19','La Yesca'),(951,18,'20','Bahía de Banderas'),(952,19,'1','Abasolo'),(953,19,'2','Agualeguas'),(954,19,'3','Los Aldamas'),(955,19,'4','Allende'),(956,19,'5','Anáhuac'),(957,19,'6','Apodaca'),(958,19,'7','Aramberri'),(959,19,'8','Bustamante'),(960,19,'9','Cadereyta Jiménez'),(961,19,'10','Carmen'),(962,19,'11','Cerralvo'),(963,19,'12','Ciénega de Flores'),(964,19,'13','China'),(965,19,'14','Dr. Arroyo'),(966,19,'15','Dr. Coss'),(967,19,'16','Dr. González'),(968,19,'17','Galeana'),(969,19,'18','García'),(970,19,'19','San Pedro Garza García'),(971,19,'20','Gral. Bravo'),(972,19,'21','Gral. Escobedo'),(973,19,'22','Gral. Terán'),(974,19,'23','Gral. Treviño'),(975,19,'24','Gral. Zaragoza'),(976,19,'25','Gral. Zuazua'),(977,19,'26','Guadalupe'),(978,19,'27','Los Herreras'),(979,19,'28','Higueras'),(980,19,'29','Hualahuises'),(981,19,'30','Iturbide'),(982,19,'31','Juárez'),(983,19,'32','Lampazos de Naranjo'),(984,19,'33','Linares'),(985,19,'34','Marín'),(986,19,'35','Melchor Ocampo'),(987,19,'36','Mier y Noriega'),(988,19,'37','Mina'),(989,19,'38','Montemorelos'),(990,19,'39','Monterrey'),(991,19,'40','Parás'),(992,19,'41','Pesquería'),(993,19,'42','Los Ramones'),(994,19,'43','Rayones'),(995,19,'44','Sabinas Hidalgo'),(996,19,'45','Salinas Victoria'),(997,19,'46','San Nicolás de los Garza'),(998,19,'47','Hidalgo'),(999,19,'48','Santa Catarina'),(1000,19,'49','Santiago'),(1001,19,'50','Vallecillo'),(1002,19,'51','Villaldama'),(1003,20,'1','Abejones'),(1004,20,'2','Acatlán de Pérez Figueroa'),(1005,20,'3','Asunción Cacalotepec'),(1006,20,'4','Asunción Cuyotepeji'),(1007,20,'5','Asunción Ixtaltepec'),(1008,20,'6','Asunción Nochixtlán'),(1009,20,'7','Asunción Ocotlán'),(1010,20,'8','Asunción Tlacolulita'),(1011,20,'9','Ayotzintepec'),(1012,20,'10','El Barrio de la Soledad'),(1013,20,'11','Calihualá'),(1014,20,'12','Candelaria Loxicha'),(1015,20,'13','Ciénega de Zimatlán'),(1016,20,'14','Ciudad Ixtepec'),(1017,20,'15','Coatecas Altas'),(1018,20,'16','Coicoyán de las Flores'),(1019,20,'17','La Compañía'),(1020,20,'18','Concepción Buenavista'),(1021,20,'19','Concepción Pápalo'),(1022,20,'20','Constancia del Rosario'),(1023,20,'21','Cosolapa'),(1024,20,'22','Cosoltepec'),(1025,20,'23','Cuilápam de Guerrero'),(1026,20,'24','Cuyamecalco Villa de Zaragoza'),(1027,20,'25','Chahuites'),(1028,20,'26','Chalcatongo de Hidalgo'),(1029,20,'27','Chiquihuitlán de Benito Juárez'),(1030,20,'28','Heroica Ciudad de Ejutla de Crespo'),(1031,20,'29','Eloxochitlán de Flores Magón'),(1032,20,'30','El Espinal'),(1033,20,'31','Tamazulapam del Espíritu Santo'),(1034,20,'32','Fresnillo de Trujano'),(1035,20,'33','Guadalupe Etla'),(1036,20,'34','Guadalupe de Ramírez'),(1037,20,'35','Guelatao de Juárez'),(1038,20,'36','Guevea de Humboldt'),(1039,20,'37','Mesones Hidalgo'),(1040,20,'38','Villa Hidalgo'),(1041,20,'39','Heroica Ciudad de Huajuapan de León'),(1042,20,'40','Huautepec'),(1043,20,'41','Huautla de Jiménez'),(1044,20,'42','Ixtlán de Juárez'),(1045,20,'43','Heroica Ciudad de Juchitán de Zaragoza'),(1046,20,'44','Loma Bonita'),(1047,20,'45','Magdalena Apasco'),(1048,20,'46','Magdalena Jaltepec'),(1049,20,'47','Santa Magdalena Jicotlán'),(1050,20,'48','Magdalena Mixtepec'),(1051,20,'49','Magdalena Ocotlán'),(1052,20,'50','Magdalena Peñasco'),(1053,20,'51','Magdalena Teitipac'),(1054,20,'52','Magdalena Tequisistlán'),(1055,20,'53','Magdalena Tlacotepec'),(1056,20,'54','Magdalena Zahuatlán'),(1057,20,'55','Mariscala de Juárez'),(1058,20,'56','Mártires de Tacubaya'),(1059,20,'57','Matías Romero Avendaño'),(1060,20,'58','Mazatlán Villa de Flores'),(1061,20,'59','Miahuatlán de Porfirio Díaz'),(1062,20,'60','Mixistlán de la Reforma'),(1063,20,'61','Monjas'),(1064,20,'62','Natividad'),(1065,20,'63','Nazareno Etla'),(1066,20,'64','Nejapa de Madero'),(1067,20,'65','Ixpantepec Nieves'),(1068,20,'66','Santiago Niltepec'),(1069,20,'67','Oaxaca de Juárez'),(1070,20,'68','Ocotlán de Morelos'),(1071,20,'69','La Pe'),(1072,20,'70','Pinotepa de Don Luis'),(1073,20,'71','Pluma Hidalgo'),(1074,20,'72','San José del Progreso'),(1075,20,'73','Putla Villa de Guerrero'),(1076,20,'74','Santa Catarina Quioquitani'),(1077,20,'75','Reforma de Pineda'),(1078,20,'76','La Reforma'),(1079,20,'77','Reyes Etla'),(1080,20,'78','Rojas de Cuauhtémoc'),(1081,20,'79','Salina Cruz'),(1082,20,'80','San Agustín Amatengo'),(1083,20,'81','San Agustín Atenango'),(1084,20,'82','San Agustín Chayuco'),(1085,20,'83','San Agustín de las Juntas'),(1086,20,'84','San Agustín Etla'),(1087,20,'85','San Agustín Loxicha'),(1088,20,'86','San Agustín Tlacotepec'),(1089,20,'87','San Agustín Yatareni'),(1090,20,'88','San Andrés Cabecera Nueva'),(1091,20,'89','San Andrés Dinicuiti'),(1092,20,'90','San Andrés Huaxpaltepec'),(1093,20,'91','San Andrés Huayapam'),(1094,20,'92','San Andrés Ixtlahuaca'),(1095,20,'93','San Andrés Lagunas'),(1096,20,'94','San Andrés Nuxiño'),(1097,20,'95','San Andrés Paxtlán'),(1098,20,'96','San Andrés Sinaxtla'),(1099,20,'97','San Andrés Solaga'),(1100,20,'98','San Andrés Teotilálpam'),(1101,20,'99','San Andrés Tepetlapa'),(1102,20,'100','San Andrés Yaá'),(1103,20,'101','San Andrés Zabache'),(1104,20,'102','San Andrés Zautla'),(1105,20,'103','San Antonino Castillo Velasco'),(1106,20,'104','San Antonino el Alto'),(1107,20,'105','San Antonino Monte Verde'),(1108,20,'106','San Antonio Acutla'),(1109,20,'107','San Antonio de la Cal'),(1110,20,'108','San Antonio Huitepec'),(1111,20,'109','San Antonio Nanahuatipam'),(1112,20,'110','San Antonio Sinicahua'),(1113,20,'111','San Antonio Tepetlapa'),(1114,20,'112','San Baltazar Chichicapam'),(1115,20,'113','San Baltazar Loxicha'),(1116,20,'114','San Baltazar Yatzachi el Bajo'),(1117,20,'115','San Bartolo Coyotepec'),(1118,20,'116','San Bartolomé Ayautla'),(1119,20,'117','San Bartolomé Loxicha'),(1120,20,'118','San Bartolomé Quialana'),(1121,20,'119','San Bartolomé Yucuañe'),(1122,20,'120','San Bartolomé Zoogocho'),(1123,20,'121','San Bartolo Soyaltepec'),(1124,20,'122','San Bartolo Yautepec'),(1125,20,'123','San Bernardo Mixtepec'),(1126,20,'124','San Blas Atempa'),(1127,20,'125','San Carlos Yautepec'),(1128,20,'126','San Cristóbal Amatlán'),(1129,20,'127','San Cristóbal Amoltepec'),(1130,20,'128','San Cristóbal Lachirioag'),(1131,20,'129','San Cristóbal Suchixtlahuaca'),(1132,20,'130','San Dionisio del Mar'),(1133,20,'131','San Dionisio Ocotepec'),(1134,20,'132','San Dionisio Ocotlán'),(1135,20,'133','San Esteban Atatlahuca'),(1136,20,'134','San Felipe Jalapa de Díaz'),(1137,20,'135','San Felipe Tejalapam'),(1138,20,'136','San Felipe Usila'),(1139,20,'137','San Francisco Cahuacúa'),(1140,20,'138','San Francisco Cajonos'),(1141,20,'139','San Francisco Chapulapa'),(1142,20,'140','San Francisco Chindúa'),(1143,20,'141','San Francisco del Mar'),(1144,20,'142','San Francisco Huehuetlán'),(1145,20,'143','San Francisco Ixhuatán'),(1146,20,'144','San Francisco Jaltepetongo'),(1147,20,'145','San Francisco Lachigoló'),(1148,20,'146','San Francisco Logueche'),(1149,20,'147','San Francisco Nuxaño'),(1150,20,'148','San Francisco Ozolotepec'),(1151,20,'149','San Francisco Sola'),(1152,20,'150','San Francisco Telixtlahuaca'),(1153,20,'151','San Francisco Teopan'),(1154,20,'152','San Francisco Tlapancingo'),(1155,20,'153','San Gabriel Mixtepec'),(1156,20,'154','San Ildefonso Amatlán'),(1157,20,'155','San Ildefonso Sola'),(1158,20,'156','San Ildefonso Villa Alta'),(1159,20,'157','San Jacinto Amilpas'),(1160,20,'158','San Jacinto Tlacotepec'),(1161,20,'159','San Jerónimo Coatlán'),(1162,20,'160','San Jerónimo Silacayoapilla'),(1163,20,'161','San Jerónimo Sosola'),(1164,20,'162','San Jerónimo Taviche'),(1165,20,'163','San Jerónimo Tecoatl'),(1166,20,'164','San Jorge Nuchita'),(1167,20,'165','San José Ayuquila'),(1168,20,'166','San José Chiltepec'),(1169,20,'167','San José del Peñasco'),(1170,20,'168','San José Estancia Grande'),(1171,20,'169','San José Independencia'),(1172,20,'170','San José Lachiguirí'),(1173,20,'171','San José Tenango'),(1174,20,'172','San Juan Achiutla'),(1175,20,'173','San Juan Atepec'),(1176,20,'174','Ánimas Trujano'),(1177,20,'175','San Juan Bautista Atatlahuca'),(1178,20,'176','San Juan Bautista Coixtlahuaca'),(1179,20,'177','San Juan Bautista Cuicatlán'),(1180,20,'178','San Juan Bautista Guelache'),(1181,20,'179','San Juan Bautista Jayacatlán'),(1182,20,'180','San Juan Bautista Lo de Soto'),(1183,20,'181','San Juan Bautista Suchitepec'),(1184,20,'182','San Juan Bautista Tlacoatzintepec'),(1185,20,'183','San Juan Bautista Tlachichilco'),(1186,20,'184','San Juan Bautista Tuxtepec'),(1187,20,'185','San Juan Cacahuatepec'),(1188,20,'186','San Juan Cieneguilla'),(1189,20,'187','San Juan Coatzospam'),(1190,20,'188','San Juan Colorado'),(1191,20,'189','San Juan Comaltepec'),(1192,20,'190','San Juan Cotzocón'),(1193,20,'191','San Juan Chicomezúchil'),(1194,20,'192','San Juan Chilateca'),(1195,20,'193','San Juan del Estado'),(1196,20,'194','San Juan del Río'),(1197,20,'195','San Juan Diuxi'),(1198,20,'196','San Juan Evangelista Analco'),(1199,20,'197','San Juan Guelavía'),(1200,20,'198','San Juan Guichicovi'),(1201,20,'199','San Juan Ihualtepec'),(1202,20,'200','San Juan Juquila Mixes'),(1203,20,'201','San Juan Juquila Vijanos'),(1204,20,'202','San Juan Lachao'),(1205,20,'203','San Juan Lachigalla'),(1206,20,'204','San Juan Lajarcia'),(1207,20,'205','San Juan Lalana'),(1208,20,'206','San Juan de los Cues'),(1209,20,'207','San Juan Mazatlán'),(1210,20,'208','San Juan Mixtepec -Distrito 08-'),(1211,20,'209','San Juan Mixtepec -Distrito 26-'),(1212,20,'210','San Juan Ñumí'),(1213,20,'211','San Juan Ozolotepec'),(1214,20,'212','San Juan Petlapa'),(1215,20,'213','San Juan Quiahije'),(1216,20,'214','San Juan Quiotepec'),(1217,20,'215','San Juan Sayultepec'),(1218,20,'216','San Juan Tabaá'),(1219,20,'217','San Juan Tamazola'),(1220,20,'218','San Juan Teita'),(1221,20,'219','San Juan Teitipac'),(1222,20,'220','San Juan Tepeuxila'),(1223,20,'221','San Juan Teposcolula'),(1224,20,'222','San Juan Yaeé'),(1225,20,'223','San Juan Yatzona'),(1226,20,'224','San Juan Yucuita'),(1227,20,'225','San Lorenzo'),(1228,20,'226','San Lorenzo Albarradas'),(1229,20,'227','San Lorenzo Cacaotepec'),(1230,20,'228','San Lorenzo Cuaunecuiltitla'),(1231,20,'229','San Lorenzo Texmelucan'),(1232,20,'230','San Lorenzo Victoria'),(1233,20,'231','San Lucas Camotlán'),(1234,20,'232','San Lucas Ojitlán'),(1235,20,'233','San Lucas Quiaviní'),(1236,20,'234','San Lucas Zoquiapam'),(1237,20,'235','San Luis Amatlán'),(1238,20,'236','San Marcial Ozolotepec'),(1239,20,'237','San Marcos Arteaga'),(1240,20,'238','San Martín de los Cansecos'),(1241,20,'239','San Martín Huamelulpam'),(1242,20,'240','San Martín Itunyoso'),(1243,20,'241','San Martín Lachilá'),(1244,20,'242','San Martín Peras'),(1245,20,'243','San Martín Tilcajete'),(1246,20,'244','San Martín Toxpalan'),(1247,20,'245','San Martín Zacatepec'),(1248,20,'246','San Mateo Cajonos'),(1249,20,'247','Capulálpam de Méndez'),(1250,20,'248','San Mateo del Mar'),(1251,20,'249','San Mateo Yoloxochitlán'),(1252,20,'250','San Mateo Etlatongo'),(1253,20,'251','San Mateo Nejapam'),(1254,20,'252','San Mateo Peñasco'),(1255,20,'253','San Mateo Piñas'),(1256,20,'254','San Mateo Río Hondo'),(1257,20,'255','San Mateo Sindihui'),(1258,20,'256','San Mateo Tlapiltepec'),(1259,20,'257','San Melchor Betaza'),(1260,20,'258','San Miguel Achiutla'),(1261,20,'259','San Miguel Ahuehuetitlán'),(1262,20,'260','San Miguel Aloápam'),(1263,20,'261','San Miguel Amatitlán'),(1264,20,'262','San Miguel Amatlán'),(1265,20,'263','San Miguel Coatlán'),(1266,20,'264','San Miguel Chicahua'),(1267,20,'265','San Miguel Chimalapa'),(1268,20,'266','San Miguel del Puerto'),(1269,20,'267','San Miguel del Río'),(1270,20,'268','San Miguel Ejutla'),(1271,20,'269','San Miguel el Grande'),(1272,20,'270','San Miguel Huautla'),(1273,20,'271','San Miguel Mixtepec'),(1274,20,'272','San Miguel Panixtlahuaca'),(1275,20,'273','San Miguel Peras'),(1276,20,'274','San Miguel Piedras'),(1277,20,'275','San Miguel Quetzaltepec'),(1278,20,'276','San Miguel Santa Flor'),(1279,20,'277','Villa Sola de Vega'),(1280,20,'278','San Miguel Soyaltepec'),(1281,20,'279','San Miguel Suchixtepec'),(1282,20,'280','Villa Talea de Castro'),(1283,20,'281','San Miguel Tecomatlán'),(1284,20,'282','San Miguel Tenango'),(1285,20,'283','San Miguel Tequixtepec'),(1286,20,'284','San Miguel Tilquiapam'),(1287,20,'285','San Miguel Tlacamama'),(1288,20,'286','San Miguel Tlacotepec'),(1289,20,'287','San Miguel Tulancingo'),(1290,20,'288','San Miguel Yotao'),(1291,20,'289','San Nicolás'),(1292,20,'290','San Nicolás Hidalgo'),(1293,20,'291','San Pablo Coatlán'),(1294,20,'292','San Pablo Cuatro Venados'),(1295,20,'293','San Pablo Etla'),(1296,20,'294','San Pablo Huitzo'),(1297,20,'295','San Pablo Huixtepec'),(1298,20,'296','San Pablo Macuiltianguis'),(1299,20,'297','San Pablo Tijaltepec'),(1300,20,'298','San Pablo Villa de Mitla'),(1301,20,'299','San Pablo Yaganiza'),(1302,20,'300','San Pedro Amuzgos'),(1303,20,'301','San Pedro Apóstol'),(1304,20,'302','San Pedro Atoyac'),(1305,20,'303','San Pedro Cajonos'),(1306,20,'304','San Pedro Coxcaltepec Cántaros'),(1307,20,'305','San Pedro Comitancillo'),(1308,20,'306','San Pedro el Alto'),(1309,20,'307','San Pedro Huamelula'),(1310,20,'308','San Pedro Huilotepec'),(1311,20,'309','San Pedro Ixcatlán'),(1312,20,'310','San Pedro Ixtlahuaca'),(1313,20,'311','San Pedro Jaltepetongo'),(1314,20,'312','San Pedro Jicayán'),(1315,20,'313','San Pedro Jocotipac'),(1316,20,'314','San Pedro Juchatengo'),(1317,20,'315','San Pedro Mártir'),(1318,20,'316','San Pedro Mártir Quiechapa'),(1319,20,'317','San Pedro Mártir Yucuxaco'),(1320,20,'318','San Pedro Mixtepec - Distrito 22 -'),(1321,20,'319','San Pedro Mixtepec - Distrito 26 -'),(1322,20,'320','San Pedro Molinos'),(1323,20,'321','San Pedro Nopala'),(1324,20,'322','San Pedro Ocopetatillo'),(1325,20,'323','San Pedro Ocotepec'),(1326,20,'324','San Pedro Pochutla'),(1327,20,'325','San Pedro Quiatoni'),(1328,20,'326','San Pedro Sochiapam'),(1329,20,'327','San Pedro Tapanatepec'),(1330,20,'328','San Pedro Taviche'),(1331,20,'329','San Pedro Teozacoalco'),(1332,20,'330','San Pedro Teutila'),(1333,20,'331','San Pedro Tidaá'),(1334,20,'332','San Pedro Topiltepec'),(1335,20,'333','San Pedro Totolapa'),(1336,20,'334','Villa de Tututepec de Melchor Ocampo'),(1337,20,'335','San Pedro Yaneri'),(1338,20,'336','San Pedro Yólox'),(1339,20,'337','San Pedro y San Pablo Ayutla'),(1340,20,'338','Villa de Etla'),(1341,20,'339','San Pedro y San Pablo Teposcolula'),(1342,20,'340','San Pedro y San Pablo Tequixtepec'),(1343,20,'341','San Pedro Yucunama'),(1344,20,'342','San Raymundo Jalpan'),(1345,20,'343','San Sebastián Abasolo'),(1346,20,'344','San Sebastián Coatlán'),(1347,20,'345','San Sebastián Ixcapa'),(1348,20,'346','San Sebastián Nicananduta'),(1349,20,'347','San Sebastián Río Hondo'),(1350,20,'348','San Sebastián Tecomaxtlahuaca'),(1351,20,'349','San Sebastián Teitipac'),(1352,20,'350','San Sebastián Tutla'),(1353,20,'351','San Simón Almolongas'),(1354,20,'352','San Simón Zahuatlán'),(1355,20,'353','Santa Ana'),(1356,20,'354','Santa Ana Ateixtlahuaca'),(1357,20,'355','Santa Ana Cuauhtémoc'),(1358,20,'356','Santa Ana del Valle'),(1359,20,'357','Santa Ana Tavela'),(1360,20,'358','Santa Ana Tlapacoyan'),(1361,20,'359','Santa Ana Yareni'),(1362,20,'360','Santa Ana Zegache'),(1363,20,'361','Santa Catalina Quieri'),(1364,20,'362','Santa Catarina Cuixtla'),(1365,20,'363','Santa Catarina Ixtepeji'),(1366,20,'364','Santa Catarina Juquila'),(1367,20,'365','Santa Catarina Lachatao'),(1368,20,'366','Santa Catarina Loxicha'),(1369,20,'367','Santa Catarina Mechoacán'),(1370,20,'368','Santa Catarina Minas'),(1371,20,'369','Santa Catarina Quiané'),(1372,20,'370','Santa Catarina Tayata'),(1373,20,'371','Santa Catarina Ticuá'),(1374,20,'372','Santa Catarina Yosonotú'),(1375,20,'373','Santa Catarina Zapoquila'),(1376,20,'374','Santa Cruz Acatepec'),(1377,20,'375','Santa Cruz Amilpas'),(1378,20,'376','Santa Cruz de Bravo'),(1379,20,'377','Santa Cruz Itundujia'),(1380,20,'378','Santa Cruz Mixtepec'),(1381,20,'379','Santa Cruz Nundaco'),(1382,20,'380','Santa Cruz Papalutla'),(1383,20,'381','Santa Cruz Tacache de Mina'),(1384,20,'382','Santa Cruz Tacahua'),(1385,20,'383','Santa Cruz Tayata'),(1386,20,'384','Santa Cruz Xitla'),(1387,20,'385','Santa Cruz Xoxocotlán'),(1388,20,'386','Santa Cruz Zenzontepec'),(1389,20,'387','Santa Gertrudis'),(1390,20,'388','Santa Inés del Monte'),(1391,20,'389','Santa Inés Yatzeche'),(1392,20,'390','Santa Lucía del Camino'),(1393,20,'391','Santa Lucía Miahuatlán'),(1394,20,'392','Santa Lucía Monteverde'),(1395,20,'393','Santa Lucía Ocotlán'),(1396,20,'394','Santa María Alotepec'),(1397,20,'395','Santa María Apazco'),(1398,20,'396','Santa María la Asunción'),(1399,20,'397','Heroica Ciudad de Tlaxiaco'),(1400,20,'398','Ayoquezco de Aldama'),(1401,20,'399','Santa María Atzompa'),(1402,20,'400','Santa María Camotlán'),(1403,20,'401','Santa María Colotepec'),(1404,20,'402','Santa María Cortijo'),(1405,20,'403','Santa María Coyotepec'),(1406,20,'404','Santa María Chachoapam'),(1407,20,'405','Villa de Chilapa de Díaz'),(1408,20,'406','Santa María Chilchotla'),(1409,20,'407','Santa María Chimalapa'),(1410,20,'408','Santa María del Rosario'),(1411,20,'409','Santa María del Tule'),(1412,20,'410','Santa María Ecatepec'),(1413,20,'411','Santa María Guelacé'),(1414,20,'412','Santa María Guienagati'),(1415,20,'413','Santa María Huatulco'),(1416,20,'414','Santa María Huazolotitlán'),(1417,20,'415','Santa María Ipalapa'),(1418,20,'416','Santa María Ixcatlán'),(1419,20,'417','Santa María Jacatepec'),(1420,20,'418','Santa María Jalapa del Marqués'),(1421,20,'419','Santa María Jaltianguis'),(1422,20,'420','Santa María Lachixío'),(1423,20,'421','Santa María Mixtequilla'),(1424,20,'422','Santa María Nativitas'),(1425,20,'423','Santa María Nduayaco'),(1426,20,'424','Santa María Ozolotepec'),(1427,20,'425','Santa María Pápalo'),(1428,20,'426','Santa María Peñoles'),(1429,20,'427','Santa María Petapa'),(1430,20,'428','Santa María Quiegolani'),(1431,20,'429','Santa María Sola'),(1432,20,'430','Santa María Tataltepec'),(1433,20,'431','Santa María Tecomavaca'),(1434,20,'432','Santa María Temaxcalapa'),(1435,20,'433','Santa María Temaxcaltepec'),(1436,20,'434','Santa María Teopoxco'),(1437,20,'435','Santa María Tepantlali'),(1438,20,'436','Santa María Texcatitlán'),(1439,20,'437','Santa María Tlahuitoltepec'),(1440,20,'438','Santa María Tlalixtac'),(1441,20,'439','Santa María Tonameca'),(1442,20,'440','Santa María Totolapilla'),(1443,20,'441','Santa María Xadani'),(1444,20,'442','Santa María Yalina'),(1445,20,'443','Santa María Yavesía'),(1446,20,'444','Santa María Yolotepec'),(1447,20,'445','Santa María Yosoyúa'),(1448,20,'446','Santa María Yucuhiti'),(1449,20,'447','Santa María Zacatepec'),(1450,20,'448','Santa María Zaniza'),(1451,20,'449','Santa María Zoquitlán'),(1452,20,'450','Santiago Amoltepec'),(1453,20,'451','Santiago Apoala'),(1454,20,'452','Santiago Apóstol'),(1455,20,'453','Santiago Astata'),(1456,20,'454','Santiago Atitlán'),(1457,20,'455','Santiago Ayuquililla'),(1458,20,'456','Santiago Cacaloxtepec'),(1459,20,'457','Santiago Camotlán'),(1460,20,'458','Santiago Comaltepec'),(1461,20,'459','Santiago Chazumba'),(1462,20,'460','Santiago Choapam'),(1463,20,'461','Santiago del Río'),(1464,20,'462','Santiago Huajolotitlán'),(1465,20,'463','Santiago Huauclilla'),(1466,20,'464','Santiago Ihuitlán Plumas'),(1467,20,'465','Santiago Ixcuintepec'),(1468,20,'466','Santiago Ixtayutla'),(1469,20,'467','Santiago Jamiltepec'),(1470,20,'468','Santiago Jocotepec'),(1471,20,'469','Santiago Juxtlahuaca'),(1472,20,'470','Santiago Lachiguiri'),(1473,20,'471','Santiago Lalopa'),(1474,20,'472','Santiago Laollaga'),(1475,20,'473','Santiago Laxopa'),(1476,20,'474','Santiago Llano Grande'),(1477,20,'475','Santiago Matatlán'),(1478,20,'476','Santiago Miltepec'),(1479,20,'477','Santiago Minas'),(1480,20,'478','Santiago Nacaltepec'),(1481,20,'479','Santiago Nejapilla'),(1482,20,'480','Santiago Nundiche'),(1483,20,'481','Santiago Nuyoó'),(1484,20,'482','Santiago Pinotepa Nacional'),(1485,20,'483','Santiago Suchilquitongo'),(1486,20,'484','Santiago Tamazola'),(1487,20,'485','Santiago Tapextla'),(1488,20,'486','Villa Tejúpam de la Unión'),(1489,20,'487','Santiago Tenango'),(1490,20,'488','Santiago Tepetlapa'),(1491,20,'489','Santiago Tetepec'),(1492,20,'490','Santiago Texcalcingo'),(1493,20,'491','Santiago Textitlán'),(1494,20,'492','Santiago Tilantongo'),(1495,20,'493','Santiago Tillo'),(1496,20,'494','Santiago Tlazoyaltepec'),(1497,20,'495','Santiago Xanica'),(1498,20,'496','Santiago Xiacuí'),(1499,20,'497','Santiago Yaitepec'),(1500,20,'498','Santiago Yaveo'),(1501,20,'499','Santiago Yolomécatl'),(1502,20,'500','Santiago Yosondúa'),(1503,20,'501','Santiago Yucuyachi'),(1504,20,'502','Santiago Zacatepec'),(1505,20,'503','Santiago Zoochila'),(1506,20,'504','Nuevo Zoquiapam'),(1507,20,'505','Santo Domingo Ingenio'),(1508,20,'506','Santo Domingo Albarradas'),(1509,20,'507','Santo Domingo Armenta'),(1510,20,'508','Santo Domingo Chihuitán'),(1511,20,'509','Santo Domingo de Morelos'),(1512,20,'510','Santo Domingo Ixcatlán'),(1513,20,'511','Santo Domingo Nuxaá'),(1514,20,'512','Santo Domingo Ozolotepec'),(1515,20,'513','Santo Domingo Petapa'),(1516,20,'514','Santo Domingo Roayaga'),(1517,20,'515','Santo Domingo Tehuantepec'),(1518,20,'516','Santo Domingo Teojomulco'),(1519,20,'517','Santo Domingo Tepuxtepec'),(1520,20,'518','Santo Domingo Tlatayapam'),(1521,20,'519','Santo Domingo Tomaltepec'),(1522,20,'520','Santo Domingo Tonalá'),(1523,20,'521','Santo Domingo Tonaltepec'),(1524,20,'522','Santo Domingo Xagacía'),(1525,20,'523','Santo Domingo Yanhuitlán'),(1526,20,'524','Santo Domingo Yodohino'),(1527,20,'525','Santo Domingo Zanatepec'),(1528,20,'526','Santos Reyes Nopala'),(1529,20,'527','Santos Reyes Pápalo'),(1530,20,'528','Santos Reyes Tepejillo'),(1531,20,'529','Santos Reyes Yucuná'),(1532,20,'530','Santo Tomás Jalieza'),(1533,20,'531','Santo Tomás Mazaltepec'),(1534,20,'532','Santo Tomás Ocotepec'),(1535,20,'533','Santo Tomás Tamazulapan'),(1536,20,'534','San Vicente Coatlán'),(1537,20,'535','San Vicente Lachixío'),(1538,20,'536','San Vicente Nuñú'),(1539,20,'537','Silacayoapam'),(1540,20,'538','Sitio de Xitlapehua'),(1541,20,'539','Soledad Etla'),(1542,20,'540','Villa de Tamazulapam del Progreso'),(1543,20,'541','Tanetze de Zaragoza'),(1544,20,'542','Taniche'),(1545,20,'543','Tataltepec de Valdés'),(1546,20,'544','Teococuilco de Marcos Pérez'),(1547,20,'545','Teotitlán de Flores Magón'),(1548,20,'546','Teotitlán del Valle'),(1549,20,'547','Teotongo'),(1550,20,'548','Tepelmeme Villa de Morelos'),(1551,20,'549','Tezoatlán de Segura y Luna'),(1552,20,'550','San Jerónimo Tlacochahuaya'),(1553,20,'551','Tlacolula de Matamoros'),(1554,20,'552','Tlacotepec Plumas'),(1555,20,'553','Tlalixtac de Cabrera'),(1556,20,'554','Totontepec Villa de Morelos'),(1557,20,'555','Trinidad Zaachila'),(1558,20,'556','La Trinidad Vista Hermosa'),(1559,20,'557','Unión Hidalgo'),(1560,20,'558','Valerio Trujano'),(1561,20,'559','San Juan Bautista Valle Nacional'),(1562,20,'560','Villa Díaz Ordaz'),(1563,20,'561','Yaxe'),(1564,20,'562','Magdalena Yodocono de Porfirio Díaz'),(1565,20,'563','Yogana'),(1566,20,'564','Yutanduchi de Guerrero'),(1567,20,'565','Villa de Zaachila'),(1568,20,'566','Zapotitlán del Río'),(1569,20,'567','Zapotitlán Lagunas'),(1570,20,'568','Zapotitlán Palmas'),(1571,20,'569','Santa Inés de Zaragoza'),(1572,20,'570','Zimatlán de Álvarez'),(1573,21,'1','Acajete'),(1574,21,'2','Acateno'),(1575,21,'3','Acatlán'),(1576,21,'4','Acatzingo'),(1577,21,'5','Acteopan'),(1578,21,'6','Ahuacatlán'),(1579,21,'7','Ahuatlán'),(1580,21,'8','Ahuazotepec'),(1581,21,'9','Ahuehuetitla'),(1582,21,'10','Ajalpan'),(1583,21,'11','Albino Zertuche'),(1584,21,'12','Aljojuca'),(1585,21,'13','Altepexi'),(1586,21,'14','Amixtlán'),(1587,21,'15','Amozoc'),(1588,21,'16','Aquixtla'),(1589,21,'17','Atempan'),(1590,21,'18','Atexcal'),(1591,21,'19','Atlixco'),(1592,21,'20','Atoyatempan'),(1593,21,'21','Atzala'),(1594,21,'22','Atzitzihuacán'),(1595,21,'23','Atzitzintla'),(1596,21,'24','Axutla'),(1597,21,'25','Ayotoxco de Guerrero'),(1598,21,'26','Calpan'),(1599,21,'27','Caltepec'),(1600,21,'28','Camocuautla'),(1601,21,'29','Caxhuacan'),(1602,21,'30','Coatepec'),(1603,21,'31','Coatzingo'),(1604,21,'32','Cohetzala'),(1605,21,'33','Cohuecan'),(1606,21,'34','Coronango'),(1607,21,'35','Coxcatlán'),(1608,21,'36','Coyomeapan'),(1609,21,'37','Coyotepec'),(1610,21,'38','Cuapiaxtla de Madero'),(1611,21,'39','Cuautempan'),(1612,21,'40','Cuautinchán'),(1613,21,'41','Cuautlancingo'),(1614,21,'42','Cuayuca de Andrade'),(1615,21,'43','Cuetzalan del Progreso'),(1616,21,'44','Cuyoaco'),(1617,21,'45','Chalchicomula de Sesma'),(1618,21,'46','Chapulco'),(1619,21,'47','Chiautla'),(1620,21,'48','Chiautzingo'),(1621,21,'49','Chiconcuautla'),(1622,21,'50','Chichiquila'),(1623,21,'51','Chietla'),(1624,21,'52','Chigmecatitlán'),(1625,21,'53','Chignahuapan'),(1626,21,'54','Chignautla'),(1627,21,'55','Chila'),(1628,21,'56','Chila de la Sal'),(1629,21,'57','Honey'),(1630,21,'58','Chilchotla'),(1631,21,'59','Chinantla'),(1632,21,'60','Domingo Arenas'),(1633,21,'61','Eloxochitlán'),(1634,21,'62','Epatlán'),(1635,21,'63','Esperanza'),(1636,21,'64','Francisco Z. Mena'),(1637,21,'65','General Felipe Ángeles'),(1638,21,'66','Guadalupe'),(1639,21,'67','Guadalupe Victoria'),(1640,21,'68','Hermenegildo Galeana'),(1641,21,'69','Huaquechula'),(1642,21,'70','Huatlatlauca'),(1643,21,'71','Huauchinango'),(1644,21,'72','Huehuetla'),(1645,21,'73','Huehuetlán el Chico'),(1646,21,'74','Huejotzingo'),(1647,21,'75','Hueyapan'),(1648,21,'76','Hueytamalco'),(1649,21,'77','Hueytlalpan'),(1650,21,'78','Huitzilan de Serdán'),(1651,21,'79','Huitziltepec'),(1652,21,'80','Atlequizayan'),(1653,21,'81','Ixcamilpa de Guerrero'),(1654,21,'82','Ixcaquixtla'),(1655,21,'83','Ixtacamaxtitlán'),(1656,21,'84','Ixtepec'),(1657,21,'85','Izúcar de Matamoros'),(1658,21,'86','Jalpan'),(1659,21,'87','Jolalpan'),(1660,21,'88','Jonotla'),(1661,21,'89','Jopala'),(1662,21,'90','Juan C. Bonilla'),(1663,21,'91','Juan Galindo'),(1664,21,'92','Juan N. Méndez'),(1665,21,'93','Lafragua'),(1666,21,'94','Libres'),(1667,21,'95','La Magdalena Tlatlauquitepec'),(1668,21,'96','Mazapiltepec de Juárez'),(1669,21,'97','Mixtla'),(1670,21,'98','Molcaxac'),(1671,21,'99','Cañada Morelos'),(1672,21,'100','Naupan'),(1673,21,'101','Nauzontla'),(1674,21,'102','Nealtican'),(1675,21,'103','Nicolás Bravo'),(1676,21,'104','Nopalucan'),(1677,21,'105','Ocotepec'),(1678,21,'106','Ocoyucan'),(1679,21,'107','Olintla'),(1680,21,'108','Oriental'),(1681,21,'109','Pahuatlán'),(1682,21,'110','Palmar de Bravo'),(1683,21,'111','Pantepec'),(1684,21,'112','Petlalcingo'),(1685,21,'113','Piaxtla'),(1686,21,'114','Puebla'),(1687,21,'115','Quecholac'),(1688,21,'116','Quimixtlán'),(1689,21,'117','Rafael Lara Grajales'),(1690,21,'118','Los Reyes de Juárez'),(1691,21,'119','San Andrés Cholula'),(1692,21,'120','San Antonio Cañada'),(1693,21,'121','San Diego la Mesa Tochimiltzingo'),(1694,21,'122','San Felipe Teotlalcingo'),(1695,21,'123','San Felipe Tepatlán'),(1696,21,'124','San Gabriel Chilac'),(1697,21,'125','San Gregorio Atzompa'),(1698,21,'126','San Jerónimo Tecuanipan'),(1699,21,'127','San Jerónimo Xayacatlán'),(1700,21,'128','San José Chiapa'),(1701,21,'129','San José Miahuatlán'),(1702,21,'130','San Juan Atenco'),(1703,21,'131','San Juan Atzompa'),(1704,21,'132','San Martín Texmelucan'),(1705,21,'133','San Martín Totoltepec'),(1706,21,'134','San Matías Tlalancaleca'),(1707,21,'135','San Miguel Ixitlán'),(1708,21,'136','San Miguel Xoxtla'),(1709,21,'137','San Nicolás Buenos Aires'),(1710,21,'138','San Nicolás de los Ranchos'),(1711,21,'139','San Pablo Anicano'),(1712,21,'140','San Pedro Cholula'),(1713,21,'141','San Pedro Yeloixtlahuaca'),(1714,21,'142','San Salvador el Seco'),(1715,21,'143','San Salvador el Verde'),(1716,21,'144','San Salvador Huixcolotla'),(1717,21,'145','San Sebastián Tlacotepec'),(1718,21,'146','Santa Catarina Tlaltempan'),(1719,21,'147','Santa Inés Ahuatempan'),(1720,21,'148','Santa Isabel Cholula'),(1721,21,'149','Santiago Miahuatlán'),(1722,21,'150','Huehuetlán el Grande'),(1723,21,'151','Santo Tomás Hueyotlipan'),(1724,21,'152','Soltepec'),(1725,21,'153','Tecali de Herrera'),(1726,21,'154','Tecamachalco'),(1727,21,'155','Tecomatlán'),(1728,21,'156','Tehuacán'),(1729,21,'157','Tehuitzingo'),(1730,21,'158','Tenampulco'),(1731,21,'159','Teopantlán'),(1732,21,'160','Teotlalco'),(1733,21,'161','Tepanco de López'),(1734,21,'162','Tepango de Rodríguez'),(1735,21,'163','Tepatlaxco de Hidalgo'),(1736,21,'164','Tepeaca'),(1737,21,'165','Tepemaxalco'),(1738,21,'166','Tepeojuma'),(1739,21,'167','Tepetzintla'),(1740,21,'168','Tepexco'),(1741,21,'169','Tepexi de Rodríguez'),(1742,21,'170','Tepeyahualco'),(1743,21,'171','Tepeyahualco de Cuauhtémoc'),(1744,21,'172','Tetela de Ocampo'),(1745,21,'173','Teteles de Avila Castillo'),(1746,21,'174','Teziutlán'),(1747,21,'175','Tianguismanalco'),(1748,21,'176','Tilapa'),(1749,21,'177','Tlacotepec de Benito Juárez'),(1750,21,'178','Tlacuilotepec'),(1751,21,'179','Tlachichuca'),(1752,21,'180','Tlahuapan'),(1753,21,'181','Tlaltenango'),(1754,21,'182','Tlanepantla'),(1755,21,'183','Tlaola'),(1756,21,'184','Tlapacoya'),(1757,21,'185','Tlapanalá'),(1758,21,'186','Tlatlauquitepec'),(1759,21,'187','Tlaxco'),(1760,21,'188','Tochimilco'),(1761,21,'189','Tochtepec'),(1762,21,'190','Totoltepec de Guerrero'),(1763,21,'191','Tulcingo'),(1764,21,'192','Tuzamapan de Galeana'),(1765,21,'193','Tzicatlacoyan'),(1766,21,'194','Venustiano Carranza'),(1767,21,'195','Vicente Guerrero'),(1768,21,'196','Xayacatlán de Bravo'),(1769,21,'197','Xicotepec'),(1770,21,'198','Xicotlán'),(1771,21,'199','Xiutetelco'),(1772,21,'200','Xochiapulco'),(1773,21,'201','Xochiltepec'),(1774,21,'202','Xochitlán de Vicente Suárez'),(1775,21,'203','Xochitlán Todos Santos'),(1776,21,'204','Yaonáhuac'),(1777,21,'205','Yehualtepec'),(1778,21,'206','Zacapala'),(1779,21,'207','Zacapoaxtla'),(1780,21,'208','Zacatlán'),(1781,21,'209','Zapotitlán'),(1782,21,'210','Zapotitlán de Méndez'),(1783,21,'211','Zaragoza'),(1784,21,'212','Zautla'),(1785,21,'213','Zihuateutla'),(1786,21,'214','Zinacatepec'),(1787,21,'215','Zongozotla'),(1788,21,'216','Zoquiapan'),(1789,21,'217','Zoquitlán'),(1790,22,'1','Amealco de Bonfil'),(1791,22,'2','Pinal de Amoles'),(1792,22,'3','Arroyo Seco'),(1793,22,'4','Cadereyta de Montes'),(1794,22,'5','Colón'),(1795,22,'6','Corregidora'),(1796,22,'7','Ezequiel Montes'),(1797,22,'8','Huimilpan'),(1798,22,'9','Jalpan de Serra'),(1799,22,'10','Landa de Matamoros'),(1800,22,'11','El Marqués'),(1801,22,'12','Pedro Escobedo'),(1802,22,'13','Peñamiller'),(1803,22,'14','Querétaro'),(1804,22,'15','San Joaquín'),(1805,22,'16','San Juan del Río'),(1806,22,'17','Tequisquiapan'),(1807,22,'18','Tolimán'),(1808,23,'1','Benito Juárez'),(1809,23,'2','Cozumel'),(1810,23,'3','Felipe Carrillo Puerto'),(1811,23,'4','Isla Mujeres'),(1812,23,'5','José María Morelos'),(1813,23,'6','Lázaro Cárdenas'),(1814,23,'7','Othon P. Blanco'),(1815,23,'8','Solidaridad'),(1816,23,'9','Tulum'),(1817,24,'1','Ahualulco'),(1818,24,'2','Alaquines'),(1819,24,'3','Aquismón'),(1820,24,'4','Armadillo de los Infante'),(1821,24,'5','Cárdenas'),(1822,24,'6','Catorce'),(1823,24,'7','Cedral'),(1824,24,'8','Cerritos'),(1825,24,'9','Cerro de San Pedro'),(1826,24,'10','Ciudad del Maíz'),(1827,24,'11','Ciudad Fernández'),(1828,24,'12','Tancanhuitz'),(1829,24,'13','Ciudad Valles'),(1830,24,'14','Coxcatlán'),(1831,24,'15','Charcas'),(1832,24,'16','Ebano'),(1833,24,'17','Guadalcázar'),(1834,24,'18','Huehuetlán'),(1835,24,'19','Lagunillas'),(1836,24,'20','Matehuala'),(1837,24,'21','Mexquitic de Carmona'),(1838,24,'22','Moctezuma'),(1839,24,'23','Rayón'),(1840,24,'24','Rioverde'),(1841,24,'25','Salinas'),(1842,24,'26','San Antonio'),(1843,24,'27','San Ciro de Acosta'),(1844,24,'28','San Luis Potosí'),(1845,24,'29','San Martín Chalchicuautla'),(1846,24,'30','San Nicolás Tolentino'),(1847,24,'31','Santa Catarina'),(1848,24,'32','Santa María del Río'),(1849,24,'33','Santo Domingo'),(1850,24,'34','San Vicente Tancuayalab'),(1851,24,'35','Soledad de Graciano Sánchez'),(1852,24,'36','Tamasopo'),(1853,24,'37','Tamazunchale'),(1854,24,'38','Tampacán'),(1855,24,'39','Tampamolón Corona'),(1856,24,'40','Tamuín'),(1857,24,'41','Tanlajás'),(1858,24,'42','Tanquián de Escobedo'),(1859,24,'43','Tierra Nueva'),(1860,24,'44','Vanegas'),(1861,24,'45','Venado'),(1862,24,'46','Villa de Arriaga'),(1863,24,'47','Villa de Guadalupe'),(1864,24,'48','Villa de la Paz'),(1865,24,'49','Villa de Ramos'),(1866,24,'50','Villa de Reyes'),(1867,24,'51','Villa Hidalgo'),(1868,24,'52','Villa Juárez'),(1869,24,'53','Axtla de Terrazas'),(1870,24,'54','Xilitla'),(1871,24,'55','Zaragoza'),(1872,24,'56','Villa de Arista'),(1873,24,'57','Matlapa'),(1874,24,'58','El Naranjo'),(1875,25,'1','Ahome'),(1876,25,'2','Angostura'),(1877,25,'3','Badiraguato'),(1878,25,'4','Concordia'),(1879,25,'5','Cosalá'),(1880,25,'6','Culiacán'),(1881,25,'7','Choix'),(1882,25,'8','Elota'),(1883,25,'9','Escuinapa'),(1884,25,'10','El Fuerte'),(1885,25,'11','Guasave'),(1886,25,'12','Mazatlán'),(1887,25,'13','Mocorito'),(1888,25,'14','Rosario'),(1889,25,'15','Salvador Alvarado'),(1890,25,'16','San Ignacio'),(1891,25,'17','Sinaloa'),(1892,25,'18','Navolato'),(1893,26,'1','Aconchi'),(1894,26,'2','Agua Prieta'),(1895,26,'3','Álamos'),(1896,26,'4','Altar'),(1897,26,'5','Arivechi'),(1898,26,'6','Arizpe'),(1899,26,'7','Átil'),(1900,26,'8','Bacadéhuachi'),(1901,26,'9','Bacanora'),(1902,26,'10','Bacerac'),(1903,26,'11','Bacoachi'),(1904,26,'12','Bácum'),(1905,26,'13','Banámichi'),(1906,26,'14','Baviácora'),(1907,26,'15','Bavispe'),(1908,26,'16','Benjamín Hill'),(1909,26,'17','Caborca'),(1910,26,'18','Cajeme'),(1911,26,'19','Cananea'),(1912,26,'20','Carbó'),(1913,26,'21','La Colorada'),(1914,26,'22','Cucurpe'),(1915,26,'23','Cumpas'),(1916,26,'24','Divisaderos'),(1917,26,'25','Empalme'),(1918,26,'26','Etchojoa'),(1919,26,'27','Fronteras'),(1920,26,'28','Granados'),(1921,26,'29','Guaymas'),(1922,26,'30','Hermosillo'),(1923,26,'31','Huachinera'),(1924,26,'32','Huásabas'),(1925,26,'33','Huatabampo'),(1926,26,'34','Huépac'),(1927,26,'35','Imuris'),(1928,26,'36','Magdalena'),(1929,26,'37','Mazatán'),(1930,26,'38','Moctezuma'),(1931,26,'39','Naco'),(1932,26,'40','Nácori Chico'),(1933,26,'41','Nacozari de García'),(1934,26,'42','Navojoa'),(1935,26,'43','Nogales'),(1936,26,'44','Ónavas'),(1937,26,'45','Opodepe'),(1938,26,'46','Oquitoa'),(1939,26,'47','Pitiquito'),(1940,26,'48','Puerto Peñasco'),(1941,26,'49','Quiriego'),(1942,26,'50','Rayón'),(1943,26,'51','Rosario'),(1944,26,'52','Sahuaripa'),(1945,26,'53','San Felipe de Jesús'),(1946,26,'54','San Javier'),(1947,26,'55','San Luis Río Colorado'),(1948,26,'56','San Miguel de Horcasitas'),(1949,26,'57','San Pedro de la Cueva'),(1950,26,'58','Santa Ana'),(1951,26,'59','Santa Cruz'),(1952,26,'60','Sáric'),(1953,26,'61','Soyopa'),(1954,26,'62','Suaqui Grande'),(1955,26,'63','Tepache'),(1956,26,'64','Trincheras'),(1957,26,'65','Tubutama'),(1958,26,'66','Ures'),(1959,26,'67','Villa Hidalgo'),(1960,26,'68','Villa Pesqueira'),(1961,26,'69','Yécora'),(1962,26,'70','General Plutarco Elías Calles'),(1963,26,'71','Benito Juárez'),(1964,26,'72','San Ignacio Río Muerto'),(1965,27,'1','Balancán'),(1966,27,'2','Cárdenas'),(1967,27,'3','Centla'),(1968,27,'4','Centro'),(1969,27,'5','Comalcalco'),(1970,27,'6','Cunduacán'),(1971,27,'7','Emiliano Zapata'),(1972,27,'8','Huimanguillo'),(1973,27,'9','Jalapa'),(1974,27,'10','Jalpa de Méndez'),(1975,27,'11','Jonuta'),(1976,27,'12','Macuspana'),(1977,27,'13','Nacajuca'),(1978,27,'14','Paraíso'),(1979,27,'15','Tacotalpa'),(1980,27,'16','Teapa'),(1981,27,'17','Tenosique'),(1982,28,'1','Abasolo'),(1983,28,'2','Aldama'),(1984,28,'3','Altamira'),(1985,28,'4','Antiguo Morelos'),(1986,28,'5','Burgos'),(1987,28,'6','Bustamante'),(1988,28,'7','Camargo'),(1989,28,'8','Casas'),(1990,28,'9','Ciudad Madero'),(1991,28,'10','Cruillas'),(1992,28,'11','Gomez Farías'),(1993,28,'12','González'),(1994,28,'13','Güémez'),(1995,28,'14','Guerrero'),(1996,28,'15','Diaz Ordaz'),(1997,28,'16','Hidalgo'),(1998,28,'17','Jaumave'),(1999,28,'18','Jiménez'),(2000,28,'19','Llera'),(2001,28,'20','Mainero'),(2002,28,'21','El Mante'),(2003,28,'22','Matamoros'),(2004,28,'23','Méndez'),(2005,28,'24','Mier'),(2006,28,'25','Miguel Alemán'),(2007,28,'26','Miquihuana'),(2008,28,'27','Nuevo Laredo'),(2009,28,'28','Nuevo Morelos'),(2010,28,'29','Ocampo'),(2011,28,'30','Padilla'),(2012,28,'31','Palmillas'),(2013,28,'32','Reynosa'),(2014,28,'33','Río Bravo'),(2015,28,'34','San Carlos'),(2016,28,'35','San Fernando'),(2017,28,'36','San Nicolás'),(2018,28,'37','Soto la Marina'),(2019,28,'38','Tampico'),(2020,28,'39','Tula'),(2021,28,'40','Valle Hermoso'),(2022,28,'41','Victoria'),(2023,28,'42','Villagrán'),(2024,28,'43','Xicoténcatl'),(2025,29,'1','Amaxac de Guerrero'),(2026,29,'2','Apetatitlán de Antonio Carvajal'),(2027,29,'3','Atlangatepec'),(2028,29,'4','Altzayanca'),(2029,29,'5','Apizaco'),(2030,29,'6','Calpulalpan'),(2031,29,'7','El Carmen Tequexquitla'),(2032,29,'8','Cuapiaxtla'),(2033,29,'9','Cuaxomulco'),(2034,29,'10','Chiautempan'),(2035,29,'11','Muñoz de Domingo Arenas'),(2036,29,'12','Españita'),(2037,29,'13','Huamantla'),(2038,29,'14','Hueyotlipan'),(2039,29,'15','Ixtacuixtla de Mariano Matamoros'),(2040,29,'16','Ixtenco'),(2041,29,'17','Mazatecochco de José María Morelos'),(2042,29,'18','Contla de Juan Cuamatzi'),(2043,29,'19','Tepetitla de Lardizábal'),(2044,29,'20','Sanctórum de Lázaro Cárdenas'),(2045,29,'21','Nanacamilpa de Mariano Arista'),(2046,29,'22','Acuamanala de Miguel Hidalgo'),(2047,29,'23','Natívitas'),(2048,29,'24','Panotla'),(2049,29,'25','San Pablo del Monte'),(2050,29,'26','Santa Cruz Tlaxcala'),(2051,29,'27','Tenancingo'),(2052,29,'28','Teolocholco'),(2053,29,'29','Tepeyanco'),(2054,29,'30','Terrenate'),(2055,29,'31','Tetla de la Solidaridad'),(2056,29,'32','Tetlatlahuca'),(2057,29,'33','Tlaxcala'),(2058,29,'34','Tlaxco'),(2059,29,'35','Tocatlán'),(2060,29,'36','Totolac'),(2061,29,'37','Zitlaltepec de Trinidad Sánchez Santos'),(2062,29,'38','Tzompantepec'),(2063,29,'39','Xalostoc'),(2064,29,'40','Xaltocan'),(2065,29,'41','Papalotla de Xicohténcatl'),(2066,29,'42','Xicohtzinco'),(2067,29,'43','Yauhquemecan'),(2068,29,'44','Zacatelco'),(2069,29,'45','Benito Juárez'),(2070,29,'46','Emiliano Zapata'),(2071,29,'47','Lázaro Cárdenas'),(2072,29,'48','La Magdalena Tlaltelulco'),(2073,29,'49','San Damián Texoloc'),(2074,29,'50','San Francisco Tetlanohcan'),(2075,29,'51','San Jerónimo Zacualpan'),(2076,29,'52','San José Teacalco'),(2077,29,'53','San Juan Huactzinco'),(2078,29,'54','San Lorenzo Axocomanitla'),(2079,29,'55','San Lucas Tecopilco'),(2080,29,'56','Santa Ana Nopalucan'),(2081,29,'57','Santa Apolonia Teacalco'),(2082,29,'58','Santa Catarina Ayometla'),(2083,29,'59','Santa Cruz Quilehtla'),(2084,29,'60','Santa Isabel Xiloxoxtla'),(2085,30,'1','Acajete'),(2086,30,'2','Acatlán'),(2087,30,'3','Acayucan'),(2088,30,'4','Actopan'),(2089,30,'5','Acula'),(2090,30,'6','Acultzingo'),(2091,30,'7','Camarón de Tejeda'),(2092,30,'8','Alpatláhuac'),(2093,30,'9','Alto Lucero de Gutiérrez Barrios'),(2094,30,'10','Altotonga'),(2095,30,'11','Alvarado'),(2096,30,'12','Amatitlán'),(2097,30,'13','Naranjos Amatlán'),(2098,30,'14','Amatlán de los Reyes'),(2099,30,'15','Ángel R. Cabada'),(2100,30,'16','La Antigua'),(2101,30,'17','Apazapan'),(2102,30,'18','Aquila'),(2103,30,'19','Astacinga'),(2104,30,'20','Atlahuilco'),(2105,30,'21','Atoyac'),(2106,30,'22','Atzacan'),(2107,30,'23','Atzalan'),(2108,30,'24','Tlaltetela'),(2109,30,'25','Ayahualulco'),(2110,30,'26','Banderilla'),(2111,30,'27','Benito Juárez'),(2112,30,'28','Boca del Río'),(2113,30,'29','Calcahualco'),(2114,30,'30','Camerino Z. Mendoza'),(2115,30,'31','Carrillo Puerto'),(2116,30,'32','Catemaco'),(2117,30,'33','Cazones de Herrera'),(2118,30,'34','Cerro Azul'),(2119,30,'35','Citlaltépetl'),(2120,30,'36','Coacoatzintla'),(2121,30,'37','Coahuitlán'),(2122,30,'38','Coatepec'),(2123,30,'39','Coatzacoalcos'),(2124,30,'40','Coatzintla'),(2125,30,'41','Coetzala'),(2126,30,'42','Colipa'),(2127,30,'43','Comapa'),(2128,30,'44','Córdoba'),(2129,30,'45','Cosamaloapan de Carpio'),(2130,30,'46','Cosautlán de Carvajal'),(2131,30,'47','Coscomatepec'),(2132,30,'48','Cosoleacaque'),(2133,30,'49','Cotaxtla'),(2134,30,'50','Coxquihui'),(2135,30,'51','Coyutla'),(2136,30,'52','Cuichapa'),(2137,30,'53','Cuitláhuac'),(2138,30,'54','Chacaltianguis'),(2139,30,'55','Chalma'),(2140,30,'56','Chiconamel'),(2141,30,'57','Chiconquiaco'),(2142,30,'58','Chicontepec'),(2143,30,'59','Chinameca'),(2144,30,'60','Chinampa de Gorostiza'),(2145,30,'61','Las Choapas'),(2146,30,'62','Chocamán'),(2147,30,'63','Chontla'),(2148,30,'64','Chumatlán'),(2149,30,'65','Emiliano Zapata'),(2150,30,'66','Espinal'),(2151,30,'67','Filomeno Mata'),(2152,30,'68','Fortín'),(2153,30,'69','Gutiérrez Zamora'),(2154,30,'70','Hidalgotitlán'),(2155,30,'71','Huatusco'),(2156,30,'72','Huayacocotla'),(2157,30,'73','Hueyapan de Ocampo'),(2158,30,'74','Huiloapan de Cuauhtémoc'),(2159,30,'75','Ignacio de la Llave'),(2160,30,'76','Ilamatlán'),(2161,30,'77','Isla'),(2162,30,'78','Ixcatepec'),(2163,30,'79','Ixhuacán de los Reyes'),(2164,30,'80','Ixhuatlán del Café'),(2165,30,'81','Ixhuatlancillo'),(2166,30,'82','Ixhuatlán del Sureste'),(2167,30,'83','Ixhuatlán de Madero'),(2168,30,'84','Ixmatlahuacan'),(2169,30,'85','Ixtaczoquitlán'),(2170,30,'86','Jalacingo'),(2171,30,'87','Xalapa'),(2172,30,'88','Jalcomulco'),(2173,30,'89','Jáltipan'),(2174,30,'90','Jamapa'),(2175,30,'91','Jesús Carranza'),(2176,30,'92','Xico'),(2177,30,'93','Jilotepec'),(2178,30,'94','Juan Rodríguez Clara'),(2179,30,'95','Juchique de Ferrer'),(2180,30,'96','Landero y Coss'),(2181,30,'97','Lerdo de Tejada'),(2182,30,'98','Magdalena'),(2183,30,'99','Maltrata'),(2184,30,'100','Manlio Fabio Altamirano'),(2185,30,'101','Mariano Escobedo'),(2186,30,'102','Martínez de la Torre'),(2187,30,'103','Mecatlán'),(2188,30,'104','Mecayapan'),(2189,30,'105','Medellín'),(2190,30,'106','Miahuatlán'),(2191,30,'107','Las Minas'),(2192,30,'108','Minatitlán'),(2193,30,'109','Misantla'),(2194,30,'110','Mixtla de Altamirano'),(2195,30,'111','Moloacán'),(2196,30,'112','Naolinco'),(2197,30,'113','Naranjal'),(2198,30,'114','Nautla'),(2199,30,'115','Nogales'),(2200,30,'116','Oluta'),(2201,30,'117','Omealca'),(2202,30,'118','Orizaba'),(2203,30,'119','Otatitlán'),(2204,30,'120','Oteapan'),(2205,30,'121','Ozuluama de Mascareñas'),(2206,30,'122','Pajapan'),(2207,30,'123','Pánuco'),(2208,30,'124','Papantla'),(2209,30,'125','Paso del Macho'),(2210,30,'126','Paso de Ovejas'),(2211,30,'127','La Perla'),(2212,30,'128','Perote'),(2213,30,'129','Platón Sánchez'),(2214,30,'130','Playa Vicente'),(2215,30,'131','Poza Rica de Hidalgo'),(2216,30,'132','Las Vigas de Ramírez'),(2217,30,'133','Pueblo Viejo'),(2218,30,'134','Puente Nacional'),(2219,30,'135','Rafael Delgado'),(2220,30,'136','Rafael Lucio'),(2221,30,'137','Los Reyes'),(2222,30,'138','Río Blanco'),(2223,30,'139','Saltabarranca'),(2224,30,'140','San Andrés Tenejapan'),(2225,30,'141','San Andrés Tuxtla'),(2226,30,'142','San Juan Evangelista'),(2227,30,'143','Santiago Tuxtla'),(2228,30,'144','Sayula de Alemán'),(2229,30,'145','Soconusco'),(2230,30,'146','Sochiapa'),(2231,30,'147','Soledad Atzompa'),(2232,30,'148','Soledad de Doblado'),(2233,30,'149','Soteapan'),(2234,30,'150','Tamalín'),(2235,30,'151','Tamiahua'),(2236,30,'152','Tampico Alto'),(2237,30,'153','Tancoco'),(2238,30,'154','Tantima'),(2239,30,'155','Tantoyuca'),(2240,30,'156','Tatatila'),(2241,30,'157','Castillo de Teayo'),(2242,30,'158','Tecolutla'),(2243,30,'159','Tehuipango'),(2244,30,'160','Temapache'),(2245,30,'161','Tempoal'),(2246,30,'162','Tenampa'),(2247,30,'163','Tenochtitlán'),(2248,30,'164','Teocelo'),(2249,30,'165','Tepatlaxco'),(2250,30,'166','Tepetlán'),(2251,30,'167','Tepetzintla'),(2252,30,'168','Tequila'),(2253,30,'169','José Azueta'),(2254,30,'170','Texcatepec'),(2255,30,'171','Texhuacán'),(2256,30,'172','Texistepec'),(2257,30,'173','Tezonapa'),(2258,30,'174','Tierra Blanca'),(2259,30,'175','Tihuatlán'),(2260,30,'176','Tlacojalpan'),(2261,30,'177','Tlacolulan'),(2262,30,'178','Tlacotalpan'),(2263,30,'179','Tlacotepec de Mejía'),(2264,30,'180','Tlachichilco'),(2265,30,'181','Tlalixcoyan'),(2266,30,'182','Tlalnelhuayocan'),(2267,30,'183','Tlapacoyan'),(2268,30,'184','Tlaquilpa'),(2269,30,'185','Tlilapan'),(2270,30,'186','Tomatlán'),(2271,30,'187','Tonayán'),(2272,30,'188','Totutla'),(2273,30,'189','Túxpan'),(2274,30,'190','Tuxtilla'),(2275,30,'191','Úrsulo Galván'),(2276,30,'192','Vega de Alatorre'),(2277,30,'193','Veracruz'),(2278,30,'194','Villa Aldama'),(2279,30,'195','Xoxocotla'),(2280,30,'196','Yanga'),(2281,30,'197','Yecuatla'),(2282,30,'198','Zacualpan'),(2283,30,'199','Zaragoza'),(2284,30,'200','Zentla'),(2285,30,'201','Zongolica'),(2286,30,'202','Zontecomatlán de López y Fuentes'),(2287,30,'203','Zozocolco de Hidalgo'),(2288,30,'204','Agua Dulce'),(2289,30,'205','El Higo'),(2290,30,'206','Nanchital de Lázaro Cárdenas del Río'),(2291,30,'207','Tres Valles'),(2292,30,'208','Carlos A. Carrillo'),(2293,30,'209','Tatahuicapan de Juárez'),(2294,30,'210','Uxpanapa'),(2295,30,'211','San Rafael'),(2296,30,'212','Santiago Sochiapan'),(2297,31,'1','Abalá'),(2298,31,'2','Acanceh'),(2299,31,'3','Akil'),(2300,31,'4','Baca'),(2301,31,'5','Bokobá'),(2302,31,'6','Buctzotz'),(2303,31,'7','Cacalchén'),(2304,31,'8','Calotmul'),(2305,31,'9','Cansahcab'),(2306,31,'10','Cantamayec'),(2307,31,'11','Celestún'),(2308,31,'12','Cenotillo'),(2309,31,'13','Conkal'),(2310,31,'14','Cuncunul'),(2311,31,'15','Cuzamá'),(2312,31,'16','Chacsinkín'),(2313,31,'17','Chankom'),(2314,31,'18','Chapab'),(2315,31,'19','Chapab'),(2316,31,'20','Chicxulub Pueblo'),(2317,31,'21','Chichimilá'),(2318,31,'22','Chikindzonot'),(2319,31,'23','Chocholá'),(2320,31,'24','Chumayel'),(2321,31,'25','Dzán'),(2322,31,'26','Dzemul'),(2323,31,'27','Dzidzantún'),(2324,31,'28','Dzilam de Bravo'),(2325,31,'29','Dzilam González'),(2326,31,'30','Dzitás'),(2327,31,'31','Dzoncauich'),(2328,31,'32','Espita'),(2329,31,'33','Halachó'),(2330,31,'34','Hocabá'),(2331,31,'35','Hoctún'),(2332,31,'36','Homún'),(2333,31,'37','Huhí'),(2334,31,'38','Hunucmá'),(2335,31,'39','Ixil'),(2336,31,'40','Izamal'),(2337,31,'41','Kanasín'),(2338,31,'42','Kantunil'),(2339,31,'43','Kaua'),(2340,31,'44','Kinchil'),(2341,31,'45','Kopomá'),(2342,31,'46','Mama'),(2343,31,'47','Maní'),(2344,31,'48','Maxcanú'),(2345,31,'49','Mayapán'),(2346,31,'50','Mérida'),(2347,31,'51','Mocochá'),(2348,31,'52','Motul'),(2349,31,'53','Muna'),(2350,31,'54','Muxupip'),(2351,31,'55','Opichén'),(2352,31,'56','Oxkutzcab'),(2353,31,'57','Panabá'),(2354,31,'58','Peto'),(2355,31,'59','Progreso'),(2356,31,'60','Quintana Roo'),(2357,31,'61','Río Lagartos'),(2358,31,'62','Sacalum'),(2359,31,'63','Samahil'),(2360,31,'64','Sanahcat'),(2361,31,'65','San Felipe'),(2362,31,'66','Santa Elena'),(2363,31,'67','Seyé'),(2364,31,'68','Sinanché'),(2365,31,'69','Sotuta'),(2366,31,'70','Sucilá'),(2367,31,'71','Sudzal'),(2368,31,'72','Suma'),(2369,31,'73','Tahdziú'),(2370,31,'74','Tahmek'),(2371,31,'75','Teabo'),(2372,31,'76','Tecoh'),(2373,31,'77','Tekal de Venegas'),(2374,31,'78','Tekantó'),(2375,31,'79','Tekax'),(2376,31,'80','Tekit'),(2377,31,'81','Tekom'),(2378,31,'82','Telchac Pueblo'),(2379,31,'83','Telchac Puerto'),(2380,31,'84','Temax'),(2381,31,'85','Temozón'),(2382,31,'86','Tepakán'),(2383,31,'87','Tetiz'),(2384,31,'88','Teya'),(2385,31,'89','Ticul'),(2386,31,'90','Timucuy'),(2387,31,'91','Tinum'),(2388,31,'92','Tixcacalcupul'),(2389,31,'93','Tixkokob'),(2390,31,'94','Tixmehuac'),(2391,31,'95','Tixpéhual'),(2392,31,'96','Tizimín'),(2393,31,'97','Tunkás'),(2394,31,'98','Tzucacab'),(2395,31,'99','Uayma'),(2396,31,'100','Ucú'),(2397,31,'101','Umán'),(2398,31,'102','Valladolid'),(2399,31,'103','Xocchel'),(2400,31,'104','Yaxcabá'),(2401,31,'105','Yaxkukul'),(2402,31,'106','Yobaín'),(2403,32,'1','Apozol'),(2404,32,'2','Apulco'),(2405,32,'3','Atolinga'),(2406,32,'4','Benito Juárez'),(2407,32,'5','Calera'),(2408,32,'6','Cañitas de Felipe Pescador'),(2409,32,'7','Concepción del Oro'),(2410,32,'8','Cuauhtémoc'),(2411,32,'9','Chalchihuites'),(2412,32,'10','Fresnillo'),(2413,32,'11','Trinidad García de la Cadena'),(2414,32,'12','Genaro Codina'),(2415,32,'13','General Enrique Estrada'),(2416,32,'14','General Francisco R. Murguía'),(2417,32,'15','El Plateado de Joaquín Amaro'),(2418,32,'16','General Pánfilo Natera'),(2419,32,'17','Guadalupe'),(2420,32,'18','Huanusco'),(2421,32,'19','Jalpa'),(2422,32,'20','Jerez'),(2423,32,'21','Jiménez del Teul'),(2424,32,'22','Juan Aldama'),(2425,32,'23','Juchipila'),(2426,32,'24','Loreto'),(2427,32,'25','Luis Moya'),(2428,32,'26','Mazapil'),(2429,32,'27','Melchor Ocampo'),(2430,32,'28','Mezquital del Oro'),(2431,32,'29','Miguel Auza'),(2432,32,'30','Momax'),(2433,32,'31','Monte Escobedo'),(2434,32,'32','Morelos'),(2435,32,'33','Moyahua de Estrada'),(2436,32,'34','Nochistlán de Mejía'),(2437,32,'35','Noria de Ángeles'),(2438,32,'36','Ojocaliente'),(2439,32,'37','Pánuco'),(2440,32,'38','Pinos'),(2441,32,'39','Río Grande'),(2442,32,'40','Saín Alto'),(2443,32,'41','El Salvador'),(2444,32,'42','Sombrerete'),(2445,32,'43','Susticacán'),(2446,32,'44','Tabasco'),(2447,32,'45','Tepechitlán'),(2448,32,'46','Tepetongo'),(2449,32,'47','Teul de González Ortega'),(2450,32,'48','Tlaltenango de Sánchez Román'),(2451,32,'49','Valparaíso'),(2452,32,'50','Vetagrande'),(2453,32,'51','Villa de Cos'),(2454,32,'52','Villa García'),(2455,32,'53','Villa González Ortega'),(2456,32,'54','Villa Hidalgo'),(2457,32,'55','Villanueva'),(2458,32,'56','Zacatecas'),(2459,32,'57','Trancoso'),(2460,32,'58','Santa María de la Paz');
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
  `hash` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idOpcion`),
  KEY `fk_Opcion_Categoria1_idx` (`idCategoria`),
  CONSTRAINT `fk_Opcion_Categoria1` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opcion`
--

LOCK TABLES `opcion` WRITE;
/*!40000 ALTER TABLE `opcion` DISABLE KEYS */;
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
  `hash` varchar(45) DEFAULT NULL,
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
  `idEmpresas` int(11) NOT NULL,
  `tipo` varchar(2) NOT NULL,
  `idEmpresa` int(11) NOT NULL,
  `poliza` varchar(100) NOT NULL,
  `fecha` datetime NOT NULL,
  `tipoPoliza` varchar(2) NOT NULL,
  `origen` varchar(45) NOT NULL,
  PRIMARY KEY (`idPoliza`),
  KEY `fk_Poliza_Empresas1_idx` (`idEmpresas`),
  KEY `fk_Poliza_Empresa1_idx` (`idEmpresa`),
  CONSTRAINT `fk_Poliza_Empresa1` FOREIGN KEY (`idEmpresa`) REFERENCES `empresa` (`idEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Poliza_Empresas1` FOREIGN KEY (`idEmpresas`) REFERENCES `empresas` (`idEmpresas`) ON DELETE NO ACTION ON UPDATE NO ACTION
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
  `preferencia` int(11) DEFAULT NULL,
  PRIMARY KEY (`idPregunta`,`idOpcion`),
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
  `hash` varchar(45) DEFAULT NULL,
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
-- Table structure for table `productoimpuesto`
--

DROP TABLE IF EXISTS `productoimpuesto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productoimpuesto` (
  `idProductoImpuesto` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` int(11) NOT NULL,
  `idImpuesto` int(11) NOT NULL,
  PRIMARY KEY (`idProductoImpuesto`),
  KEY `fk_ProductoImpuesto_Producto1_idx` (`idProducto`),
  KEY `fk_ProductoImpuesto_Impuesto1_idx` (`idImpuesto`),
  CONSTRAINT `fk_ProductoImpuesto_Impuesto1` FOREIGN KEY (`idImpuesto`) REFERENCES `impuesto` (`idImpuesto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ProductoImpuesto_Producto1` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productoimpuesto`
--

LOCK TABLES `productoimpuesto` WRITE;
/*!40000 ALTER TABLE `productoimpuesto` DISABLE KEYS */;
/*!40000 ALTER TABLE `productoimpuesto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proveedores` (
  `idProveedores` int(11) NOT NULL AUTO_INCREMENT,
  `idEmpresa` int(11) NOT NULL,
  `idTipoProveedor` int(11) NOT NULL,
  PRIMARY KEY (`idProveedores`),
  KEY `fk_Proveedores_Empresa1_idx` (`idEmpresa`),
  KEY `fk_Proveedores_TipoProveedor1_idx` (`idTipoProveedor`),
  CONSTRAINT `fk_Proveedores_Empresa1` FOREIGN KEY (`idEmpresa`) REFERENCES `empresa` (`idEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Proveedores_TipoProveedor1` FOREIGN KEY (`idTipoProveedor`) REFERENCES `tipoproveedor` (`idTipoProveedor`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedores`
--

LOCK TABLES `proveedores` WRITE;
/*!40000 ALTER TABLE `proveedores` DISABLE KEYS */;
/*!40000 ALTER TABLE `proveedores` ENABLE KEYS */;
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
-- Table structure for table `respuesta`
--

DROP TABLE IF EXISTS `respuesta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `respuesta` (
  `idRespuesta` int(11) NOT NULL AUTO_INCREMENT,
  `idEncuesta` int(11) NOT NULL,
  `idPregunta` int(11) NOT NULL,
  `respuesta` text NOT NULL,
  `fecha` datetime NOT NULL,
  `hash` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idRespuesta`),
  KEY `fk_Respuesta_Pregunta1_idx` (`idPregunta`),
  KEY `fk_Respuesta_Encuesta1_idx` (`idEncuesta`),
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
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol` (
  `idRol` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(200) NOT NULL,
  `fecha` datetime NOT NULL,
  `hash` varchar(45) DEFAULT NULL,
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
  `hash` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idSeccion`),
  KEY `fk_Seccion_Encuesta1_idx` (`idEncuesta`),
  CONSTRAINT `fk_Seccion_Encuesta1` FOREIGN KEY (`idEncuesta`) REFERENCES `encuesta` (`idEncuesta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seccion`
--

LOCK TABLES `seccion` WRITE;
/*!40000 ALTER TABLE `seccion` DISABLE KEYS */;
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
  `hash` varchar(45) DEFAULT NULL,
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
  `telefono` varchar(16) NOT NULL,
  `extensiones` varchar(20) DEFAULT NULL,
  `hash` varchar(45) DEFAULT NULL,
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
  `password` varchar(100) NOT NULL,
  `nombres` varchar(150) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `fecha` datetime NOT NULL,
  `hash` varchar(45) DEFAULT NULL,
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
  `idTelefono` int(11) NOT NULL,
  `idDomicilio` int(11) NOT NULL,
  `estatus` varchar(1) NOT NULL,
  `fechaAlta` datetime NOT NULL,
  `comision` decimal(10,0) NOT NULL,
  PRIMARY KEY (`idVendedor`),
  KEY `fk_Vendedor_Domicilio1_idx` (`idDomicilio`),
  KEY `fk_Vendedor_Telefono1_idx` (`idTelefono`),
  CONSTRAINT `fk_Vendedor_Domicilio1` FOREIGN KEY (`idDomicilio`) REFERENCES `domicilio` (`idDomicilio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Vendedor_Telefono1` FOREIGN KEY (`idTelefono`) REFERENCES `telefono` (`idTelefono`) ON DELETE NO ACTION ON UPDATE NO ACTION
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

-- Dump completed on 2016-02-17 18:33:28
