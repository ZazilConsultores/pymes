CREATE DATABASE  IF NOT EXISTS `general` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `general`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win64 (x86_64)
--
-- Host: localhost    Database: general
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
  `banco` varchar(200) NOT NULL,
  `cuenta` varchar(60) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `saldo` decimal(10,0) NOT NULL,
  PRIMARY KEY (`idBanco`)
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
  `claveCategoria` text NOT NULL,
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
  `idEstado` int(11) NOT NULL,
  `calle` varchar(60) NOT NULL,
  `colonia` varchar(60) NOT NULL,
  `codigoPostal` varchar(5) NOT NULL,
  `numeroInterior` varchar(60) NOT NULL,
  `numeroExterior` varchar(60) NOT NULL,
  PRIMARY KEY (`idDomicilio`),
  KEY `fk_Domicilio_Municipio1_idx` (`idMunicipio`,`idEstado`),
  CONSTRAINT `fk_Domicilio_Municipio1` FOREIGN KEY (`idMunicipio`, `idEstado`) REFERENCES `municipio` (`idMunicipio`, `idEstado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `domicilio`
--

LOCK TABLES `domicilio` WRITE;
/*!40000 ALTER TABLE `domicilio` DISABLE KEYS */;
INSERT INTO `domicilio` VALUES (1,2,9,'RANCHO CUCHILLA','HACIENDAS DE COYOACAN','04970','-','-'),(2,2,9,'RETORNO 48','AVANTE','04460','-','48'),(3,11,9,'CIPRES','CHIMILLI','14749','-','MANZANA 15 LOTE 6'),(4,12,9,'AVENIDA XOCHIMILCO','SANTA CRUZ XOCHITEPEC','16100','-','-'),(5,2,9,'EUDEVAS','CARACOL','04739','-','-'),(6,14,9,'TUXPAN','ROMA SUR','06760','204','89'),(7,13,9,'AV. INSURGENTES SUR','DEL VALLE','03100','-','800');
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
  PRIMARY KEY (`idEmail`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email`
--

LOCK TABLES `email` WRITE;
/*!40000 ALTER TABLE `email` DISABLE KEYS */;
INSERT INTO `email` VALUES (1,'info@hasan.com'),(2,'info@sirio.com'),(3,'info@zazil.net'),(4,'info@ikal.net'),(5,'info@hasi.com'),(6,'info@cafedelcentro.com'),(7,'info@minerva.com');
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` VALUES (1,1),(2,2),(3,3),(4,4),(5,5),(6,6),(7,7);
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
  `claveEncuesta` text NOT NULL,
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
  `claveEstado` varchar(20) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `capital` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado`
--

LOCK TABLES `estado` WRITE;
/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
INSERT INTO `estado` VALUES (1,'01','Aguascalientes','Aguascalientes'),(2,'02','Baja California','Mexicali'),(3,'03','Baja California Sur','La Paz'),(4,'04','Campeche','Campeche'),(5,'05','Chiapas','Tuxtla Gutiérrez'),(6,'06','Chihuahua','Chihuahua'),(7,'07','Coahuila de Zaragoza','Saltillo'),(8,'08','Colima','Colima'),(9,'09','Distrito Federal','Ciudad de México'),(10,'10','Durango','Durango'),(11,'11','Guanajuato','Guanajuato'),(12,'12','Guerrero','Chilpancingo'),(13,'13','Hidalgo','Pachuca'),(14,'14','Jalisco','Guadalajara'),(15,'15','México','Toluca'),(16,'16','Michoacán de Ocampo','Morelia'),(17,'17','Morelos','Cuernavaca'),(18,'18','Nayarit','Tepic'),(19,'19','Nuevo León','Monterrey'),(20,'20','Oaxaca','Oaxaca'),(21,'21','Puebla','Puebla'),(22,'22','Querétaro','Querétaro'),(23,'23','Quintana Roo','Chetumal'),(24,'24','San Luis Potosí','San Luis Potosí'),(25,'25','Sinaloa','Culiacán'),(26,'26','Sonora','Hermosillo'),(27,'27','Tabasco','Villahermosa'),(28,'28','Tamaulipas','Ciudad Victoria'),(29,'29','Tlaxcala','Tlaxcala'),(30,'30','Veracruz de Ignacio de la Llave','Xalapa'),(31,'31','Yucatán','Mérida'),(32,'32','Zacatecas','Zacatecas'),(33,'00','Desconocido',NULL);
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
  PRIMARY KEY (`idFiscales`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fiscales`
--

LOCK TABLES `fiscales` WRITE;
/*!40000 ALTER TABLE `fiscales` DISABLE KEYS */;
INSERT INTO `fiscales` VALUES (1,'MGR1307164K7','MECANICA EN GENERAL Y REFACCIONES HASAN SA DE CV'),(2,'SSC130716PK6','SIRIO SOLUCIONES EN COMERCIALIZACION SA DE CV'),(3,'ZCO130206K49','ZAZIL CONSULTORES SA DE CV'),(4,'GPI130715FJ9','GESTION DE PROYECTOS IKAL SA DE CV'),(5,'CDD130603N40','CONSULTORIA Y DESARROLLO DE TECNOLOGIAS DE INFORMACION HASI SA DE CV'),(6,'CGC150130UA7','COMERCIALIZADORA GRAN CAFÉ DEL CENTRO SA DE CV'),(7,'MDC150313IL0','MINERVA DISEÑO EN CONSTRUCCION SA DE CV'),(8,'MTO31203 Q45','AYUNTAMIENTO DE TONANITLA EDO DE MEXICO'),(9,'GCU120928 IAA','ZAPATAS TRADING S.A. DE C.V.'),(24,'TCP121005 2Z1','TERRACERIAS Y CONCRETOS PRADA S.A. DE C.V.'),(25,'MAVF681101 LA','FLORIBERTO GABRIEL MARTINEZ VILLEGAS'),(28,'MTE790101 4X1','MUNICIPIO DE TEOTIHUACAN'),(29,'NDI111122 Q1A','NAPE SERVICIO DIGITAL SA DE CV'),(30,'SSI111125815','SIBENT SISTEMS SA DE CV'),(31,'JIMG680108123','JORGE ISRAEL MARTINEZ GARCIA'),(35,'PAI100126 PK4','PROMOTORA DE ACCION Y INFORMACION SOCIAL A.C.'),(36,'DAMM800712122','DALIA ASUCENA MARTINEZ MARTINEZ'),(37,'MMO850101 ID2','MUNICIPIO DE MELCHOR OCAMPO'),(38,'IET111024 GD1','INFRAESTRUCTURA Y EDIFICACIONES TOXQUI S.A. DE C.V.'),(39,'ZAI80913 1I9','ZYCARDO´S ASOCIADOS INTEGRALES AGENTE DE SEGUROS SA DE CV'),(92,'ATE100416760','AGRONOMICOS TEXCOCO SA DE CV'),(99,'CDD130603N40','RESTAURANTE LA PARROQUIA POTOSINA SA'),(108,'SOA740912J31','SERVICIO OJO DE AGUA SA DE CV'),(110,'GOMO40622MRA','GASOLINERA OMEGA MATEHUALA II SA DE CV'),(177,'MATT89010517J','TONANTZIN MARTINEZ TRUJILLO'),(200,'HIB910222BP2','HOTEL IMPALA DEL BAJIO SA DE CV'),(276,'GPA961226ST9','GASOLINERIA PALACIOS SA DE CV'),(306,'LST100127V49','LLANTAS Y SERVICIOS DE TECAMAC SA DE CV'),(329,'CART561021Q50','OLIMPUS CENTRO ACUATICO');
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
  PRIMARY KEY (`idFiscalesDomicilios`),
  KEY `fk_FiscalesDomicilios_Domicilio1_idx` (`idDomicilio`),
  KEY `fk_FiscalesDomicilios_Fiscales1_idx` (`idFiscales`),
  CONSTRAINT `fk_FiscalesDomicilios_Domicilio1` FOREIGN KEY (`idDomicilio`) REFERENCES `domicilio` (`idDomicilio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_FiscalesDomicilios_Fiscales1` FOREIGN KEY (`idFiscales`) REFERENCES `fiscales` (`idFiscales`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fiscalesdomicilios`
--

LOCK TABLES `fiscalesdomicilios` WRITE;
/*!40000 ALTER TABLE `fiscalesdomicilios` DISABLE KEYS */;
INSERT INTO `fiscalesdomicilios` VALUES (1,1,1),(2,2,2),(3,3,3),(4,4,4),(5,5,5),(6,6,6),(7,7,7);
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fiscalesemail`
--

LOCK TABLES `fiscalesemail` WRITE;
/*!40000 ALTER TABLE `fiscalesemail` DISABLE KEYS */;
INSERT INTO `fiscalesemail` VALUES (1,1,1),(2,2,2),(3,3,3),(4,4,4),(5,5,5),(6,6,6),(7,7,7);
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
  `idTelefono` int(11) NOT NULL,
  `idFiscales` int(11) NOT NULL,
  PRIMARY KEY (`idFiscalesTelefonos`),
  KEY `fk_FiscalesTelefonos_Telefono1_idx` (`idTelefono`),
  KEY `fk_FiscalesTelefonos_Fiscales1_idx` (`idFiscales`),
  CONSTRAINT `fk_FiscalesTelefonos_Fiscales1` FOREIGN KEY (`idFiscales`) REFERENCES `fiscales` (`idFiscales`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_FiscalesTelefonos_Telefono1` FOREIGN KEY (`idTelefono`) REFERENCES `telefono` (`idTelefono`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fiscalestelefonos`
--

LOCK TABLES `fiscalestelefonos` WRITE;
/*!40000 ALTER TABLE `fiscalestelefonos` DISABLE KEYS */;
INSERT INTO `fiscalestelefonos` VALUES (1,1,1),(2,2,2),(3,3,3),(4,4,4),(5,5,5),(6,6,6),(7,7,7);
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
  `claveGrupo` text NOT NULL,
  `tipo` varchar(2) NOT NULL,
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
  `claveMunicipio` varchar(20) DEFAULT NULL,
  `municipio` varchar(100) NOT NULL,
  PRIMARY KEY (`idMunicipio`,`idEstado`),
  KEY `fk_Municipio_Estado_idx` (`idEstado`),
  CONSTRAINT `fk_Municipio_Estado` FOREIGN KEY (`idEstado`) REFERENCES `estado` (`idEstado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2453 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `municipio`
--

LOCK TABLES `municipio` WRITE;
/*!40000 ALTER TABLE `municipio` DISABLE KEYS */;
INSERT INTO `municipio` VALUES (1,9,'002','Azcapotzalco'),(2,9,'003','Coyoacán'),(3,9,'004','Cuajimalpa de Morelos'),(4,9,'005','Gustavo A. Madero'),(5,9,'006','Iztacalco'),(6,9,'007','Iztapalapa'),(7,9,'008','La Magdalena Contreras'),(8,9,'009','Milpa Alta'),(9,9,'010','Álvaro Obregón'),(10,9,'011','Tláhuac'),(11,9,'012','Tlalpan'),(12,9,'013','Xochimilco'),(13,9,'014','Benito Juárez'),(14,9,'015','Cuauhtémoc'),(15,9,'016','Miguel Hidalgo'),(16,9,'017','Venustiano Carranza'),(17,1,'001','Aguascalientes'),(18,1,'002','Asientos'),(19,1,'003','Calvillo'),(20,1,'004','Cosío'),(21,1,'005','El Llano'),(22,1,'006','Jesús María'),(23,1,'007','Pabellón de Arteaga'),(24,1,'008','Rincón de Romos'),(25,1,'009','San Francisco de los Romo'),(26,1,'010','San José de Gracia'),(27,1,'011','Tepezalá'),(28,2,'001','Ensenada'),(29,2,'002','Mexicali'),(30,2,'003','Playas de Rosarito'),(31,2,'004','Tecate'),(32,2,'005','Tijuana'),(33,3,'001','Comondú'),(34,3,'002','La Paz'),(35,3,'003','Loreto'),(36,3,'004','Los Cabos'),(37,3,'005','Mulegé'),(38,4,'001','Calakmul'),(39,4,'002','Calkiní'),(40,4,'003','Campeche'),(41,4,'004','Candelaria'),(42,4,'005','Carmen'),(43,4,'006','Champotón'),(44,4,'007','Escárcega'),(45,4,'008','Hecelchakán'),(46,4,'009','Hopelchén'),(47,4,'010','Palizada'),(48,4,'011','Tenabo'),(49,5,'001','Acacoyagua'),(50,5,'002','Acala'),(51,5,'003','Acapetahua'),(52,5,'004','Aldama'),(53,5,'005','Altamirano'),(54,5,'006','Amatán'),(55,5,'007','Amatenango de la Frontera'),(56,5,'008','Amatenango del Valle'),(57,5,'009','Ángel Albino Corzo'),(58,5,'010','Arriaga'),(59,5,'011','Bejucal de Ocampo'),(60,5,'012','Bella Vista'),(61,5,'013','Benemérito de las Américas'),(62,5,'014','Berriozábal'),(63,5,'015','Bochil'),(64,5,'016','Cacahoatán'),(65,5,'017','Chalchihuitán'),(66,5,'018','Chamula'),(67,5,'019','Chanal'),(68,5,'020','Chapultenango'),(69,5,'021','Catazajá'),(70,5,'022','Chenalhó'),(71,5,'023','Chiapa de Corzo'),(72,5,'024','Chiapilla'),(73,5,'025','Chicoasén'),(74,5,'026','Chicomosuelo'),(75,5,'027','Cintalpa'),(76,5,'028','Chilón'),(77,5,'029','Coapilla'),(78,5,'030','Comitán de Domínguez'),(79,5,'031','Copainalá'),(80,5,'032','El Bosque'),(81,5,'033','El Porvenir'),(82,5,'034','Escuintla'),(83,5,'035','Francisco León'),(84,5,'036','Frontera Comalapa'),(85,5,'037','Frontera Hidalgo'),(86,5,'038','Huehuetán'),(87,5,'039','Huitiupán'),(88,5,'040','Huixtán'),(89,5,'041','Huixtla'),(90,5,'042','Ixhuatán'),(91,5,'043','Ixtacomitán'),(92,5,'044','Ixtapa'),(93,5,'045','Ixtapangajoya'),(94,5,'046','Jiquipilas'),(95,5,'047','Jitotol'),(96,5,'048','Juárez'),(97,5,'049','La Concordia'),(98,5,'050','La Grandeza'),(99,5,'051','La Independencia'),(100,5,'052','La Libertad'),(101,5,'053','La Trinitaria'),(102,5,'054','Larráinzar'),(103,5,'055','Las Margaritas'),(104,5,'056','Las Rosas'),(105,5,'057','Mapastepec'),(106,5,'058','Maravilla Tenejapa'),(107,5,'059','Marqués de Comillas'),(108,5,'060','Mazapa de Madero'),(109,5,'061','Mazatán'),(110,5,'062','Metapa'),(111,5,'063','Mitontic'),(112,5,'064','Montecristo de Guerrero'),(113,5,'065','Motozintla'),(114,5,'066','Nicolás Ruíz'),(115,5,'067','Ocosingo'),(116,5,'068','Ocotepec'),(117,5,'069','Ocozocoautla de Espinosa'),(118,5,'070','Ostuacán'),(119,5,'071','Osumacinta'),(120,5,'072','Oxchuc'),(121,5,'073','Palenque'),(122,5,'074','Pantelhó'),(123,5,'075','Pantepec'),(124,5,'076','Pichucalco'),(125,5,'077','Pijijiapan'),(126,5,'078','Pueblo Nuevo Solistahuacán'),(127,5,'079','Rayón'),(128,5,'080','Reforma'),(129,5,'081','Sabanilla'),(130,5,'082','Salto de Agua'),(131,5,'083','San Andrés Duraznal'),(132,5,'084','San Cristóbal de las Casas'),(133,5,'085','San Fernando'),(134,5,'086','San Juan Cancuc'),(135,5,'087','San Lucas'),(136,5,'088','Santiago el Pinar'),(137,5,'089','Siltepec'),(138,5,'090','Simojovel'),(139,5,'091','Sitalá'),(140,5,'092','Socoltenango'),(141,5,'093','Solosuchiapa'),(142,5,'094','Soyaló'),(143,5,'095','Suchiapa'),(144,5,'096','Suchiate'),(145,5,'097','Sunuapa'),(146,5,'098','Tapachula'),(147,5,'099','Tapalapa'),(148,5,'100','Tapilula'),(149,5,'101','Tecpatán'),(150,5,'102','Tenejapa'),(151,5,'103','Teopisca'),(152,5,'104','Tila'),(153,5,'105','Tonalá'),(154,5,'106','Totolapa'),(155,5,'107','Tumbalá'),(156,5,'108','Tuxtla Chico'),(157,5,'109','Tuxtla Gutiérrez'),(158,5,'110','Tuzantán'),(159,5,'111','Tzimol'),(160,5,'112','Unión Juárez'),(161,5,'113','Venustiano Carranza'),(162,5,'114','Villa Comaltitlán'),(163,5,'115','Villa Corzo'),(164,5,'116','Villaflores'),(165,5,'117','Yajalón'),(166,5,'118','Zinacantán'),(167,6,'001','Ahumada'),(168,6,'002','Aldama'),(169,6,'003','Allende'),(170,6,'004','Aquiles Serdán'),(171,6,'005','Ascensión'),(172,6,'006','Bachíniva'),(173,6,'007','Balleza'),(174,6,'008','Batopilas'),(175,6,'009','Bocoyna'),(176,6,'010','Buenaventura'),(177,6,'011','Camargo'),(178,6,'012','Carichí'),(179,6,'013','Casas Grandes'),(180,6,'014','Chihuahua'),(181,6,'015','Chínipas'),(182,6,'016','Coronado'),(183,6,'017','Coyame del Sotol'),(184,6,'018','Cuauhtémoc'),(185,6,'019','Cusihuiriachi'),(186,6,'020','Delicias'),(187,6,'021','Dr. Belisario Domínguez'),(188,6,'022','El Tule'),(189,6,'023','Galeana'),(190,6,'024','Gómez Farías'),(191,6,'025','Gran Morelos'),(192,6,'026','Guachochi'),(193,6,'027','Guadalupe D.B.'),(194,6,'028','Guadalupe y Calvo'),(195,6,'029','Guazapares'),(196,6,'030','Guerrero'),(197,6,'031','Hidalgo del Parral'),(198,6,'032','Huejoitán'),(199,6,'033','Ignacio Zaragoza'),(200,6,'034','Janos'),(201,6,'035','Jiménez'),(202,6,'036','Juárez'),(203,6,'037','Julimes'),(204,6,'038','La Cruz'),(205,6,'039','López'),(206,6,'040','Madera'),(207,6,'041','Maguarichi'),(208,6,'042','Manuel Benavides'),(209,6,'043','Matachí'),(210,6,'044','Matamoros'),(211,6,'045','Meoqui'),(212,6,'046','Morelos'),(213,6,'047','Moris'),(214,6,'048','Namiquipa'),(215,6,'049','Nonoava'),(216,6,'050','Nuevo Casas Grandes'),(217,6,'051','Ocampo'),(218,6,'052','Ojinaga'),(219,6,'053','Praxedis G. Guerrero'),(220,6,'054','Riva Palacio'),(221,6,'055','Rosales'),(222,6,'056','Rosario'),(223,6,'057','San Francisco de Borja'),(224,6,'058','San Francisco de Conchos'),(225,6,'059','San Francisco del Oro'),(226,6,'060','Santa Bárabara'),(227,6,'061','Santa Isabel'),(228,6,'062','Satevó'),(229,6,'063','Saucillo'),(230,6,'064','Temósachi'),(231,6,'065','Urique'),(232,6,'066','Uriachi'),(233,7,'001','Abasolo'),(234,7,'002','Acuña'),(235,7,'003','Allende'),(236,7,'004','Arteaga'),(237,7,'005','Candela'),(238,7,'006','Castaños'),(239,7,'007','Cuatrociénegas'),(240,7,'008','Escobedo'),(241,7,'009','Francisco I. Madero'),(242,7,'010','Frontera'),(243,7,'011','General Cepeda'),(244,7,'012','Guerrero'),(245,7,'013','Hidalgo'),(246,7,'014','Jiménez'),(247,7,'015','Juárez'),(248,7,'016','Lamadrid'),(249,7,'017','Matamoros'),(250,7,'018','Monclova'),(251,7,'019','Morelos'),(252,7,'020','Múzquiz'),(253,7,'021','Nadadores'),(254,7,'022','Nava'),(255,7,'023','Ocampo'),(256,7,'024','Parras'),(257,7,'025','Piedras Negras'),(258,7,'026','Progreso'),(259,7,'027','Ramos Arizpe'),(260,7,'028','Sabinas'),(261,7,'029','Sacramento'),(262,7,'030','Saltillo'),(263,7,'031','San Buenaventura'),(264,7,'032','San Juan de Sabinas'),(265,7,'033','San Pedro'),(266,7,'034','Sierra Mojada'),(267,7,'035','Torreón'),(268,7,'036','Viesca'),(269,7,'037','Villa Unión'),(270,7,'038','Zaragoza'),(271,8,'001','Armería'),(272,8,'002','Colima'),(273,8,'003','Comala'),(274,8,'004','Coquimatlán'),(275,8,'005','Cuauhtémoc'),(276,8,'006','Ixtlahuacán'),(277,8,'007','Manzanillo'),(278,8,'008','Minatitlán'),(279,8,'009','Tecomán'),(280,8,'010','Villa de Álvarez'),(281,10,'001','Canatlán'),(282,10,'002','Canelas'),(283,10,'003','Coneto de Comonfort'),(284,10,'004','Cuencamé'),(285,10,'005','Durango'),(286,10,'006','El Oro'),(287,10,'007','Gómez Palacio'),(288,10,'008','Gral. Simón Bolívar'),(289,10,'009','Guadalupe Victoria'),(290,10,'010','Guanaceví'),(291,10,'011','Hidalgo'),(292,10,'012','Indé'),(293,10,'013','Lerdo'),(294,10,'014','Mapimí'),(295,10,'015','Mezquital'),(296,10,'016','Nazas'),(297,10,'017','Nombre de Dios'),(298,10,'018','Nuevo Ideal'),(299,10,'019','Ocampo'),(300,10,'020','Otáez'),(301,10,'021','Pánuco de Coronado'),(302,10,'022','Peñón Blanco'),(303,10,'023','Poanas'),(304,10,'024','Pueblo Nuevo'),(305,10,'025','Rodeo'),(306,10,'026','San Bernardo'),(307,10,'027','San Dimas'),(308,10,'028','San Juan de Guadalupe'),(309,10,'029','San Juan del Río'),(310,10,'030','San Luis del Cordero'),(311,10,'031','San Pedro del Gallo'),(312,10,'032','Santa Clara'),(313,10,'033','Santiago Papasquiaro'),(314,10,'034','Súchil'),(315,10,'035','Tamazula'),(316,10,'036','Tepehuanes'),(317,10,'037','Tlahualilo'),(318,10,'038','Topia'),(319,10,'039','Vicente Guerrero'),(320,11,'001','Abasolo'),(321,11,'002','Acámbaro'),(322,11,'003','Apaseo el Alto'),(323,11,'004','Apaseo el Grande'),(324,11,'005','Atarjea'),(325,11,'006','Celaya'),(326,11,'007','Comonfort'),(327,11,'008','Coroneo'),(328,11,'009','Cortazar'),(329,11,'010','Cuerámaro'),(330,11,'011','Doctor Mora'),(331,11,'012','Dolores Hidalgo'),(332,11,'013','Guanajuato'),(333,11,'014','Huanímaro'),(334,11,'015','Irapuato'),(335,11,'016','Jaral del Progreso'),(336,11,'017','Jerécuaro'),(337,11,'018','León'),(338,11,'019','Manuel Doblado'),(339,11,'020','Moroleón'),(340,11,'021','Ocampo'),(341,11,'022','Pénjamo'),(342,11,'023','Pueblo Nuevo'),(343,11,'024','Purísima del Rincón'),(344,11,'025','Romita'),(345,11,'026','Salamanca'),(346,11,'027','Salvatierra'),(347,11,'028','San Diego de la Unión'),(348,11,'029','San Felipe'),(349,11,'030','San Francisco del Rincón'),(350,11,'031','San José Iturbide'),(351,11,'032','San Luis de la Paz'),(352,11,'033','San Miguel de Allende'),(353,11,'034','Santa Catarina'),(354,11,'035','Santa Cruz de Juventino'),(355,11,'036','Santiago Maravatío'),(356,11,'037','Silao'),(357,11,'038','Tarandacuao'),(358,11,'039','Tarimoro'),(359,11,'040','Tierra Blanca'),(360,11,'041','Uruangato'),(361,11,'042','Valle de Santiago'),(362,11,'043','Victoria'),(363,11,'044','Villagrán'),(364,11,'045','Xichú'),(365,11,'046','Yuriria'),(366,12,'001','Acapulco de Juárez'),(367,12,'002','Acatepec'),(368,12,'003','Ahuacuotzingo'),(369,12,'004','Ajuchitlán del Progreso'),(370,12,'005','Alcozauca de Guerrero'),(371,12,'006','Alpoyeca'),(372,12,'007','Apaxtla de Castrejón'),(373,12,'008','Arcelia'),(374,12,'009','Atenango del Río'),(375,12,'010','Atlamajalcingo del Monte'),(376,12,'011','Atlixtac'),(377,12,'012','Atoyac de Álvarez'),(378,12,'013','Ayutla de los Libres'),(379,12,'014','Azoyú'),(380,12,'015','Benito Juárez'),(381,12,'016','Buenavista de Cuéllar'),(382,12,'017','Chilapa de Álvarez'),(383,12,'018','Chilpancingo de los Bravo'),(384,12,'019','Coahuayutla de José María Izazaga'),(385,12,'020','Cochoapa el Grande'),(386,12,'021','Cocula'),(387,12,'022','Copala'),(388,12,'023','Copalillo'),(389,12,'024','Copanatoyac'),(390,12,'025','Coyuca de Benítez'),(391,12,'026','Coyuca de Catalán'),(392,12,'027','Cuajinicuilapa'),(393,12,'028','Cualác'),(394,12,'029','Cuautepec'),(395,12,'030','Cuetzala del Progreso'),(396,12,'031','Cutzamala de Pinzón'),(397,12,'032','Eduardo Neri'),(398,12,'033','Florencio Villarreal'),(399,12,'034','General Canuto A. Neri'),(400,12,'035','General Heliodoro Castillo'),(401,12,'036','Huamuxtitlán'),(402,12,'037','Huitzuco de los Figueroa'),(403,12,'038','Iguala de la Independencia'),(404,12,'039','Igualapa'),(405,12,'040','Iliatenco'),(406,12,'041','Ixcateopan de Cuauhtémoc'),(407,12,'042','José Joaquín de Herrera'),(408,12,'043','Juan R. Escudero'),(409,12,'044','Juchitán'),(410,12,'045','La Unión de Isidoro Montes de Oca'),(411,12,'046','Leonardo Bravo'),(412,12,'047','Malinaltepec'),(413,12,'048','Marquelia'),(414,12,'049','Mártir de Cuilapan'),(415,12,'050','Metlatónoc'),(416,12,'051','Mochitlán'),(417,12,'052','Olinalá'),(418,12,'053','Ometepec'),(419,12,'054','Pedro Ascencio Alquisiras'),(420,12,'055','Petatlán'),(421,12,'056','Pilcaya'),(422,12,'057','Pungarabato'),(423,12,'058','Quechultenango'),(424,12,'059','San Luis Acatlán'),(425,12,'060','San Marcos'),(426,12,'061','San Miguel Totolapan'),(427,12,'062','Taxco de Alarcón'),(428,12,'063','Tecoanapa'),(429,12,'064','Técpan de Galeana'),(430,12,'065','Teloloapan'),(431,12,'066','Tepecoacuilco de Trujano'),(432,12,'067','Tetipac'),(433,12,'068','Tixtla de Guerrero'),(434,12,'069','Tlacoachistlahuaca'),(435,12,'070','Tlacoapa'),(436,12,'071','Tlalchapa'),(437,12,'072','Tlalixtlaquilla de Maldanado'),(438,12,'073','Tlapa de Comonfort'),(439,12,'074','Tlapehuala'),(440,12,'075','Xalpatláhuac'),(441,12,'076','Xochihuehuetlán'),(442,12,'077','Xochistlahuaca'),(443,12,'078','Zapotitlán Tablas'),(444,12,'079','Zihuatanejo de Azueta'),(445,12,'080','Zirándaro de los Chávez'),(446,12,'081','Zitlala'),(447,13,'001','Acatlán'),(448,13,'002','Acaxochitlán'),(449,13,'003','Actopan'),(450,13,'004','Agua Blanca de Iturbide'),(451,13,'005','Ajacuba'),(452,13,'006','Alfajayucan'),(453,13,'007','Almoloya'),(454,13,'008','Apan'),(455,13,'009','Atitalaquia'),(456,13,'010','Atlapexco'),(457,13,'011','Atotonilco de Tula'),(458,13,'012','Atotonilco el Grande'),(459,13,'013','Calnali'),(460,13,'014','Chapantongo'),(461,13,'015','Chapulhuacán'),(462,13,'016','Cardonal'),(463,13,'017','Chilcuautla'),(464,13,'018','Cuautepec de Hinojosa'),(465,13,'019','El Arenal'),(466,13,'020','Eloxochitlán'),(467,13,'021','Emiliano Zapata'),(468,13,'022','Epazoyucan'),(469,13,'023','Francisco I. Madero'),(470,13,'024','Huasca de Ocampo'),(471,13,'025','Huautla'),(472,13,'026','Huazalingo'),(473,13,'027','Huejutla de Reyes'),(474,13,'028','Huehuetla  '),(475,13,'029','Huichapan'),(476,13,'030','Ixmiquilpan'),(477,13,'031','Jacala de Ledezma'),(478,13,'032','Jaltocán'),(479,13,'033','Juárez Hidalgo'),(480,13,'034','La Misión'),(481,13,'035','Lolotla'),(482,13,'036','Metepec'),(483,13,'037','Metztitlán'),(484,13,'038','Mineral de la Reforma'),(485,13,'039','Mineral del Chico'),(486,13,'040','Mineral del Monte'),(487,13,'041','Mixquiahuala de Juárez'),(488,13,'042','Molango de Escamilla'),(489,13,'043','Nicolás Flores'),(490,13,'044','Nopala de Villagrán'),(491,13,'045','Omitlán de Juárez'),(492,13,'046','Pachuca de Soto'),(493,13,'047','Pacula'),(494,13,'048','Pisaflores'),(495,13,'049','Progreso de Obregón'),(496,13,'050','San Agustín Metzquititlán'),(497,13,'051','San Agustín Tlaxiaca'),(498,13,'052','San Bartolo Tutotepec'),(499,13,'053','San Felipe Orizatlán'),(500,13,'054','San Salvador'),(501,13,'055','Santiago de Anaya'),(502,13,'056','Santiago Tulantepec de Lugo Guerrero'),(503,13,'057','Singuilucan'),(504,13,'058','Tasquillo'),(505,13,'059','Tecozautla'),(506,13,'060','Tenango de Doria'),(507,13,'061','Tepeapulco'),(508,13,'062','Tepehuacán de Guerrero'),(509,13,'063','Tepeji del Río de Ocampo'),(510,13,'064','Tepetitlán'),(511,13,'065','Tetepango'),(512,13,'066','Tezontepec de Aldama'),(513,13,'067','Tianguistengo'),(514,13,'068','Tizayuca'),(515,13,'069','Tlahuelilpan'),(516,13,'070','Tlahuiltepa'),(517,13,'071','Tlanalapa'),(518,13,'072','Tlanchinol'),(519,13,'073','Tlaxcoapan'),(520,13,'074','Tolcayuca'),(521,13,'075','Tula de Allende'),(522,13,'076','Tulancingo de Bravo'),(523,13,'077','Villa de Tezontepec'),(524,13,'078','Xochiatipan'),(525,13,'079','Xochicoatlán'),(526,13,'080','Yahualica'),(527,13,'081','Zacualtipán de Ángeles'),(528,13,'082','Zapotlán de Juárez'),(529,13,'083','Zempoala'),(530,13,'084','Zimapán'),(531,14,'001','Acatic'),(532,14,'002','Acatlán de Juárez'),(533,14,'003','Ahualulco de Mercado'),(534,14,'004','Amacueca'),(535,14,'005','Amatitán'),(536,14,'006','Ameca'),(537,14,'007','Arandas'),(538,14,'008','Atemajac de Brizuela'),(539,14,'009','Atengo'),(540,14,'010','Atenguillo'),(541,14,'011','Atotonilco el Alto'),(542,14,'012','Atoyac'),(543,14,'013','Autlán de Navarro'),(544,14,'014','Ayotlán'),(545,14,'015','Ayutla'),(546,14,'016','Bolaños'),(547,14,'017','Cabo Corrientes'),(548,14,'018','Cañadas de Obregón'),(549,14,'019','Casimiro Castillo'),(550,14,'020','Chapala'),(551,14,'021','Chimaltitán'),(552,14,'022','Chiquilistlán'),(553,14,'023','Cihuatlán'),(554,14,'024','Cocula'),(555,14,'025','Colotlán'),(556,14,'026','Concepción de Buenos Aires'),(557,14,'027','Cuauitlán de García Barragán'),(558,14,'028','Cuautla'),(559,14,'029','Cuquío'),(560,14,'030','Degollado'),(561,14,'031','Ejutla'),(562,14,'032','El Arenal'),(563,14,'033','El Grullo'),(564,14,'034','El Limón'),(565,14,'035','El Salto'),(566,14,'036','Encarnación de Díaz'),(567,14,'037','Etzatlán'),(568,14,'038','Gómez Farías'),(569,14,'039','Guachinango'),(570,14,'040','Guadalajara'),(571,14,'041','Hostotipaquillo'),(572,14,'042','Huejúcar'),(573,14,'043','Huejuquilla el Alto'),(574,14,'044','Ixtlahuacán de los Membrillos'),(575,14,'045','Ixtlahuacán del Río'),(576,14,'046','Jalostotitlán'),(577,14,'047','Jamay'),(578,14,'048','Jesús María'),(579,14,'049','Jilotlán de los Dolores'),(580,14,'050','Jocotepec'),(581,14,'051','Juanacatlán'),(582,14,'052','Juchitlán'),(583,14,'053','La Barca'),(584,14,'054','Lagos de Moreno'),(585,14,'055','La Manzanilla de la Paz'),(586,14,'056','La Huerta'),(587,14,'057','Magdalena'),(588,14,'058','Mascota'),(589,14,'059','Mazamitla'),(590,14,'060','Mexticacán'),(591,14,'061','Mezquitic'),(592,14,'062','Mixtlán'),(593,14,'063','Ojuelos de Jalisco'),(594,14,'064','Ocotlán '),(595,14,'065','Pihuamo'),(596,14,'066','Poncitlán'),(597,14,'067','Puerto Vallarta'),(598,14,'068','Quitupan'),(599,14,'069','San Cristóbal de la Barranca'),(600,14,'070','San Diego de Alejandría'),(601,14,'071','San Gabriel'),(602,14,'072','San Ignacio Cerro Gordo '),(603,14,'073','San Juan de los Lagos'),(604,14,'074','San Juanito de Escobedo'),(605,14,'075','San Julián'),(606,14,'076','San Marcos'),(607,14,'077','San Martín de Bolaños'),(608,14,'078','San Martín Hidalgo'),(609,14,'079','San Miguel el Alto'),(610,14,'080','San Sebastián del Oeste'),(611,14,'081','Santa María de los Ángeles'),(612,14,'082','Santa María del Oro'),(613,14,'083','Sayula'),(614,14,'084','Tala'),(615,14,'085','Talpa de Allende'),(616,14,'086','Tamazula de Gordiano'),(617,14,'087','Tapalpa'),(618,14,'088','Tecalitlán'),(619,14,'089','Techaluta de Montenegro'),(620,14,'090','Tecolotlán'),(621,14,'091','Tenamaxtlán'),(622,14,'092','Teocaltiche'),(623,14,'093','Teocuitatlán de Corona'),(624,14,'094','Tepatitlán de Morelos'),(625,14,'095','Tequila'),(626,14,'096','Teuchitlán'),(627,14,'097','Tizapán el Alto'),(628,14,'098','Tlajomulco de Zúñiga'),(629,14,'099','Tlaquepaque'),(630,14,'100','Tolimán'),(631,14,'101','Tomatlán'),(632,14,'102','Tonalá'),(633,14,'103','Tonaya'),(634,14,'104','Tonila'),(635,14,'105','Totatiche'),(636,14,'106','Tototlán'),(637,14,'107','Tuxcacuesco'),(638,14,'108','Tuxcueca'),(639,14,'109','Tuxpan'),(640,14,'110','Unión de San Antonio'),(641,14,'111','Unión de Tula'),(642,14,'112','Valle de Guadalupe'),(643,14,'113','Valle de Juárez'),(644,14,'114','Villa Corona'),(645,14,'115','Villa Guerrero'),(646,14,'116','Villa Hidalgo'),(647,14,'117','Villa Purificación'),(648,14,'118','Yahualica de González Gallo'),(649,14,'119','Zacoalco de Torres'),(650,14,'120','Zapopan'),(651,14,'121','Zapotiltic'),(652,14,'122','Zapotitlán de Vadillo'),(653,14,'123','Zapotlán del Rey'),(654,14,'124','Zapotlanejo '),(655,15,'001','Acambay'),(656,15,'002','Acolman'),(657,15,'003','Aculco'),(658,15,'004','Almoloya de Alquisiras'),(659,15,'005','Almoloya de Juárez'),(660,15,'006','Almoloya del Río'),(661,15,'007','Amanalco'),(662,15,'008','Amatepec'),(663,15,'009','Amecameca'),(664,15,'010','Apaxco'),(665,15,'011','Atenco'),(666,15,'012','Atizapán'),(667,15,'013','Atizapán de Zaragoza'),(668,15,'014','Atlacomulco'),(669,15,'015','Atlautla'),(670,15,'016','Axapusco'),(671,15,'017','Ayapango'),(672,15,'018','Calimaya'),(673,15,'019','Capulhuac'),(674,15,'020','Chalco'),(675,15,'021','Chapa de Mota'),(676,15,'022','Chapultepec'),(677,15,'023','Chiautla'),(678,15,'024','Chicoloapan'),(679,15,'025','Chiconcuac'),(680,15,'026','Chimalhuacán'),(681,15,'027','Coacalco de Berriozábal'),(682,15,'028','Coatepec Harinas'),(683,15,'029','Cocotitlán'),(684,15,'030','Coyotepec'),(685,15,'031','Cuautitlán'),(686,15,'032','Cuautitlán Izcalli'),(687,15,'033','Donato Guerra'),(688,15,'034','Ecatepec de Morelos'),(689,15,'035','Ecatzingo'),(690,15,'036','El Oro'),(691,15,'037','Huehuetoca'),(692,15,'038','Hueypoxtla'),(693,15,'039','Huixquilucan'),(694,15,'040','Isidro Fabela'),(695,15,'041','Ixtapaluca'),(696,15,'042','Ixtapan de la Sal'),(697,15,'043','Ixtapan del Oro'),(698,15,'044','Ixtlahuaca'),(699,15,'045','Jaltenco'),(700,15,'046','Jilotepec'),(701,15,'047','Jilotzingo'),(702,15,'048','Jiquipilco'),(703,15,'049','Jocotitlán'),(704,15,'050','Joquicingo'),(705,15,'051','Juchitepec'),(706,15,'052','La Paz'),(707,15,'053','Lerma'),(708,15,'054','Luvianos'),(709,15,'055','Malinalco'),(710,15,'056','Melchor Ocampo'),(711,15,'057','Metepec'),(712,15,'058','Mexicaltzingo'),(713,15,'059','Morelos'),(714,15,'060','Naucalpan de Juárez'),(715,15,'061','Nextlalpan'),(716,15,'062','Nezahualcoyotl'),(717,15,'063','Nicolás Romero'),(718,15,'064','Nopaltepec'),(719,15,'065','Ocoyoacac'),(720,15,'066','Ocuilan'),(721,15,'067','Otumba'),(722,15,'068','Otzoloapan'),(723,15,'069','Otzolotepec'),(724,15,'070','Ozumba'),(725,15,'071','Papalotla'),(726,15,'072','Polotitlán'),(727,15,'073','Rayón'),(728,15,'074','San Antonio la Isla'),(729,15,'075','San Felipe del Progreso'),(730,15,'076','San José del Rincón'),(731,15,'077','San Martín de las Pirámides'),(732,15,'078','San Mateo Atenco'),(733,15,'079','San Simón de Guerrero'),(734,15,'080','Santo Tomás'),(735,15,'081','Soyaniquilpan de Juárez'),(736,15,'082','Sultepec'),(737,15,'083','Tecámac'),(738,15,'084','Tejupilco'),(739,15,'085','Temamatla'),(740,15,'086','Temascalapa'),(741,15,'087','Temascalcingo'),(742,15,'088','Temascaltepec'),(743,15,'089','Temoaya'),(744,15,'090','Tenancingo'),(745,15,'091','Tenango del Aire'),(746,15,'092','Tenango del Valle'),(747,15,'093','Teoloyucán'),(748,15,'094','Teotihuacán'),(749,15,'095','Tepetlaoxtoc'),(750,15,'096','Tepetlixpa'),(751,15,'097','Tepotzotlán'),(752,15,'098','Tequixquiac'),(753,15,'099','Texcaltitlán'),(754,15,'100','Texcalyacac'),(755,15,'101','Texcoco'),(756,15,'102','Tezoyuca'),(757,15,'103','Tianguistenco'),(758,15,'104','Timilpan'),(759,15,'105','Tlalmanalco'),(760,15,'106','Tlalnepantla de Baz'),(761,15,'107','Tlatlaya'),(762,15,'108','Toluca'),(763,15,'109','Tonanitla'),(764,15,'110','Tonatico'),(765,15,'111','Tultepec'),(766,15,'112','Tultitlán'),(767,15,'113','Valle de Bravo'),(768,15,'114','Valle de Chalco Solidaridad'),(769,15,'115','Villa de Allende'),(770,15,'116','Villa del Carbón'),(771,15,'117','Villa Guerrero'),(772,15,'118','Villa Victoria'),(773,15,'119','Xalatlaco'),(774,15,'120','Xonacatlán'),(775,15,'121','Zacazonapan'),(776,15,'122','Zacualpan'),(777,15,'123','Zinacantepec'),(778,15,'124','Zumpahuacán'),(779,15,'125','Zumpango'),(780,16,'001','Acuitzio'),(781,16,'002','Aguililla'),(782,16,'003','Álvaro Obregón'),(783,16,'004','Angamacutiro'),(784,16,'005','Angangueo'),(785,16,'006','Apatzingán'),(786,16,'007','Aporo'),(787,16,'008','Aquila'),(788,16,'009','Ario de Rosales'),(789,16,'010','Arteaga Riseñas'),(790,16,'011','Briseñas'),(791,16,'012','Buenavista'),(792,16,'013','Carácuaro'),(793,16,'014','Charapan'),(794,16,'015','Charo'),(795,16,'016','Chavinda'),(796,16,'017','Cherán'),(797,16,'018','Chilchota'),(798,16,'019','Chuinicuila'),(799,16,'020','Chucándiro'),(800,16,'021','Churintzio'),(801,16,'022','Churumuco'),(802,16,'023','Coahuayana'),(803,16,'024','Coalcomán de Vázquez Pallares'),(804,16,'025','Coeneo'),(805,16,'026','Cojumatlán de Régules'),(806,16,'027','Contepec'),(807,16,'028','Copándaro'),(808,16,'029','Cotija'),(809,16,'030','Cuitzeo'),(810,16,'031','Escuandureo'),(811,16,'032','Epitacio Huerta'),(812,16,'033','Erongarícuaro'),(813,16,'034','Gabriel Zamora'),(814,16,'035','Hidalgo'),(815,16,'036','Huandacareo'),(816,16,'037','Huaniqueo'),(817,16,'038','Huetamo'),(818,16,'039','Huiramba'),(819,16,'040','Indaparapeo'),(820,16,'041','Irimbo'),(821,16,'042','Ixtlán'),(822,16,'043','Jacona'),(823,16,'044','Jiménez'),(824,16,'045','Jiquilpan'),(825,16,'046','José Sixto Verduzco'),(826,16,'047','Juárez'),(827,16,'048','Jungapeo'),(828,16,'049','La Huacana'),(829,16,'050','La Piedad'),(830,16,'051','Lagunillas'),(831,16,'052','Lázaro Cárdenas'),(832,16,'053','Los Reyes'),(833,16,'054','Madero'),(834,16,'055','Maravatío'),(835,16,'056','Marcos Castellanos'),(836,16,'057','Morelia'),(837,16,'058','Morelos'),(838,16,'059','Múgica'),(839,16,'060','Nahuatzen'),(840,16,'061','Nocupétaro'),(841,16,'062','Nuevo Parangaricutiro'),(842,16,'063','Nuevo Urecho'),(843,16,'064','Numarán'),(844,16,'065','Ocampo'),(845,16,'066','Pajacuarán'),(846,16,'067','Panindícuaro'),(847,16,'068','Paracho'),(848,16,'069','Parácuaro'),(849,16,'070','Pátzcuaro'),(850,16,'071','Penjamillo'),(851,16,'072','Peribán'),(852,16,'073','Purépero'),(853,16,'074','Puruándiro'),(854,16,'075','Queréndaro'),(855,16,'076','Quiroga'),(856,16,'077','Sahuayo'),(857,16,'078','Salvador Escalante'),(858,16,'079','San Lucas'),(859,16,'080','Santa Ana Maya'),(860,16,'081','Senguio'),(861,16,'082','Susupuato'),(862,16,'083','Tancítaro'),(863,16,'084','Tangamandapio'),(864,16,'085','Tangancícuaro'),(865,16,'086','Tanhuato'),(866,16,'087','Taretan'),(867,16,'088','Tarímbaro'),(868,16,'089','Tepalcatepec'),(869,16,'090','Tingüindín'),(870,16,'091','Tingambato'),(871,16,'092','Tiquicheo de Nicolás Romero'),(872,16,'093','Tlalpujahua'),(873,16,'094','Tlazazalca'),(874,16,'095','Tocumbo'),(875,16,'096','Tumbiscatío'),(876,16,'097','Turicato'),(877,16,'098','Tuxpan'),(878,16,'099','Tuzantla'),(879,16,'100','Tzintzuntzan'),(880,16,'101','Tzitzio'),(881,16,'102','Uruapan'),(882,16,'103','Venustiano Carranza'),(883,16,'104','Villamar'),(884,16,'105','Vista Hermosa'),(885,16,'106','Yurécuaro'),(886,16,'107','Zacapu'),(887,16,'108','Zamora'),(888,16,'109','Zináparo'),(889,16,'110','Zinapécuaro'),(890,16,'111','Ziracuaretiro'),(891,16,'112','Zitácuaro'),(892,17,'001','Amacuzac'),(893,17,'002','Atlatlahucan'),(894,17,'003','Axochiapan'),(895,17,'004','Ayala'),(896,17,'005','Coatlán del Río'),(897,17,'006','Cuautla'),(898,17,'007','Cuernavaca'),(899,17,'008','Emiliano Zapata'),(900,17,'009','Huitzilac'),(901,17,'010','Jantetelco'),(902,17,'011','Jiutepec'),(903,17,'012','Jojutla'),(904,17,'013','Jonacatepec'),(905,17,'014','Mazatepec'),(906,17,'015','Miacatlán'),(907,17,'016','Ocuituco'),(908,17,'017','Puente de Ixtla'),(909,17,'018','Temixco'),(910,17,'019','Temoac'),(911,17,'020','Tepalcingo'),(912,17,'021','Tepoztlán'),(913,17,'022','Tetecala'),(914,17,'023','Tetela del Volcán'),(915,17,'024','Tlalnepantla'),(916,17,'025','Tlaltizapán de Zapata'),(917,17,'026','Tlaquiltenango'),(918,17,'027','Tlayacapan'),(919,17,'028','Totolapan'),(920,17,'029','Xochitepec'),(921,17,'030','Yautepec de Zaragoza'),(922,17,'031','Yecapixtla'),(923,17,'032','Zacatepec de Hidalgo'),(924,17,'033','Zacualpan de Amilpas'),(925,18,'001','Acaponeta'),(926,18,'002','Ahuacatlán'),(927,18,'003','Amatlán de Cañas'),(928,18,'004','Bahía de Banderas'),(929,18,'005','Compostela'),(930,18,'006','El Nayar'),(931,18,'007','Huajicori'),(932,18,'008','Ixtlán del Río'),(933,18,'009','Jala'),(934,18,'010','La Yesca'),(935,18,'011','Rosamorada'),(936,18,'012','Ruíz'),(937,18,'013','San Blas'),(938,18,'014','San Pedro Lagunillas'),(939,18,'015','Santa María del Oro'),(940,18,'016','Santiago Ixcuintla'),(941,18,'017','Tecuala'),(942,18,'018','Tepic'),(943,18,'019','Tuxpan'),(944,18,'020','Xalisco'),(945,19,'001','Abasolo'),(946,19,'002','Agualeguas'),(947,19,'003','Allende'),(948,19,'004','Anáhuac'),(949,19,'005','Apodaca'),(950,19,'006','Aramberri'),(951,19,'007','Bustamante'),(952,19,'008','Cadereyta Jiménez'),(953,19,'009','Cerralvo'),(954,19,'010','China'),(955,19,'011','Ciénega de Flores'),(956,19,'012','Doctor Arroyo'),(957,19,'013','Doctor Coss'),(958,19,'014','Doctor González'),(959,19,'015','El Carmen'),(960,19,'016','Galeana'),(961,19,'017','García'),(962,19,'018','General Bravo'),(963,19,'019','General Escobedo'),(964,19,'020','General Terán'),(965,19,'021','General Treviño'),(966,19,'022','General Zaragoza'),(967,19,'023','General Zuazua'),(968,19,'024','Guadalupe'),(969,19,'025','Hidalgo'),(970,19,'026','Higueras'),(971,19,'027','Hualahuises'),(972,19,'028','Iturbide'),(973,19,'029','Juárez'),(974,19,'030','Lampazos de Naranjo'),(975,19,'031','Linares'),(976,19,'032','Los Aldamas'),(977,19,'033','Los Herreras'),(978,19,'034','Los Ramones'),(979,19,'035','Marín'),(980,19,'036','Melchor Ocampo'),(981,19,'037','Mier y Noriega'),(982,19,'038','Mina'),(983,19,'039','Montemorelos'),(984,19,'040','Monterrey'),(985,19,'041','Parás'),(986,19,'042','Pesquería'),(987,19,'043','Rayones'),(988,19,'044','Sabinas Hidalgo'),(989,19,'045','Salinas Victoria'),(990,19,'046','San Nicolás de los Garza'),(991,19,'047','San Pedro Garza García'),(992,19,'048','Santa Catarina'),(993,19,'049','Santiago'),(994,19,'050','Vallecillo'),(995,19,'051','Villaldama'),(996,20,'001','Abejones'),(997,20,'002','Acatlán de Pérez Figueroa'),(998,20,'003','Ánimas Trujano'),(999,20,'004','Asunción Cacalotepec'),(1000,20,'005','Asunción Cuyotepeji'),(1001,20,'006','Asunción Ixtaltepec'),(1002,20,'007','Asunción Nochixtlán'),(1003,20,'008','Asunción Ocotlán'),(1004,20,'009','Asunción Tlacolulita'),(1005,20,'010','Ayoquezco de Aldama'),(1006,20,'011','Ayotzintepec'),(1007,20,'012','Calihualá'),(1008,20,'013','Candelaria Loxicha'),(1009,20,'014','Capulalpam de Méndez'),(1010,20,'015','Chahuites'),(1011,20,'016','Chalcatongo de Hidalgo'),(1012,20,'017','Chiquihuitlán de Benito Juárez'),(1013,20,'018','Ciénega de Zimatlán'),(1014,20,'019','Ciudad Ixtepec'),(1015,20,'020','Coatecas Altas'),(1016,20,'021','Coicoyán de las Flores'),(1017,20,'022','Concepción Buenavista'),(1018,20,'023','Concepción Pápalo'),(1019,20,'024','Constancia del Rosario'),(1020,20,'025','Cosolapa'),(1021,20,'026','Cosoltepec'),(1022,20,'027','Cuilapam de Guerrero'),(1023,20,'028','Cuyamecalco Villa de Zaragoza'),(1024,20,'029','El Barrio de la Soledad'),(1025,20,'030','El Espinal'),(1026,20,'031','Eloxochitlán de Flores Magón'),(1027,20,'032','Fresnillo de Trujano'),(1028,20,'033','Guadalupe de Ramírez'),(1029,20,'034','Guadalupe Etla'),(1030,20,'035','Guelatao de Juárez'),(1031,20,'036','Guevea de Humboldt'),(1032,20,'037','Heróica Ciudad de Ejutla de Crespo'),(1033,20,'038','Heróica Ciudad de Huajuapan de León'),(1034,20,'039','Heróica Ciudad de Tlaxiaco'),(1035,20,'040','Huautepec'),(1036,20,'041','Huautla de Jiménez'),(1037,20,'042','Ixpantepec Nieves'),(1038,20,'043','Ixtlán de Juárez'),(1039,20,'044','Juchitán de Zaragoza'),(1040,20,'045','La Compañía'),(1041,20,'046','La Pe'),(1042,20,'047','La Reforma'),(1043,20,'048','La Trinidad Vista Hermosa'),(1044,20,'049','Loma Bonita'),(1045,20,'050','Magdalena Apasco'),(1046,20,'051','Magdalena Jaltepec'),(1047,20,'052','Magdalena Mixtepec'),(1048,20,'053','Magdalena Ocotlán'),(1049,20,'054','Magdalena Peñasco'),(1050,20,'055','Magdalena Teitipac'),(1051,20,'056','Magdalena Tequisistlán'),(1052,20,'057','Magdalena Tlacotepec'),(1053,20,'058','Magdalena Yodocono de Porfirio Díaz'),(1054,20,'059','Magdalena Zahuatlán'),(1055,20,'060','Mariscala de Juárez'),(1056,20,'061','Mártires de Tacubaya'),(1057,20,'062','Matías Romero Avendaño'),(1058,20,'063','Mazatlán Villa de Flores'),(1059,20,'064','Mesones Hidalgo'),(1060,20,'065','Miahuatlán de Porfirio Díaz'),(1061,20,'066','Mixistlán de la Reforma'),(1062,20,'067','Monjas'),(1063,20,'068','Natividad'),(1064,20,'069','Nazareno Etla'),(1065,20,'070','Nejapa de Madero'),(1066,20,'071','Nuevo Zoquiapam'),(1067,20,'072','Oaxaca de Juárez'),(1068,20,'073','Ocotlán de Morelos'),(1069,20,'074','Pinotepa de Don Luis'),(1070,20,'075','Pluma Hidalgo'),(1071,20,'076','Putla Villa de Guerrero'),(1072,20,'077','Reforma de Pineda'),(1073,20,'078','Reyes Etla'),(1074,20,'079','Rojas de Cuauhtémoc'),(1075,20,'080','Salina Cruz'),(1076,20,'081','San Agustín Amatengo'),(1077,20,'082','San Agustín Atenango'),(1078,20,'083','San Agustín Chayuco'),(1079,20,'084','San Agustín de las Juntas'),(1080,20,'085','San Agustín Etla'),(1081,20,'086','San Agustín Loxicha'),(1082,20,'087','San Agustín Tlacotepec'),(1083,20,'088','San Agustín Yatareni'),(1084,20,'089','San Andrés Cabecera Nueva'),(1085,20,'090','San Andrés Dinicuiti'),(1086,20,'091','San Andrés Huaxpaltepec'),(1087,20,'092','San Andrés Huayapam'),(1088,20,'093','San Andrés Ixtlahuaca'),(1089,20,'094','San Andrés Lagunas'),(1090,20,'095','San Andrés Nuxiño'),(1091,20,'096','San Andrés Paxtlán'),(1092,20,'097','San Andrés Sinaxtla'),(1093,20,'098','San Andrés Solaga'),(1094,20,'099','San Andrés Teotilalpam'),(1095,20,'100','San Andrés Tepetlapa'),(1096,20,'101','San Andrés Yaa'),(1097,20,'102','San Andrés Zabache'),(1098,20,'103','San Andrés Zautla'),(1099,20,'104','San Antonino Castillo Velasco'),(1100,20,'105','San Antonino el Alto'),(1101,20,'106','San Antonino Monteverde'),(1102,20,'107','San Antonio Acutla'),(1103,20,'108','San Antonio de la Cal'),(1104,20,'109','San Antonio Huitepec'),(1105,20,'110','San Antonio Nanahuatipam'),(1106,20,'111','San Antonio Sinicahua'),(1107,20,'112','San Antonio Tepetlapa'),(1108,20,'113','San Baltazar Chichicápam'),(1109,20,'114','San Baltazar Loxicha'),(1110,20,'115','San Baltazar Yatzachi el Bajo'),(1111,20,'116','San Bartolo Coyotepec'),(1112,20,'117','San Bartolo Soyaltepec'),(1113,20,'118','San Bartolo Yautepec'),(1114,20,'119','San Bartolomé Ayautla'),(1115,20,'120','San Bartolomé Loxicha'),(1116,20,'121','San Bartolomé Quialana'),(1117,20,'122','San Bartolomé Yucuañe'),(1118,20,'123','San Bartolomé Zoogocho'),(1119,20,'124','San Bernardo Mixtepec'),(1120,20,'125','San Blas Atempa'),(1121,20,'126','San Carlos Yautepec'),(1122,20,'127','San Cristóbal Amatlán'),(1123,20,'128','San Cristóbal Amoltepec'),(1124,20,'129','San Cristóbal Lachirioag'),(1125,20,'130','San Cristóbal Suchixtlahuaca'),(1126,20,'131','San Dionisio del Mar'),(1127,20,'132','San Dionisio Ocotepec'),(1128,20,'133','San Dionisio Ocotlán'),(1129,20,'134','San Esteban Atatlahuca'),(1130,20,'135','San Felipe Jalapa de Díaz'),(1131,20,'136','San Felipe Tejalapam'),(1132,20,'137','San Felipe Usila'),(1133,20,'138','San Francisco Cahuacuá'),(1134,20,'139','San Francisco Cajonos'),(1135,20,'140','San Francisco Chapulapa'),(1136,20,'141','San Francisco Chindua'),(1137,20,'142','San Francisco del Mar'),(1138,20,'143','San Francisco Huehuetlán'),(1139,20,'144','San Francisco Ixhuatán'),(1140,20,'145','San Francisco Jaltepetongo'),(1141,20,'146','San Francisco Lachigoló'),(1142,20,'147','San Francisco Logueche'),(1143,20,'148','San Francisco Nuxaño'),(1144,20,'149','San Francisco Ozolotepec'),(1145,20,'150','San Francisco Sola'),(1146,20,'151','San Francisco Telixtlahuaca'),(1147,20,'152','San Francisco Teopan'),(1148,20,'153','San Francisco Tlapancingo'),(1149,20,'154','San Gabriel Mixtepec'),(1150,20,'155','San Ildefonso Amatlán'),(1151,20,'156','San Ildefonso Sola'),(1152,20,'157','San Ildefonso Villa Alta'),(1153,20,'158','San Jacinto Amilpas'),(1154,20,'159','San Jacinto Tlacotepec'),(1155,20,'160','San Jerónimo Coatlán'),(1156,20,'161','San Jerónimo Silacayoapilla'),(1157,20,'162','San Jerónimo Sosola'),(1158,20,'163','San Jerónimo Taviche'),(1159,20,'164','San Jerónimo Tecoatl'),(1160,20,'165','San Jerónimo Tlacochahuaya'),(1161,20,'166','San Jorge Nuchita'),(1162,20,'167','San José Ayuquila'),(1163,20,'168','San José Chiltepec'),(1164,20,'169','San José del Peñasco'),(1165,20,'170','San José del Progreso'),(1166,20,'171','San José Estancia Grande'),(1167,20,'172','San José Independencia'),(1168,20,'173','San José Lachiguiri'),(1169,20,'174','San José Tenango'),(1170,20,'175','San Juan Achiutla'),(1171,20,'176','San Juan Atepec'),(1172,20,'177','San Juan Bautista Atatlahuca'),(1173,20,'178','San Juan Bautista Coixtlahuaca'),(1174,20,'179','San Juan Bautista Cuicatlán'),(1175,20,'180','San Juan Bautista Guelache'),(1176,20,'181','San Juan Bautista Jayacatlán'),(1177,20,'182','San Juan Bautista Lo de Soto'),(1178,20,'183','San Juan Bautista Suchitepec'),(1179,20,'184','San Juan Bautista Tlacoatzintepec'),(1180,20,'185','San Juan Bautista Tlachichilco'),(1181,20,'186','San Juan Bautista Tuxtepec'),(1182,20,'187','San Juan Bautista Valle Nacional'),(1183,20,'188','San Juan Cacahuatepec'),(1184,20,'189','San Juan Chicomezúchil'),(1185,20,'190','San Juan Chilateca'),(1186,20,'191','San Juan Cieneguilla'),(1187,20,'192','San Juan Coatzóspam'),(1188,20,'193','San Juan Colorado'),(1189,20,'194','San Juan Comaltepec'),(1190,20,'195','San Juan Cotzocón'),(1191,20,'196','San Juan del Estado'),(1192,20,'197','San Juan de los Cués'),(1193,20,'198','San Juan del Río'),(1194,20,'199','San Juan Diuxi'),(1195,20,'200','San Juan Evangelista Analco'),(1196,20,'201','San Juan Guelavia'),(1197,20,'202','San Juan Guichicovi'),(1198,20,'203','San Juan Ihualtepec'),(1199,20,'204','San Juan Juquila Mixes'),(1200,20,'205','San Juan Juquila Vijanos'),(1201,20,'206','San Juan Lachao'),(1202,20,'207','San Juan Lachigalla'),(1203,20,'208','San Juan Lajarcia'),(1204,20,'209','San Juan Lalana'),(1205,20,'210','San Juan Mazatlán'),(1206,20,'211','San Juan Mixtepec, distrito 08'),(1207,20,'212','San Juan Mixtepec, distrito 26'),(1208,20,'213','San Juan Ñumi'),(1209,20,'214','San Juan Ozolotepec'),(1210,20,'215','San Juan Petlapa'),(1211,20,'216','San Juan Quiahije'),(1212,20,'217','San Juan Quiotepec'),(1213,20,'218','San Juan Sayultepec'),(1214,20,'219','San Juan Tabaá'),(1215,20,'220','San Juan Tamazola'),(1216,20,'221','San Juan Teita'),(1217,20,'222','San Juan Teitipac'),(1218,20,'223','San Juan Tepeuxila'),(1219,20,'224','San Juan Teposcolula'),(1220,20,'225','San Juan Yaeé'),(1221,20,'226','San Juan Yatzona'),(1222,20,'227','San Juan Yucuita'),(1223,20,'228','San Lorenzo'),(1224,20,'229','San Lorenzo Albarradas'),(1225,20,'230','San Lorenzo Cacaotepec'),(1226,20,'231','San Lorenzo Cuaunecuiltitla'),(1227,20,'232','San Lorenzo Texmelucan'),(1228,20,'233','San Lorenzo Victoria'),(1229,20,'234','San Lucas Camotlán'),(1230,20,'235','San Lucas Ojitlán'),(1231,20,'236','San Lucas Quiaviní'),(1232,20,'237','San Lucas Zoquiápam'),(1233,20,'238','San Luis Amatlán'),(1234,20,'239','San Marcial Ozolotepec'),(1235,20,'240','San Marcos Arteaga'),(1236,20,'241','San Martín de los Cansecos'),(1237,20,'242','San Martín Huamelúlpam'),(1238,20,'243','San Martín Itunyoso'),(1239,20,'244','San Martín Lachilá'),(1240,20,'245','San Martín Peras'),(1241,20,'246','San Martín Tilcajete'),(1242,20,'247','San Martín Toxpalan'),(1243,20,'248','San Martín Zacatepec'),(1244,20,'249','San Mateo Cajonos'),(1245,20,'250','San Mateo del Mar'),(1246,20,'251','San Mateo Etlatongo'),(1247,20,'252','San Mateo Nejápam'),(1248,20,'253','San Mateo Peñasco'),(1249,20,'254','San Mateo Piñas'),(1250,20,'255','San Mateo Río Hondo'),(1251,20,'256','San Mateo Sindihui'),(1252,20,'257','San Mateo Tlapiltepec'),(1253,20,'258','San Mateo Yoloxochitlán'),(1254,20,'259','San Melchor Betaza'),(1255,20,'260','San Miguel Achiutla'),(1256,20,'261','San Miguel Ahuehuetitlán'),(1257,20,'262','San Miguel Aloápam'),(1258,20,'263','San Miguel Amatitlán'),(1259,20,'264','San Miguel Amatlán'),(1260,20,'265','San Miguel Coatlán'),(1261,20,'266','San Miguel Chicahua'),(1262,20,'267','San Miguel Chimalapa'),(1263,20,'268','San Miguel del Puerto'),(1264,20,'269','San Miguel del Río'),(1265,20,'270','San Miguel Ejutla'),(1266,20,'271','San Miguel el Grande'),(1267,20,'272','San Miguel Huautla'),(1268,20,'273','San Miguel Mixtepec'),(1269,20,'274','San Miguel Panixtlahuaca'),(1270,20,'275','San Miguel Peras'),(1271,20,'276','San Miguel Piedras'),(1272,20,'277','San Miguel Quetzaltepec'),(1273,20,'278','San Miguel Santa Flor'),(1274,20,'279','San Miguel Soyaltepec'),(1275,20,'280','San Miguel Suchixtepec'),(1276,20,'281','San Miguel Tecomatlán'),(1277,20,'282','San Miguel Tenango'),(1278,20,'283','San Miguel Tequixtepec'),(1279,20,'284','San Miguel Tilquiápam'),(1280,20,'285','San Miguel Tlacamama'),(1281,20,'286','San Miguel Tlacotepec'),(1282,20,'287','San Miguel Tulancingo'),(1283,20,'288','San Miguel Yotao'),(1284,20,'289','San Nicolás'),(1285,20,'290','San Nicolás Hidalgo'),(1286,20,'291','San Pablo Coatlán'),(1287,20,'292','San Pablo Cuatro Venados'),(1288,20,'293','San Pablo Etla'),(1289,20,'294','San Pablo Huitzo'),(1290,20,'295','San Pablo Huixtepec'),(1291,20,'296','San Pablo Macuiltianguis'),(1292,20,'297','San Pablo Tijaltepec'),(1293,20,'298','San Pablo Villa de Mitla'),(1294,20,'299','San Pablo Yaganiza'),(1295,20,'300','San Pedro Amuzgos'),(1296,20,'301','San Pedro Apóstol'),(1297,20,'302','San Pedro Atoyac'),(1298,20,'303','San Pedro Cajonos'),(1299,20,'304','San Pedro Comitancillo'),(1300,20,'305','San Pedro Cocaltepec Cántaros'),(1301,20,'306','San Pedro el Alto'),(1302,20,'307','San Pedro Huamelula'),(1303,20,'308','San Pedro Huilotepec'),(1304,20,'309','San Pedro Ixcatlán'),(1305,20,'310','San Pedro Ixtlahuaca'),(1306,20,'311','San Pedro Jaltepetongo'),(1307,20,'312','San Pedro Jicayán'),(1308,20,'313','San Pedro Jocotipac'),(1309,20,'314','San Pedro Juchatengo'),(1310,20,'315','San Pedro Mártir'),(1311,20,'316','San Pedro Mártir Quiechapa'),(1312,20,'317','San Pedro Mártir Yucuxaco'),(1313,20,'318','San Pedro Mixtepec, distrito 22'),(1314,20,'319','San Pedro Mixtepec, distrito 26'),(1315,20,'320','San Pedro Molinos'),(1316,20,'321','San Pedro Nopala'),(1317,20,'322','San Pedro Ocopetatillo'),(1318,20,'323','San Pedro Ocotepec'),(1319,20,'324','San Pedro Pochutla'),(1320,20,'325','San Pedro Quiatoni'),(1321,20,'326','San Pedro Sochiápam'),(1322,20,'327','San Pedro Tapanatepec'),(1323,20,'328','San Pedro Taviche'),(1324,20,'329','San Pedro Teozacoalco'),(1325,20,'330','San Pedro Teutila'),(1326,20,'331','San Pedro Tidaá'),(1327,20,'332','San Pedro Topiltepec'),(1328,20,'333','San Pedro Totolápam'),(1329,20,'334','San Pedro y San Pablo Ayutla'),(1330,20,'335','San Pedro y San Pablo Teposcolula'),(1331,20,'336','San Pedro y San Pablo Tequixtepec'),(1332,20,'337','San Pedro Yaneri'),(1333,20,'338','San Pedro Yólox'),(1334,20,'339','San Pedro Yucunama'),(1335,20,'340','San Raymundo Jalpan'),(1336,20,'341','San Sebastián Abasolo'),(1337,20,'342','San Sebastián Coatlán'),(1338,20,'343','San Sebastián Ixcapa'),(1339,20,'344','San Sebastián Nicananduta'),(1340,20,'345','San Sebastián Río Hondo'),(1341,20,'346','San Sebastián Tecomaxtlahuaca'),(1342,20,'347','San Sebastián Teitipac'),(1343,20,'348','San Sebastián Tutla'),(1344,20,'349','San Simón Almolongas'),(1345,20,'350','San Simón Zahuatlán  '),(1346,20,'351','Santa Ana'),(1347,20,'352','Santa Ana Ateixtlahuaca'),(1348,20,'353','Santa Ana Cuauhtémoc'),(1349,20,'354','Santa Ana del Valle'),(1350,20,'355','Santa Ana Tavela'),(1351,20,'356','Santa Ana Tlapacoyan'),(1352,20,'357','Santa Ana Yareni'),(1353,20,'358','Santa Ana Zegache'),(1354,20,'359','Santa Catalina Quieri'),(1355,20,'360','Santa Catarina Cuixtla'),(1356,20,'361','Santa Catarina Ixtepeji'),(1357,20,'362','Santa Catarina Juquila'),(1358,20,'363','Santa Catarina Lachatao'),(1359,20,'364','Santa Catarina Loxicha'),(1360,20,'365','Santa Catarina Mechoacán'),(1361,20,'366','Santa Catarina Minas'),(1362,20,'367','Santa Catarina Quiané'),(1363,20,'368','Santa Catarina Quioquitani'),(1364,20,'369','Santa CatarinaTayata'),(1365,20,'370','Santa Catarina Ticuá'),(1366,20,'371','Santa Catarina Yosonotú'),(1367,20,'372','Santa Catarina Zapoquila'),(1368,20,'373','Santa Cruz Acatepec'),(1369,20,'374','Santa Cruz Amilpas'),(1370,20,'375','Santa Cruz de Bravo'),(1371,20,'376','Santa Cruz Itundujia'),(1372,20,'377','Santa Cruz Mixtepec'),(1373,20,'378','Santa Cruz Nundaco'),(1374,20,'379','Santa Cruz Papalutla'),(1375,20,'380','Santa Cruz Tacache de Mina'),(1376,20,'381','Santa Cruz Tacahua'),(1377,20,'382','Santa Cruz Tayata'),(1378,20,'383','Santa Cruz Xitla'),(1379,20,'384','Santa Cruz Xoxocotlán'),(1380,20,'385','Santa Cruz Zenzontepec'),(1381,20,'386','Santa Gertrudis'),(1382,20,'387','Santa Inés del Monte'),(1383,20,'388','Santa Inés de Zaragoza'),(1384,20,'389','Santa Inés Yatzeche'),(1385,20,'390','Santa Lucía del Camino'),(1386,20,'391','Santa Lucía Miahuatlán'),(1387,20,'392','Santa Lucía Monteverde'),(1388,20,'393','Santa Lucía Ocotlán'),(1389,20,'394','Santa Magdalena Jicotlán'),(1390,20,'395','Santa María Alotepec'),(1391,20,'396','Santa María Apazco'),(1392,20,'397','Santa María Atzompa'),(1393,20,'398','Santa María Camotlán'),(1394,20,'399','Santa María Chachoápam'),(1395,20,'400','Santa María Chilchotla'),(1396,20,'401','Santa María Chimalapa'),(1397,20,'402','Santa María Colotepec'),(1398,20,'403','Santa María Cortijo'),(1399,20,'404','Santa María Coyotepec'),(1400,20,'405','Santa María del Rosario'),(1401,20,'406','Santa María del Tule'),(1402,20,'407','Santa María Ecatepec'),(1403,20,'408','Santa María Guelacé'),(1404,20,'409','Santa María Guienagati'),(1405,20,'410','Santa María Huatulco'),(1406,20,'411','Santa María Huazolotitlán'),(1407,20,'412','Santa María Ipalapa'),(1408,20,'413','Santa María Ixcatlán'),(1409,20,'414','Santa María Jacatepec'),(1410,20,'415','Santa María Jalapa del Marqués'),(1411,20,'416','Santa María Jaltianguis'),(1412,20,'417','Santa María la Asunción'),(1413,20,'418','Santa María Lachixío'),(1414,20,'419','Santa María Mixtequilla'),(1415,20,'420','Santa María Nativitas'),(1416,20,'421','Santa María Nduayaco'),(1417,20,'422','Santa María Ozolotepec'),(1418,20,'423','Santa María Pápalo'),(1419,20,'424','Santa María Peñoles'),(1420,20,'425','Santa María Petapa'),(1421,20,'426','Santa María Quiegolani'),(1422,20,'427','Santa María Sola'),(1423,20,'428','Santa María Tataltepec'),(1424,20,'429','Santa María Tecomavaca'),(1425,20,'430','Santa María Temaxcalapa'),(1426,20,'431','Santa María Temaxcaltepec'),(1427,20,'432','Santa María Teopoxco'),(1428,20,'433','Santa María Tepantlali'),(1429,20,'434','Santa María Texcatitlán'),(1430,20,'435','Santa María Tlahuitoltepec'),(1431,20,'436','Santa María Tlalixtac'),(1432,20,'437','Santa María Tonameca'),(1433,20,'438','Santa María Totolapilla'),(1434,20,'439','Santa María Xadani'),(1435,20,'440','Santa María Yalina'),(1436,20,'441','Santa María Yavesía'),(1437,20,'442','Santa María Yolotepec'),(1438,20,'443','Santa María Yosoyua'),(1439,20,'444','Santa María Yucuhiti'),(1440,20,'445','Santa María Zacatepec'),(1441,20,'446','Santa María Zaniza'),(1442,20,'447','Santa María Zoquitlán'),(1443,20,'448','Santiago Amoltepec'),(1444,20,'449','Santiago Apoala'),(1445,20,'450','Santiago Apóstol'),(1446,20,'451','Santiago Astata'),(1447,20,'452','Santiago Atitlán'),(1448,20,'453','Santiago Ayuquililla'),(1449,20,'454','Santiago Cacaloxtepec'),(1450,20,'455','Santiago Camotlán'),(1451,20,'456','Santiago Chazumba'),(1452,20,'457','Santiago Choápam'),(1453,20,'458','Santiago Comaltepec'),(1454,20,'459','Santiago del Río'),(1455,20,'460','Santiago Huajolotitlán'),(1456,20,'461','Santiago Huauclilla'),(1457,20,'462','Santiago Ihuitlán Plumas'),(1458,20,'463','Santiago Ixcuintepec'),(1459,20,'464','Santiago Ixtayutla'),(1460,20,'465','Santiago Jamiltepec'),(1461,20,'466','Santiago Jocotepec'),(1462,20,'467','Santiago Juxtlahuaca'),(1463,20,'468','Santiago Lachiguiri'),(1464,20,'469','Santiago Lalopa'),(1465,20,'470','Santiago Laollaga'),(1466,20,'471','Santiago Laxopa'),(1467,20,'472','Santiago Llano Grande'),(1468,20,'473','Santiago Matatlán'),(1469,20,'474','Santiago Miltepec'),(1470,20,'475','Santiago Minas'),(1471,20,'476','Santiago Nacaltepec'),(1472,20,'477','Santiago Nejapilla'),(1473,20,'478','Santiago Niltepec'),(1474,20,'479','Santiago Nundiche'),(1475,20,'480','Santiago Nuyoó'),(1476,20,'481','Santiago Pinotepa Nacional'),(1477,20,'482','Santiago Suchilquitongo'),(1478,20,'483','Santiago Tamazola'),(1479,20,'484','Santiago Tapextla'),(1480,20,'485','Santiago Tenango'),(1481,20,'486','Santiago Tepetlapa'),(1482,20,'487','Santiago Tetepec'),(1483,20,'488','Santiago Texcalcingo'),(1484,20,'489','Santiago Textitlán'),(1485,20,'490','Santiago Tilantongo'),(1486,20,'491','Santiago Tillo'),(1487,20,'492','Santiago Tlazoyaltepec'),(1488,20,'493','Santiago Xanica'),(1489,20,'494','Santiago Xiacuí'),(1490,20,'495','Santiago Yaitepec'),(1491,20,'496','Santiago Yaveo'),(1492,20,'497','Santiago Yolomécatl'),(1493,20,'498','Santiago Yosondúa'),(1494,20,'499','Santiago Yucuyachi'),(1495,20,'500','Santiago Zacatepec'),(1496,20,'501','Santiago Zoochila'),(1497,20,'502','Santo Domingo Albarradas'),(1498,20,'503','Santo Domingo Armenta'),(1499,20,'504','Santo Domingo Chihuitán'),(1500,20,'505','Santo Domingo de Morelos'),(1501,20,'506','Santo Domingo Ingenio'),(1502,20,'507','Santo Domingo Ixcatlán'),(1503,20,'508','Santo Domingo Nuxaá'),(1504,20,'509','Santo Domingo Ozolotepec'),(1505,20,'510','Santo Domingo Petapa'),(1506,20,'511','Santo Domingo Roayaga'),(1507,20,'512','Santo Domingo Tehuantepec'),(1508,20,'513','Santo Domingo Teojomulco'),(1509,20,'514','Santo Domingo Tepuxtepec'),(1510,20,'515','Santo Domingo Tlatayapam'),(1511,20,'516','Santo Domingo Tomaltepec'),(1512,20,'517','Santo Domingo Tonalá'),(1513,20,'518','Santo Domingo Tonaltepec'),(1514,20,'519','Santo Domingo Xagacía'),(1515,20,'520','Santo Domingo Yanhuitlán'),(1516,20,'521','Santo Domingo Yodohino'),(1517,20,'522','Santo Domingo Zanatepec'),(1518,20,'523','Santo Tomás Jalieza'),(1519,20,'524','Santo Tomás Mazaltepec'),(1520,20,'525','Santo Tomás Ocotepec'),(1521,20,'526','Santo Tomás Tamazulapan'),(1522,20,'527','Santos Reyes Nopala'),(1523,20,'528','Santos Reyes Pápalo'),(1524,20,'529','Santos Reyes Tepejillo'),(1525,20,'530','Santos Reyes Yucuná'),(1526,20,'531','San Vicente Coatlán'),(1527,20,'532','San Vicente Lachixío'),(1528,20,'533','San Vicente Nuñú'),(1529,20,'534','Silacayoápam'),(1530,20,'535','Sitio de Xitlapehua'),(1531,20,'536','Soledad Etla'),(1532,20,'537','Tamazulápam del Espíritu Santo'),(1533,20,'538','Tanetze de Zaragoza'),(1534,20,'539','Taniche'),(1535,20,'540','Tataltepec de Valdés'),(1536,20,'541','Teococuilco de Marcos Pérez'),(1537,20,'542','Teotitlán de Flores Magón'),(1538,20,'543','Teotitlán del Valle'),(1539,20,'544','Teotongo'),(1540,20,'545','Tepelmeme Villa de Morelos'),(1541,20,'546','Tezoatlán de Segura y Luna'),(1542,20,'547','Tlacolula de Matamoros'),(1543,20,'548','Tlacotepec Plumas'),(1544,20,'549','Tlalixtac de Cabrera'),(1545,20,'550','Totontepec Villa de Morelos'),(1546,20,'551','Trinidad Zaáchila'),(1547,20,'552','Unión Hidalgo'),(1548,20,'553','Valerio Trujano'),(1549,20,'554','Villa de Chilapa de Díaz'),(1550,20,'555','Villa de Etla'),(1551,20,'556','Villa de Tamazulápam del Progreso'),(1552,20,'557','Villa de Tututepec de Melchor Ocampo'),(1553,20,'558','Villa de Zaáchila'),(1554,20,'559','Villa Díaz Ordaz'),(1555,20,'560','Villa Hidalgo'),(1556,20,'561','Villa Sola de Vega'),(1557,20,'562','Villa Talea de Castro'),(1558,20,'563','Villa Tejupam de la Unión'),(1559,20,'564','Yaxe'),(1560,20,'565','Yogana'),(1561,20,'566','Yutanduchi de Guerrero'),(1562,20,'567','Zapotitlán del Río'),(1563,20,'568','Zapotitlán Lagunas'),(1564,20,'569','Zapotitlán Palmas'),(1565,20,'570','Zimatlán de Álvarez'),(1566,21,'001','Acajete'),(1567,21,'002','Acateno'),(1568,21,'003','Acatlán'),(1569,21,'004','Acatzingo'),(1570,21,'005','Acteopan'),(1571,21,'006','Ahuacatlán'),(1572,21,'007','Ahuatlán'),(1573,21,'008','Ahuazotepec'),(1574,21,'009','Ahuehuetitla'),(1575,21,'010','Ajalpan'),(1576,21,'011','Albino Zertuche'),(1577,21,'012','Aljojuca'),(1578,21,'013','Altepexi'),(1579,21,'014','Amixtlán'),(1580,21,'015','Amozoc'),(1581,21,'016','Aquixtla'),(1582,21,'017','Atempan'),(1583,21,'018','Atexcal'),(1584,21,'019','Atlequizayan'),(1585,21,'020','Atlixco'),(1586,21,'021','Atoyatempan'),(1587,21,'022','Atzala'),(1588,21,'023','Atzitzihuacán'),(1589,21,'024','Atzitzintla'),(1590,21,'025','Axutla'),(1591,21,'026','Ayotoxco de Guerrero'),(1592,21,'027','Calpan'),(1593,21,'028','Caltepec'),(1594,21,'029','Camocuautla'),(1595,21,'030','Cañada Morelos'),(1596,21,'031','Caxhuacan'),(1597,21,'032','Chalchicomula de Sesma'),(1598,21,'033','Chapulco'),(1599,21,'034','Chiautla'),(1600,21,'035','Chiautzingo'),(1601,21,'036','Chichiquila'),(1602,21,'037','Chiconcuautla'),(1603,21,'038','Chietla'),(1604,21,'039','Chigmecatitlán'),(1605,21,'040','Chignahuapan'),(1606,21,'041','Chignautla'),(1607,21,'042','Chila'),(1608,21,'043','Chila de la Sal'),(1609,21,'044','Chilchotla'),(1610,21,'045','Chinantla'),(1611,21,'046','Coatepec'),(1612,21,'047','Coatzingo'),(1613,21,'048','Cohetzala'),(1614,21,'049','Cohuecan'),(1615,21,'050','Coronango'),(1616,21,'051','Coxcatlán'),(1617,21,'052','Coyomeapan'),(1618,21,'053','Coyotepec'),(1619,21,'054','Cuapiaxtla de Madero'),(1620,21,'055','Cuautempan'),(1621,21,'056','Cuautinchán'),(1622,21,'057','Cuautlancingo'),(1623,21,'058','Cuayuca de Andradre'),(1624,21,'059','Cuetzalan del Progreso'),(1625,21,'060','Cuyoaco'),(1626,21,'061','Domingo Arenas'),(1627,21,'062','Eloxochitlán'),(1628,21,'063','Epatlán'),(1629,21,'064','Esperanza'),(1630,21,'065','Francisco Z. Mena'),(1631,21,'066','General Felipe Ángeles'),(1632,21,'067','Guadalupe'),(1633,21,'068','Guadalupe Victoria'),(1634,21,'069','Hermenegildo Galeana'),(1635,21,'070','Honey'),(1636,21,'071','Huaquechula'),(1637,21,'072','Huatlatlauca'),(1638,21,'073','Huauchinango'),(1639,21,'074','Huehuetla'),(1640,21,'075','Huehuetlán el Chico'),(1641,21,'076','Huehuetlán el Grande'),(1642,21,'077','Huejotzingo'),(1643,21,'078','Hueyapan'),(1644,21,'079','Hueytamalco'),(1645,21,'080','Hueytlalpan'),(1646,21,'081','Huitzilán de Serdán'),(1647,21,'082','Huitziltepec'),(1648,21,'083','Ixcamilpa de Guerrero'),(1649,21,'084','Ixcaquixtla'),(1650,21,'085','Ixtacamaxtitlán'),(1651,21,'086','Ixtepec'),(1652,21,'087','Izúcar de Matamoros'),(1653,21,'088','Jalpan'),(1654,21,'089','Jolalpan'),(1655,21,'090','Jonotla'),(1656,21,'091','Jopala'),(1657,21,'092','Juan C. Bonilla'),(1658,21,'093','Juan Galindo'),(1659,21,'094','Juan N. Méndez'),(1660,21,'095','Lafragua'),(1661,21,'096','Libres'),(1662,21,'097','Los Reyes de Juárez'),(1663,21,'098','Magdalena Tlatlauquitepec'),(1664,21,'099','Mazapiltepec de Juárez'),(1665,21,'100','Mixtla'),(1666,21,'101','Molcaxac'),(1667,21,'102','Naupan'),(1668,21,'103','Nauzontla'),(1669,21,'104','Nealtican'),(1670,21,'105','Nicolás Bravo'),(1671,21,'106','Nopalucan'),(1672,21,'107','Ocotepec'),(1673,21,'108','Ocoyucan'),(1674,21,'109','Olintla'),(1675,21,'110','Oriental'),(1676,21,'111','Pahuatlán'),(1677,21,'112','Palmar de Bravo'),(1678,21,'113','Pantepec'),(1679,21,'114','Petlalcingo'),(1680,21,'115','Piaxtla'),(1681,21,'116','Puebla de Zaragoza'),(1682,21,'117','Quecholac'),(1683,21,'118','Quimixtlán'),(1684,21,'119','Rafael Lara Grajales'),(1685,21,'120','San Andrés Cholula'),(1686,21,'121','San Antonio Cañada'),(1687,21,'122','San Diego La Meza Tochimiltzingo'),(1688,21,'123','San Felipe Teotlalcingo'),(1689,21,'124','San Felipe Tepatlán'),(1690,21,'125','San Gabriel Chilac'),(1691,21,'126','San Gregorio Atzompa'),(1692,21,'127','San Jerónimo Tecuanipan'),(1693,21,'128','San Jerónimo Xayacatlán'),(1694,21,'129','San José Chiapa'),(1695,21,'130','San José Miahuatlán'),(1696,21,'131','San Juan Atenco'),(1697,21,'132','San Juan Atzompa'),(1698,21,'133','San Martín Texmelucan'),(1699,21,'134','San Martín Totoltepec'),(1700,21,'135','San Matías Tlalancaleca'),(1701,21,'136','San Miguel Ixtitlán'),(1702,21,'137','San Miguel Xoxtla'),(1703,21,'138','San Nicolás Buenos Aires'),(1704,21,'139','San Nicolás de los Ranchos'),(1705,21,'140','San Pablo Anicano'),(1706,21,'141','San Pedro Cholula'),(1707,21,'142','San Pedro Yeloixtlahuaca'),(1708,21,'143','San Salvador el Seco'),(1709,21,'144','San Salvador el Verde'),(1710,21,'145','San Salvador Huixcolotla'),(1711,21,'146','San Sebastián Tlacotepec'),(1712,21,'147','Santa Catarina Tlaltempan'),(1713,21,'148','San Inés Ahuatempan'),(1714,21,'149','Santa Isabel Cholula'),(1715,21,'150','Santiago Miahuatlán '),(1716,21,'151','Santo Tomás Hueyotlipan'),(1717,21,'152','Soltepec'),(1718,21,'153','Tecali de Herrera'),(1719,21,'154','Tecamachalco'),(1720,21,'155','Tecomatlán'),(1721,21,'156','Tehuacán'),(1722,21,'157','Tehuitzingo'),(1723,21,'158','Tenampulco'),(1724,21,'159','Teopantlán'),(1725,21,'160','Teotlalco'),(1726,21,'161','Tepanco de López'),(1727,21,'162','Tepango de Rodríguez'),(1728,21,'163','Tepatlaxco de Hidalgo'),(1729,21,'164','Tepeaca'),(1730,21,'165','Tepemaxalco'),(1731,21,'166','Tepeojuma'),(1732,21,'167','Tepetzintla'),(1733,21,'168','Tepexco'),(1734,21,'169','Tepexi de Rodríguez'),(1735,21,'170','Tepeyahualco'),(1736,21,'171','Tepeyahualco de Cuauhtémoc'),(1737,21,'172','Tetela de Ocampo'),(1738,21,'173','Teteles de Ávila Castillo'),(1739,21,'174','Teziutlán'),(1740,21,'175','Tianguismanalco'),(1741,21,'176','Tilapa'),(1742,21,'177','Tlacotepec de Benito Juárez'),(1743,21,'178','Tlacuilotepec'),(1744,21,'179','Tlachichuca'),(1745,21,'180','Tlahuapan'),(1746,21,'181','Tlaltenango'),(1747,21,'182','Tlanepantla'),(1748,21,'183','Tlaola'),(1749,21,'184','Tlapacoya'),(1750,21,'185','Tlapanalá'),(1751,21,'186','Tlatlauquitepec'),(1752,21,'187','Tlaxco'),(1753,21,'188','Tochimilco'),(1754,21,'189','Tochtepec'),(1755,21,'190','Totoltepec de Guerrero'),(1756,21,'191','Tulcingo'),(1757,21,'192','Tuzamapan de Galeana'),(1758,21,'193','Tzicatlacoyan'),(1759,21,'194','Venustiano Carranza'),(1760,21,'195','Vicente Guerrero'),(1761,21,'196','Xayacatlán de Bravo'),(1762,21,'197','Xicotepec'),(1763,21,'198','Xicotlán'),(1764,21,'199','Xiutetelco'),(1765,21,'200','Xochiapulco'),(1766,21,'201','Xochiltepec'),(1767,21,'202','Xochitlán de Vicente Suárez'),(1768,21,'203','Xochitlán Todos Santos'),(1769,21,'204','Yaonahuac'),(1770,21,'205','Yehualtepec'),(1771,21,'206','Zacapala'),(1772,21,'207','Zacapoaxtla'),(1773,21,'208','Zacatlán'),(1774,21,'209','Zapotitlán'),(1775,21,'210','Zapotitlán de Méndez'),(1776,21,'211','Zaragoza'),(1777,21,'212','Zautla'),(1778,21,'213','Zihuateutla'),(1779,21,'214','Zinacatepec'),(1780,21,'215','Zongozotla'),(1781,21,'216','Zoquiapan'),(1782,21,'217','Zoquitlán'),(1783,22,'001','Amealco de Bonfil'),(1784,22,'002','Arroyo Seco'),(1785,22,'003','Cadereyta de Montes'),(1786,22,'004','Colón'),(1787,22,'005','Corregidora'),(1788,22,'006','El Marqués'),(1789,22,'007','Ezequiel Montes'),(1790,22,'008','Huimilpan'),(1791,22,'009','Jalpan de Serra'),(1792,22,'010','Landa de Matamoros'),(1793,22,'011','Pedro Escobedo'),(1794,22,'012','Peñamiller'),(1795,22,'013','Pinal de Amoles'),(1796,22,'014','Querétaro'),(1797,22,'015','San Joaquín'),(1798,22,'016','San Juan del Río'),(1799,22,'017','Tequisquiapan'),(1800,22,'018','Tolimán'),(1801,23,'001','Benito Juárez'),(1802,23,'002','Cozumel'),(1803,23,'003','Felipe Carrillo Puerto'),(1804,23,'004','Isla Mujeres'),(1805,23,'005','José María Morelos'),(1806,23,'006','Lázaro Cárdenas'),(1807,23,'007','Othon P. Blanco'),(1808,23,'008','Solidaridad'),(1809,23,'009','Tulum'),(1810,24,'001','Ahualulco'),(1811,24,'002','Alaquines'),(1812,24,'003','Aquismón'),(1813,24,'004','Armadillo de los Infante'),(1814,24,'005','Axtla de Terrazas'),(1815,24,'006','Cárdenas'),(1816,24,'007','Catorce'),(1817,24,'008','Cedral'),(1818,24,'009','Cerritos'),(1819,24,'010','Cerro de San Pedro'),(1820,24,'011','Charcas'),(1821,24,'012','Ciudad del Maíz'),(1822,24,'013','Ciudad Fernández'),(1823,24,'014','Ciudad Valles'),(1824,24,'015','Coxcatlán'),(1825,24,'016','Ebano'),(1826,24,'017','El Naranjo'),(1827,24,'018','Guadalcázar'),(1828,24,'019','Huehuetlán'),(1829,24,'020','Lagunillas'),(1830,24,'021','Matehuala'),(1831,24,'022','Matlapa'),(1832,24,'023','Mexquitic de Carmona'),(1833,24,'024','Moctezuma'),(1834,24,'025','Rayón'),(1835,24,'026','Rioverde'),(1836,24,'027','Salinas'),(1837,24,'028','San Antonio'),(1838,24,'029','San Ciro de Acosta'),(1839,24,'030','San Luis Potosí'),(1840,24,'031','San Martín Chalchicuautla'),(1841,24,'032','San Nicolás Tolentino'),(1842,24,'033','Santa Catarina'),(1843,24,'034','Santa María del Río'),(1844,24,'035','Santo Domingo'),(1845,24,'036','San Vicente Tancuayalab'),(1846,24,'037','Soledad de Graciano Sánchez'),(1847,24,'038','Tamasopo'),(1848,24,'039','Tamazunchale'),(1849,24,'040','Tampacán'),(1850,24,'041','Tampamolón Corona'),(1851,24,'042','Tamuín'),(1852,24,'043','Tancanhuitz de Santos'),(1853,24,'044','Tanlajás'),(1854,24,'045','Tanquián de Escobedo'),(1855,24,'046','Tierra Nueva'),(1856,24,'047','Vanegas'),(1857,24,'048','Venado'),(1858,24,'049','Villa de Arriaga'),(1859,24,'050','Villa de Arista'),(1860,24,'051','Villa de Guadalupe'),(1861,24,'052','Villa de la Paz'),(1862,24,'053','Villa de Ramos'),(1863,24,'054','Villa de Reyes'),(1864,24,'055','Villa Hidalgo'),(1865,24,'056','Villa Juárez'),(1866,24,'057','Xilitla'),(1867,24,'058','Zaragoza'),(1868,25,'001','Ahome'),(1869,25,'002','Angostura'),(1870,25,'003','Badiraguato'),(1871,25,'004','Choix'),(1872,25,'005','Concordia'),(1873,25,'006','Cosalá'),(1874,25,'007','Culiacán'),(1875,25,'008','El Fuerte'),(1876,25,'009','Elota'),(1877,25,'010','El Rosario'),(1878,25,'011','Escuinapa'),(1879,25,'012','Guasave'),(1880,25,'013','Mazatlán'),(1881,25,'014','Mocorito'),(1882,25,'015','Navolato'),(1883,25,'016','Salvador Alvarado'),(1884,25,'017','San Ignacio'),(1885,25,'018','Sinaloa de Leyva'),(1886,26,'001','Aconchi'),(1887,26,'002','Agua Prieta'),(1888,26,'003','Alamos'),(1889,26,'004','Altar'),(1890,26,'005','Arivechi'),(1891,26,'006','Arizpe'),(1892,26,'007','Atil'),(1893,26,'008','Bacadéhuachi'),(1894,26,'009','Bacanora'),(1895,26,'010','Bacerac'),(1896,26,'011','Bacoachi'),(1897,26,'012','Bácum'),(1898,26,'013','Banámichi'),(1899,26,'014','Baviácora'),(1900,26,'015','Bavíspe'),(1901,26,'016','Benito Juárez'),(1902,26,'017','Benjamín Hill'),(1903,26,'018','Caborca'),(1904,26,'019','Cajeme'),(1905,26,'020','Cananea'),(1906,26,'021','Carbó'),(1907,26,'022','Cocurpe'),(1908,26,'023','Cumpas'),(1909,26,'024','Divisaderos'),(1910,26,'025','Empalme'),(1911,26,'026','Etchojoa'),(1912,26,'027','Fronteras'),(1913,26,'028','General Plutarco Elías Calles'),(1914,26,'029','Granados'),(1915,26,'030','Guaymas'),(1916,26,'031','Hermosillo'),(1917,26,'032','Huachinera'),(1918,26,'033','Huásabas'),(1919,26,'034','Huatabampo'),(1920,26,'035','Huépac'),(1921,26,'036','Imuris'),(1922,26,'037','La Colorada'),(1923,26,'038','Magdalena'),(1924,26,'039','Mazatán'),(1925,26,'040','Moctezuma'),(1926,26,'041','Naco'),(1927,26,'042','Nácori Chico'),(1928,26,'043','Nacozari de García'),(1929,26,'044','Navojoa'),(1930,26,'045','Nogales'),(1931,26,'046','Onavas'),(1932,26,'047','Opodepe'),(1933,26,'048','Oquitoa'),(1934,26,'049','Pitiquito'),(1935,26,'050','Puerto Peñasco'),(1936,26,'051','Quiriego'),(1937,26,'052','Rayón'),(1938,26,'053','Rosario'),(1939,26,'054','Sahuaripa'),(1940,26,'055','San Felipe de Jesús'),(1941,26,'056','San Ignacio Río Muerto'),(1942,26,'057','San Javier'),(1943,26,'058','San Luis Río Colorado'),(1944,26,'059','San Miguel de Horcasitas'),(1945,26,'060','San Pedro de la Cueva'),(1946,26,'061','Santa Ana'),(1947,26,'062','Santa Cruz'),(1948,26,'063','Sáric'),(1949,26,'064','Soyopa'),(1950,26,'065','Suaqui Grande'),(1951,26,'066','Tepache'),(1952,26,'067','Trincheras'),(1953,26,'068','Tubutama'),(1954,26,'069','Ures'),(1955,26,'070','Villa Hidalgo'),(1956,26,'071','Villa Pesqueira'),(1957,26,'072','Yécora'),(1958,27,'001','Balancán'),(1959,27,'002','Cárdenas'),(1960,27,'003','Centla'),(1961,27,'004','Centro'),(1962,27,'005','Comalcalco'),(1963,27,'006','Cunduacán'),(1964,27,'007','Emiliano Zapata'),(1965,27,'008','Huimanguillo'),(1966,27,'009','Jalapa'),(1967,27,'010','Jalpa de Méndez'),(1968,27,'011','Jonuta'),(1969,27,'012','Macuspana'),(1970,27,'013','Nacajuca'),(1971,27,'014','Paraíso'),(1972,27,'015','Tacotalpa'),(1973,27,'016','Teapa'),(1974,27,'017','Tenosique'),(1975,28,'001','Abasolo'),(1976,28,'002','Aldama'),(1977,28,'003','Altamira'),(1978,28,'004','Antiguo Morelos'),(1979,28,'005','Burgos'),(1980,28,'006','Bustamante'),(1981,28,'007','Camargo'),(1982,28,'008','Casas'),(1983,28,'009','Ciudad Madero'),(1984,28,'010','Cruillas'),(1985,28,'011','Gómez Farías'),(1986,28,'012','González'),(1987,28,'013','Güemez'),(1988,28,'014','Guerrero'),(1989,28,'015','Gustavo Díaz Ordaz'),(1990,28,'016','Hidalgo'),(1991,28,'017','Jaumave'),(1992,28,'018','Jiménez'),(1993,28,'019','Llera'),(1994,28,'020','Mainero'),(1995,28,'021','Mante'),(1996,28,'022','Matamoros'),(1997,28,'023','Méndez'),(1998,28,'024','Mier'),(1999,28,'025','Miguel Alemán'),(2000,28,'026','Miquihuana'),(2001,28,'027','Nuevo Laredo'),(2002,28,'028','Nuevo Morelos'),(2003,28,'029','Ocampo'),(2004,28,'030','Padilla'),(2005,28,'031','Palmillas'),(2006,28,'032','Reynosa'),(2007,28,'033','Río Bravo'),(2008,28,'034','San Carlos'),(2009,28,'035','San Fernando'),(2010,28,'036','San Nicolás'),(2011,28,'037','Soto La Marina'),(2012,28,'038','Tampico'),(2013,28,'039','Tula'),(2014,28,'040','Valle Hermoso'),(2015,28,'041','Victoria'),(2016,28,'042','Villagrán'),(2017,28,'043','Xicotencatl'),(2018,29,'001','Acuamanala de Miguel Hidalgo'),(2019,29,'002','Altzayanca'),(2020,29,'003','Amaxac de Guerrero'),(2021,29,'004','Apetatitlán de Antonio Carvajal'),(2022,29,'005','Atlangatepec'),(2023,29,'006','Apizaco'),(2024,29,'007','Benito Juárez'),(2025,29,'008','Calpulalpan'),(2026,29,'009','Chiautempan'),(2027,29,'010','Contla de Juan Cuamatzi'),(2028,29,'011','Cuapiaxtla'),(2029,29,'012','Cuaxomulco'),(2030,29,'013','El Carmen Tequexquitla'),(2031,29,'014','Emiliano Zapata'),(2032,29,'015','Españita'),(2033,29,'016','Huamantla'),(2034,29,'017','Hueyotlipan'),(2035,29,'018','Ixtacuixtla de Mariano Matamoros'),(2036,29,'019','Ixtenco'),(2037,29,'020','La Magdalena Tlaltelulco'),(2038,29,'021','Lázaro Cárdenas'),(2039,29,'022','Mazatecochco de José María Morelos'),(2040,29,'023','Muñoz de Domingo Arenas'),(2041,29,'024','Nanacamilpa de Mariano Arista'),(2042,29,'025','Nativitas'),(2043,29,'026','Panotla'),(2044,29,'027','Papalotla de Xicohténcatl'),(2045,29,'028','Sanctorum de Lázaro Cárdenas'),(2046,29,'029','San Damián Texoloc'),(2047,29,'030','San Francisco Tetlanohcan'),(2048,29,'031','San Jerónimo Zacualpan'),(2049,29,'032','San José Teacalco'),(2050,29,'033','San Juan Huactzinco'),(2051,29,'034','San Lorenzo Axocomanitla'),(2052,29,'035','San Lucas Tecopilco'),(2053,29,'036','San Pablo del Monte'),(2054,29,'037','Santa Ana Nopalucan'),(2055,29,'038','Santa Apolonia Teacalco'),(2056,29,'039','Santa Catarina Ayometla'),(2057,29,'040','Santa Cruz Quilehtla'),(2058,29,'041','Santa Cruz Tlaxcala'),(2059,29,'042','Santa Isabel Xiloxoxtla'),(2060,29,'043','Tenancingo'),(2061,29,'044','Teolocholco'),(2062,29,'045','Tepetitla de Lardizábal'),(2063,29,'046','Tepeyanco'),(2064,29,'047','Terrenate'),(2065,29,'048','Tetla de la Solidaridad'),(2066,29,'049','Tetlatlahuca'),(2067,29,'050','Tlaxcala'),(2068,29,'051','Tlaxco'),(2069,29,'052','Tocatlán'),(2070,29,'053','Totolac'),(2071,29,'054','Tzompantepec'),(2072,29,'055','Xaloztoc'),(2073,29,'056','Xaltocan'),(2074,29,'057','Xicohtzinco'),(2075,29,'058','Yauhquemecan'),(2076,29,'059','Zacatelco'),(2077,29,'060','Zitlaltepec de Trinidad Sánchez Santos'),(2078,30,'001','Acajete'),(2079,30,'002','Acatlán'),(2080,30,'003','Acayucan'),(2081,30,'004','Actopan'),(2082,30,'005','Acula'),(2083,30,'006','Acultzingo'),(2084,30,'007','Agua Dulce'),(2085,30,'008','Álamo Temapache'),(2086,30,'009','Alpatláhuac'),(2087,30,'010','Alto Lucero de Gutiérrez Barrios'),(2088,30,'011','Altotonga'),(2089,30,'012','Alvarado'),(2090,30,'013','Amatitlán'),(2091,30,'014','Amatlán de los Reyes'),(2092,30,'015','Ángel R. Cabada'),(2093,30,'016','Apazapan'),(2094,30,'017','Aquila'),(2095,30,'018','Astacinga'),(2096,30,'019','Atlahuilco'),(2097,30,'020','Atoyac'),(2098,30,'021','Atzacan'),(2099,30,'022','Atzalan'),(2100,30,'023','Ayahualulco'),(2101,30,'024','Banderilla'),(2102,30,'025','Benito Juárez'),(2103,30,'026','Boca del Río'),(2104,30,'027','Calcahualco'),(2105,30,'028','Camarón de Tejeda'),(2106,30,'029','Camerino Z. Mendoza'),(2107,30,'030','Carlos A. Carrillo'),(2108,30,'031','Carrillo Puerto'),(2109,30,'032','Castillo de Teayo'),(2110,30,'033','Catemaco'),(2111,30,'034','Cazones de Herrera'),(2112,30,'035','Cerro Azul'),(2113,30,'036','Chacaltianguis'),(2114,30,'037','Chalma'),(2115,30,'038','Chiconamel'),(2116,30,'039','Chiconquiaco'),(2117,30,'040','Chicontepec'),(2118,30,'041','Chinameca'),(2119,30,'042','Chinampa de Gorostiza'),(2120,30,'043','Chocamán'),(2121,30,'044','Chontla'),(2122,30,'045','Chumatlán'),(2123,30,'046','Citlaltépetl'),(2124,30,'047','Coacoatzintla'),(2125,30,'048','Coahuitlán'),(2126,30,'049','Coatepec'),(2127,30,'050','Coatzacoalcos'),(2128,30,'051','Coatzintla'),(2129,30,'052','Coetzala'),(2130,30,'053','Colipa'),(2131,30,'054','Comapa'),(2132,30,'055','Córdoba'),(2133,30,'056','Cosamaloapan de Carpio'),(2134,30,'057','Consautlán de Carvajal'),(2135,30,'058','Coscomatepec'),(2136,30,'059','Cosoleacaque'),(2137,30,'060','Cotaxtla'),(2138,30,'061','Coxquihui'),(2139,30,'062','Coyutla'),(2140,30,'063','Cuichapa'),(2141,30,'064','Cuitláhuac'),(2142,30,'065','El Higo'),(2143,30,'066','Emiliano Zapata'),(2144,30,'067','Espinal'),(2145,30,'068','Filomeno Mata'),(2146,30,'069','Fortín'),(2147,30,'070','Gutiérrez Zamora'),(2148,30,'071','Hidalgotitlán'),(2149,30,'072','Huayacocotla'),(2150,30,'073','Hueyapan de Ocampo'),(2151,30,'074','Huiloapan de Cuauhtémoc'),(2152,30,'075','Ignacio de la Llave'),(2153,30,'076','Ilamatlán'),(2154,30,'077','Isla'),(2155,30,'078','Ixcatepec'),(2156,30,'079','Ixhuacán de los Reyes'),(2157,30,'080','Ixhuatlancillo'),(2158,30,'081','Ixhuatlán del Café'),(2159,30,'082','Ixhuatlán de Madero'),(2160,30,'083','Ixhuatlán del Sureste'),(2161,30,'084','Ixmatlahuacan'),(2162,30,'085','Ixtaczoquitlán'),(2163,30,'086','Jalacingo'),(2164,30,'087','Jalcomulco'),(2165,30,'088','Jáltipan'),(2166,30,'089','Jamapa'),(2167,30,'090','Jesús Carranza'),(2168,30,'091','Jilotepec'),(2169,30,'092','José Azueta'),(2170,30,'093','Juan Rodríguez Clara'),(2171,30,'094','Juchique de Ferrer'),(2172,30,'095','La Antigua'),(2173,30,'096','Landero y Coss'),(2174,30,'097','La Perla'),(2175,30,'098','Las Choapas'),(2176,30,'099','Las Minas'),(2177,30,'100','Las Vigas de Ramírez'),(2178,30,'101','Lerdo de Tejada'),(2179,30,'102','Los Reyes'),(2180,30,'103','Magdalena'),(2181,30,'104','Maltrata'),(2182,30,'105','Manlio Fabio Altamirano'),(2183,30,'106','Mariano Escobedo'),(2184,30,'107','Martínez de la Torre'),(2185,30,'108','Mecatlán'),(2186,30,'109','Mecayapan'),(2187,30,'110','Medellín'),(2188,30,'111','Miahuatlán'),(2189,30,'112','Minatitlán'),(2190,30,'113','Misantla'),(2191,30,'114','Mixtla de Altamirano'),(2192,30,'115','Moloacán'),(2193,30,'116','Nanchital de Lázaro Cárdenas del Río'),(2194,30,'117','Naolinco'),(2195,30,'118','Naranjal'),(2196,30,'119','Naranjos Amatlán'),(2197,30,'120','Nautla'),(2198,30,'121','Nogales'),(2199,30,'122','Oluta'),(2200,30,'123','Omealca'),(2201,30,'124','Orizaba'),(2202,30,'125','Otatitlán'),(2203,30,'126','Oteapan'),(2204,30,'127','Ozuluama de Mascañeras'),(2205,30,'128','Pajapan'),(2206,30,'129','Pánuco'),(2207,30,'130','Papantla'),(2208,30,'131','Paso del Macho'),(2209,30,'132','Paso de Ovejas'),(2210,30,'133','Perote'),(2211,30,'134','Platón Sánchez'),(2212,30,'135','Playa Vicente'),(2213,30,'136','Poza Rica de Hidalgo'),(2214,30,'137','Pueblo Viejo'),(2215,30,'138','Puente Nacional'),(2216,30,'139','Rafael Delgado'),(2217,30,'140','Rafael Lucio'),(2218,30,'141','Río Blanco'),(2219,30,'142','Saltabarranca'),(2220,30,'143','San Andrés Tenejapan'),(2221,30,'144','San Andrés Tuxtla'),(2222,30,'145','San Juan Evangelista'),(2223,30,'146','San Rafael'),(2224,30,'147','Santiago Sochiapan'),(2225,30,'148','Santiago Tuxtla'),(2226,30,'149','Sayula de Alemán'),(2227,30,'150','Soconusco'),(2228,30,'151','Sochiapa'),(2229,30,'152','Soledad Atzompa'),(2230,30,'153','Soledad de Doblado'),(2231,30,'154','Soteapan'),(2232,30,'155','Tamalín'),(2233,30,'156','Tamiahua'),(2234,30,'157','Tampico Alto'),(2235,30,'158','Tancoco'),(2236,30,'159','Tantima'),(2237,30,'160','Tantoyuca'),(2238,30,'161','Tatatila'),(2239,30,'162','Tatahuicapan de Juárez'),(2240,30,'163','Tecolutla'),(2241,30,'164','Tehuipango'),(2242,30,'165','Tempoal'),(2243,30,'166','Tenampa'),(2244,30,'167','Tenochtitlán'),(2245,30,'168','Teocelo'),(2246,30,'169','Tepatlaxco'),(2247,30,'170','Tepetlán'),(2248,30,'171','Tepetzintla'),(2249,30,'172','Tequila'),(2250,30,'173','Texcatepec'),(2251,30,'174','Texhuacán'),(2252,30,'175','Texistepec'),(2253,30,'176','Tezonapa'),(2254,30,'177','Tihuatlán'),(2255,30,'178','Tierra Blanca'),(2256,30,'179','Tlacojalpan'),(2257,30,'180','Tlacolulan'),(2258,30,'181','Tlacotalpan'),(2259,30,'182','Tlacotepec de Mejía'),(2260,30,'183','Tlachichilco'),(2261,30,'184','Tlalixcoyan'),(2262,30,'185','Tlalnelhuayocan'),(2263,30,'186','Tlaltetela'),(2264,30,'187','Tlapacoyan'),(2265,30,'188','Tlaquilpa'),(2266,30,'189','Tlilapan'),(2267,30,'190','Tomatlán'),(2268,30,'191','Tonayán'),(2269,30,'192','Totutla'),(2270,30,'193','Tres Valles'),(2271,30,'194','Tuxpan'),(2272,30,'195','Tuxtilla'),(2273,30,'196','Úrsulo Galván'),(2274,30,'197','Uxpanapa'),(2275,30,'198','Vega de Alatorre'),(2276,30,'199','Veracruz'),(2277,30,'200','Villa Aldama'),(2278,30,'201','Xalapa'),(2279,30,'202','Xico'),(2280,30,'203','Xoxocotla'),(2281,30,'204','Yanga'),(2282,30,'205','Yecuatla'),(2283,30,'206','Zacualpan'),(2284,30,'207','Zaragoza'),(2285,30,'208','Zentla'),(2286,30,'209','Zongolica'),(2287,30,'210','Zontecomatlán'),(2288,30,'211','Zozocolco de Hidalgo'),(2289,31,'001','Abalá'),(2290,31,'002','Acanceh'),(2291,31,'003','Akil'),(2292,31,'004','Baca'),(2293,31,'005','Bokobá'),(2294,31,'006','Buctzotz'),(2295,31,'007','Cacalchén'),(2296,31,'008','Calotmul'),(2297,31,'009','Cansahcab'),(2298,31,'010','Cantamayec'),(2299,31,'011','Calestún'),(2300,31,'012','Cenotillo'),(2301,31,'013','Conkal'),(2302,31,'014','Cuncunul'),(2303,31,'015','Cuzamá'),(2304,31,'016','Chacsinkín'),(2305,31,'017','Chankom'),(2306,31,'018','Chapab'),(2307,31,'019','Chemax'),(2308,31,'020','Chicxulub Pueblo'),(2309,31,'021','Chichimilá'),(2310,31,'022','Chikindzonot'),(2311,31,'023','Chocholá'),(2312,31,'024','Chumayel'),(2313,31,'025','Dzán'),(2314,31,'026','Dzemul'),(2315,31,'027','Dzidzantún'),(2316,31,'028','Dzilam de Bravo'),(2317,31,'029','Dzilam González'),(2318,31,'030','Dzitás'),(2319,31,'031','Dzoncauich'),(2320,31,'032','Espita'),(2321,31,'033','Halachó'),(2322,31,'034','Hocabá'),(2323,31,'035','Hoctún'),(2324,31,'036','Homún'),(2325,31,'037','Huhí'),(2326,31,'038','Hunucmá'),(2327,31,'039','Ixtil'),(2328,31,'040','Izamal'),(2329,31,'041','Kanasín'),(2330,31,'042','Kantunil'),(2331,31,'043','Kaua'),(2332,31,'044','Kinchil'),(2333,31,'045','Kopomá'),(2334,31,'046','Mama'),(2335,31,'047','Maní'),(2336,31,'048','Maxcanú'),(2337,31,'049','Mayapán'),(2338,31,'050','Mérida'),(2339,31,'051','Mocochá'),(2340,31,'052','Motul'),(2341,31,'053','Muna'),(2342,31,'054','Muxupip'),(2343,31,'055','Opichén'),(2344,31,'056','Oxkutzcab'),(2345,31,'057','Panabá'),(2346,31,'058','Peto'),(2347,31,'059','Progreso'),(2348,31,'060','Quintana Roo'),(2349,31,'061','Río Lagartos'),(2350,31,'062','Sacalum'),(2351,31,'063','Samahil'),(2352,31,'064','Sanahcat'),(2353,31,'065','San Felipe'),(2354,31,'066','Santa Elena'),(2355,31,'067','Seyé'),(2356,31,'068','Sinanché'),(2357,31,'069','Sotuta'),(2358,31,'070','Sucilá'),(2359,31,'071','Sudzal'),(2360,31,'072','Suma de Hidalgo'),(2361,31,'073','Tahdziú'),(2362,31,'074','Tahmek'),(2363,31,'075','Teabo'),(2364,31,'076','Tecoh'),(2365,31,'077','Tekal de Venegas'),(2366,31,'078','Tekantó'),(2367,31,'079','Tekax'),(2368,31,'080','Tekit'),(2369,31,'081','Tekom'),(2370,31,'082','Telchac Pueblo'),(2371,31,'083','Telchac Puerto'),(2372,31,'084','Temax'),(2373,31,'085','Temozón'),(2374,31,'086','Tepakán'),(2375,31,'087','Tetiz'),(2376,31,'088','Teya'),(2377,31,'089','Ticul'),(2378,31,'090','Timucuy'),(2379,31,'091','Tinúm'),(2380,31,'092','Tixcacalcupul'),(2381,31,'093','Tixkokob'),(2382,31,'094','Tixméhuac'),(2383,31,'095','Tixpéhual'),(2384,31,'096','Tizimín'),(2385,31,'097','Tunkás'),(2386,31,'098','Tzucacab'),(2387,31,'099','Uayma'),(2388,31,'100','Ucú'),(2389,31,'101','Umán'),(2390,31,'102','Valladolid'),(2391,31,'103','Xocchel'),(2392,31,'104','Yaxcabá'),(2393,31,'105','Yaxkukul'),(2394,31,'106','Yobaín'),(2395,32,'001','Apozol'),(2396,32,'002','Apulco'),(2397,32,'003','Atolinga'),(2398,32,'004','Benito Juárez'),(2399,32,'005','Calera'),(2400,32,'006','Cañitas de Felipe Pescador'),(2401,32,'007','Concepción del Oro'),(2402,32,'008','Cuauhtémoc'),(2403,32,'009','Chalchihuites'),(2404,32,'010','Fresnillo'),(2405,32,'011','Trinidad García de la Cadena'),(2406,32,'012','Genaro Codina'),(2407,32,'013','General Enrique Estrada'),(2408,32,'014','General Francisco R. Murguía'),(2409,32,'015','El Plateado de Joaquín Amaro'),(2410,32,'016','El Salvador'),(2411,32,'017','General Pánfilo Natera'),(2412,32,'018','Guadalupe'),(2413,32,'019','Huanusco'),(2414,32,'020','Jalpa'),(2415,32,'021','Jerez'),(2416,32,'022','Jiménez del Teul'),(2417,32,'023','Juan Aldama'),(2418,32,'024','Juchipila'),(2419,32,'025','Loreto'),(2420,32,'026','Luis Moya'),(2421,32,'027','Mazapil'),(2422,32,'028','Melchor Ocampo'),(2423,32,'029','Mezquital del Oro'),(2424,32,'030','Miguel Auza'),(2425,32,'031','Momax'),(2426,32,'032','Monte Escobedo'),(2427,32,'033','Morelos'),(2428,32,'034','Moyahua de Estrada'),(2429,32,'035','Nochistlán de Mejía'),(2430,32,'036','Noria de Ángeles'),(2431,32,'037','Ojocaliente'),(2432,32,'038','Pánuco'),(2433,32,'039','Pinos'),(2434,32,'040','Río Grande'),(2435,32,'041','Sain Alto'),(2436,32,'042','Santa María de la Paz'),(2437,32,'043','Sombrerete'),(2438,32,'044','Susticacán'),(2439,32,'045','Tabasco'),(2440,32,'046','Tepechitlán'),(2441,32,'047','Tepetongo'),(2442,32,'048','Teul de González Ortega'),(2443,32,'049','Tlaltenango de Sánchez Román'),(2444,32,'050','Trancoso'),(2445,32,'051','Valparaíso'),(2446,32,'052','Vetagrande'),(2447,32,'053','Villa de Cos'),(2448,32,'054','Villa García'),(2449,32,'055','Villa González Ortega'),(2450,32,'056','Villa Hidalgo'),(2451,32,'057','Villanueva'),(2452,32,'058','Zacatecas');
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
  `claveOpcion` text NOT NULL,
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
  `idEmpresas` int(11) NOT NULL,
  `parametro` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  PRIMARY KEY (`idParametro`),
  KEY `fk_Parametro_Empresas1_idx` (`idEmpresas`),
  CONSTRAINT `fk_Parametro_Empresas1` FOREIGN KEY (`idEmpresas`) REFERENCES `empresas` (`idEmpresas`) ON DELETE NO ACTION ON UPDATE NO ACTION
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
  `clavePregunta` text NOT NULL,
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
  `claveRegistro` varchar(20) NOT NULL,
  `referencia` text NOT NULL,
  `tipo` varchar(1) NOT NULL,
  `fechaAlta` datetime NOT NULL,
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
  `claveSeccion` text NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telefono`
--

LOCK TABLES `telefono` WRITE;
/*!40000 ALTER TABLE `telefono` DISABLE KEYS */;
INSERT INTO `telefono` VALUES (1,'01','50-03-29-90','-'),(2,'01','50-0329-93','-'),(3,'01','50-25-12-07','-'),(4,'01','50-25-15-79','-'),(5,'01','50-03-29-94','-'),(6,'01','0','-'),(7,'01','0','-'),(8,'01','59323113','-');
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

-- Dump completed on 2016-01-26 19:32:11
