CREATE DATABASE  IF NOT EXISTS `general` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `general`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: localhost    Database: general
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
-- Table structure for table `cicloe`
--

DROP TABLE IF EXISTS `cicloe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cicloe` (
  `idCiclo` int(11) NOT NULL AUTO_INCREMENT,
  `ciclo` varchar(5) NOT NULL,
  `actual` varchar(1) NOT NULL,
  `inicio` datetime NOT NULL,
  `termino` datetime NOT NULL,
  `descripcion` text,
  `hash` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idCiclo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cicloe`
--

LOCK TABLES `cicloe` WRITE;
/*!40000 ALTER TABLE `cicloe` DISABLE KEYS */;
INSERT INTO `cicloe` VALUES (1,'2017A','S','2016-01-25 12:00:00','2016-07-28 12:00:00','Grado prueba','fdc93a2d1969482db67c774b93fa1ac7');
/*!40000 ALTER TABLE `cicloe` ENABLE KEYS */;
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
  `fecha` datetime DEFAULT NULL,
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
  `idFiscales` int(11) NOT NULL AUTO_INCREMENT,
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
  `idFiscalesTelefonos` int(11) NOT NULL AUTO_INCREMENT,
  `idFiscales` int(11) NOT NULL,
  `idTelefono` int(11) NOT NULL,
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
-- Table structure for table `gradoe`
--

DROP TABLE IF EXISTS `gradoe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gradoe` (
  `idGrado` int(11) NOT NULL AUTO_INCREMENT,
  `idNivel` int(11) NOT NULL,
  `grado` varchar(60) NOT NULL,
  `abreviatura` varchar(45) NOT NULL,
  `descripcion` varchar(150) DEFAULT NULL,
  `hash` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idGrado`),
  KEY `fk_GradoE_NivelE1_idx` (`idNivel`),
  CONSTRAINT `fk_GradoE_NivelE1` FOREIGN KEY (`idNivel`) REFERENCES `nivele` (`idNivel`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gradoe`
--

LOCK TABLES `gradoe` WRITE;
/*!40000 ALTER TABLE `gradoe` DISABLE KEYS */;
INSERT INTO `gradoe` VALUES (1,1,'Primer Grado Escolar','1','Se cursa de los 4 a los 5 años de edad','2c3e61dcef4f5e36538140a05fb38c0d'),(2,1,'Segundo Grado Escolar','2','Se cursa de los 5 a los 6 años de edad','e55e2d7ec32fb4906b502da2c328f34b'),(3,2,'Primer Grado Escolar','1','Se cursa de los 6 a los 7 años de edad.','9a3cca275768ac8f24ac85cadb15092b'),(4,2,'Segundo Grado Escolar','2','Se cursa de los 7 a los 8 años de edad.','b9a9523a5944b096367f301a2e6a8e21'),(5,2,'Tercer Grado Escolar','3','Se cursa de los 8 a los 9 años de edad.','e124769ea6789a5a168d3146311df56f'),(6,2,'Cuarto Grado Escolar','4','Se cursa de los 9 a los 10 años de edad.','b3732dbc87e25b2cdec62081866360f6'),(7,2,'Quinto Grado Escolar','5','Se cursa de los 10 a los 11 años de edad.','f659c809a6e561c2170f81dd39f85ba8'),(8,2,'Sexto Grado Escolar','6','Se cursa de los 11 a los 12 años de edad.','476ba64c9dc63fc6cef0871f73d2c562'),(9,3,'Primer Grado Escolar','1','Se cursa de los 12 a los 13 años de edad.','5276ec572c1e7eb92716865c983e79b7'),(10,3,'Segundo Grado Escolar','2','Se cursa de los 13 a los 14 años de edad.','f23699df22fe5366356ba739ab5be89d'),(11,3,'Tercer Grado Escolar','3','Se cursa de los 14 a los 15 años de edad.','2584172095d847afc16ee4714ce15226'),(12,4,'Primer Semestre Escolar','1','Se cursa en medio año.','737d49a5a8cd8a733a79962666198f84'),(13,4,'Segundo Semestre Escolar','2','Se cursa en medio año.','0f0efbdb038c6c1164e90ab2ac7de87a'),(14,4,'Tercer Semestre Escolar','3','Se cursa en medio año.','2c3becff875b6eda8adf395f5b637c45'),(15,4,'Cuarto Semestre Escolar','4','Se cursa en medio año.','5f428c10b144d29c997a9b6206197abe'),(16,4,'Quinto Semestre Escolar','5','Se cursa en medio año.','5ec3794f8daba2f47f71144203ac12e2'),(17,4,'Sexto Semestre Escolar','6','Se cursa en medio año.','b0d0d1342ddcad68f4474cddb23bff22');
/*!40000 ALTER TABLE `gradoe` ENABLE KEYS */;
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
-- Table structure for table `grupoe`
--

DROP TABLE IF EXISTS `grupoe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupoe` (
  `idGrupo` int(11) NOT NULL AUTO_INCREMENT,
  `idGrado` int(11) NOT NULL,
  `idCiclo` int(11) NOT NULL,
  `grupo` varchar(40) NOT NULL,
  `hash` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idGrupo`),
  KEY `fk_GrupoC_GradoE1_idx` (`idGrado`),
  KEY `fk_GrupoE_CicloE1_idx` (`idCiclo`),
  CONSTRAINT `fk_GrupoC_GradoE1` FOREIGN KEY (`idGrado`) REFERENCES `gradoe` (`idGrado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_GrupoE_CicloE1` FOREIGN KEY (`idCiclo`) REFERENCES `cicloe` (`idCiclo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupoe`
--

LOCK TABLES `grupoe` WRITE;
/*!40000 ALTER TABLE `grupoe` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupoe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gruposprofesor`
--

DROP TABLE IF EXISTS `gruposprofesor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gruposprofesor` (
  `idProfesor` int(11) NOT NULL,
  `idGrupo` int(11) NOT NULL,
  `idMateria` int(11) NOT NULL,
  PRIMARY KEY (`idProfesor`,`idGrupo`,`idMateria`),
  KEY `fk_meGruposProfesor_meGrupoC1_idx` (`idGrupo`),
  KEY `fk_GruposProfesor_MateriaE1_idx` (`idMateria`),
  CONSTRAINT `fk_GruposProfesor_MateriaE1` FOREIGN KEY (`idMateria`) REFERENCES `materiae` (`idMateria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_meGruposProfesor_meGrupoC1` FOREIGN KEY (`idGrupo`) REFERENCES `grupoe` (`idGrupo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_meGruposProfesor_meProfesorC1` FOREIGN KEY (`idProfesor`) REFERENCES `profesore` (`idProfesor`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gruposprofesor`
--

LOCK TABLES `gruposprofesor` WRITE;
/*!40000 ALTER TABLE `gruposprofesor` DISABLE KEYS */;
/*!40000 ALTER TABLE `gruposprofesor` ENABLE KEYS */;
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
-- Table structure for table `materiae`
--

DROP TABLE IF EXISTS `materiae`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `materiae` (
  `idMateria` int(11) NOT NULL AUTO_INCREMENT,
  `materia` varchar(100) NOT NULL,
  `creditos` float DEFAULT NULL,
  `hash` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idMateria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materiae`
--

LOCK TABLES `materiae` WRITE;
/*!40000 ALTER TABLE `materiae` DISABLE KEYS */;
/*!40000 ALTER TABLE `materiae` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materiasgrupo`
--

DROP TABLE IF EXISTS `materiasgrupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `materiasgrupo` (
  `idGrupo` int(11) NOT NULL,
  `idMateria` int(11) NOT NULL,
  PRIMARY KEY (`idGrupo`,`idMateria`),
  KEY `fk_meMateriasGrupoC_meMateriaC1_idx` (`idMateria`),
  CONSTRAINT `fk_meMateriasGrupoC_meGrupoC1` FOREIGN KEY (`idGrupo`) REFERENCES `grupoe` (`idGrupo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_meMateriasGrupoC_meMateriaC1` FOREIGN KEY (`idMateria`) REFERENCES `materiae` (`idMateria`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materiasgrupo`
--

LOCK TABLES `materiasgrupo` WRITE;
/*!40000 ALTER TABLE `materiasgrupo` DISABLE KEYS */;
/*!40000 ALTER TABLE `materiasgrupo` ENABLE KEYS */;
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
-- Table structure for table `nivele`
--

DROP TABLE IF EXISTS `nivele`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nivele` (
  `idNivel` int(11) NOT NULL AUTO_INCREMENT,
  `nivel` varchar(60) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `hash` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idNivel`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nivele`
--

LOCK TABLES `nivele` WRITE;
/*!40000 ALTER TABLE `nivele` DISABLE KEYS */;
INSERT INTO `nivele` VALUES (1,'Preescolar','Nivel educativo que se cursa en 2 años desde los 4 a 6 años de edad','db459b6176646bd2534fed18f6454155'),(2,'Primaria','Nivel educativo que se cursa en 6 años desde los 6 a 12 años de edad','7b99555169c487e737f0e98bac011bd8'),(3,'Secundaria','Nivel educativo que se cursa en 3 años desde los 12 a 15 años de edad','e6305f57bf72dbef5de2fc10aa057200'),(4,'Preparatoria','Nivel educativo que se cursa en 3 años desde los 15 a 18 años de edad','5134ff606971ff92b7584d459dcd3027');
/*!40000 ALTER TABLE `nivele` ENABLE KEYS */;
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
-- Table structure for table `profesore`
--

DROP TABLE IF EXISTS `profesore`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profesore` (
  `idProfesor` int(11) NOT NULL AUTO_INCREMENT,
  `idRegistro` int(11) NOT NULL,
  PRIMARY KEY (`idProfesor`,`idRegistro`),
  KEY `fk_meProfesorC_Registro1_idx` (`idRegistro`),
  CONSTRAINT `fk_meProfesorC_Registro1` FOREIGN KEY (`idRegistro`) REFERENCES `registro` (`idRegistro`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='	';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profesore`
--

LOCK TABLES `profesore` WRITE;
/*!40000 ALTER TABLE `profesore` DISABLE KEYS */;
/*!40000 ALTER TABLE `profesore` ENABLE KEYS */;
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
  `hash` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idRegistro`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro`
--

LOCK TABLES `registro` WRITE;
/*!40000 ALTER TABLE `registro` DISABLE KEYS */;
INSERT INTO `registro` VALUES (1,'20160303001','DO','Erika','Arcos Lozano','2016-03-03 20:19:18','33bf1f010c1f32b7ee3b44996ba7107b'),(2,'20160303002','DO','Maria Elena','Amador Aguilar','2016-03-03 20:20:09','ac9c566279c76e2700e60fd1b2844a7a'),(3,'20160303003','DO','María del Carmen','Fonseca De la Rosa','2016-03-03 20:20:59','44487950c37c5144fe99347d850bde04'),(4,'20160303004','DO','Armando','Hernandez Rodríguez','2016-03-03 20:22:17','57dabc5558f171f77a983021f0cc0981'),(5,'20160303005','DO','Norma Alicia','Hernandez Rodríguez','2016-03-03 20:22:55','a52fdf5f4e54dbed1bb5ff706ae2c782'),(6,'20160303006','DO','Erik Alejandro','Pérez Rodríguez','2016-03-03 20:23:31','1ce34a3d7441a7e6619774abfd30d5e4'),(7,'20160303007','DO','Denisse','Barber Silva','2016-03-03 20:24:37','4361293ebc23821555f4537688d9375b'),(8,'20160303008','DO','María Dolores','Soto Hernandez','2016-03-03 20:29:08','5df8ba73fbcceefae9059e478076f19b'),(9,'20160303009','DO','Shaque','Vartougian Carrillo','2016-03-03 20:29:48','b9bac7ccb6075746f5e13fe04b634e3f'),(10,'20160303010','DO','Alberto','Cajas Torres','2016-03-03 20:30:17','9f2c25c6d592f153de5dfa564b297505'),(11,'20160303011','DO','María','Mijares Fernández','2016-03-03 20:31:34','87b944fd5c3bbbc4cec81dec46f9c472'),(12,'20160303012','DO','María Elena','Senties Laborde','2016-03-03 20:32:43','f7371d56b416fcc45105c65a09f63b0e'),(13,'20160303013','DO','Mónica','Gallastegui Brambilla','2016-03-03 20:33:42','0fbefe031518183ea5f479aa6e9ba1b6'),(14,'20160303014','DO','María Cristina','Cortés Izquierdo','2016-03-03 20:34:18','4198168c2647fb90c2bc938969561273');
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
  `tipo` varchar(45) DEFAULT NULL,
  `lada` varchar(7) DEFAULT NULL,
  `telefono` varchar(16) NOT NULL,
  `extensiones` varchar(20) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
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

-- Dump completed on 2016-03-03 22:41:44
