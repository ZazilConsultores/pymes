CREATE DATABASE  IF NOT EXISTS `generaldos` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `generaldos`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win64 (x86_64)
--
-- Host: localhost    Database: generaldos
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
  `descripcion` text NOT NULL,
  `fecha` datetime NOT NULL,
  `fechaInicio` datetime NOT NULL,
  `fechaFin` datetime NOT NULL,
  `estatus` varchar(1) NOT NULL,
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
INSERT INTO `estado` VALUES (1,'Aguascalientes','Aguascalientes'),(2,'Baja California','Mexicali'),(3,'Baja California Sur','La Paz'),(4,'Campeche','Campeche'),(5,'Chiapas','Tuxtla Gutiérrez'),(6,'Chihuahua','Chihuahua'),(7,'Coahuila','Saltillo'),(8,'Colima','Colima'),(9,'Distrito Federal','Ciudad de México'),(10,'Durango','Durango'),(11,'Guanajuato','Guanajuato'),(12,'Guerrero','Chilpancingo'),(13,'Hidalgo','Pachuca'),(14,'Jalisco','Guadalajara'),(15,'México','Toluca'),(16,'Michoacán','Morelia'),(17,'Morelos','Cuernavaca'),(18,'Nayarit','Tepic'),(19,'Nuevo León','Monterrey'),(20,'Oaxaca','Oaxaca'),(21,'Puebla','Puebla'),(22,'Querétaro','Querétaro'),(23,'Quintana Roo','Chetumal'),(24,'San Luis Potosí','San Luis Potosí'),(25,'Sinaloa','Culiacán'),(26,'Sonora','Hermosillo'),(27,'Tabasco','Villahermosa'),(28,'Tamauilipas','Ciudad Victoria'),(29,'Tlaxcala','Tlaxcala'),(30,'Veracruz','Xalapa'),(31,'Yucatán','Mérida'),(32,'Zacatecas','Zacatecas');
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
  `idEmpresas` int(11) NOT NULL,
  `tipo` varchar(2) NOT NULL,
  `idEmpresa` int(11) NOT NULL,
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
  `rfc` varchar(13) DEFAULT NULL,
  `razonSocial` varchar(200) DEFAULT NULL,
  `rfcAlfa` varchar(4) DEFAULT NULL,
  `rfcNum` varchar(6) DEFAULT NULL,
  `rfcHom` varchar(3) DEFAULT NULL,
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
  `esSucursal` varchar(1) DEFAULT NULL,
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
  `fecha` datetime NOT NULL,
  `orden` int(11) NOT NULL,
  `elementos` int(11) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=2453 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `municipio`
--

LOCK TABLES `municipio` WRITE;
/*!40000 ALTER TABLE `municipio` DISABLE KEYS */;
INSERT INTO `municipio` VALUES (1,1,'Aguascalientes'),(2,1,'Asientos'),(3,1,'Calvillo'),(4,1,'Cosío'),(5,1,'El Llano'),(6,1,'Jesús María'),(7,1,'Pabellón de Arteaga'),(8,1,'Rincón de Romos'),(9,1,'San Francisco de los Romo'),(10,1,'San José de Gracia'),(11,1,'Tepezalá'),(12,2,'Ensenada'),(13,2,'Mexicali'),(14,2,'Playas de Rosarito'),(15,2,'Tecate'),(16,2,'Tijuana'),(17,3,'Comondú'),(18,3,'La Paz'),(19,3,'Loreto'),(20,3,'Los Cabos'),(21,3,'Mulegé'),(22,4,'Calakmul'),(23,4,'Calkiní'),(24,4,'Campeche'),(25,4,'Candelaria'),(26,4,'Carmen'),(27,4,'Champotón'),(28,4,'Escárcega'),(29,4,'Hecelchakán'),(30,4,'Hopelchén'),(31,4,'Palizada'),(32,4,'Tenabo'),(33,5,'Acacoyagua'),(34,5,'Acala'),(35,5,'Acapetahua'),(36,5,'Aldama'),(37,5,'Altamirano'),(38,5,'Amatán'),(39,5,'Amatenango de la Frontera'),(40,5,'Amatenango del Valle'),(41,5,'Ángel Albino Corzo'),(42,5,'Arriaga'),(43,5,'Bejucal de Ocampo'),(44,5,'Bella Vista'),(45,5,'Benemérito de las Américas'),(46,5,'Berriozábal'),(47,5,'Bochil'),(48,5,'Cacahoatán'),(49,5,'Chalchihuitán'),(50,5,'Chamula'),(51,5,'Chanal'),(52,5,'Chapultenango'),(53,5,'Catazajá'),(54,5,'Chenalhó'),(55,5,'Chiapa de Corzo'),(56,5,'Chiapilla'),(57,5,'Chicoasén'),(58,5,'Chicomosuelo'),(59,5,'Cintalpa'),(60,5,'Chilón'),(61,5,'Coapilla'),(62,5,'Comitán de Domínguez'),(63,5,'Copainalá'),(64,5,'El Bosque'),(65,5,'El Porvenir'),(66,5,'Escuintla'),(67,5,'Francisco León'),(68,5,'Frontera Comalapa'),(69,5,'Frontera Hidalgo'),(70,5,'Huehuetán'),(71,5,'Huitiupán'),(72,5,'Huixtán'),(73,5,'Huixtla'),(74,5,'Ixhuatán'),(75,5,'Ixtacomitán'),(76,5,'Ixtapa'),(77,5,'Ixtapangajoya'),(78,5,'Jiquipilas'),(79,5,'Jitotol'),(80,5,'Juárez'),(81,5,'La Concordia'),(82,5,'La Grandeza'),(83,5,'La Independencia'),(84,5,'La Libertad'),(85,5,'La Trinitaria'),(86,5,'Larráinzar'),(87,5,'Las Margaritas'),(88,5,'Las Rosas'),(89,5,'Mapastepec'),(90,5,'Maravilla Tenejapa'),(91,5,'Marqués de Comillas'),(92,5,'Mazapa de Madero'),(93,5,'Mazatán'),(94,5,'Metapa'),(95,5,'Mitontic'),(96,5,'Montecristo de Guerrero'),(97,5,'Motozintla'),(98,5,'Nicolás Ruíz'),(99,5,'Ocosingo'),(100,5,'Ocotepec'),(101,5,'Ocozocoautla de Espinosa'),(102,5,'Ostuacán'),(103,5,'Osumacinta'),(104,5,'Oxchuc'),(105,5,'Palenque'),(106,5,'Pantelhó'),(107,5,'Pantepec'),(108,5,'Pichucalco'),(109,5,'Pijijiapan'),(110,5,'Pueblo Nuevo Solistahuacán'),(111,5,'Rayón'),(112,5,'Reforma'),(113,5,'Sabanilla'),(114,5,'Salto de Agua'),(115,5,'San Andrés Duraznal'),(116,5,'San Cristóbal de las Casas'),(117,5,'San Fernando'),(118,5,'San Juan Cancuc'),(119,5,'San Lucas'),(120,5,'Santiago el Pinar'),(121,5,'Siltepec'),(122,5,'Simojovel'),(123,5,'Sitalá'),(124,5,'Socoltenango'),(125,5,'Solosuchiapa'),(126,5,'Soyaló'),(127,5,'Suchiapa'),(128,5,'Suchiate'),(129,5,'Sunuapa'),(130,5,'Tapachula'),(131,5,'Tapalapa'),(132,5,'Tapilula'),(133,5,'Tecpatán'),(134,5,'Tenejapa'),(135,5,'Teopisca'),(136,5,'Tila'),(137,5,'Tonalá'),(138,5,'Totolapa'),(139,5,'Tumbalá'),(140,5,'Tuxtla Chico'),(141,5,'Tuxtla Gutiérrez'),(142,5,'Tuzantán'),(143,5,'Tzimol'),(144,5,'Unión Juárez'),(145,5,'Venustiano Carranza'),(146,5,'Villa Comaltitlán'),(147,5,'Villa Corzo'),(148,5,'Villaflores'),(149,5,'Yajalón'),(150,5,'Zinacantán'),(151,6,'Ahumada'),(152,6,'Aldama'),(153,6,'Allende'),(154,6,'Aquiles Serdán'),(155,6,'Ascensión'),(156,6,'Bachíniva'),(157,6,'Balleza'),(158,6,'Batopilas'),(159,6,'Bocoyna'),(160,6,'Buenaventura'),(161,6,'Camargo'),(162,6,'Carichí'),(163,6,'Casas Grandes'),(164,6,'Chihuahua'),(165,6,'Chínipas'),(166,6,'Coronado'),(167,6,'Coyame del Sotol'),(168,6,'Cuauhtémoc'),(169,6,'Cusihuiriachi'),(170,6,'Delicias'),(171,6,'Dr. Belisario Domínguez'),(172,6,'El Tule'),(173,6,'Galeana'),(174,6,'Gómez Farías'),(175,6,'Gran Morelos'),(176,6,'Guachochi'),(177,6,'Guadalupe D.B.'),(178,6,'Guadalupe y Calvo'),(179,6,'Guazapares'),(180,6,'Guerrero'),(181,6,'Hidalgo del Parral'),(182,6,'Huejoitán'),(183,6,'Ignacio Zaragoza'),(184,6,'Janos'),(185,6,'Jiménez'),(186,6,'Juárez'),(187,6,'Julimes'),(188,6,'La Cruz'),(189,6,'López'),(190,6,'Madera'),(191,6,'Maguarichi'),(192,6,'Manuel Benavides'),(193,6,'Matachí'),(194,6,'Matamoros'),(195,6,'Meoqui'),(196,6,'Morelos'),(197,6,'Moris'),(198,6,'Namiquipa'),(199,6,'Nonoava'),(200,6,'Nuevo Casas Grandes'),(201,6,'Ocampo'),(202,6,'Ojinaga'),(203,6,'Praxedis G. Guerrero'),(204,6,'Riva Palacio'),(205,6,'Rosales'),(206,6,'Rosario'),(207,6,'San Francisco de Borja'),(208,6,'San Francisco de Conchos'),(209,6,'San Francisco del Oro'),(210,6,'Santa Bárabara'),(211,6,'Santa Isabel'),(212,6,'Satevó'),(213,6,'Saucillo'),(214,6,'Temósachi'),(215,6,'Urique'),(216,6,'Uriachi'),(217,7,'Abasolo'),(218,7,'Acuña'),(219,7,'Allende'),(220,7,'Arteaga'),(221,7,'Candela'),(222,7,'Castaños'),(223,7,'Cuatrociénegas'),(224,7,'Escobedo'),(225,7,'Francisco I. Madero'),(226,7,'Frontera'),(227,7,'General Cepeda'),(228,7,'Guerrero'),(229,7,'Hidalgo'),(230,7,'Jiménez'),(231,7,'Juárez'),(232,7,'Lamadrid'),(233,7,'Matamoros'),(234,7,'Monclova'),(235,7,'Morelos'),(236,7,'Múzquiz'),(237,7,'Nadadores'),(238,7,'Nava'),(239,7,'Ocampo'),(240,7,'Parras'),(241,7,'Piedras Negras'),(242,7,'Progreso'),(243,7,'Ramos Arizpe'),(244,7,'Sabinas'),(245,7,'Sacramento'),(246,7,'Saltillo'),(247,7,'San Buenaventura'),(248,7,'San Juan de Sabinas'),(249,7,'San Pedro'),(250,7,'Sierra Mojada'),(251,7,'Torreón'),(252,7,'Viesca'),(253,7,'Villa Unión'),(254,7,'Zaragoza'),(255,8,'Armería'),(256,8,'Colima'),(257,8,'Comala'),(258,8,'Coquimatlán'),(259,8,'Cuauhtémoc'),(260,8,'Ixtlahuacán'),(261,8,'Manzanillo'),(262,8,'Minatitlán'),(263,8,'Tecomán'),(264,8,'Villa de Álvarez'),(265,9,'Álvaro Obregón'),(266,9,'Azcapotzalco'),(267,9,'Benito Juárez'),(268,9,'Coyoacán'),(269,9,'Cuajimalpa de Morelos'),(270,9,'Cuauhtémoc'),(271,9,'Gustavo A. Madero'),(272,9,'Iztacalco'),(273,9,'Iztapalapa'),(274,9,'Magdalena Contreras'),(275,9,'Miguel Hidalgo'),(276,9,'Milpa Alta'),(277,9,'Tláhuac'),(278,9,'Tlalpan'),(279,9,'Venustiano Carranza'),(280,9,'Xochimilco'),(281,10,'Canatlán'),(282,10,'Canelas'),(283,10,'Coneto de Comonfort'),(284,10,'Cuencamé'),(285,10,'Durango'),(286,10,'El Oro'),(287,10,'Gómez Palacio'),(288,10,'Gral. Simón Bolívar'),(289,10,'Guadalupe Victoria'),(290,10,'Guanaceví'),(291,10,'Hidalgo'),(292,10,'Indé'),(293,10,'Lerdo'),(294,10,'Mapimí'),(295,10,'Mezquital'),(296,10,'Nazas'),(297,10,'Nombre de Dios'),(298,10,'Nuevo Ideal'),(299,10,'Ocampo'),(300,10,'Otáez'),(301,10,'Pánuco de Coronado'),(302,10,'Peñón Blanco'),(303,10,'Poanas'),(304,10,'Pueblo Nuevo'),(305,10,'Rodeo'),(306,10,'San Bernardo'),(307,10,'San Dimas'),(308,10,'San Juan de Guadalupe'),(309,10,'San Juan del Río'),(310,10,'San Luis del Cordero'),(311,10,'San Pedro del Gallo'),(312,10,'Santa Clara'),(313,10,'Santiago Papasquiaro'),(314,10,'Súchil'),(315,10,'Tamazula'),(316,10,'Tepehuanes'),(317,10,'Tlahualilo'),(318,10,'Topia'),(319,10,'Vicente Guerrero'),(320,11,'Abasolo'),(321,11,'Acámbaro'),(322,11,'Apaseo el Alto'),(323,11,'Apaseo el Grande'),(324,11,'Atarjea'),(325,11,'Celaya'),(326,11,'Comonfort'),(327,11,'Coroneo'),(328,11,'Cortazar'),(329,11,'Cuerámaro'),(330,11,'Doctor Mora'),(331,11,'Dolores Hidalgo'),(332,11,'Guanajuato'),(333,11,'Huanímaro'),(334,11,'Irapuato'),(335,11,'Jaral del Progreso'),(336,11,'Jerécuaro'),(337,11,'León'),(338,11,'Manuel Doblado'),(339,11,'Moroleón'),(340,11,'Ocampo'),(341,11,'Pénjamo'),(342,11,'Pueblo Nuevo'),(343,11,'Purísima del Rincón'),(344,11,'Romita'),(345,11,'Salamanca'),(346,11,'Salvatierra'),(347,11,'San Diego de la Unión'),(348,11,'San Felipe'),(349,11,'San Francisco del Rincón'),(350,11,'San José Iturbide'),(351,11,'San Luis de la Paz'),(352,11,'San Miguel de Allende'),(353,11,'Santa Catarina'),(354,11,'Santa Cruz de Juventino'),(355,11,'Santiago Maravatío'),(356,11,'Silao'),(357,11,'Tarandacuao'),(358,11,'Tarimoro'),(359,11,'Tierra Blanca'),(360,11,'Uruangato'),(361,11,'Valle de Santiago'),(362,11,'Victoria'),(363,11,'Villagrán'),(364,11,'Xichú'),(365,11,'Yuriria'),(366,12,'Acapulco de Juárez'),(367,12,'Acatepec'),(368,12,'Ahuacuotzingo'),(369,12,'Ajuchitlán del Progreso'),(370,12,'Alcozauca de Guerrero'),(371,12,'Alpoyeca'),(372,12,'Apaxtla de Castrejón'),(373,12,'Arcelia'),(374,12,'Atenango del Río'),(375,12,'Atlamajalcingo del Monte'),(376,12,'Atlixtac'),(377,12,'Atoyac de Álvarez'),(378,12,'Ayutla de los Libres'),(379,12,'Azoyú'),(380,12,'Benito Juárez'),(381,12,'Buenavista de Cuéllar'),(382,12,'Chilapa de Álvarez'),(383,12,'Chilpancingo de los Bravo'),(384,12,'Coahuayutla de José María Izazaga'),(385,12,'Cochoapa el Grande'),(386,12,'Cocula'),(387,12,'Copala'),(388,12,'Copalillo'),(389,12,'Copanatoyac'),(390,12,'Coyuca de Benítez'),(391,12,'Coyuca de Catalán'),(392,12,'Cuajinicuilapa'),(393,12,'Cualác'),(394,12,'Cuautepec'),(395,12,'Cuetzala del Progreso'),(396,12,'Cutzamala de Pinzón'),(397,12,'Eduardo Neri'),(398,12,'Florencio Villarreal'),(399,12,'General Canuto A. Neri'),(400,12,'General Heliodoro Castillo'),(401,12,'Huamuxtitlán'),(402,12,'Huitzuco de los Figueroa'),(403,12,'Iguala de la Independencia'),(404,12,'Igualapa'),(405,12,'Iliatenco'),(406,12,'Ixcateopan de Cuauhtémoc'),(407,12,'José Joaquín de Herrera'),(408,12,'Juan R. Escudero'),(409,12,'Juchitán'),(410,12,'La Unión de Isidoro Montes de Oca'),(411,12,'Leonardo Bravo'),(412,12,'Malinaltepec'),(413,12,'Marquelia'),(414,12,'Mártir de Cuilapan'),(415,12,'Metlatónoc'),(416,12,'Mochitlán'),(417,12,'Olinalá'),(418,12,'Ometepec'),(419,12,'Pedro Ascencio Alquisiras'),(420,12,'Petatlán'),(421,12,'Pilcaya'),(422,12,'Pungarabato'),(423,12,'Quechultenango'),(424,12,'San Luis Acatlán'),(425,12,'San Marcos'),(426,12,'San Miguel Totolapan'),(427,12,'Taxco de Alarcón'),(428,12,'Tecoanapa'),(429,12,'Técpan de Galeana'),(430,12,'Teloloapan'),(431,12,'Tepecoacuilco de Trujano'),(432,12,'Tetipac'),(433,12,'Tixtla de Guerrero'),(434,12,'Tlacoachistlahuaca'),(435,12,'Tlacoapa'),(436,12,'Tlalchapa'),(437,12,'Tlalixtlaquilla de Maldanado'),(438,12,'Tlapa de Comonfort'),(439,12,'Tlapehuala'),(440,12,'Xalpatláhuac'),(441,12,'Xochihuehuetlán'),(442,12,'Xochistlahuaca'),(443,12,'Zapotitlán Tablas'),(444,12,'Zihuatanejo de Azueta'),(445,12,'Zirándaro de los Chávez'),(446,12,'Zitlala'),(447,13,'Acatlán'),(448,13,'Acaxochitlán'),(449,13,'Actopan'),(450,13,'Agua Blanca de Iturbide'),(451,13,'Ajacuba'),(452,13,'Alfajayucan'),(453,13,'Almoloya'),(454,13,'Apan'),(455,13,'Atitalaquia'),(456,13,'Atlapexco'),(457,13,'Atotonilco de Tula'),(458,13,'Atotonilco el Grande'),(459,13,'Calnali'),(460,13,'Chapantongo'),(461,13,'Chapulhuacán'),(462,13,'Cardonal'),(463,13,'Chilcuautla'),(464,13,'Cuautepec de Hinojosa'),(465,13,'El Arenal'),(466,13,'Eloxochitlán'),(467,13,'Emiliano Zapata'),(468,13,'Epazoyucan'),(469,13,'Francisco I. Madero'),(470,13,'Huasca de Ocampo'),(471,13,'Huautla'),(472,13,'Huazalingo'),(473,13,'Huejutla de Reyes'),(474,13,'Huehuetla  '),(475,13,'Huichapan'),(476,13,'Ixmiquilpan'),(477,13,'Jacala de Ledezma'),(478,13,'Jaltocán'),(479,13,'Juárez Hidalgo'),(480,13,'La Misión'),(481,13,'Lolotla'),(482,13,'Metepec'),(483,13,'Metztitlán'),(484,13,'Mineral de la Reforma'),(485,13,'Mineral del Chico'),(486,13,'Mineral del Monte'),(487,13,'Mixquiahuala de Juárez'),(488,13,'Molango de Escamilla'),(489,13,'Nicolás Flores'),(490,13,'Nopala de Villagrán'),(491,13,'Omitlán de Juárez'),(492,13,'Pachuca de Soto'),(493,13,'Pacula'),(494,13,'Pisaflores'),(495,13,'Progreso de Obregón'),(496,13,'San Agustín Metzquititlán'),(497,13,'San Agustín Tlaxiaca'),(498,13,'San Bartolo Tutotepec'),(499,13,'San Felipe Orizatlán'),(500,13,'San Salvador'),(501,13,'Santiago de Anaya'),(502,13,'Santiago Tulantepec de Lugo Guerrero'),(503,13,'Singuilucan'),(504,13,'Tasquillo'),(505,13,'Tecozautla'),(506,13,'Tenango de Doria'),(507,13,'Tepeapulco'),(508,13,'Tepehuacán de Guerrero'),(509,13,'Tepeji del Río de Ocampo'),(510,13,'Tepetitlán'),(511,13,'Tetepango'),(512,13,'Tezontepec de Aldama'),(513,13,'Tianguistengo'),(514,13,'Tizayuca'),(515,13,'Tlahuelilpan'),(516,13,'Tlahuiltepa'),(517,13,'Tlanalapa'),(518,13,'Tlanchinol'),(519,13,'Tlaxcoapan'),(520,13,'Tolcayuca'),(521,13,'Tula de Allende'),(522,13,'Tulancingo de Bravo'),(523,13,'Villa de Tezontepec'),(524,13,'Xochiatipan'),(525,13,'Xochicoatlán'),(526,13,'Yahualica'),(527,13,'Zacualtipán de Ángeles'),(528,13,'Zapotlán de Juárez'),(529,13,'Zempoala'),(530,13,'Zimapán'),(531,14,'Acatic'),(532,14,'Acatlán de Juárez'),(533,14,'Ahualulco de Mercado'),(534,14,'Amacueca'),(535,14,'Amatitán'),(536,14,'Ameca'),(537,14,'Arandas'),(538,14,'Atemajac de Brizuela'),(539,14,'Atengo'),(540,14,'Atenguillo'),(541,14,'Atotonilco el Alto'),(542,14,'Atoyac'),(543,14,'Autlán de Navarro'),(544,14,'Ayotlán'),(545,14,'Ayutla'),(546,14,'Bolaños'),(547,14,'Cabo Corrientes'),(548,14,'Cañadas de Obregón'),(549,14,'Casimiro Castillo'),(550,14,'Chapala'),(551,14,'Chimaltitán'),(552,14,'Chiquilistlán'),(553,14,'Cihuatlán'),(554,14,'Cocula'),(555,14,'Colotlán'),(556,14,'Concepción de Buenos Aires'),(557,14,'Cuauitlán de García Barragán'),(558,14,'Cuautla'),(559,14,'Cuquío'),(560,14,'Degollado'),(561,14,'Ejutla'),(562,14,'El Arenal'),(563,14,'El Grullo'),(564,14,'El Limón'),(565,14,'El Salto'),(566,14,'Encarnación de Díaz'),(567,14,'Etzatlán'),(568,14,'Gómez Farías'),(569,14,'Guachinango'),(570,14,'Guadalajara'),(571,14,'Hostotipaquillo'),(572,14,'Huejúcar'),(573,14,'Huejuquilla el Alto'),(574,14,'Ixtlahuacán de los Membrillos'),(575,14,'Ixtlahuacán del Río'),(576,14,'Jalostotitlán'),(577,14,'Jamay'),(578,14,'Jesús María'),(579,14,'Jilotlán de los Dolores'),(580,14,'Jocotepec'),(581,14,'Juanacatlán'),(582,14,'Juchitlán'),(583,14,'La Barca'),(584,14,'Lagos de Moreno'),(585,14,'La Manzanilla de la Paz'),(586,14,'La Huerta'),(587,14,'Magdalena'),(588,14,'Mascota'),(589,14,'Mazamitla'),(590,14,'Mexticacán'),(591,14,'Mezquitic'),(592,14,'Mixtlán'),(593,14,'Ojuelos de Jalisco'),(594,14,'Ocotlán '),(595,14,'Pihuamo'),(596,14,'Poncitlán'),(597,14,'Puerto Vallarta'),(598,14,'Quitupan'),(599,14,'San Cristóbal de la Barranca'),(600,14,'San Diego de Alejandría'),(601,14,'San Gabriel'),(602,14,'San Ignacio Cerro Gordo '),(603,14,'San Juan de los Lagos'),(604,14,'San Juanito de Escobedo'),(605,14,'San Julián'),(606,14,'San Marcos'),(607,14,'San Martín de Bolaños'),(608,14,'San Martín Hidalgo'),(609,14,'San Miguel el Alto'),(610,14,'San Sebastián del Oeste'),(611,14,'Santa María de los Ángeles'),(612,14,'Santa María del Oro'),(613,14,'Sayula'),(614,14,'Tala'),(615,14,'Talpa de Allende'),(616,14,'Tamazula de Gordiano'),(617,14,'Tapalpa'),(618,14,'Tecalitlán'),(619,14,'Techaluta de Montenegro'),(620,14,'Tecolotlán'),(621,14,'Tenamaxtlán'),(622,14,'Teocaltiche'),(623,14,'Teocuitatlán de Corona'),(624,14,'Tepatitlán de Morelos'),(625,14,'Tequila'),(626,14,'Teuchitlán'),(627,14,'Tizapán el Alto'),(628,14,'Tlajomulco de Zúñiga'),(629,14,'Tlaquepaque'),(630,14,'Tolimán'),(631,14,'Tomatlán'),(632,14,'Tonalá'),(633,14,'Tonaya'),(634,14,'Tonila'),(635,14,'Totatiche'),(636,14,'Tototlán'),(637,14,'Tuxcacuesco'),(638,14,'Tuxcueca'),(639,14,'Tuxpan'),(640,14,'Unión de San Antonio'),(641,14,'Unión de Tula'),(642,14,'Valle de Guadalupe'),(643,14,'Valle de Juárez'),(644,14,'Villa Corona'),(645,14,'Villa Guerrero'),(646,14,'Villa Hidalgo'),(647,14,'Villa Purificación'),(648,14,'Yahualica de González Gallo'),(649,14,'Zacoalco de Torres'),(650,14,'Zapopan'),(651,14,'Zapotiltic'),(652,14,'Zapotitlán de Vadillo'),(653,14,'Zapotlán del Rey'),(654,14,'Zapotlanejo '),(655,15,'Acambay'),(656,15,'Acolman'),(657,15,'Aculco'),(658,15,'Almoloya de Alquisiras'),(659,15,'Almoloya de Juárez'),(660,15,'Almoloya del Río'),(661,15,'Amanalco'),(662,15,'Amatepec'),(663,15,'Amecameca'),(664,15,'Apaxco'),(665,15,'Atenco'),(666,15,'Atizapán'),(667,15,'Atizapán de Zaragoza'),(668,15,'Atlacomulco'),(669,15,'Atlautla'),(670,15,'Axapusco'),(671,15,'Ayapango'),(672,15,'Calimaya'),(673,15,'Capulhuac'),(674,15,'Chalco'),(675,15,'Chapa de Mota'),(676,15,'Chapultepec'),(677,15,'Chiautla'),(678,15,'Chicoloapan'),(679,15,'Chiconcuac'),(680,15,'Chimalhuacán'),(681,15,'Coacalco de Berriozábal'),(682,15,'Coatepec Harinas'),(683,15,'Cocotitlán'),(684,15,'Coyotepec'),(685,15,'Cuautitlán'),(686,15,'Cuautitlán Izcalli'),(687,15,'Donato Guerra'),(688,15,'Ecatepec de Morelos'),(689,15,'Ecatzingo'),(690,15,'El Oro'),(691,15,'Huehuetoca'),(692,15,'Hueypoxtla'),(693,15,'Huixquilucan'),(694,15,'Isidro Fabela'),(695,15,'Ixtapaluca'),(696,15,'Ixtapan de la Sal'),(697,15,'Ixtapan del Oro'),(698,15,'Ixtlahuaca'),(699,15,'Jaltenco'),(700,15,'Jilotepec'),(701,15,'Jilotzingo'),(702,15,'Jiquipilco'),(703,15,'Jocotitlán'),(704,15,'Joquicingo'),(705,15,'Juchitepec'),(706,15,'La Paz'),(707,15,'Lerma'),(708,15,'Luvianos'),(709,15,'Malinalco'),(710,15,'Melchor Ocampo'),(711,15,'Metepec'),(712,15,'Mexicaltzingo'),(713,15,'Morelos'),(714,15,'Naucalpan de Juárez'),(715,15,'Nextlalpan'),(716,15,'Nezahualcoyotl'),(717,15,'Nicolás Romero'),(718,15,'Nopaltepec'),(719,15,'Ocoyoacac'),(720,15,'Ocuilan'),(721,15,'Otumba'),(722,15,'Otzoloapan'),(723,15,'Otzolotepec'),(724,15,'Ozumba'),(725,15,'Papalotla'),(726,15,'Polotitlán'),(727,15,'Rayón'),(728,15,'San Antonio la Isla'),(729,15,'San Felipe del Progreso'),(730,15,'San José del Rincón'),(731,15,'San Martín de las Pirámides'),(732,15,'San Mateo Atenco'),(733,15,'San Simón de Guerrero'),(734,15,'Santo Tomás'),(735,15,'Soyaniquilpan de Juárez'),(736,15,'Sultepec'),(737,15,'Tecámac'),(738,15,'Tejupilco'),(739,15,'Temamatla'),(740,15,'Temascalapa'),(741,15,'Temascalcingo'),(742,15,'Temascaltepec'),(743,15,'Temoaya'),(744,15,'Tenancingo'),(745,15,'Tenango del Aire'),(746,15,'Tenango del Valle'),(747,15,'Teoloyucán'),(748,15,'Teotihuacán'),(749,15,'Tepetlaoxtoc'),(750,15,'Tepetlixpa'),(751,15,'Tepotzotlán'),(752,15,'Tequixquiac'),(753,15,'Texcaltitlán'),(754,15,'Texcalyacac'),(755,15,'Texcoco'),(756,15,'Tezoyuca'),(757,15,'Tianguistenco'),(758,15,'Timilpan'),(759,15,'Tlalmanalco'),(760,15,'Tlalnepantla de Baz'),(761,15,'Tlatlaya'),(762,15,'Toluca'),(763,15,'Tonanitla'),(764,15,'Tonatico'),(765,15,'Tultepec'),(766,15,'Tultitlán'),(767,15,'Valle de Bravo'),(768,15,'Valle de Chalco Solidaridad'),(769,15,'Villa de Allende'),(770,15,'Villa del Carbón'),(771,15,'Villa Guerrero'),(772,15,'Villa Victoria'),(773,15,'Xalatlaco'),(774,15,'Xonacatlán'),(775,15,'Zacazonapan'),(776,15,'Zacualpan'),(777,15,'Zinacantepec'),(778,15,'Zumpahuacán'),(779,15,'Zumpango'),(780,16,'Acuitzio'),(781,16,'Aguililla'),(782,16,'Álvaro Obregón'),(783,16,'Angamacutiro'),(784,16,'Angangueo'),(785,16,'Apatzingán'),(786,16,'Aporo'),(787,16,'Aquila'),(788,16,'Ario de Rosales'),(789,16,'Arteaga Riseñas'),(790,16,'Briseñas'),(791,16,'Buenavista'),(792,16,'Carácuaro'),(793,16,'Charapan'),(794,16,'Charo'),(795,16,'Chavinda'),(796,16,'Cherán'),(797,16,'Chilchota'),(798,16,'Chuinicuila'),(799,16,'Chucándiro'),(800,16,'Churintzio'),(801,16,'Churumuco'),(802,16,'Coahuayana'),(803,16,'Coalcomán de Vázquez Pallares'),(804,16,'Coeneo'),(805,16,'Cojumatlán de Régules'),(806,16,'Contepec'),(807,16,'Copándaro'),(808,16,'Cotija'),(809,16,'Cuitzeo'),(810,16,'Escuandureo'),(811,16,'Epitacio Huerta'),(812,16,'Erongarícuaro'),(813,16,'Gabriel Zamora'),(814,16,'Hidalgo'),(815,16,'Huandacareo'),(816,16,'Huaniqueo'),(817,16,'Huetamo'),(818,16,'Huiramba'),(819,16,'Indaparapeo'),(820,16,'Irimbo'),(821,16,'Ixtlán'),(822,16,'Jacona'),(823,16,'Jiménez'),(824,16,'Jiquilpan'),(825,16,'José Sixto Verduzco'),(826,16,'Juárez'),(827,16,'Jungapeo'),(828,16,'La Huacana'),(829,16,'La Piedad'),(830,16,'Lagunillas'),(831,16,'Lázaro Cárdenas'),(832,16,'Los Reyes'),(833,16,'Madero'),(834,16,'Maravatío'),(835,16,'Marcos Castellanos'),(836,16,'Morelia'),(837,16,'Morelos'),(838,16,'Múgica'),(839,16,'Nahuatzen'),(840,16,'Nocupétaro'),(841,16,'Nuevo Parangaricutiro'),(842,16,'Nuevo Urecho'),(843,16,'Numarán'),(844,16,'Ocampo'),(845,16,'Pajacuarán'),(846,16,'Panindícuaro'),(847,16,'Paracho'),(848,16,'Parácuaro'),(849,16,'Pátzcuaro'),(850,16,'Penjamillo'),(851,16,'Peribán'),(852,16,'Purépero'),(853,16,'Puruándiro'),(854,16,'Queréndaro'),(855,16,'Quiroga'),(856,16,'Sahuayo'),(857,16,'Salvador Escalante'),(858,16,'San Lucas'),(859,16,'Santa Ana Maya'),(860,16,'Senguio'),(861,16,'Susupuato'),(862,16,'Tancítaro'),(863,16,'Tangamandapio'),(864,16,'Tangancícuaro'),(865,16,'Tanhuato'),(866,16,'Taretan'),(867,16,'Tarímbaro'),(868,16,'Tepalcatepec'),(869,16,'Tingüindín'),(870,16,'Tingambato'),(871,16,'Tiquicheo de Nicolás Romero'),(872,16,'Tlalpujahua'),(873,16,'Tlazazalca'),(874,16,'Tocumbo'),(875,16,'Tumbiscatío'),(876,16,'Turicato'),(877,16,'Tuxpan'),(878,16,'Tuzantla'),(879,16,'Tzintzuntzan'),(880,16,'Tzitzio'),(881,16,'Uruapan'),(882,16,'Venustiano Carranza'),(883,16,'Villamar'),(884,16,'Vista Hermosa'),(885,16,'Yurécuaro'),(886,16,'Zacapu'),(887,16,'Zamora'),(888,16,'Zináparo'),(889,16,'Zinapécuaro'),(890,16,'Ziracuaretiro'),(891,16,'Zitácuaro'),(892,17,'Amacuzac'),(893,17,'Atlatlahucan'),(894,17,'Axochiapan'),(895,17,'Ayala'),(896,17,'Coatlán del Río'),(897,17,'Cuautla'),(898,17,'Cuernavaca'),(899,17,'Emiliano Zapata'),(900,17,'Huitzilac'),(901,17,'Jantetelco'),(902,17,'Jiutepec'),(903,17,'Jojutla'),(904,17,'Jonacatepec'),(905,17,'Mazatepec'),(906,17,'Miacatlán'),(907,17,'Ocuituco'),(908,17,'Puente de Ixtla'),(909,17,'Temixco'),(910,17,'Temoac'),(911,17,'Tepalcingo'),(912,17,'Tepoztlán'),(913,17,'Tetecala'),(914,17,'Tetela del Volcán'),(915,17,'Tlalnepantla'),(916,17,'Tlaltizapán de Zapata'),(917,17,'Tlaquiltenango'),(918,17,'Tlayacapan'),(919,17,'Totolapan'),(920,17,'Xochitepec'),(921,17,'Yautepec de Zaragoza'),(922,17,'Yecapixtla'),(923,17,'Zacatepec de Hidalgo'),(924,17,'Zacualpan de Amilpas'),(925,18,'Acaponeta'),(926,18,'Ahuacatlán'),(927,18,'Amatlán de Cañas'),(928,18,'Bahía de Banderas'),(929,18,'Compostela'),(930,18,'El Nayar'),(931,18,'Huajicori'),(932,18,'Ixtlán del Río'),(933,18,'Jala'),(934,18,'La Yesca'),(935,18,'Rosamorada'),(936,18,'Ruíz'),(937,18,'San Blas'),(938,18,'San Pedro Lagunillas'),(939,18,'Santa María del Oro'),(940,18,'Santiago Ixcuintla'),(941,18,'Tecuala'),(942,18,'Tepic'),(943,18,'Tuxpan'),(944,18,'Xalisco'),(945,19,'Abasolo'),(946,19,'Agualeguas'),(947,19,'Allende'),(948,19,'Anáhuac'),(949,19,'Apodaca'),(950,19,'Aramberri'),(951,19,'Bustamante'),(952,19,'Cadereyta Jiménez'),(953,19,'Cerralvo'),(954,19,'China'),(955,19,'Ciénega de Flores'),(956,19,'Doctor Arroyo'),(957,19,'Doctor Coss'),(958,19,'Doctor González'),(959,19,'El Carmen'),(960,19,'Galeana'),(961,19,'García'),(962,19,'General Bravo'),(963,19,'General Escobedo'),(964,19,'General Terán'),(965,19,'General Treviño'),(966,19,'General Zaragoza'),(967,19,'General Zuazua'),(968,19,'Guadalupe'),(969,19,'Hidalgo'),(970,19,'Higueras'),(971,19,'Hualahuises'),(972,19,'Iturbide'),(973,19,'Juárez'),(974,19,'Lampazos de Naranjo'),(975,19,'Linares'),(976,19,'Los Aldamas'),(977,19,'Los Herreras'),(978,19,'Los Ramones'),(979,19,'Marín'),(980,19,'Melchor Ocampo'),(981,19,'Mier y Noriega'),(982,19,'Mina'),(983,19,'Montemorelos'),(984,19,'Monterrey'),(985,19,'Parás'),(986,19,'Pesquería'),(987,19,'Rayones'),(988,19,'Sabinas Hidalgo'),(989,19,'Salinas Victoria'),(990,19,'San Nicolás de los Garza'),(991,19,'San Pedro Garza García'),(992,19,'Santa Catarina'),(993,19,'Santiago'),(994,19,'Vallecillo'),(995,19,'Villaldama'),(996,20,'Abejones'),(997,20,'Acatlán de Pérez Figueroa'),(998,20,'Ánimas Trujano'),(999,20,'Asunción Cacalotepec'),(1000,20,'Asunción Cuyotepeji'),(1001,20,'Asunción Ixtaltepec'),(1002,20,'Asunción Nochixtlán'),(1003,20,'Asunción Ocotlán'),(1004,20,'Asunción Tlacolulita'),(1005,20,'Ayoquezco de Aldama'),(1006,20,'Ayotzintepec'),(1007,20,'Calihualá'),(1008,20,'Candelaria Loxicha'),(1009,20,'Capulalpam de Méndez'),(1010,20,'Chahuites'),(1011,20,'Chalcatongo de Hidalgo'),(1012,20,'Chiquihuitlán de Benito Juárez'),(1013,20,'Ciénega de Zimatlán'),(1014,20,'Ciudad Ixtepec'),(1015,20,'Coatecas Altas'),(1016,20,'Coicoyán de las Flores'),(1017,20,'Concepción Buenavista'),(1018,20,'Concepción Pápalo'),(1019,20,'Constancia del Rosario'),(1020,20,'Cosolapa'),(1021,20,'Cosoltepec'),(1022,20,'Cuilapam de Guerrero'),(1023,20,'Cuyamecalco Villa de Zaragoza'),(1024,20,'El Barrio de la Soledad'),(1025,20,'El Espinal'),(1026,20,'Eloxochitlán de Flores Magón'),(1027,20,'Fresnillo de Trujano'),(1028,20,'Guadalupe de Ramírez'),(1029,20,'Guadalupe Etla'),(1030,20,'Guelatao de Juárez'),(1031,20,'Guevea de Humboldt'),(1032,20,'Heróica Ciudad de Ejutla de Crespo'),(1033,20,'Heróica Ciudad de Huajuapan de León'),(1034,20,'Heróica Ciudad de Tlaxiaco'),(1035,20,'Huautepec'),(1036,20,'Huautla de Jiménez'),(1037,20,'Ixpantepec Nieves'),(1038,20,'Ixtlán de Juárez'),(1039,20,'Juchitán de Zaragoza'),(1040,20,'La Compañía'),(1041,20,'La Pe'),(1042,20,'La Reforma'),(1043,20,'La Trinidad Vista Hermosa'),(1044,20,'Loma Bonita'),(1045,20,'Magdalena Apasco'),(1046,20,'Magdalena Jaltepec'),(1047,20,'Magdalena Mixtepec'),(1048,20,'Magdalena Ocotlán'),(1049,20,'Magdalena Peñasco'),(1050,20,'Magdalena Teitipac'),(1051,20,'Magdalena Tequisistlán'),(1052,20,'Magdalena Tlacotepec'),(1053,20,'Magdalena Yodocono de Porfirio Díaz'),(1054,20,'Magdalena Zahuatlán'),(1055,20,'Mariscala de Juárez'),(1056,20,'Mártires de Tacubaya'),(1057,20,'Matías Romero Avendaño'),(1058,20,'Mazatlán Villa de Flores'),(1059,20,'Mesones Hidalgo'),(1060,20,'Miahuatlán de Porfirio Díaz'),(1061,20,'Mixistlán de la Reforma'),(1062,20,'Monjas'),(1063,20,'Natividad'),(1064,20,'Nazareno Etla'),(1065,20,'Nejapa de Madero'),(1066,20,'Nuevo Zoquiapam'),(1067,20,'Oaxaca de Juárez'),(1068,20,'Ocotlán de Morelos'),(1069,20,'Pinotepa de Don Luis'),(1070,20,'Pluma Hidalgo'),(1071,20,'Putla Villa de Guerrero'),(1072,20,'Reforma de Pineda'),(1073,20,'Reyes Etla'),(1074,20,'Rojas de Cuauhtémoc'),(1075,20,'Salina Cruz'),(1076,20,'San Agustín Amatengo'),(1077,20,'San Agustín Atenango'),(1078,20,'San Agustín Chayuco'),(1079,20,'San Agustín de las Juntas'),(1080,20,'San Agustín Etla'),(1081,20,'San Agustín Loxicha'),(1082,20,'San Agustín Tlacotepec'),(1083,20,'San Agustín Yatareni'),(1084,20,'San Andrés Cabecera Nueva'),(1085,20,'San Andrés Dinicuiti'),(1086,20,'San Andrés Huaxpaltepec'),(1087,20,'San Andrés Huayapam'),(1088,20,'San Andrés Ixtlahuaca'),(1089,20,'San Andrés Lagunas'),(1090,20,'San Andrés Nuxiño'),(1091,20,'San Andrés Paxtlán'),(1092,20,'San Andrés Sinaxtla'),(1093,20,'San Andrés Solaga'),(1094,20,'San Andrés Teotilalpam'),(1095,20,'San Andrés Tepetlapa'),(1096,20,'San Andrés Yaa'),(1097,20,'San Andrés Zabache'),(1098,20,'San Andrés Zautla'),(1099,20,'San Antonino Castillo Velasco'),(1100,20,'San Antonino el Alto'),(1101,20,'San Antonino Monteverde'),(1102,20,'San Antonio Acutla'),(1103,20,'San Antonio de la Cal'),(1104,20,'San Antonio Huitepec'),(1105,20,'San Antonio Nanahuatipam'),(1106,20,'San Antonio Sinicahua'),(1107,20,'San Antonio Tepetlapa'),(1108,20,'San Baltazar Chichicápam'),(1109,20,'San Baltazar Loxicha'),(1110,20,'San Baltazar Yatzachi el Bajo'),(1111,20,'San Bartolo Coyotepec'),(1112,20,'San Bartolo Soyaltepec'),(1113,20,'San Bartolo Yautepec'),(1114,20,'San Bartolomé Ayautla'),(1115,20,'San Bartolomé Loxicha'),(1116,20,'San Bartolomé Quialana'),(1117,20,'San Bartolomé Yucuañe'),(1118,20,'San Bartolomé Zoogocho'),(1119,20,'San Bernardo Mixtepec'),(1120,20,'San Blas Atempa'),(1121,20,'San Carlos Yautepec'),(1122,20,'San Cristóbal Amatlán'),(1123,20,'San Cristóbal Amoltepec'),(1124,20,'San Cristóbal Lachirioag'),(1125,20,'San Cristóbal Suchixtlahuaca'),(1126,20,'San Dionisio del Mar'),(1127,20,'San Dionisio Ocotepec'),(1128,20,'San Dionisio Ocotlán'),(1129,20,'San Esteban Atatlahuca'),(1130,20,'San Felipe Jalapa de Díaz'),(1131,20,'San Felipe Tejalapam'),(1132,20,'San Felipe Usila'),(1133,20,'San Francisco Cahuacuá'),(1134,20,'San Francisco Cajonos'),(1135,20,'San Francisco Chapulapa'),(1136,20,'San Francisco Chindua'),(1137,20,'San Francisco del Mar'),(1138,20,'San Francisco Huehuetlán'),(1139,20,'San Francisco Ixhuatán'),(1140,20,'San Francisco Jaltepetongo'),(1141,20,'San Francisco Lachigoló'),(1142,20,'San Francisco Logueche'),(1143,20,'San Francisco Nuxaño'),(1144,20,'San Francisco Ozolotepec'),(1145,20,'San Francisco Sola'),(1146,20,'San Francisco Telixtlahuaca'),(1147,20,'San Francisco Teopan'),(1148,20,'San Francisco Tlapancingo'),(1149,20,'San Gabriel Mixtepec'),(1150,20,'San Ildefonso Amatlán'),(1151,20,'San Ildefonso Sola'),(1152,20,'San Ildefonso Villa Alta'),(1153,20,'San Jacinto Amilpas'),(1154,20,'San Jacinto Tlacotepec'),(1155,20,'San Jerónimo Coatlán'),(1156,20,'San Jerónimo Silacayoapilla'),(1157,20,'San Jerónimo Sosola'),(1158,20,'San Jerónimo Taviche'),(1159,20,'San Jerónimo Tecoatl'),(1160,20,'San Jerónimo Tlacochahuaya'),(1161,20,'San Jorge Nuchita'),(1162,20,'San José Ayuquila'),(1163,20,'San José Chiltepec'),(1164,20,'San José del Peñasco'),(1165,20,'San José del Progreso'),(1166,20,'San José Estancia Grande'),(1167,20,'San José Independencia'),(1168,20,'San José Lachiguiri'),(1169,20,'San José Tenango'),(1170,20,'San Juan Achiutla'),(1171,20,'San Juan Atepec'),(1172,20,'San Juan Bautista Atatlahuca'),(1173,20,'San Juan Bautista Coixtlahuaca'),(1174,20,'San Juan Bautista Cuicatlán'),(1175,20,'San Juan Bautista Guelache'),(1176,20,'San Juan Bautista Jayacatlán'),(1177,20,'San Juan Bautista Lo de Soto'),(1178,20,'San Juan Bautista Suchitepec'),(1179,20,'San Juan Bautista Tlacoatzintepec'),(1180,20,'San Juan Bautista Tlachichilco'),(1181,20,'San Juan Bautista Tuxtepec'),(1182,20,'San Juan Bautista Valle Nacional'),(1183,20,'San Juan Cacahuatepec'),(1184,20,'San Juan Chicomezúchil'),(1185,20,'San Juan Chilateca'),(1186,20,'San Juan Cieneguilla'),(1187,20,'San Juan Coatzóspam'),(1188,20,'San Juan Colorado'),(1189,20,'San Juan Comaltepec'),(1190,20,'San Juan Cotzocón'),(1191,20,'San Juan del Estado'),(1192,20,'San Juan de los Cués'),(1193,20,'San Juan del Río'),(1194,20,'San Juan Diuxi'),(1195,20,'San Juan Evangelista Analco'),(1196,20,'San Juan Guelavia'),(1197,20,'San Juan Guichicovi'),(1198,20,'San Juan Ihualtepec'),(1199,20,'San Juan Juquila Mixes'),(1200,20,'San Juan Juquila Vijanos'),(1201,20,'San Juan Lachao'),(1202,20,'San Juan Lachigalla'),(1203,20,'San Juan Lajarcia'),(1204,20,'San Juan Lalana'),(1205,20,'San Juan Mazatlán'),(1206,20,'San Juan Mixtepec, distrito 08'),(1207,20,'San Juan Mixtepec, distrito 26'),(1208,20,'San Juan Ñumi'),(1209,20,'San Juan Ozolotepec'),(1210,20,'San Juan Petlapa'),(1211,20,'San Juan Quiahije'),(1212,20,'San Juan Quiotepec'),(1213,20,'San Juan Sayultepec'),(1214,20,'San Juan Tabaá'),(1215,20,'San Juan Tamazola'),(1216,20,'San Juan Teita'),(1217,20,'San Juan Teitipac'),(1218,20,'San Juan Tepeuxila'),(1219,20,'San Juan Teposcolula'),(1220,20,'San Juan Yaeé'),(1221,20,'San Juan Yatzona'),(1222,20,'San Juan Yucuita'),(1223,20,'San Lorenzo'),(1224,20,'San Lorenzo Albarradas'),(1225,20,'San Lorenzo Cacaotepec'),(1226,20,'San Lorenzo Cuaunecuiltitla'),(1227,20,'San Lorenzo Texmelucan'),(1228,20,'San Lorenzo Victoria'),(1229,20,'San Lucas Camotlán'),(1230,20,'San Lucas Ojitlán'),(1231,20,'San Lucas Quiaviní'),(1232,20,'San Lucas Zoquiápam'),(1233,20,'San Luis Amatlán'),(1234,20,'San Marcial Ozolotepec'),(1235,20,'San Marcos Arteaga'),(1236,20,'San Martín de los Cansecos'),(1237,20,'San Martín Huamelúlpam'),(1238,20,'San Martín Itunyoso'),(1239,20,'San Martín Lachilá'),(1240,20,'San Martín Peras'),(1241,20,'San Martín Tilcajete'),(1242,20,'San Martín Toxpalan'),(1243,20,'San Martín Zacatepec'),(1244,20,'San Mateo Cajonos'),(1245,20,'San Mateo del Mar'),(1246,20,'San Mateo Etlatongo'),(1247,20,'San Mateo Nejápam'),(1248,20,'San Mateo Peñasco'),(1249,20,'San Mateo Piñas'),(1250,20,'San Mateo Río Hondo'),(1251,20,'San Mateo Sindihui'),(1252,20,'San Mateo Tlapiltepec'),(1253,20,'San Mateo Yoloxochitlán'),(1254,20,'San Melchor Betaza'),(1255,20,'San Miguel Achiutla'),(1256,20,'San Miguel Ahuehuetitlán'),(1257,20,'San Miguel Aloápam'),(1258,20,'San Miguel Amatitlán'),(1259,20,'San Miguel Amatlán'),(1260,20,'San Miguel Coatlán'),(1261,20,'San Miguel Chicahua'),(1262,20,'San Miguel Chimalapa'),(1263,20,'San Miguel del Puerto'),(1264,20,'San Miguel del Río'),(1265,20,'San Miguel Ejutla'),(1266,20,'San Miguel el Grande'),(1267,20,'San Miguel Huautla'),(1268,20,'San Miguel Mixtepec'),(1269,20,'San Miguel Panixtlahuaca'),(1270,20,'San Miguel Peras'),(1271,20,'San Miguel Piedras'),(1272,20,'San Miguel Quetzaltepec'),(1273,20,'San Miguel Santa Flor'),(1274,20,'San Miguel Soyaltepec'),(1275,20,'San Miguel Suchixtepec'),(1276,20,'San Miguel Tecomatlán'),(1277,20,'San Miguel Tenango'),(1278,20,'San Miguel Tequixtepec'),(1279,20,'San Miguel Tilquiápam'),(1280,20,'San Miguel Tlacamama'),(1281,20,'San Miguel Tlacotepec'),(1282,20,'San Miguel Tulancingo'),(1283,20,'San Miguel Yotao'),(1284,20,'San Nicolás'),(1285,20,'San Nicolás Hidalgo'),(1286,20,'San Pablo Coatlán'),(1287,20,'San Pablo Cuatro Venados'),(1288,20,'San Pablo Etla'),(1289,20,'San Pablo Huitzo'),(1290,20,'San Pablo Huixtepec'),(1291,20,'San Pablo Macuiltianguis'),(1292,20,'San Pablo Tijaltepec'),(1293,20,'San Pablo Villa de Mitla'),(1294,20,'San Pablo Yaganiza'),(1295,20,'San Pedro Amuzgos'),(1296,20,'San Pedro Apóstol'),(1297,20,'San Pedro Atoyac'),(1298,20,'San Pedro Cajonos'),(1299,20,'San Pedro Comitancillo'),(1300,20,'San Pedro Cocaltepec Cántaros'),(1301,20,'San Pedro el Alto'),(1302,20,'San Pedro Huamelula'),(1303,20,'San Pedro Huilotepec'),(1304,20,'San Pedro Ixcatlán'),(1305,20,'San Pedro Ixtlahuaca'),(1306,20,'San Pedro Jaltepetongo'),(1307,20,'San Pedro Jicayán'),(1308,20,'San Pedro Jocotipac'),(1309,20,'San Pedro Juchatengo'),(1310,20,'San Pedro Mártir'),(1311,20,'San Pedro Mártir Quiechapa'),(1312,20,'San Pedro Mártir Yucuxaco'),(1313,20,'San Pedro Mixtepec, distrito 22'),(1314,20,'San Pedro Mixtepec, distrito 26'),(1315,20,'San Pedro Molinos'),(1316,20,'San Pedro Nopala'),(1317,20,'San Pedro Ocopetatillo'),(1318,20,'San Pedro Ocotepec'),(1319,20,'San Pedro Pochutla'),(1320,20,'San Pedro Quiatoni'),(1321,20,'San Pedro Sochiápam'),(1322,20,'San Pedro Tapanatepec'),(1323,20,'San Pedro Taviche'),(1324,20,'San Pedro Teozacoalco'),(1325,20,'San Pedro Teutila'),(1326,20,'San Pedro Tidaá'),(1327,20,'San Pedro Topiltepec'),(1328,20,'San Pedro Totolápam'),(1329,20,'San Pedro y San Pablo Ayutla'),(1330,20,'San Pedro y San Pablo Teposcolula'),(1331,20,'San Pedro y San Pablo Tequixtepec'),(1332,20,'San Pedro Yaneri'),(1333,20,'San Pedro Yólox'),(1334,20,'San Pedro Yucunama'),(1335,20,'San Raymundo Jalpan'),(1336,20,'San Sebastián Abasolo'),(1337,20,'San Sebastián Coatlán'),(1338,20,'San Sebastián Ixcapa'),(1339,20,'San Sebastián Nicananduta'),(1340,20,'San Sebastián Río Hondo'),(1341,20,'San Sebastián Tecomaxtlahuaca'),(1342,20,'San Sebastián Teitipac'),(1343,20,'San Sebastián Tutla'),(1344,20,'San Simón Almolongas'),(1345,20,'San Simón Zahuatlán  '),(1346,20,'Santa Ana'),(1347,20,'Santa Ana Ateixtlahuaca'),(1348,20,'Santa Ana Cuauhtémoc'),(1349,20,'Santa Ana del Valle'),(1350,20,'Santa Ana Tavela'),(1351,20,'Santa Ana Tlapacoyan'),(1352,20,'Santa Ana Yareni'),(1353,20,'Santa Ana Zegache'),(1354,20,'Santa Catalina Quieri'),(1355,20,'Santa Catarina Cuixtla'),(1356,20,'Santa Catarina Ixtepeji'),(1357,20,'Santa Catarina Juquila'),(1358,20,'Santa Catarina Lachatao'),(1359,20,'Santa Catarina Loxicha'),(1360,20,'Santa Catarina Mechoacán'),(1361,20,'Santa Catarina Minas'),(1362,20,'Santa Catarina Quiané'),(1363,20,'Santa Catarina Quioquitani'),(1364,20,'Santa CatarinaTayata'),(1365,20,'Santa Catarina Ticuá'),(1366,20,'Santa Catarina Yosonotú'),(1367,20,'Santa Catarina Zapoquila'),(1368,20,'Santa Cruz Acatepec'),(1369,20,'Santa Cruz Amilpas'),(1370,20,'Santa Cruz de Bravo'),(1371,20,'Santa Cruz Itundujia'),(1372,20,'Santa Cruz Mixtepec'),(1373,20,'Santa Cruz Nundaco'),(1374,20,'Santa Cruz Papalutla'),(1375,20,'Santa Cruz Tacache de Mina'),(1376,20,'Santa Cruz Tacahua'),(1377,20,'Santa Cruz Tayata'),(1378,20,'Santa Cruz Xitla'),(1379,20,'Santa Cruz Xoxocotlán'),(1380,20,'Santa Cruz Zenzontepec'),(1381,20,'Santa Gertrudis'),(1382,20,'Santa Inés del Monte'),(1383,20,'Santa Inés de Zaragoza'),(1384,20,'Santa Inés Yatzeche'),(1385,20,'Santa Lucía del Camino'),(1386,20,'Santa Lucía Miahuatlán'),(1387,20,'Santa Lucía Monteverde'),(1388,20,'Santa Lucía Ocotlán'),(1389,20,'Santa Magdalena Jicotlán'),(1390,20,'Santa María Alotepec'),(1391,20,'Santa María Apazco'),(1392,20,'Santa María Atzompa'),(1393,20,'Santa María Camotlán'),(1394,20,'Santa María Chachoápam'),(1395,20,'Santa María Chilchotla'),(1396,20,'Santa María Chimalapa'),(1397,20,'Santa María Colotepec'),(1398,20,'Santa María Cortijo'),(1399,20,'Santa María Coyotepec'),(1400,20,'Santa María del Rosario'),(1401,20,'Santa María del Tule'),(1402,20,'Santa María Ecatepec'),(1403,20,'Santa María Guelacé'),(1404,20,'Santa María Guienagati'),(1405,20,'Santa María Huatulco'),(1406,20,'Santa María Huazolotitlán'),(1407,20,'Santa María Ipalapa'),(1408,20,'Santa María Ixcatlán'),(1409,20,'Santa María Jacatepec'),(1410,20,'Santa María Jalapa del Marqués'),(1411,20,'Santa María Jaltianguis'),(1412,20,'Santa María la Asunción'),(1413,20,'Santa María Lachixío'),(1414,20,'Santa María Mixtequilla'),(1415,20,'Santa María Nativitas'),(1416,20,'Santa María Nduayaco'),(1417,20,'Santa María Ozolotepec'),(1418,20,'Santa María Pápalo'),(1419,20,'Santa María Peñoles'),(1420,20,'Santa María Petapa'),(1421,20,'Santa María Quiegolani'),(1422,20,'Santa María Sola'),(1423,20,'Santa María Tataltepec'),(1424,20,'Santa María Tecomavaca'),(1425,20,'Santa María Temaxcalapa'),(1426,20,'Santa María Temaxcaltepec'),(1427,20,'Santa María Teopoxco'),(1428,20,'Santa María Tepantlali'),(1429,20,'Santa María Texcatitlán'),(1430,20,'Santa María Tlahuitoltepec'),(1431,20,'Santa María Tlalixtac'),(1432,20,'Santa María Tonameca'),(1433,20,'Santa María Totolapilla'),(1434,20,'Santa María Xadani'),(1435,20,'Santa María Yalina'),(1436,20,'Santa María Yavesía'),(1437,20,'Santa María Yolotepec'),(1438,20,'Santa María Yosoyua'),(1439,20,'Santa María Yucuhiti'),(1440,20,'Santa María Zacatepec'),(1441,20,'Santa María Zaniza'),(1442,20,'Santa María Zoquitlán'),(1443,20,'Santiago Amoltepec'),(1444,20,'Santiago Apoala'),(1445,20,'Santiago Apóstol'),(1446,20,'Santiago Astata'),(1447,20,'Santiago Atitlán'),(1448,20,'Santiago Ayuquililla'),(1449,20,'Santiago Cacaloxtepec'),(1450,20,'Santiago Camotlán'),(1451,20,'Santiago Chazumba'),(1452,20,'Santiago Choápam'),(1453,20,'Santiago Comaltepec'),(1454,20,'Santiago del Río'),(1455,20,'Santiago Huajolotitlán'),(1456,20,'Santiago Huauclilla'),(1457,20,'Santiago Ihuitlán Plumas'),(1458,20,'Santiago Ixcuintepec'),(1459,20,'Santiago Ixtayutla'),(1460,20,'Santiago Jamiltepec'),(1461,20,'Santiago Jocotepec'),(1462,20,'Santiago Juxtlahuaca'),(1463,20,'Santiago Lachiguiri'),(1464,20,'Santiago Lalopa'),(1465,20,'Santiago Laollaga'),(1466,20,'Santiago Laxopa'),(1467,20,'Santiago Llano Grande'),(1468,20,'Santiago Matatlán'),(1469,20,'Santiago Miltepec'),(1470,20,'Santiago Minas'),(1471,20,'Santiago Nacaltepec'),(1472,20,'Santiago Nejapilla'),(1473,20,'Santiago Niltepec'),(1474,20,'Santiago Nundiche'),(1475,20,'Santiago Nuyoó'),(1476,20,'Santiago Pinotepa Nacional'),(1477,20,'Santiago Suchilquitongo'),(1478,20,'Santiago Tamazola'),(1479,20,'Santiago Tapextla'),(1480,20,'Santiago Tenango'),(1481,20,'Santiago Tepetlapa'),(1482,20,'Santiago Tetepec'),(1483,20,'Santiago Texcalcingo'),(1484,20,'Santiago Textitlán'),(1485,20,'Santiago Tilantongo'),(1486,20,'Santiago Tillo'),(1487,20,'Santiago Tlazoyaltepec'),(1488,20,'Santiago Xanica'),(1489,20,'Santiago Xiacuí'),(1490,20,'Santiago Yaitepec'),(1491,20,'Santiago Yaveo'),(1492,20,'Santiago Yolomécatl'),(1493,20,'Santiago Yosondúa'),(1494,20,'Santiago Yucuyachi'),(1495,20,'Santiago Zacatepec'),(1496,20,'Santiago Zoochila'),(1497,20,'Santo Domingo Albarradas'),(1498,20,'Santo Domingo Armenta'),(1499,20,'Santo Domingo Chihuitán'),(1500,20,'Santo Domingo de Morelos'),(1501,20,'Santo Domingo Ingenio'),(1502,20,'Santo Domingo Ixcatlán'),(1503,20,'Santo Domingo Nuxaá'),(1504,20,'Santo Domingo Ozolotepec'),(1505,20,'Santo Domingo Petapa'),(1506,20,'Santo Domingo Roayaga'),(1507,20,'Santo Domingo Tehuantepec'),(1508,20,'Santo Domingo Teojomulco'),(1509,20,'Santo Domingo Tepuxtepec'),(1510,20,'Santo Domingo Tlatayapam'),(1511,20,'Santo Domingo Tomaltepec'),(1512,20,'Santo Domingo Tonalá'),(1513,20,'Santo Domingo Tonaltepec'),(1514,20,'Santo Domingo Xagacía'),(1515,20,'Santo Domingo Yanhuitlán'),(1516,20,'Santo Domingo Yodohino'),(1517,20,'Santo Domingo Zanatepec'),(1518,20,'Santo Tomás Jalieza'),(1519,20,'Santo Tomás Mazaltepec'),(1520,20,'Santo Tomás Ocotepec'),(1521,20,'Santo Tomás Tamazulapan'),(1522,20,'Santos Reyes Nopala'),(1523,20,'Santos Reyes Pápalo'),(1524,20,'Santos Reyes Tepejillo'),(1525,20,'Santos Reyes Yucuná'),(1526,20,'San Vicente Coatlán'),(1527,20,'San Vicente Lachixío'),(1528,20,'San Vicente Nuñú'),(1529,20,'Silacayoápam'),(1530,20,'Sitio de Xitlapehua'),(1531,20,'Soledad Etla'),(1532,20,'Tamazulápam del Espíritu Santo'),(1533,20,'Tanetze de Zaragoza'),(1534,20,'Taniche'),(1535,20,'Tataltepec de Valdés'),(1536,20,'Teococuilco de Marcos Pérez'),(1537,20,'Teotitlán de Flores Magón'),(1538,20,'Teotitlán del Valle'),(1539,20,'Teotongo'),(1540,20,'Tepelmeme Villa de Morelos'),(1541,20,'Tezoatlán de Segura y Luna'),(1542,20,'Tlacolula de Matamoros'),(1543,20,'Tlacotepec Plumas'),(1544,20,'Tlalixtac de Cabrera'),(1545,20,'Totontepec Villa de Morelos'),(1546,20,'Trinidad Zaáchila'),(1547,20,'Unión Hidalgo'),(1548,20,'Valerio Trujano'),(1549,20,'Villa de Chilapa de Díaz'),(1550,20,'Villa de Etla'),(1551,20,'Villa de Tamazulápam del Progreso'),(1552,20,'Villa de Tututepec de Melchor Ocampo'),(1553,20,'Villa de Zaáchila'),(1554,20,'Villa Díaz Ordaz'),(1555,20,'Villa Hidalgo'),(1556,20,'Villa Sola de Vega'),(1557,20,'Villa Talea de Castro'),(1558,20,'Villa Tejupam de la Unión'),(1559,20,'Yaxe'),(1560,20,'Yogana'),(1561,20,'Yutanduchi de Guerrero'),(1562,20,'Zapotitlán del Río'),(1563,20,'Zapotitlán Lagunas'),(1564,20,'Zapotitlán Palmas'),(1565,20,'Zimatlán de Álvarez'),(1566,21,'Acajete'),(1567,21,'Acateno'),(1568,21,'Acatlán'),(1569,21,'Acatzingo'),(1570,21,'Acteopan'),(1571,21,'Ahuacatlán'),(1572,21,'Ahuatlán'),(1573,21,'Ahuazotepec'),(1574,21,'Ahuehuetitla'),(1575,21,'Ajalpan'),(1576,21,'Albino Zertuche'),(1577,21,'Aljojuca'),(1578,21,'Altepexi'),(1579,21,'Amixtlán'),(1580,21,'Amozoc'),(1581,21,'Aquixtla'),(1582,21,'Atempan'),(1583,21,'Atexcal'),(1584,21,'Atlequizayan'),(1585,21,'Atlixco'),(1586,21,'Atoyatempan'),(1587,21,'Atzala'),(1588,21,'Atzitzihuacán'),(1589,21,'Atzitzintla'),(1590,21,'Axutla'),(1591,21,'Ayotoxco de Guerrero'),(1592,21,'Calpan'),(1593,21,'Caltepec'),(1594,21,'Camocuautla'),(1595,21,'Cañada Morelos'),(1596,21,'Caxhuacan'),(1597,21,'Chalchicomula de Sesma'),(1598,21,'Chapulco'),(1599,21,'Chiautla'),(1600,21,'Chiautzingo'),(1601,21,'Chichiquila'),(1602,21,'Chiconcuautla'),(1603,21,'Chietla'),(1604,21,'Chigmecatitlán'),(1605,21,'Chignahuapan'),(1606,21,'Chignautla'),(1607,21,'Chila'),(1608,21,'Chila de la Sal'),(1609,21,'Chilchotla'),(1610,21,'Chinantla'),(1611,21,'Coatepec'),(1612,21,'Coatzingo'),(1613,21,'Cohetzala'),(1614,21,'Cohuecan'),(1615,21,'Coronango'),(1616,21,'Coxcatlán'),(1617,21,'Coyomeapan'),(1618,21,'Coyotepec'),(1619,21,'Cuapiaxtla de Madero'),(1620,21,'Cuautempan'),(1621,21,'Cuautinchán'),(1622,21,'Cuautlancingo'),(1623,21,'Cuayuca de Andradre'),(1624,21,'Cuetzalan del Progreso'),(1625,21,'Cuyoaco'),(1626,21,'Domingo Arenas'),(1627,21,'Eloxochitlán'),(1628,21,'Epatlán'),(1629,21,'Esperanza'),(1630,21,'Francisco Z. Mena'),(1631,21,'General Felipe Ángeles'),(1632,21,'Guadalupe'),(1633,21,'Guadalupe Victoria'),(1634,21,'Hermenegildo Galeana'),(1635,21,'Honey'),(1636,21,'Huaquechula'),(1637,21,'Huatlatlauca'),(1638,21,'Huauchinango'),(1639,21,'Huehuetla'),(1640,21,'Huehuetlán el Chico'),(1641,21,'Huehuetlán el Grande'),(1642,21,'Huejotzingo'),(1643,21,'Hueyapan'),(1644,21,'Hueytamalco'),(1645,21,'Hueytlalpan'),(1646,21,'Huitzilán de Serdán'),(1647,21,'Huitziltepec'),(1648,21,'Ixcamilpa de Guerrero'),(1649,21,'Ixcaquixtla'),(1650,21,'Ixtacamaxtitlán'),(1651,21,'Ixtepec'),(1652,21,'Izúcar de Matamoros'),(1653,21,'Jalpan'),(1654,21,'Jolalpan'),(1655,21,'Jonotla'),(1656,21,'Jopala'),(1657,21,'Juan C. Bonilla'),(1658,21,'Juan Galindo'),(1659,21,'Juan N. Méndez'),(1660,21,'Lafragua'),(1661,21,'Libres'),(1662,21,'Los Reyes de Juárez'),(1663,21,'Magdalena Tlatlauquitepec'),(1664,21,'Mazapiltepec de Juárez'),(1665,21,'Mixtla'),(1666,21,'Molcaxac'),(1667,21,'Naupan'),(1668,21,'Nauzontla'),(1669,21,'Nealtican'),(1670,21,'Nicolás Bravo'),(1671,21,'Nopalucan'),(1672,21,'Ocotepec'),(1673,21,'Ocoyucan'),(1674,21,'Olintla'),(1675,21,'Oriental'),(1676,21,'Pahuatlán'),(1677,21,'Palmar de Bravo'),(1678,21,'Pantepec'),(1679,21,'Petlalcingo'),(1680,21,'Piaxtla'),(1681,21,'Puebla de Zaragoza'),(1682,21,'Quecholac'),(1683,21,'Quimixtlán'),(1684,21,'Rafael Lara Grajales'),(1685,21,'San Andrés Cholula'),(1686,21,'San Antonio Cañada'),(1687,21,'San Diego La Meza Tochimiltzingo'),(1688,21,'San Felipe Teotlalcingo'),(1689,21,'San Felipe Tepatlán'),(1690,21,'San Gabriel Chilac'),(1691,21,'San Gregorio Atzompa'),(1692,21,'San Jerónimo Tecuanipan'),(1693,21,'San Jerónimo Xayacatlán'),(1694,21,'San José Chiapa'),(1695,21,'San José Miahuatlán'),(1696,21,'San Juan Atenco'),(1697,21,'San Juan Atzompa'),(1698,21,'San Martín Texmelucan'),(1699,21,'San Martín Totoltepec'),(1700,21,'San Matías Tlalancaleca'),(1701,21,'San Miguel Ixtitlán'),(1702,21,'San Miguel Xoxtla'),(1703,21,'San Nicolás Buenos Aires'),(1704,21,'San Nicolás de los Ranchos'),(1705,21,'San Pablo Anicano'),(1706,21,'San Pedro Cholula'),(1707,21,'San Pedro Yeloixtlahuaca'),(1708,21,'San Salvador el Seco'),(1709,21,'San Salvador el Verde'),(1710,21,'San Salvador Huixcolotla'),(1711,21,'San Sebastián Tlacotepec'),(1712,21,'Santa Catarina Tlaltempan'),(1713,21,'San Inés Ahuatempan'),(1714,21,'Santa Isabel Cholula'),(1715,21,'Santiago Miahuatlán '),(1716,21,'Santo Tomás Hueyotlipan'),(1717,21,'Soltepec'),(1718,21,'Tecali de Herrera'),(1719,21,'Tecamachalco'),(1720,21,'Tecomatlán'),(1721,21,'Tehuacán'),(1722,21,'Tehuitzingo'),(1723,21,'Tenampulco'),(1724,21,'Teopantlán'),(1725,21,'Teotlalco'),(1726,21,'Tepanco de López'),(1727,21,'Tepango de Rodríguez'),(1728,21,'Tepatlaxco de Hidalgo'),(1729,21,'Tepeaca'),(1730,21,'Tepemaxalco'),(1731,21,'Tepeojuma'),(1732,21,'Tepetzintla'),(1733,21,'Tepexco'),(1734,21,'Tepexi de Rodríguez'),(1735,21,'Tepeyahualco'),(1736,21,'Tepeyahualco de Cuauhtémoc'),(1737,21,'Tetela de Ocampo'),(1738,21,'Teteles de Ávila Castillo'),(1739,21,'Teziutlán'),(1740,21,'Tianguismanalco'),(1741,21,'Tilapa'),(1742,21,'Tlacotepec de Benito Juárez'),(1743,21,'Tlacuilotepec'),(1744,21,'Tlachichuca'),(1745,21,'Tlahuapan'),(1746,21,'Tlaltenango'),(1747,21,'Tlanepantla'),(1748,21,'Tlaola'),(1749,21,'Tlapacoya'),(1750,21,'Tlapanalá'),(1751,21,'Tlatlauquitepec'),(1752,21,'Tlaxco'),(1753,21,'Tochimilco'),(1754,21,'Tochtepec'),(1755,21,'Totoltepec de Guerrero'),(1756,21,'Tulcingo'),(1757,21,'Tuzamapan de Galeana'),(1758,21,'Tzicatlacoyan'),(1759,21,'Venustiano Carranza'),(1760,21,'Vicente Guerrero'),(1761,21,'Xayacatlán de Bravo'),(1762,21,'Xicotepec'),(1763,21,'Xicotlán'),(1764,21,'Xiutetelco'),(1765,21,'Xochiapulco'),(1766,21,'Xochiltepec'),(1767,21,'Xochitlán de Vicente Suárez'),(1768,21,'Xochitlán Todos Santos'),(1769,21,'Yaonahuac'),(1770,21,'Yehualtepec'),(1771,21,'Zacapala'),(1772,21,'Zacapoaxtla'),(1773,21,'Zacatlán'),(1774,21,'Zapotitlán'),(1775,21,'Zapotitlán de Méndez'),(1776,21,'Zaragoza'),(1777,21,'Zautla'),(1778,21,'Zihuateutla'),(1779,21,'Zinacatepec'),(1780,21,'Zongozotla'),(1781,21,'Zoquiapan'),(1782,21,'Zoquitlán'),(1783,22,'Amealco de Bonfil'),(1784,22,'Arroyo Seco'),(1785,22,'Cadereyta de Montes'),(1786,22,'Colón'),(1787,22,'Corregidora'),(1788,22,'El Marqués'),(1789,22,'Ezequiel Montes'),(1790,22,'Huimilpan'),(1791,22,'Jalpan de Serra'),(1792,22,'Landa de Matamoros'),(1793,22,'Pedro Escobedo'),(1794,22,'Peñamiller'),(1795,22,'Pinal de Amoles'),(1796,22,'Querétaro'),(1797,22,'San Joaquín'),(1798,22,'San Juan del Río'),(1799,22,'Tequisquiapan'),(1800,22,'Tolimán'),(1801,23,'Benito Juárez'),(1802,23,'Cozumel'),(1803,23,'Felipe Carrillo Puerto'),(1804,23,'Isla Mujeres'),(1805,23,'José María Morelos'),(1806,23,'Lázaro Cárdenas'),(1807,23,'Othon P. Blanco'),(1808,23,'Solidaridad'),(1809,23,'Tulum'),(1810,24,'Ahualulco'),(1811,24,'Alaquines'),(1812,24,'Aquismón'),(1813,24,'Armadillo de los Infante'),(1814,24,'Axtla de Terrazas'),(1815,24,'Cárdenas'),(1816,24,'Catorce'),(1817,24,'Cedral'),(1818,24,'Cerritos'),(1819,24,'Cerro de San Pedro'),(1820,24,'Charcas'),(1821,24,'Ciudad del Maíz'),(1822,24,'Ciudad Fernández'),(1823,24,'Ciudad Valles'),(1824,24,'Coxcatlán'),(1825,24,'Ebano'),(1826,24,'El Naranjo'),(1827,24,'Guadalcázar'),(1828,24,'Huehuetlán'),(1829,24,'Lagunillas'),(1830,24,'Matehuala'),(1831,24,'Matlapa'),(1832,24,'Mexquitic de Carmona'),(1833,24,'Moctezuma'),(1834,24,'Rayón'),(1835,24,'Rioverde'),(1836,24,'Salinas'),(1837,24,'San Antonio'),(1838,24,'San Ciro de Acosta'),(1839,24,'San Luis Potosí'),(1840,24,'San Martín Chalchicuautla'),(1841,24,'San Nicolás Tolentino'),(1842,24,'Santa Catarina'),(1843,24,'Santa María del Río'),(1844,24,'Santo Domingo'),(1845,24,'San Vicente Tancuayalab'),(1846,24,'Soledad de Graciano Sánchez'),(1847,24,'Tamasopo'),(1848,24,'Tamazunchale'),(1849,24,'Tampacán'),(1850,24,'Tampamolón Corona'),(1851,24,'Tamuín'),(1852,24,'Tancanhuitz de Santos'),(1853,24,'Tanlajás'),(1854,24,'Tanquián de Escobedo'),(1855,24,'Tierra Nueva'),(1856,24,'Vanegas'),(1857,24,'Venado'),(1858,24,'Villa de Arriaga'),(1859,24,'Villa de Arista'),(1860,24,'Villa de Guadalupe'),(1861,24,'Villa de la Paz'),(1862,24,'Villa de Ramos'),(1863,24,'Villa de Reyes'),(1864,24,'Villa Hidalgo'),(1865,24,'Villa Juárez'),(1866,24,'Xilitla'),(1867,24,'Zaragoza'),(1868,25,'Ahome'),(1869,25,'Angostura'),(1870,25,'Badiraguato'),(1871,25,'Choix'),(1872,25,'Concordia'),(1873,25,'Cosalá'),(1874,25,'Culiacán'),(1875,25,'El Fuerte'),(1876,25,'Elota'),(1877,25,'El Rosario'),(1878,25,'Escuinapa'),(1879,25,'Guasave'),(1880,25,'Mazatlán'),(1881,25,'Mocorito'),(1882,25,'Navolato'),(1883,25,'Salvador Alvarado'),(1884,25,'San Ignacio'),(1885,25,'Sinaloa de Leyva'),(1886,26,'Aconchi'),(1887,26,'Agua Prieta'),(1888,26,'Alamos'),(1889,26,'Altar'),(1890,26,'Arivechi'),(1891,26,'Arizpe'),(1892,26,'Atil'),(1893,26,'Bacadéhuachi'),(1894,26,'Bacanora'),(1895,26,'Bacerac'),(1896,26,'Bacoachi'),(1897,26,'Bácum'),(1898,26,'Banámichi'),(1899,26,'Baviácora'),(1900,26,'Bavíspe'),(1901,26,'Benito Juárez'),(1902,26,'Benjamín Hill'),(1903,26,'Caborca'),(1904,26,'Cajeme'),(1905,26,'Cananea'),(1906,26,'Carbó'),(1907,26,'Cocurpe'),(1908,26,'Cumpas'),(1909,26,'Divisaderos'),(1910,26,'Empalme'),(1911,26,'Etchojoa'),(1912,26,'Fronteras'),(1913,26,'General Plutarco Elías Calles'),(1914,26,'Granados'),(1915,26,'Guaymas'),(1916,26,'Hermosillo'),(1917,26,'Huachinera'),(1918,26,'Huásabas'),(1919,26,'Huatabampo'),(1920,26,'Huépac'),(1921,26,'Imuris'),(1922,26,'La Colorada'),(1923,26,'Magdalena'),(1924,26,'Mazatán'),(1925,26,'Moctezuma'),(1926,26,'Naco'),(1927,26,'Nácori Chico'),(1928,26,'Nacozari de García'),(1929,26,'Navojoa'),(1930,26,'Nogales'),(1931,26,'Onavas'),(1932,26,'Opodepe'),(1933,26,'Oquitoa'),(1934,26,'Pitiquito'),(1935,26,'Puerto Peñasco'),(1936,26,'Quiriego'),(1937,26,'Rayón'),(1938,26,'Rosario'),(1939,26,'Sahuaripa'),(1940,26,'San Felipe de Jesús'),(1941,26,'San Ignacio Río Muerto'),(1942,26,'San Javier'),(1943,26,'San Luis Río Colorado'),(1944,26,'San Miguel de Horcasitas'),(1945,26,'San Pedro de la Cueva'),(1946,26,'Santa Ana'),(1947,26,'Santa Cruz'),(1948,26,'Sáric'),(1949,26,'Soyopa'),(1950,26,'Suaqui Grande'),(1951,26,'Tepache'),(1952,26,'Trincheras'),(1953,26,'Tubutama'),(1954,26,'Ures'),(1955,26,'Villa Hidalgo'),(1956,26,'Villa Pesqueira'),(1957,26,'Yécora'),(1958,27,'Balancán'),(1959,27,'Cárdenas'),(1960,27,'Centla'),(1961,27,'Centro'),(1962,27,'Comalcalco'),(1963,27,'Cunduacán'),(1964,27,'Emiliano Zapata'),(1965,27,'Huimanguillo'),(1966,27,'Jalapa'),(1967,27,'Jalpa de Méndez'),(1968,27,'Jonuta'),(1969,27,'Macuspana'),(1970,27,'Nacajuca'),(1971,27,'Paraíso'),(1972,27,'Tacotalpa'),(1973,27,'Teapa'),(1974,27,'Tenosique'),(1975,28,'Abasolo'),(1976,28,'Aldama'),(1977,28,'Altamira'),(1978,28,'Antiguo Morelos'),(1979,28,'Burgos'),(1980,28,'Bustamante'),(1981,28,'Camargo'),(1982,28,'Casas'),(1983,28,'Ciudad Madero'),(1984,28,'Cruillas'),(1985,28,'Gómez Farías'),(1986,28,'González'),(1987,28,'Güemez'),(1988,28,'Guerrero'),(1989,28,'Gustavo Díaz Ordaz'),(1990,28,'Hidalgo'),(1991,28,'Jaumave'),(1992,28,'Jiménez'),(1993,28,'Llera'),(1994,28,'Mainero'),(1995,28,'Mante'),(1996,28,'Matamoros'),(1997,28,'Méndez'),(1998,28,'Mier'),(1999,28,'Miguel Alemán'),(2000,28,'Miquihuana'),(2001,28,'Nuevo Laredo'),(2002,28,'Nuevo Morelos'),(2003,28,'Ocampo'),(2004,28,'Padilla'),(2005,28,'Palmillas'),(2006,28,'Reynosa'),(2007,28,'Río Bravo'),(2008,28,'San Carlos'),(2009,28,'San Fernando'),(2010,28,'San Nicolás'),(2011,28,'Soto La Marina'),(2012,28,'Tampico'),(2013,28,'Tula'),(2014,28,'Valle Hermoso'),(2015,28,'Victoria'),(2016,28,'Villagrán'),(2017,28,'Xicotencatl'),(2018,29,'Acuamanala de Miguel Hidalgo'),(2019,29,'Altzayanca'),(2020,29,'Amaxac de Guerrero'),(2021,29,'Apetatitlán de Antonio Carvajal'),(2022,29,'Atlangatepec'),(2023,29,'Apizaco'),(2024,29,'Benito Juárez'),(2025,29,'Calpulalpan'),(2026,29,'Chiautempan'),(2027,29,'Contla de Juan Cuamatzi'),(2028,29,'Cuapiaxtla'),(2029,29,'Cuaxomulco'),(2030,29,'El Carmen Tequexquitla'),(2031,29,'Emiliano Zapata'),(2032,29,'Españita'),(2033,29,'Huamantla'),(2034,29,'Hueyotlipan'),(2035,29,'Ixtacuixtla de Mariano Matamoros'),(2036,29,'Ixtenco'),(2037,29,'La Magdalena Tlaltelulco'),(2038,29,'Lázaro Cárdenas'),(2039,29,'Mazatecochco de José María Morelos'),(2040,29,'Muñoz de Domingo Arenas'),(2041,29,'Nanacamilpa de Mariano Arista'),(2042,29,'Nativitas'),(2043,29,'Panotla'),(2044,29,'Papalotla de Xicohténcatl'),(2045,29,'Sanctorum de Lázaro Cárdenas'),(2046,29,'San Damián Texoloc'),(2047,29,'San Francisco Tetlanohcan'),(2048,29,'San Jerónimo Zacualpan'),(2049,29,'San José Teacalco'),(2050,29,'San Juan Huactzinco'),(2051,29,'San Lorenzo Axocomanitla'),(2052,29,'San Lucas Tecopilco'),(2053,29,'San Pablo del Monte'),(2054,29,'Santa Ana Nopalucan'),(2055,29,'Santa Apolonia Teacalco'),(2056,29,'Santa Catarina Ayometla'),(2057,29,'Santa Cruz Quilehtla'),(2058,29,'Santa Cruz Tlaxcala'),(2059,29,'Santa Isabel Xiloxoxtla'),(2060,29,'Tenancingo'),(2061,29,'Teolocholco'),(2062,29,'Tepetitla de Lardizábal'),(2063,29,'Tepeyanco'),(2064,29,'Terrenate'),(2065,29,'Tetla de la Solidaridad'),(2066,29,'Tetlatlahuca'),(2067,29,'Tlaxcala'),(2068,29,'Tlaxco'),(2069,29,'Tocatlán'),(2070,29,'Totolac'),(2071,29,'Tzompantepec'),(2072,29,'Xaloztoc'),(2073,29,'Xaltocan'),(2074,29,'Xicohtzinco'),(2075,29,'Yauhquemecan'),(2076,29,'Zacatelco'),(2077,29,'Zitlaltepec de Trinidad Sánchez Santos'),(2078,30,'Acajete'),(2079,30,'Acatlán'),(2080,30,'Acayucan'),(2081,30,'Actopan'),(2082,30,'Acula'),(2083,30,'Acultzingo'),(2084,30,'Agua Dulce'),(2085,30,'Álamo Temapache'),(2086,30,'Alpatláhuac'),(2087,30,'Alto Lucero de Gutiérrez Barrios'),(2088,30,'Altotonga'),(2089,30,'Alvarado'),(2090,30,'Amatitlán'),(2091,30,'Amatlán de los Reyes'),(2092,30,'Ángel R. Cabada'),(2093,30,'Apazapan'),(2094,30,'Aquila'),(2095,30,'Astacinga'),(2096,30,'Atlahuilco'),(2097,30,'Atoyac'),(2098,30,'Atzacan'),(2099,30,'Atzalan'),(2100,30,'Ayahualulco'),(2101,30,'Banderilla'),(2102,30,'Benito Juárez'),(2103,30,'Boca del Río'),(2104,30,'Calcahualco'),(2105,30,'Camarón de Tejeda'),(2106,30,'Camerino Z. Mendoza'),(2107,30,'Carlos A. Carrillo'),(2108,30,'Carrillo Puerto'),(2109,30,'Castillo de Teayo'),(2110,30,'Catemaco'),(2111,30,'Cazones de Herrera'),(2112,30,'Cerro Azul'),(2113,30,'Chacaltianguis'),(2114,30,'Chalma'),(2115,30,'Chiconamel'),(2116,30,'Chiconquiaco'),(2117,30,'Chicontepec'),(2118,30,'Chinameca'),(2119,30,'Chinampa de Gorostiza'),(2120,30,'Chocamán'),(2121,30,'Chontla'),(2122,30,'Chumatlán'),(2123,30,'Citlaltépetl'),(2124,30,'Coacoatzintla'),(2125,30,'Coahuitlán'),(2126,30,'Coatepec'),(2127,30,'Coatzacoalcos'),(2128,30,'Coatzintla'),(2129,30,'Coetzala'),(2130,30,'Colipa'),(2131,30,'Comapa'),(2132,30,'Córdoba'),(2133,30,'Cosamaloapan de Carpio'),(2134,30,'Consautlán de Carvajal'),(2135,30,'Coscomatepec'),(2136,30,'Cosoleacaque'),(2137,30,'Cotaxtla'),(2138,30,'Coxquihui'),(2139,30,'Coyutla'),(2140,30,'Cuichapa'),(2141,30,'Cuitláhuac'),(2142,30,'El Higo'),(2143,30,'Emiliano Zapata'),(2144,30,'Espinal'),(2145,30,'Filomeno Mata'),(2146,30,'Fortín'),(2147,30,'Gutiérrez Zamora'),(2148,30,'Hidalgotitlán'),(2149,30,'Huayacocotla'),(2150,30,'Hueyapan de Ocampo'),(2151,30,'Huiloapan de Cuauhtémoc'),(2152,30,'Ignacio de la Llave'),(2153,30,'Ilamatlán'),(2154,30,'Isla'),(2155,30,'Ixcatepec'),(2156,30,'Ixhuacán de los Reyes'),(2157,30,'Ixhuatlancillo'),(2158,30,'Ixhuatlán del Café'),(2159,30,'Ixhuatlán de Madero'),(2160,30,'Ixhuatlán del Sureste'),(2161,30,'Ixmatlahuacan'),(2162,30,'Ixtaczoquitlán'),(2163,30,'Jalacingo'),(2164,30,'Jalcomulco'),(2165,30,'Jáltipan'),(2166,30,'Jamapa'),(2167,30,'Jesús Carranza'),(2168,30,'Jilotepec'),(2169,30,'José Azueta'),(2170,30,'Juan Rodríguez Clara'),(2171,30,'Juchique de Ferrer'),(2172,30,'La Antigua'),(2173,30,'Landero y Coss'),(2174,30,'La Perla'),(2175,30,'Las Choapas'),(2176,30,'Las Minas'),(2177,30,'Las Vigas de Ramírez'),(2178,30,'Lerdo de Tejada'),(2179,30,'Los Reyes'),(2180,30,'Magdalena'),(2181,30,'Maltrata'),(2182,30,'Manlio Fabio Altamirano'),(2183,30,'Mariano Escobedo'),(2184,30,'Martínez de la Torre'),(2185,30,'Mecatlán'),(2186,30,'Mecayapan'),(2187,30,'Medellín'),(2188,30,'Miahuatlán'),(2189,30,'Minatitlán'),(2190,30,'Misantla'),(2191,30,'Mixtla de Altamirano'),(2192,30,'Moloacán'),(2193,30,'Nanchital de Lázaro Cárdenas del Río'),(2194,30,'Naolinco'),(2195,30,'Naranjal'),(2196,30,'Naranjos Amatlán'),(2197,30,'Nautla'),(2198,30,'Nogales'),(2199,30,'Oluta'),(2200,30,'Omealca'),(2201,30,'Orizaba'),(2202,30,'Otatitlán'),(2203,30,'Oteapan'),(2204,30,'Ozuluama de Mascañeras'),(2205,30,'Pajapan'),(2206,30,'Pánuco'),(2207,30,'Papantla'),(2208,30,'Paso del Macho'),(2209,30,'Paso de Ovejas'),(2210,30,'Perote'),(2211,30,'Platón Sánchez'),(2212,30,'Playa Vicente'),(2213,30,'Poza Rica de Hidalgo'),(2214,30,'Pueblo Viejo'),(2215,30,'Puente Nacional'),(2216,30,'Rafael Delgado'),(2217,30,'Rafael Lucio'),(2218,30,'Río Blanco'),(2219,30,'Saltabarranca'),(2220,30,'San Andrés Tenejapan'),(2221,30,'San Andrés Tuxtla'),(2222,30,'San Juan Evangelista'),(2223,30,'San Rafael'),(2224,30,'Santiago Sochiapan'),(2225,30,'Santiago Tuxtla'),(2226,30,'Sayula de Alemán'),(2227,30,'Soconusco'),(2228,30,'Sochiapa'),(2229,30,'Soledad Atzompa'),(2230,30,'Soledad de Doblado'),(2231,30,'Soteapan'),(2232,30,'Tamalín'),(2233,30,'Tamiahua'),(2234,30,'Tampico Alto'),(2235,30,'Tancoco'),(2236,30,'Tantima'),(2237,30,'Tantoyuca'),(2238,30,'Tatatila'),(2239,30,'Tatahuicapan de Juárez'),(2240,30,'Tecolutla'),(2241,30,'Tehuipango'),(2242,30,'Tempoal'),(2243,30,'Tenampa'),(2244,30,'Tenochtitlán'),(2245,30,'Teocelo'),(2246,30,'Tepatlaxco'),(2247,30,'Tepetlán'),(2248,30,'Tepetzintla'),(2249,30,'Tequila'),(2250,30,'Texcatepec'),(2251,30,'Texhuacán'),(2252,30,'Texistepec'),(2253,30,'Tezonapa'),(2254,30,'Tihuatlán'),(2255,30,'Tierra Blanca'),(2256,30,'Tlacojalpan'),(2257,30,'Tlacolulan'),(2258,30,'Tlacotalpan'),(2259,30,'Tlacotepec de Mejía'),(2260,30,'Tlachichilco'),(2261,30,'Tlalixcoyan'),(2262,30,'Tlalnelhuayocan'),(2263,30,'Tlaltetela'),(2264,30,'Tlapacoyan'),(2265,30,'Tlaquilpa'),(2266,30,'Tlilapan'),(2267,30,'Tomatlán'),(2268,30,'Tonayán'),(2269,30,'Totutla'),(2270,30,'Tres Valles'),(2271,30,'Tuxpan'),(2272,30,'Tuxtilla'),(2273,30,'Úrsulo Galván'),(2274,30,'Uxpanapa'),(2275,30,'Vega de Alatorre'),(2276,30,'Veracruz'),(2277,30,'Villa Aldama'),(2278,30,'Xalapa'),(2279,30,'Xico'),(2280,30,'Xoxocotla'),(2281,30,'Yanga'),(2282,30,'Yecuatla'),(2283,30,'Zacualpan'),(2284,30,'Zaragoza'),(2285,30,'Zentla'),(2286,30,'Zongolica'),(2287,30,'Zontecomatlán'),(2288,30,'Zozocolco de Hidalgo'),(2289,31,'Abalá'),(2290,31,'Acanceh'),(2291,31,'Akil'),(2292,31,'Baca'),(2293,31,'Bokobá'),(2294,31,'Buctzotz'),(2295,31,'Cacalchén'),(2296,31,'Calotmul'),(2297,31,'Cansahcab'),(2298,31,'Cantamayec'),(2299,31,'Calestún'),(2300,31,'Cenotillo'),(2301,31,'Conkal'),(2302,31,'Cuncunul'),(2303,31,'Cuzamá'),(2304,31,'Chacsinkín'),(2305,31,'Chankom'),(2306,31,'Chapab'),(2307,31,'Chemax'),(2308,31,'Chicxulub Pueblo'),(2309,31,'Chichimilá'),(2310,31,'Chikindzonot'),(2311,31,'Chocholá'),(2312,31,'Chumayel'),(2313,31,'Dzán'),(2314,31,'Dzemul'),(2315,31,'Dzidzantún'),(2316,31,'Dzilam de Bravo'),(2317,31,'Dzilam González'),(2318,31,'Dzitás'),(2319,31,'Dzoncauich'),(2320,31,'Espita'),(2321,31,'Halachó'),(2322,31,'Hocabá'),(2323,31,'Hoctún'),(2324,31,'Homún'),(2325,31,'Huhí'),(2326,31,'Hunucmá'),(2327,31,'Ixtil'),(2328,31,'Izamal'),(2329,31,'Kanasín'),(2330,31,'Kantunil'),(2331,31,'Kaua'),(2332,31,'Kinchil'),(2333,31,'Kopomá'),(2334,31,'Mama'),(2335,31,'Maní'),(2336,31,'Maxcanú'),(2337,31,'Mayapán'),(2338,31,'Mérida'),(2339,31,'Mocochá'),(2340,31,'Motul'),(2341,31,'Muna'),(2342,31,'Muxupip'),(2343,31,'Opichén'),(2344,31,'Oxkutzcab'),(2345,31,'Panabá'),(2346,31,'Peto'),(2347,31,'Progreso'),(2348,31,'Quintana Roo'),(2349,31,'Río Lagartos'),(2350,31,'Sacalum'),(2351,31,'Samahil'),(2352,31,'Sanahcat'),(2353,31,'San Felipe'),(2354,31,'Santa Elena'),(2355,31,'Seyé'),(2356,31,'Sinanché'),(2357,31,'Sotuta'),(2358,31,'Sucilá'),(2359,31,'Sudzal'),(2360,31,'Suma de Hidalgo'),(2361,31,'Tahdziú'),(2362,31,'Tahmek'),(2363,31,'Teabo'),(2364,31,'Tecoh'),(2365,31,'Tekal de Venegas'),(2366,31,'Tekantó'),(2367,31,'Tekax'),(2368,31,'Tekit'),(2369,31,'Tekom'),(2370,31,'Telchac Pueblo'),(2371,31,'Telchac Puerto'),(2372,31,'Temax'),(2373,31,'Temozón'),(2374,31,'Tepakán'),(2375,31,'Tetiz'),(2376,31,'Teya'),(2377,31,'Ticul'),(2378,31,'Timucuy'),(2379,31,'Tinúm'),(2380,31,'Tixcacalcupul'),(2381,31,'Tixkokob'),(2382,31,'Tixméhuac'),(2383,31,'Tixpéhual'),(2384,31,'Tizimín'),(2385,31,'Tunkás'),(2386,31,'Tzucacab'),(2387,31,'Uayma'),(2388,31,'Ucú'),(2389,31,'Umán'),(2390,31,'Valladolid'),(2391,31,'Xocchel'),(2392,31,'Yaxcabá'),(2393,31,'Yaxkukul'),(2394,31,'Yobaín'),(2395,32,'Apozol'),(2396,32,'Apulco'),(2397,32,'Atolinga'),(2398,32,'Benito Juárez'),(2399,32,'Calera'),(2400,32,'Cañitas de Felipe Pescador'),(2401,32,'Concepción del Oro'),(2402,32,'Cuauhtémoc'),(2403,32,'Chalchihuites'),(2404,32,'Fresnillo'),(2405,32,'Trinidad García de la Cadena'),(2406,32,'Genaro Codina'),(2407,32,'General Enrique Estrada'),(2408,32,'General Francisco R. Murguía'),(2409,32,'El Plateado de Joaquín Amaro'),(2410,32,'El Salvador'),(2411,32,'General Pánfilo Natera'),(2412,32,'Guadalupe'),(2413,32,'Huanusco'),(2414,32,'Jalpa'),(2415,32,'Jerez'),(2416,32,'Jiménez del Teul'),(2417,32,'Juan Aldama'),(2418,32,'Juchipila'),(2419,32,'Loreto'),(2420,32,'Luis Moya'),(2421,32,'Mazapil'),(2422,32,'Melchor Ocampo'),(2423,32,'Mezquital del Oro'),(2424,32,'Miguel Auza'),(2425,32,'Momax'),(2426,32,'Monte Escobedo'),(2427,32,'Morelos'),(2428,32,'Moyahua de Estrada'),(2429,32,'Nochistlán de Mejía'),(2430,32,'Noria de Ángeles'),(2431,32,'Ojocaliente'),(2432,32,'Pánuco'),(2433,32,'Pinos'),(2434,32,'Río Grande'),(2435,32,'Sain Alto'),(2436,32,'Santa María de la Paz'),(2437,32,'Sombrerete'),(2438,32,'Susticacán'),(2439,32,'Tabasco'),(2440,32,'Tepechitlán'),(2441,32,'Tepetongo'),(2442,32,'Teul de González Ortega'),(2443,32,'Tlaltenango de Sánchez Román'),(2444,32,'Trancoso'),(2445,32,'Valparaíso'),(2446,32,'Vetagrande'),(2447,32,'Villa de Cos'),(2448,32,'Villa García'),(2449,32,'Villa González Ortega'),(2450,32,'Villa Hidalgo'),(2451,32,'Villanueva'),(2452,32,'Zacatecas');
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
-- Table structure for table `opcionesgrupo`
--

DROP TABLE IF EXISTS `opcionesgrupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opcionesgrupo` (
  `idOpcionesGrupo` int(11) NOT NULL AUTO_INCREMENT,
  `idGrupo` int(11) NOT NULL,
  `opciones` text NOT NULL,
  PRIMARY KEY (`idOpcionesGrupo`,`idGrupo`),
  KEY `fk_OpcionesGrupo_Grupo1_idx` (`idGrupo`),
  CONSTRAINT `fk_OpcionesGrupo_Grupo1` FOREIGN KEY (`idGrupo`) REFERENCES `grupo` (`idGrupo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opcionesgrupo`
--

LOCK TABLES `opcionesgrupo` WRITE;
/*!40000 ALTER TABLE `opcionesgrupo` DISABLE KEYS */;
/*!40000 ALTER TABLE `opcionesgrupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opcionespregunta`
--

DROP TABLE IF EXISTS `opcionespregunta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opcionespregunta` (
  `idOpcionesPregunta` int(11) NOT NULL AUTO_INCREMENT,
  `idPregunta` int(11) NOT NULL,
  PRIMARY KEY (`idOpcionesPregunta`),
  KEY `fk_OpcionesPregunta_Pregunta1_idx` (`idPregunta`),
  CONSTRAINT `fk_OpcionesPregunta_Pregunta1` FOREIGN KEY (`idPregunta`) REFERENCES `pregunta` (`idPregunta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opcionespregunta`
--

LOCK TABLES `opcionespregunta` WRITE;
/*!40000 ALTER TABLE `opcionespregunta` DISABLE KEYS */;
/*!40000 ALTER TABLE `opcionespregunta` ENABLE KEYS */;
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
-- Table structure for table `pregunta`
--

DROP TABLE IF EXISTS `pregunta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pregunta` (
  `idPregunta` int(11) NOT NULL AUTO_INCREMENT,
  `pregunta` text NOT NULL,
  `origen` varchar(1) NOT NULL,
  `idOrigen` varchar(20) NOT NULL,
  `tipo` varchar(2) NOT NULL,
  `orden` int(11) NOT NULL,
  PRIMARY KEY (`idPregunta`)
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
  `claveProducto` varchar(60) NOT NULL,
  `codigoBarras` varchar(60) NOT NULL,
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
-- Table structure for table `realizadas`
--

DROP TABLE IF EXISTS `realizadas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `realizadas` (
  `idRealizadas` int(11) NOT NULL AUTO_INCREMENT,
  `idRegistro` int(11) NOT NULL,
  `idEncuesta` int(11) NOT NULL,
  PRIMARY KEY (`idRealizadas`),
  KEY `fk_Realizadas_Registro1_idx` (`idRegistro`),
  KEY `fk_Realizadas_Encuesta1_idx` (`idEncuesta`),
  CONSTRAINT `fk_Realizadas_Encuesta1` FOREIGN KEY (`idEncuesta`) REFERENCES `encuesta` (`idEncuesta`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Realizadas_Registro1` FOREIGN KEY (`idRegistro`) REFERENCES `registro` (`idRegistro`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `realizadas`
--

LOCK TABLES `realizadas` WRITE;
/*!40000 ALTER TABLE `realizadas` DISABLE KEYS */;
/*!40000 ALTER TABLE `realizadas` ENABLE KEYS */;
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
  `tipo` varchar(1) NOT NULL,
  `fecha` datetime NOT NULL,
  `nombres` varchar(200) NOT NULL,
  `apellidos` varchar(200) NOT NULL,
  PRIMARY KEY (`idRegistro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro`
--

LOCK TABLES `registro` WRITE;
/*!40000 ALTER TABLE `registro` DISABLE KEYS */;
/*!40000 ALTER TABLE `registro` ENABLE KEYS */;
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
  `respuesta` text NOT NULL,
  PRIMARY KEY (`idRespuesta`),
  KEY `fk_Respuesta_Pregunta1_idx` (`idPregunta`),
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
-- Table structure for table `seccion`
--

DROP TABLE IF EXISTS `seccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seccion` (
  `idSeccion` int(11) NOT NULL AUTO_INCREMENT,
  `idEncuesta` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `fecha` datetime NOT NULL,
  `orden` int(11) NOT NULL,
  `elementos` int(11) NOT NULL,
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
-- Table structure for table `vendedor`
--

DROP TABLE IF EXISTS `vendedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vendedor` (
  `idVendedor` int(11) NOT NULL AUTO_INCREMENT,
  `claveVendedor` varchar(20) DEFAULT NULL,
  `nombre` varchar(60) DEFAULT NULL,
  `idTelefono` int(11) NOT NULL,
  `idDomicilio` int(11) NOT NULL,
  `estatus` varchar(1) DEFAULT NULL,
  `fechaAlta` datetime DEFAULT NULL,
  `comision` decimal(10,0) DEFAULT NULL,
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

-- Dump completed on 2016-01-12 20:43:33
