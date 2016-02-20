CREATE DATABASE  IF NOT EXISTS `General` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `General`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: 192.168.1.5    Database: General
-- ------------------------------------------------------
-- Server version	5.5.47-0ubuntu0.14.04.1

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
-- Table structure for table `Banco`
--

DROP TABLE IF EXISTS `Banco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Banco` (
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
-- Dumping data for table `Banco`
--

LOCK TABLES `Banco` WRITE;
/*!40000 ALTER TABLE `Banco` DISABLE KEYS */;
/*!40000 ALTER TABLE `Banco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BancosEmpresa`
--

DROP TABLE IF EXISTS `BancosEmpresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BancosEmpresa` (
  `idBancosEmpresa` int(11) NOT NULL AUTO_INCREMENT,
  `idEmpresa` int(11) NOT NULL,
  `idBanco` int(11) NOT NULL,
  PRIMARY KEY (`idBancosEmpresa`),
  KEY `fk_BancosEmpresa_Empresa1_idx` (`idEmpresa`),
  KEY `fk_BancosEmpresa_Banco1_idx` (`idBanco`),
  CONSTRAINT `fk_BancosEmpresa_Banco1` FOREIGN KEY (`idBanco`) REFERENCES `Banco` (`idBanco`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_BancosEmpresa_Empresa1` FOREIGN KEY (`idEmpresa`) REFERENCES `Empresa` (`idEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BancosEmpresa`
--

LOCK TABLES `BancosEmpresa` WRITE;
/*!40000 ALTER TABLE `BancosEmpresa` DISABLE KEYS */;
/*!40000 ALTER TABLE `BancosEmpresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Capas`
--

DROP TABLE IF EXISTS `Capas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Capas` (
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
  CONSTRAINT `fk_Capas_Divisa1` FOREIGN KEY (`idDivisa`) REFERENCES `Divisa` (`idDivisa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Capas_Producto1` FOREIGN KEY (`idProducto`) REFERENCES `Producto` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Capas`
--

LOCK TABLES `Capas` WRITE;
/*!40000 ALTER TABLE `Capas` DISABLE KEYS */;
/*!40000 ALTER TABLE `Capas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Cardex`
--

DROP TABLE IF EXISTS `Cardex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Cardex` (
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
  CONSTRAINT `fk_Cardex_Divisa1` FOREIGN KEY (`idDivisa`) REFERENCES `Divisa` (`idDivisa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cardex_Factura1` FOREIGN KEY (`idFactura`) REFERENCES `Factura` (`idFactura`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cardex_Poliza1` FOREIGN KEY (`idPoliza`) REFERENCES `Poliza` (`idPoliza`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cardex_Producto1` FOREIGN KEY (`idProducto`) REFERENCES `Producto` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Cardex`
--

LOCK TABLES `Cardex` WRITE;
/*!40000 ALTER TABLE `Cardex` DISABLE KEYS */;
/*!40000 ALTER TABLE `Cardex` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Categoria`
--

DROP TABLE IF EXISTS `Categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Categoria` (
  `idCategoria` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` text NOT NULL,
  `claveCategoria` text NOT NULL,
  `descripcion` text NOT NULL,
  PRIMARY KEY (`idCategoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Categoria`
--

LOCK TABLES `Categoria` WRITE;
/*!40000 ALTER TABLE `Categoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `Categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Clientes`
--

DROP TABLE IF EXISTS `Clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Clientes` (
  `idCliente` int(11) NOT NULL AUTO_INCREMENT,
  `idEmpresa` int(11) NOT NULL,
  PRIMARY KEY (`idCliente`),
  KEY `fk_Clientes_Empresa1_idx` (`idEmpresa`),
  CONSTRAINT `fk_Clientes_Empresa1` FOREIGN KEY (`idEmpresa`) REFERENCES `Empresa` (`idEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Clientes`
--

LOCK TABLES `Clientes` WRITE;
/*!40000 ALTER TABLE `Clientes` DISABLE KEYS */;
INSERT INTO `Clientes` VALUES (1,1),(2,2),(3,3),(4,4),(5,5),(6,6),(7,7),(8,8),(9,9),(16,16),(17,17),(18,18),(19,19),(22,22),(23,23),(24,24),(25,25),(28,28),(29,29),(30,30),(31,31),(32,32),(33,33),(35,35),(36,36),(37,37),(38,38),(39,39),(43,43),(44,44);
/*!40000 ALTER TABLE `Clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Cuentasxc`
--

DROP TABLE IF EXISTS `Cuentasxc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Cuentasxc` (
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
  CONSTRAINT `fk_Cuentasxc_Empresa1` FOREIGN KEY (`idEmpresa`) REFERENCES `Empresa` (`idEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxc_Empresas1` FOREIGN KEY (`idEmpresas`) REFERENCES `Empresas` (`idEmpresas`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxc_Factura1` FOREIGN KEY (`idFactura`) REFERENCES `Factura` (`idFactura`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxc_Proyecto1` FOREIGN KEY (`idProyecto`) REFERENCES `Proyecto` (`idProyecto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxc_TipoMovimiento1` FOREIGN KEY (`idTipoMovimiento`) REFERENCES `TipoMovimiento` (`idTipoMovimiento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Cuentasxc`
--

LOCK TABLES `Cuentasxc` WRITE;
/*!40000 ALTER TABLE `Cuentasxc` DISABLE KEYS */;
/*!40000 ALTER TABLE `Cuentasxc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Cuentasxp`
--

DROP TABLE IF EXISTS `Cuentasxp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Cuentasxp` (
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
  CONSTRAINT `fk_Cuentasxp_Empresa1` FOREIGN KEY (`idEmpresa`) REFERENCES `Empresa` (`idEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxp_Empresas1` FOREIGN KEY (`idEmpresas`) REFERENCES `Empresas` (`idEmpresas`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxp_Factura1` FOREIGN KEY (`idFactura`) REFERENCES `Factura` (`idFactura`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxp_Proyecto1` FOREIGN KEY (`idProyecto`) REFERENCES `Proyecto` (`idProyecto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxp_TipoMovimiento1` FOREIGN KEY (`idTipoMovimiento`) REFERENCES `TipoMovimiento` (`idTipoMovimiento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Cuentasxp`
--

LOCK TABLES `Cuentasxp` WRITE;
/*!40000 ALTER TABLE `Cuentasxp` DISABLE KEYS */;
/*!40000 ALTER TABLE `Cuentasxp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Divisa`
--

DROP TABLE IF EXISTS `Divisa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Divisa` (
  `idDivisa` int(11) NOT NULL AUTO_INCREMENT,
  `divisa` varchar(200) NOT NULL,
  `claveDivisa` varchar(10) NOT NULL,
  `descripcion` text NOT NULL,
  `tipoCambio` float NOT NULL,
  PRIMARY KEY (`idDivisa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Divisa`
--

LOCK TABLES `Divisa` WRITE;
/*!40000 ALTER TABLE `Divisa` DISABLE KEYS */;
/*!40000 ALTER TABLE `Divisa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Domicilio`
--

DROP TABLE IF EXISTS `Domicilio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Domicilio` (
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
  CONSTRAINT `fk_Domicilio_Municipio1` FOREIGN KEY (`idMunicipio`, `idEstado`) REFERENCES `Municipio` (`idMunicipio`, `idEstado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Domicilio`
--

LOCK TABLES `Domicilio` WRITE;
/*!40000 ALTER TABLE `Domicilio` DISABLE KEYS */;
INSERT INTO `Domicilio` VALUES (1,2,9,'RANCHO CUCHILLA','HACIENDAS DE COYOACAN','04970','-','-'),(2,2,9,'RETORNO 48','AVANTE','04460','-','48'),(3,11,9,'CIPRES','CHIMILLI','14749','-','MANZANA 15 LOTE 6'),(4,12,9,'AVENIDA XOCHIMILCO','SANTA CRUZ XOCHITEPEC','16100','-','-'),(5,2,9,'EUDEVAS','CARACOL','04739','-','-'),(6,14,9,'TUXPAN','ROMA SUR','06760','204','89'),(7,13,9,'AV. INSURGENTES SUR','DEL VALLE','03100','-','800'),(8,271,15,'22 DE DICIEMBRE','CENTRO','55770','2','1'),(9,271,15,'Bicentenario','-','55785','-','1'),(10,36,11,'Obreros','Obrera','37000','-','101'),(17,271,15,'2 DE ABRIL','Centro','55790','-','-'),(18,131,13,'VENUSINA','FRACCIONAMIENTO GEOVILLAS TIZAYUCA','43806','MZ 13 LOTE 6','5'),(19,254,15,'CUAHUTEMOC','col. BARRIO DE GUADALUPE','54960','-','46'),(20,205,15,'CARRETERA ESTATAL OJO E AGUA  SANTANA NEXTLALPAN','PUEBLO DE SAN MIGUEL XALTOCAN','55790','-','-'),(21,131,13,'HACIENDA SAN MIGUEL REGLA','col. HACIENDA LAS TORRES III TIZAYUCA','43802','-','MZ 36 LOTE 1'),(22,203,15,'AV CIRCUITOS INGENIEROS','CIUDAD SATELITE','53100','-','27'),(23,227,15,'LAZARO CARDENAS','AMPLIACIÓN OZUMBILLA','55760','-','331'),(24,252,15,'AGRIPIN GARCIA ESTRADA','SANTA CRUZ ATZCAPOTZALTONGO','50030','-','1306'),(25,205,15,'HOMBRES ILUSTRES','CENTRO  NEXTLALPAN','55790','-','23'),(26,237,15,'Av. San Antonio','Tlatilco','54770','-','-'),(29,238,15,'Plaza Juarez','Centro','55800','-','1'),(30,15,9,'Bosques de Duraznos','Bosques de las Lomas','11700','75','703  A'),(31,14,9,'Paseo de la Reforma  Piso 10','-','6500','-','389'),(32,271,15,'5 de Octubre','Centro','55770','-','12'),(33,271,15,'5 de Octubre','Centro','55770','-','12'),(34,179,15,'Vía Morelos','Ecatepec de Morelos ','55540','-','571'),(36,14,9,'ZAMORA','CONDESA','6140','B2','169'),(37,271,15,'5 de Octubre','Centro','55770','-','12'),(38,199,15,'Avenida Adolfo Lopez Mateos','Barrio Señor de los Milagros ','54880','-','72'),(39,549,21,'2 SUR','PUEBLA CENTRO','72000','102','502'),(40,227,15,'PASEO DE LAS MARGARITAS','FRACC HACIENDA OJO DE AGUA','55700','MZ 59','LT 22'),(44,14,9,'Paseo de la Reforma','Cuauhtemoc','06500','-','389'),(45,14,9,'Paseo de la Reforma','Juárez','06600','Piso 11','350'),(100,680,24,'AV V CARRANZA','CENTRO','78000','-','303');
/*!40000 ALTER TABLE `Domicilio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Email`
--

DROP TABLE IF EXISTS `Email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Email` (
  `idEmail` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(60) NOT NULL,
  PRIMARY KEY (`idEmail`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Email`
--

LOCK TABLES `Email` WRITE;
/*!40000 ALTER TABLE `Email` DISABLE KEYS */;
INSERT INTO `Email` VALUES (1,'info@hasan.com'),(2,'info@sirio.com'),(3,'info@zazil.net'),(4,'info@ikal.net'),(5,'info@hasi.com'),(6,'info@cafedelcentro.com'),(7,'info@minerva.com'),(8,'-'),(9,'-'),(16,'-'),(17,'arvut@live.com'),(18,'-'),(19,'e_stoa@hotmail.com'),(22,'-'),(23,'-'),(24,'compras.prada@hotmail.com'),(25,'-'),(28,'presidencia@teotihuacan.gob.mx'),(29,'-'),(30,'-'),(31,'-'),(32,'adolfo.martinez@zazil.net'),(33,'echilpa@launak.mx'),(35,'-'),(36,'-'),(37,'isidrocomprometidocontigo@hotmail.com'),(38,'grupo_toxqui@hotmail.com'),(39,'-'),(43,'-'),(44,'-');
/*!40000 ALTER TABLE `Email` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Empresa`
--

DROP TABLE IF EXISTS `Empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Empresa` (
  `idEmpresa` int(11) NOT NULL AUTO_INCREMENT,
  `idFiscales` int(11) NOT NULL,
  PRIMARY KEY (`idEmpresa`),
  KEY `fk_Empresa_Fiscales1_idx` (`idFiscales`),
  CONSTRAINT `fk_Empresa_Fiscales1` FOREIGN KEY (`idFiscales`) REFERENCES `Fiscales` (`idFiscales`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Empresa`
--

LOCK TABLES `Empresa` WRITE;
/*!40000 ALTER TABLE `Empresa` DISABLE KEYS */;
INSERT INTO `Empresa` VALUES (1,1),(2,2),(3,3),(4,4),(5,5),(6,6),(7,7),(8,8),(9,9),(16,16),(17,17),(18,18),(19,19),(22,22),(23,23),(24,24),(25,25),(28,28),(29,29),(30,30),(31,31),(32,32),(33,33),(35,35),(36,36),(37,37),(38,38),(39,39),(43,43),(44,44);
/*!40000 ALTER TABLE `Empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Empresas`
--

DROP TABLE IF EXISTS `Empresas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Empresas` (
  `idEmpresas` int(11) NOT NULL AUTO_INCREMENT,
  `idEmpresa` int(11) NOT NULL,
  PRIMARY KEY (`idEmpresas`),
  KEY `fk_Empresas_Empresa1_idx` (`idEmpresa`),
  CONSTRAINT `fk_Empresas_Empresa1` FOREIGN KEY (`idEmpresa`) REFERENCES `Empresa` (`idEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Empresas`
--

LOCK TABLES `Empresas` WRITE;
/*!40000 ALTER TABLE `Empresas` DISABLE KEYS */;
INSERT INTO `Empresas` VALUES (1,1),(2,2),(3,3),(4,4),(5,5),(6,6),(7,7);
/*!40000 ALTER TABLE `Empresas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Encuesta`
--

DROP TABLE IF EXISTS `Encuesta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Encuesta` (
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
-- Dumping data for table `Encuesta`
--

LOCK TABLES `Encuesta` WRITE;
/*!40000 ALTER TABLE `Encuesta` DISABLE KEYS */;
/*!40000 ALTER TABLE `Encuesta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Estado`
--

DROP TABLE IF EXISTS `Estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Estado` (
  `idEstado` int(11) NOT NULL AUTO_INCREMENT,
  `claveEstado` varchar(20) NOT NULL,
  `estado` varchar(50) NOT NULL,
  PRIMARY KEY (`idEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Estado`
--

LOCK TABLES `Estado` WRITE;
/*!40000 ALTER TABLE `Estado` DISABLE KEYS */;
INSERT INTO `Estado` VALUES (1,'01','Aguascalientes'),(2,'02','Baja California'),(3,'03','Baja California Sur'),(4,'04','Campeche'),(5,'05','Coahuila de Zaragoza'),(6,'06','Colima'),(7,'07','Chiapas'),(8,'08','Chihuahua'),(9,'09','Distrito Federal'),(10,'10','Durango'),(11,'11','Guanajuato'),(12,'12','Guerrero'),(13,'13','Hidalgo'),(14,'14','Jalisco'),(15,'15','México'),(16,'16','Michoacán de Ocampo'),(17,'17','Morelos'),(18,'18','Nayarit'),(19,'19','Nuevo León'),(20,'20','Oaxaca'),(21,'21','Puebla'),(22,'22','Querétaro'),(23,'23','Quintana Roo'),(24,'24','San Luis Potosí'),(25,'25','Sinaloa'),(26,'26','Sonora'),(27,'27','Tabasco'),(28,'28','Tamaulipas'),(29,'29','Tlaxcala'),(30,'30','Veracruz de Ignacio de la Llave'),(31,'31','Yucatán'),(32,'32','Zacatecas'),(33,'00','Desconocido');
/*!40000 ALTER TABLE `Estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Factura`
--

DROP TABLE IF EXISTS `Factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Factura` (
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
  CONSTRAINT `fk_Factura_Empresa1` FOREIGN KEY (`idEmpresa`) REFERENCES `Empresa` (`idEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Factura_Empresas1` FOREIGN KEY (`idEmpresas`) REFERENCES `Empresas` (`idEmpresas`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Factura`
--

LOCK TABLES `Factura` WRITE;
/*!40000 ALTER TABLE `Factura` DISABLE KEYS */;
/*!40000 ALTER TABLE `Factura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `FacturaDetalle`
--

DROP TABLE IF EXISTS `FacturaDetalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `FacturaDetalle` (
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
  CONSTRAINT `fk_FacturaDetalle_Factura1` FOREIGN KEY (`idFactura`) REFERENCES `Factura` (`idFactura`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_FacturaDetalle_Multiplos1` FOREIGN KEY (`idMultiplos`) REFERENCES `Multiplos` (`idMultiplos`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `FacturaDetalle`
--

LOCK TABLES `FacturaDetalle` WRITE;
/*!40000 ALTER TABLE `FacturaDetalle` DISABLE KEYS */;
/*!40000 ALTER TABLE `FacturaDetalle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Fiscales`
--

DROP TABLE IF EXISTS `Fiscales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Fiscales` (
  `idFiscales` int(11) NOT NULL,
  `rfc` varchar(13) DEFAULT NULL,
  `razonSocial` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`idFiscales`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Fiscales`
--

LOCK TABLES `Fiscales` WRITE;
/*!40000 ALTER TABLE `Fiscales` DISABLE KEYS */;
INSERT INTO `Fiscales` VALUES (1,'MGR1307164K7','MECANICA EN GENERAL Y REFACCIONES HASAN SA DE CV'),(2,'SSC130716PK6','SIRIO SOLUCIONES EN COMERCIALIZACION SA DE CV'),(3,'ZCO130206K49','ZAZIL CONSULTORES SA DE CV'),(4,'GPI130715FJ9','GESTION DE PROYECTOS IKAL SA DE CV'),(5,'CDD130603N40','CONSULTORIA Y DESARROLLO DE TECNOLOGIAS DE INFORMACION HASI SA DE CV'),(6,'CGC150130UA7','COMERCIALIZADORA GRAN CAFÉ DEL CENTRO SA DE CV'),(7,'MDC150313IL0','MINERVA DISEÑO EN CONSTRUCCION SA DE CV'),(8,'MTO31203 Q45','AYUNTAMIENTO DE TONANITLA EDO DE MEXICO'),(9,'ZTR560608T81','ZAPATAS TRADING S.A. DE C.V.'),(16,'ACO110114 JD1','ASJAZA CONSTRUCCIONES SA DE CV.'),(17,'CAR120329 SG9','CONSTRUCTORA ARVUT S.A. DE C.V.'),(18,'CGO971212 G67','CONSTRUCCIONES GENERACION 80 SA DE CV'),(19,'EST130112 LV5','EDIFICACIONES STOA S.A. DE C.V.'),(20,'ITP101129 5D1','INNOVACIONES TECNOLOGICAS DE PUBLICIDAD SA DE CV'),(21,'JIC011114 MX7','JAGUAR INGENIEROS CONSTRUCTORES S.A. DE C.V.'),(22,'JUPJ720620 BQ','JUANA MAGNOLIA JUAREZ PEREZ'),(23,'SEI920604 D7A','SERVICIOS EDUCATIVOS INTEGRADOS AL ESTADO DE MEXICO'),(24,'TCP121005 2Z1','TERRACERIAS Y CONCRETOS PRADA S.A. DE C.V.'),(25,'MAVF681101 LA','FLORIBERTO GABRIEL MARTINEZ VILLEGAS'),(28,'MTE790101 4X1','MUNICIPIO DE TEOTIHUACAN'),(29,'NDI111122 Q1A','NAPE SERVICIO DIGITAL SA DE CV'),(30,'SSI111125815','SIBENT SISTEMS SA DE CV'),(31,'JIMG680108123','JORGE ISRAEL MARTINEZ GARCIA'),(32,'MAMA560807 L8','ADOLFO MARTINEZ MARTINEZ'),(33,'LAU821028IIS','LAUNAK S.A. DE C.V.'),(35,'PAI100126 PK4','PROMOTORA DE ACCION Y INFORMACION SOCIAL A.C.'),(36,'DAMM800712122','DALIA ASUCENA MARTINEZ MARTINEZ'),(37,'MMO850101 ID2','MUNICIPIO DE MELCHOR OCAMPO'),(38,'IET111024 GD1','INFRAESTRUCTURA Y EDIFICACIONES TOXQUI S.A. DE C.V.'),(39,'ZAI80913 1I9','ZYCARDO´S ASOCIADOS INTEGRALES AGENTE DE SEGUROS SA DE CV'),(43,'SARR80701852','SERVICIOS ARROS SA DE CV'),(44,'RMM080101V54','REGUS MANAGEMENT DE MEXICO SA DE CV'),(92,'ATE100416760','AGRONOMICOS TEXCOCO SA DE CV'),(99,'CDD130603N40','RESTAURANTE LA PARROQUIA POTOSINA SA'),(108,'SOA740912J31','SERVICIO OJO DE AGUA SA DE CV'),(110,'GOMO40622MRA','GASOLINERA OMEGA MATEHUALA II SA DE CV'),(177,'MATT89010517J','TONANTZIN MARTINEZ TRUJILLO'),(200,'HIB910222BP2','HOTEL IMPALA DEL BAJIO SA DE CV'),(276,'GPA961226ST9','GASOLINERIA PALACIOS SA DE CV'),(306,'LST100127V49','LLANTAS Y SERVICIOS DE TECAMAC SA DE CV'),(329,'CART561021Q50','OLIMPUS CENTRO ACUATICO');
/*!40000 ALTER TABLE `Fiscales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `FiscalesDomicilios`
--

DROP TABLE IF EXISTS `FiscalesDomicilios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `FiscalesDomicilios` (
  `idFiscalesDomicilios` int(11) NOT NULL AUTO_INCREMENT,
  `idDomicilio` int(11) NOT NULL,
  `idFiscales` int(11) NOT NULL,
  PRIMARY KEY (`idFiscalesDomicilios`),
  KEY `fk_FiscalesDomicilios_Domicilio1_idx` (`idDomicilio`),
  KEY `fk_FiscalesDomicilios_Fiscales1_idx` (`idFiscales`),
  CONSTRAINT `fk_FiscalesDomicilios_Domicilio1` FOREIGN KEY (`idDomicilio`) REFERENCES `Domicilio` (`idDomicilio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_FiscalesDomicilios_Fiscales1` FOREIGN KEY (`idFiscales`) REFERENCES `Fiscales` (`idFiscales`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `FiscalesDomicilios`
--

LOCK TABLES `FiscalesDomicilios` WRITE;
/*!40000 ALTER TABLE `FiscalesDomicilios` DISABLE KEYS */;
INSERT INTO `FiscalesDomicilios` VALUES (1,1,1),(2,2,2),(3,3,3),(4,4,4),(5,5,5),(6,6,6),(7,7,7),(8,8,6),(9,9,8),(10,10,9),(17,17,16),(18,18,17),(19,19,18),(20,20,19),(23,23,22),(24,24,23),(25,25,24),(26,26,25),(29,29,28),(30,30,29),(31,31,30),(32,32,31),(33,33,32),(34,34,33),(36,36,35),(37,37,36),(38,38,37),(39,39,38),(40,40,39),(44,44,43),(45,45,44),(100,100,99);
/*!40000 ALTER TABLE `FiscalesDomicilios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `FiscalesEmail`
--

DROP TABLE IF EXISTS `FiscalesEmail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `FiscalesEmail` (
  `idFiscalesEmail` int(11) NOT NULL AUTO_INCREMENT,
  `idEmail` int(11) NOT NULL,
  `idFiscales` int(11) NOT NULL,
  PRIMARY KEY (`idFiscalesEmail`),
  KEY `fk_FiscalesEmail_Email1_idx` (`idEmail`),
  KEY `fk_FiscalesEmail_Fiscales1_idx` (`idFiscales`),
  CONSTRAINT `fk_FiscalesEmail_Email1` FOREIGN KEY (`idEmail`) REFERENCES `Email` (`idEmail`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_FiscalesEmail_Fiscales1` FOREIGN KEY (`idFiscales`) REFERENCES `Fiscales` (`idFiscales`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `FiscalesEmail`
--

LOCK TABLES `FiscalesEmail` WRITE;
/*!40000 ALTER TABLE `FiscalesEmail` DISABLE KEYS */;
INSERT INTO `FiscalesEmail` VALUES (1,1,1),(2,2,2),(3,3,3),(4,4,4),(5,5,5),(6,6,6),(7,7,7),(8,8,8),(9,9,9),(16,16,16),(17,17,17),(18,18,18),(19,19,19),(22,22,22),(23,23,23),(24,24,24),(25,25,25),(28,28,28),(29,29,29),(30,30,30),(31,31,31),(32,32,32),(33,33,33),(35,35,35),(36,36,36),(37,37,37),(38,38,38),(39,39,39),(43,43,43),(44,44,44);
/*!40000 ALTER TABLE `FiscalesEmail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `FiscalesTelefonos`
--

DROP TABLE IF EXISTS `FiscalesTelefonos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `FiscalesTelefonos` (
  `idFiscalesTelefonos` int(11) NOT NULL AUTO_INCREMENT,
  `idTelefono` int(11) NOT NULL,
  `idFiscales` int(11) NOT NULL,
  PRIMARY KEY (`idFiscalesTelefonos`),
  KEY `fk_FiscalesTelefonos_Telefono1_idx` (`idTelefono`),
  KEY `fk_FiscalesTelefonos_Fiscales1_idx` (`idFiscales`),
  CONSTRAINT `fk_FiscalesTelefonos_Fiscales1` FOREIGN KEY (`idFiscales`) REFERENCES `Fiscales` (`idFiscales`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_FiscalesTelefonos_Telefono1` FOREIGN KEY (`idTelefono`) REFERENCES `Telefono` (`idTelefono`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `FiscalesTelefonos`
--

LOCK TABLES `FiscalesTelefonos` WRITE;
/*!40000 ALTER TABLE `FiscalesTelefonos` DISABLE KEYS */;
INSERT INTO `FiscalesTelefonos` VALUES (1,1,1),(2,2,2),(3,3,3),(4,4,4),(5,5,5),(6,6,6),(7,7,7),(8,8,6),(9,9,8),(10,10,9),(17,17,16),(18,18,17),(19,19,18),(20,20,19),(23,23,22),(24,24,23),(25,25,24),(26,26,25),(29,29,28),(30,30,29),(31,31,30),(32,32,31),(33,33,32),(34,34,33),(36,36,35),(37,37,36),(38,38,37),(39,39,38),(40,40,39),(44,44,43),(45,45,44);
/*!40000 ALTER TABLE `FiscalesTelefonos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Grupo`
--

DROP TABLE IF EXISTS `Grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Grupo` (
  `idGrupo` int(11) NOT NULL AUTO_INCREMENT,
  `idSeccion` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `claveGrupo` text NOT NULL,
  `tipo` varchar(2) NOT NULL,
  `orden` int(11) NOT NULL,
  `elementos` int(11) NOT NULL,
  PRIMARY KEY (`idGrupo`),
  KEY `fk_Grupo_Seccion1_idx` (`idSeccion`),
  CONSTRAINT `fk_Grupo_Seccion1` FOREIGN KEY (`idSeccion`) REFERENCES `Seccion` (`idSeccion`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Grupo`
--

LOCK TABLES `Grupo` WRITE;
/*!40000 ALTER TABLE `Grupo` DISABLE KEYS */;
/*!40000 ALTER TABLE `Grupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Impuesto`
--

DROP TABLE IF EXISTS `Impuesto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Impuesto` (
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
-- Dumping data for table `Impuesto`
--

LOCK TABLES `Impuesto` WRITE;
/*!40000 ALTER TABLE `Impuesto` DISABLE KEYS */;
/*!40000 ALTER TABLE `Impuesto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Inventario`
--

DROP TABLE IF EXISTS `Inventario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Inventario` (
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
  CONSTRAINT `fk_Inventario_Divisa1` FOREIGN KEY (`idDivisa`) REFERENCES `Divisa` (`idDivisa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Inventario_Empresas1` FOREIGN KEY (`idEmpresas`) REFERENCES `Empresas` (`idEmpresas`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Inventario_Producto1` FOREIGN KEY (`idProducto`) REFERENCES `Producto` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Inventario`
--

LOCK TABLES `Inventario` WRITE;
/*!40000 ALTER TABLE `Inventario` DISABLE KEYS */;
/*!40000 ALTER TABLE `Inventario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Movimientos`
--

DROP TABLE IF EXISTS `Movimientos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Movimientos` (
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
  CONSTRAINT `fk_Movimientos_Factura1` FOREIGN KEY (`idFactura`) REFERENCES `Factura` (`idFactura`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Movimientos_Poliza1` FOREIGN KEY (`idPoliza`) REFERENCES `Poliza` (`idPoliza`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Movimientos_Producto1` FOREIGN KEY (`idProducto`) REFERENCES `Producto` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Movimientos_Proyecto1` FOREIGN KEY (`idProyecto`) REFERENCES `Proyecto` (`idProyecto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Movimientos_TipoMovimiento1` FOREIGN KEY (`idTipoMovimiento`) REFERENCES `TipoMovimiento` (`idTipoMovimiento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Movimientos`
--

LOCK TABLES `Movimientos` WRITE;
/*!40000 ALTER TABLE `Movimientos` DISABLE KEYS */;
/*!40000 ALTER TABLE `Movimientos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Multiplos`
--

DROP TABLE IF EXISTS `Multiplos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Multiplos` (
  `idMultiplos` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` int(11) NOT NULL,
  `cantidad` float NOT NULL,
  `unidad` varchar(20) NOT NULL,
  `abreviatura` varchar(20) NOT NULL,
  PRIMARY KEY (`idMultiplos`),
  KEY `fk_Multiplos_Producto1_idx` (`idProducto`),
  CONSTRAINT `fk_Multiplos_Producto1` FOREIGN KEY (`idProducto`) REFERENCES `Producto` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Multiplos`
--

LOCK TABLES `Multiplos` WRITE;
/*!40000 ALTER TABLE `Multiplos` DISABLE KEYS */;
/*!40000 ALTER TABLE `Multiplos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Municipio`
--

DROP TABLE IF EXISTS `Municipio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Municipio` (
  `idMunicipio` int(11) NOT NULL AUTO_INCREMENT,
  `idEstado` int(11) NOT NULL,
  `claveMunicipio` varchar(20) DEFAULT NULL,
  `municipio` varchar(100) NOT NULL,
  PRIMARY KEY (`idMunicipio`,`idEstado`),
  KEY `fk_Municipio_Estado_idx` (`idEstado`),
  CONSTRAINT `fk_Municipio_Estado` FOREIGN KEY (`idEstado`) REFERENCES `Estado` (`idEstado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1205 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Municipio`
--

LOCK TABLES `Municipio` WRITE;
/*!40000 ALTER TABLE `Municipio` DISABLE KEYS */;
INSERT INTO `Municipio` VALUES (1,9,'002','Azcapotzalco'),(2,9,'003','Coyoacán'),(3,9,'004','Cuajimalpa de Morelos'),(4,9,'005','Gustavo A. Madero'),(5,9,'006','Iztacalco'),(6,9,'007','Iztapalapa'),(7,9,'008','La Magdalena Contreras'),(8,9,'009','Milpa Alta'),(9,9,'010','Álvaro Obregón'),(10,9,'011','Tláhuac'),(11,9,'012','Tlalpan'),(12,9,'013','Xochimilco'),(13,9,'014','Benito Juárez'),(14,9,'015','Cuauhtémoc'),(15,9,'016','Miguel Hidalgo'),(16,9,'017','Venustiano Carranza'),(17,11,'001','Abasolo'),(18,11,'002','Acámbaro'),(19,11,'003','San Miguel de Allende'),(20,11,'004','Apaseo el Alto'),(21,11,'005','Apaseo el Grande'),(22,11,'006','Atarjea'),(23,11,'007','Celaya'),(24,11,'008','Manuel Doblado'),(25,11,'009','Comonfort'),(26,11,'010','Coroneo'),(27,11,'011','Cortazar'),(28,11,'012','Cuerámaro'),(29,11,'013','Doctor Mora'),(30,11,'014','Dolores Hidalgo Cuna de la Independencia Nacional'),(31,11,'015','Guanajuato'),(32,11,'016','Huanímaro'),(33,11,'017','Irapuato'),(34,11,'018','Jaral del Progreso'),(35,11,'019','Jerécuaro'),(36,11,'020','León'),(37,11,'021','Moroleón'),(38,11,'022','Ocampo'),(39,11,'023','Pénjamo'),(40,11,'024','Pueblo Nuevo'),(41,11,'025','Purísima del Rincón'),(42,11,'026','Romita'),(43,11,'027','Salamanca'),(44,11,'028','Salvatierra'),(45,11,'029','San Diego de la Unión'),(46,11,'030','San Felipe'),(47,11,'031','San Francisco del Rincón'),(48,11,'032','San José Iturbide'),(49,11,'033','San Luis de la Paz'),(50,11,'034','Santa Catarina'),(51,11,'035','Santa Cruz de Juventino Rosas'),(52,11,'036','Santiago Maravatío'),(53,11,'037','Silao'),(54,11,'038','Tarandacuao'),(55,11,'039','Tarimoro'),(56,11,'040','Tierra Blanca'),(57,11,'041','Uriangato'),(58,11,'042','Valle de Santiago'),(59,11,'043','Victoria'),(60,11,'044','Villagrán'),(61,11,'045','Xichú'),(62,11,'046','Yuriria'),(63,13,'001','Acatlán'),(64,13,'002','Acaxochitlán'),(65,13,'003','Actopan'),(66,13,'004','Agua Blanca de Iturbide'),(67,13,'005','Ajacuba'),(68,13,'006','Alfajayucan'),(69,13,'007','Almoloya'),(70,13,'008','Apan'),(71,13,'009','El Arenal'),(72,13,'010','Atitalaquia'),(73,13,'011','Atlapexco'),(74,13,'012','Atotonilco el Grande'),(75,13,'013','Atotonilco de Tula'),(76,13,'014','Calnali'),(77,13,'015','Cardonal'),(78,13,'016','Cuautepec de Hinojosa'),(79,13,'017','Chapantongo'),(80,13,'018','Chapulhuacán'),(81,13,'019','Chilcuautla'),(82,13,'020','Eloxochitlán'),(83,13,'021','Emiliano Zapata'),(84,13,'022','Epazoyucan'),(85,13,'023','Francisco I. Madero'),(86,13,'024','Huasca de Ocampo'),(87,13,'025','Huautla'),(88,13,'026','Huazalingo'),(89,13,'027','Huehuetla'),(90,13,'028','Huejutla de Reyes'),(91,13,'029','Huichapan'),(92,13,'030','Ixmiquilpan'),(93,13,'031','Jacala de Ledezma'),(94,13,'032','Jaltocán'),(95,13,'033','Juárez Hidalgo'),(96,13,'034','Lolotla'),(97,13,'035','Metepec'),(98,13,'036','San Agustín Metzquititlán'),(99,13,'037','Metztitlán'),(100,13,'038','Mineral del Chico'),(101,13,'039','Mineral del Monte'),(102,13,'040','La Misión'),(103,13,'041','Mixquiahuala de Juárez'),(104,13,'042','Molango de Escamilla'),(105,13,'043','Nicolás Flores'),(106,13,'044','Nopala de Villagrán'),(107,13,'045','Omitlán de Juárez'),(108,13,'046','San Felipe Orizatlán'),(109,13,'047','Pacula'),(110,13,'048','Pachuca de Soto'),(111,13,'049','Pisaflores'),(112,13,'050','Progreso de Obregón'),(113,13,'051','Mineral de la Reforma'),(114,13,'052','San Agustín Tlaxiaca'),(115,13,'053','San Bartolo Tutotepec'),(116,13,'054','San Salvador'),(117,13,'055','Santiago de Anaya'),(118,13,'056','Santiago Tulantepec de Lugo Guerrero'),(119,13,'057','Singuilucan'),(120,13,'058','Tasquillo'),(121,13,'059','Tecozautla'),(122,13,'060','Tenango de Doria'),(123,13,'061','Tepeapulco'),(124,13,'062','Tepehuacán de Guerrero'),(125,13,'063','Tepeji del Río de Ocampo'),(126,13,'064','Tepetitlán'),(127,13,'065','Tetepango'),(128,13,'066','Villa de Tezontepec'),(129,13,'067','Tezontepec de Aldama'),(130,13,'068','Tianguistengo'),(131,13,'069','Tizayuca'),(132,13,'070','Tlahuelilpan'),(133,13,'071','Tlahuiltepa'),(134,13,'072','Tlanalapa'),(135,13,'073','Tlanchinol'),(136,13,'074','Tlaxcoapan'),(137,13,'075','Tolcayuca'),(138,13,'076','Tula de Allende'),(139,13,'077','Tulancingo de Bravo'),(140,13,'078','Xochiatipan'),(141,13,'079','Xochicoatlán'),(142,13,'080','Yahualica'),(143,13,'081','Zacualtipán de Ángeles'),(144,13,'082','Zapotlán de Juárez'),(145,13,'083','Zempoala'),(146,13,'084','Zimapán'),(147,15,'001','Acambay'),(148,15,'002','Acolman'),(149,15,'003','Aculco'),(150,15,'004','Almoloya de Alquisiras'),(151,15,'005','Almoloya de Juárez'),(152,15,'006','Almoloya del Río'),(153,15,'007','Amanalco'),(154,15,'008','Amatepec'),(155,15,'009','Amecameca'),(156,15,'010','Apaxco'),(157,15,'011','Atenco'),(158,15,'012','Atizapán'),(159,15,'013','Atizapán de Zaragoza'),(160,15,'014','Atlacomulco'),(161,15,'015','Atlautla'),(162,15,'016','Axapusco'),(163,15,'017','Ayapango'),(164,15,'018','Calimaya'),(165,15,'019','Capulhuac'),(166,15,'020','Coacalco de Berriozábal'),(167,15,'021','Coatepec Harinas'),(168,15,'022','Cocotitlán'),(169,15,'023','Coyotepec'),(170,15,'024','Cuautitlán'),(171,15,'025','Chalco'),(172,15,'026','Chapa de Mota'),(173,15,'027','Chapultepec'),(174,15,'028','Chiautla'),(175,15,'029','Chicoloapan'),(176,15,'030','Chiconcuac'),(177,15,'031','Chimalhuacán'),(178,15,'032','Donato Guerra'),(179,15,'033','Ecatepec de Morelos'),(180,15,'034','Ecatzingo'),(181,15,'035','Huehuetoca'),(182,15,'036','Hueypoxtla'),(183,15,'037','Huixquilucan'),(184,15,'038','Isidro Fabela'),(185,15,'039','Ixtapaluca'),(186,15,'040','Ixtapan de la Sal'),(187,15,'041','Ixtapan del Oro'),(188,15,'042','Ixtlahuaca'),(189,15,'043','Xalatlaco'),(190,15,'044','Jaltenco'),(191,15,'045','Jilotepec'),(192,15,'046','Jilotzingo'),(193,15,'047','Jiquipilco'),(194,15,'048','Jocotitlán'),(195,15,'049','Joquicingo'),(196,15,'050','Juchitepec'),(197,15,'051','Lerma'),(198,15,'052','Malinalco'),(199,15,'053','Melchor Ocampo'),(200,15,'054','Metepec'),(201,15,'055','Mexicaltzingo'),(202,15,'056','Morelos'),(203,15,'057','Naucalpan de Juárez'),(204,15,'058','Nezahualcóyotl'),(205,15,'059','Nextlalpan'),(206,15,'060','Nicolás Romero'),(207,15,'061','Nopaltepec'),(208,15,'062','Ocoyoacac'),(209,15,'063','Ocuilan'),(210,15,'064','El Oro'),(211,15,'065','Otumba'),(212,15,'066','Otzoloapan'),(213,15,'067','Otzolotepec'),(214,15,'068','Ozumba'),(215,15,'069','Papalotla'),(216,15,'070','La Paz'),(217,15,'071','Polotitlán'),(218,15,'072','Rayón'),(219,15,'073','San Antonio la Isla'),(220,15,'074','San Felipe del Progreso'),(221,15,'075','San Martín de las Pirámides'),(222,15,'076','San Mateo Atenco'),(223,15,'077','San Simón de Guerrero'),(224,15,'078','Santo Tomás'),(225,15,'079','Soyaniquilpan de Juárez'),(226,15,'080','Sultepec'),(227,15,'081','Tecámac'),(228,15,'082','Tejupilco'),(229,15,'083','Temamatla'),(230,15,'084','Temascalapa'),(231,15,'085','Temascalcingo'),(232,15,'086','Temascaltepec'),(233,15,'087','Temascaltepec'),(234,15,'088','Tenancingo'),(235,15,'089','Tenango del Aire'),(236,15,'090','Tenango del Valle'),(237,15,'091','Teoloyucan'),(238,15,'092','Teotihuacán'),(239,15,'093','Tepetlaoxtoc'),(240,15,'094','Tepetlixpa'),(241,15,'095','Tepotzotlán'),(242,15,'096','Tequixquiac'),(243,15,'097','Texcaltitlán'),(244,15,'098','Texcalyacac'),(245,15,'099','Texcoco'),(246,15,'100','Tezoyuca'),(247,15,'101','Tianguistenco'),(248,15,'102','Timilpan'),(249,15,'103','Tlalmanalco'),(250,15,'104','Tlalnepantla de Baz'),(251,15,'105','Tlatlaya'),(252,15,'106','Toluca'),(253,15,'107','Tonatico'),(254,15,'108','Tultepec'),(255,15,'109','Tultitlán'),(256,15,'110','Valle de Bravo'),(257,15,'111','Villa de Allende'),(258,15,'112','Villa del Carbón'),(259,15,'113','Villa Guerrero'),(260,15,'114','Villa Victoria'),(261,15,'115','Xonacatlán'),(262,15,'116','Zacazonapan'),(263,15,'117','Zacualpan'),(264,15,'118','Zinacantepec'),(265,15,'119','Zumpahuacán'),(266,15,'120','Zumpango'),(267,15,'121','Cuautitlán Izcalli'),(268,15,'122','Valle de Chalco Solidaridad'),(269,15,'123','Luvianos'),(270,15,'124','San José del Rincón'),(271,15,'125','Tonanitla'),(272,16,'001','Acuitzio'),(273,16,'002','Aguililla'),(274,16,'003','Álvaro Obregón'),(275,16,'004','Angamacutiro'),(276,16,'005','Angangueo'),(277,16,'006','Apatzingán'),(278,16,'007','Aporo'),(279,16,'008','Aquila'),(280,16,'009','Ario'),(281,16,'010','Arteaga'),(282,16,'011','Briseñas'),(283,16,'012','Buenavista'),(284,16,'013','Carácuaro'),(285,16,'014','Coahuayana'),(286,16,'015','Coalcomán de Vázquez Pallares'),(287,16,'016','Coeneo'),(288,16,'017','Contepec'),(289,16,'018','Copándaro'),(290,16,'019','Cotija'),(291,16,'020','Cuitzeo'),(292,16,'021','Charapan'),(293,16,'022','Charo'),(294,16,'023','Chavinda'),(295,16,'024','Cherán'),(296,16,'025','Chilchota'),(297,16,'026','Chinicuila'),(298,16,'027','Chucándiro'),(299,16,'028','Churintzio'),(300,16,'029','Churumuco'),(301,16,'030','Ecuandureo'),(302,16,'031','Epitacio Huerta'),(303,16,'032','Erongarícuaro'),(304,16,'033','Gabriel Zamora'),(305,16,'034','Gabriel Zamora'),(306,16,'035','La Huacana'),(307,16,'036','Huandacareo'),(308,16,'037','Huaniqueo'),(309,16,'038','Huetamo'),(310,16,'039','Huiramba'),(311,16,'040','Indaparapeo'),(312,16,'041','Irimbo'),(313,16,'042','Ixtlán'),(314,16,'043','Jacona'),(315,16,'044','Jiménez'),(316,16,'045','Jiquilpan'),(317,16,'046','Juárez'),(318,16,'047','Jungapeo'),(319,16,'048','Lagunillas'),(320,16,'049','Madero'),(321,16,'050','Maravatío'),(322,16,'051','Marcos Castellanos'),(323,16,'052','Lázaro Cárdenas'),(324,16,'053','Morelia'),(325,16,'054','Morelos'),(326,16,'055','Múgica'),(327,16,'056','Nahuatzen'),(328,16,'057','Nocupétaro'),(329,16,'058','Nuevo Parangaricutiro'),(330,16,'059','Nuevo Urecho'),(331,16,'060','Numarán'),(332,16,'061','Ocampo'),(333,16,'062','Pajacuarán'),(334,16,'063','Panindícuaro'),(335,16,'064','Parácuaro'),(336,16,'065','Paracho'),(337,16,'066','Pátzcuaro'),(338,16,'067','Penjamillo'),(339,16,'068','Peribán'),(340,16,'069','La Piedad'),(341,16,'070','Purépero'),(342,16,'071','Puruándiro'),(343,16,'072','Queréndaro'),(344,16,'073','Quiroga'),(345,16,'074','Cojumatlán de Régules'),(346,16,'075','Los Reyes'),(347,16,'076','Sahuayo'),(348,16,'077','San Lucas'),(349,16,'078','Santa Ana Maya'),(350,16,'079','Salvador Escalante'),(351,16,'080','Senguio'),(352,16,'081','Susupuato'),(353,16,'082','Tacámbaro'),(354,16,'083','Tancítaro'),(355,16,'084','Tangamandapio'),(356,16,'085','Tangancícuaro'),(357,16,'086','Tanhuato'),(358,16,'087','Taretan'),(359,16,'088','Tarímbaro'),(360,16,'089','Tepalcatepec'),(361,16,'090','Tingambato'),(362,16,'091','Tingüindín'),(363,16,'092','Tiquicheo de Nicolás Romero'),(364,16,'093','Tlalpujahua'),(365,16,'094','Tlazazalca'),(366,16,'095','Tocumbo'),(367,16,'096','Tumbiscatío'),(368,16,'097','Turicato'),(369,16,'098','Tuxpan'),(370,16,'099','Tuzantla'),(371,16,'100','Tzintzuntzan'),(372,16,'101','Tzitzio'),(373,16,'102','Uruapan'),(374,16,'103','Venustiano Carranza'),(375,16,'104','Villamar'),(376,16,'105','Vista Hermosa'),(377,16,'106','Yurécuaro'),(378,16,'107','Zacapu'),(379,16,'108','Zamora'),(380,16,'109','Zináparo'),(381,16,'110','Zinapécuaro'),(382,16,'111','Zinapécuaro'),(383,16,'112','Zitácuaro'),(384,16,'113','José Sixto Verduzco'),(385,19,'001','Abasolo'),(386,19,'002','Agualeguas'),(387,19,'003','Los Aldamas'),(388,19,'004','Allende'),(389,19,'005','Anáhuac'),(390,19,'006','Apodaca'),(391,19,'007','Aramberri'),(392,19,'008','Bustamante'),(393,19,'009','Cadereyta Jiménez'),(394,19,'010','Carmen'),(395,19,'011','Cerralvo'),(396,19,'012','Ciénega de Flores'),(397,19,'013','China'),(398,19,'014','Dr. Arroyo'),(399,19,'015','Dr. Coss'),(400,19,'016','Dr. González'),(401,19,'017','Galeana'),(402,19,'018','García'),(403,19,'019','San Pedro Garza García'),(404,19,'020','Gral. Bravo'),(405,19,'021','Gral. Escobedo'),(406,19,'022','Gral. Terán'),(407,19,'023','Gral. Treviño'),(408,19,'024','Gral. Zaragoza'),(409,19,'025','Gral. Zuazua'),(410,19,'026','Guadalupe'),(411,19,'027','Los Herreras'),(412,19,'028','Higueras'),(413,19,'029','Hualahuises'),(414,19,'030','Iturbide'),(415,19,'031','Juárez'),(416,19,'032','Lampazos de Naranjo'),(417,19,'033','Linares'),(418,19,'034','Marín'),(419,19,'035','Melchor Ocampo'),(420,19,'036','Mier y Noriega'),(421,19,'037','Mina'),(422,19,'038','Montemorelos'),(423,19,'039','Monterrey'),(424,19,'040','Parás'),(425,19,'041','Pesquería'),(426,19,'042','Los Ramones'),(427,19,'043','Rayones'),(428,19,'044','Sabinas Hidalgo'),(429,19,'045','Salinas Victoria'),(430,19,'046','San Nicolás de los Garza'),(431,19,'047','Hidalgo'),(432,19,'048','Santa Catarina'),(433,19,'049','Santiago'),(434,19,'050','Vallecillo'),(435,19,'051','Villaldama'),(436,21,'001','Acajete'),(437,21,'002','Acateno'),(438,21,'003','Acatlán'),(439,21,'004','Acatzingo'),(440,21,'005','Acteopan'),(441,21,'006','Ahuacatlán'),(442,21,'007','Ahuatlán'),(443,21,'008','Ahuazotepec'),(444,21,'009','Ahuehuetitla'),(445,21,'010','Ajalpan'),(446,21,'011','Albino Zertuche'),(447,21,'012','Aljojuca'),(448,21,'013','Altepexi'),(449,21,'014','Amixtlán'),(450,21,'015','Amozoc'),(451,21,'016','Aquixtla'),(452,21,'017','Atempan'),(453,21,'018','Atexcal'),(454,21,'019','Atlixco'),(455,21,'020','Atoyatempan'),(456,21,'021','Atzala'),(457,21,'022','Atzitzihuacán'),(458,21,'023','Atzitzintla'),(459,21,'024','Axutla'),(460,21,'025','Ayotoxco de Guerrero'),(461,21,'026','Calpan'),(462,21,'027','Caltepec'),(463,21,'028','Camocuautla'),(464,21,'029','Caxhuacan'),(465,21,'030','Coatepec'),(466,21,'031','Coatzingo'),(467,21,'032','Cohetzala'),(468,21,'033','Cohuecan'),(469,21,'034','Coronango'),(470,21,'035','Coxcatlán'),(471,21,'036','Coyomeapan'),(472,21,'037','Coyotepec'),(473,21,'038','Cuapiaxtla de Madero'),(474,21,'039','Cuautempan'),(475,21,'040','Cuautinchán'),(476,21,'041','Cuautlancingo'),(477,21,'042','Cuayuca de Andrade'),(478,21,'043','Cuetzalan del Progreso'),(479,21,'044','Cuyoaco'),(480,21,'045','Chalchicomula de Sesma'),(481,21,'046','Chapulco'),(482,21,'047','Chiautla'),(483,21,'048','Chiautzingo'),(484,21,'049','Chiconcuautla'),(485,21,'050','Chichiquila'),(486,21,'051','Chietla'),(487,21,'052','Chigmecatitlán'),(488,21,'053','Chignahuapan'),(489,21,'054','Chignautla'),(490,21,'055','Chila'),(491,21,'056','Chila de la Sal'),(492,21,'057','Honey'),(493,21,'058','Chilchotla'),(494,21,'059','Chinantla'),(495,21,'060','Domingo Arenas'),(496,21,'061','Eloxochitlán'),(497,21,'062','Epatlán'),(498,21,'063','Esperanza'),(499,21,'064','Francisco Z. Mena'),(500,21,'065','General Felipe Ángeles'),(501,21,'066','Guadalupe'),(502,21,'067','Guadalupe Victoria'),(503,21,'068','Hermenegildo Galeana'),(504,21,'069','Huaquechula'),(505,21,'070','Huatlatlauca'),(506,21,'071','Huauchinango'),(507,21,'072','Huehuetla'),(508,21,'073','Huehuetlán el Chico'),(509,21,'074','Huejotzingo'),(510,21,'075','Hueyapan'),(511,21,'076','Hueytamalco'),(512,21,'077','Hueytlalpan'),(513,21,'078','Huitzilan de Serdán'),(514,21,'079','Huitziltepec'),(515,21,'080','Atlequizayan'),(516,21,'081','Ixcamilpa de Guerrero'),(517,21,'082','Ixcaquixtla'),(518,21,'083','Ixtacamaxtitlán'),(519,21,'084','Ixtepec'),(520,21,'085','Izúcar de Matamoros'),(521,21,'086','Jalpan'),(522,21,'087','Jolalpan'),(523,21,'088','Jonotla'),(524,21,'089','Jopala'),(525,21,'090','Juan C. Bonilla'),(526,21,'091','Juan Galindo'),(527,21,'092','Juan N. Méndez'),(528,21,'093','Lafragua'),(529,21,'094','Libres'),(530,21,'095','La Magdalena Tlatlauquitepec'),(531,21,'096','Mazapiltepec de Juárez'),(532,21,'097','Mixtla'),(533,21,'098','Molcaxac'),(534,21,'099','Cañada Morelos'),(535,21,'100','Naupan'),(536,21,'101','Nauzontla'),(537,21,'102','Nealtican'),(538,21,'103','Nicolás Bravo'),(539,21,'104','Nopalucan'),(540,21,'105','Ocotepec'),(541,21,'106','Ocoyucan'),(542,21,'107','Olintla'),(543,21,'108','Oriental'),(544,21,'109','Pahuatlán'),(545,21,'110','Palmar de Bravo'),(546,21,'111','Pantepec'),(547,21,'112','Petlalcingo'),(548,21,'113','Piaxtla'),(549,21,'114','Puebla'),(550,21,'115','Quecholac'),(551,21,'116','Quimixtlán'),(552,21,'117','Rafael Lara Grajales'),(553,21,'118','Los Reyes de Juárez'),(554,21,'119','San Andrés Cholula'),(555,21,'120','San Antonio Cañada'),(556,21,'121','San Diego la Mesa Tochimiltzingo'),(557,21,'122','San Felipe Teotlalcingo'),(558,21,'123','San Felipe Tepatlán'),(559,21,'124','San Gabriel Chilac'),(560,21,'125','San Gregorio Atzompa'),(561,21,'126','San Jerónimo Tecuanipan'),(562,21,'127','San Jerónimo Xayacatlán'),(563,21,'128','San José Chiapa'),(564,21,'129','San José Miahuatlán'),(565,21,'130','San Juan Atenco'),(566,21,'131','San Juan Atzompa'),(567,21,'132','San Martín Texmelucan'),(568,21,'133','San Martín Totoltepec'),(569,21,'134','San Matías Tlalancaleca'),(570,21,'135','San Miguel Ixitlán'),(571,21,'136','San Miguel Xoxtla'),(572,21,'137','San Nicolás Buenos Aires'),(573,21,'138','San Nicolás de los Ranchos'),(574,21,'139','San Pablo Anicano'),(575,21,'140','San Pedro Cholula'),(576,21,'141','San Pedro Yeloixtlahuaca'),(577,21,'142','San Salvador el Seco'),(578,21,'143','San Salvador el Verde'),(579,21,'144','San Salvador Huixcolotla'),(580,21,'145','San Sebastián Tlacotepec'),(581,21,'146','Santa Catarina Tlaltempan'),(582,21,'147','Santa Inés Ahuatempan'),(583,21,'148','Santa Isabel Cholula'),(584,21,'149','Santiago Miahuatlán'),(585,21,'150','Huehuetlán el Grande'),(586,21,'151','Santo Tomás Hueyotlipan'),(587,21,'152','Soltepec'),(588,21,'153','Tecali de Herrera'),(589,21,'154','Tecamachalco'),(590,21,'155','Tecomatlán'),(591,21,'156','Tehuacán'),(592,21,'157','Tehuitzingo'),(593,21,'158','Tenampulco'),(594,21,'159','Teopantlán'),(595,21,'160','Teotlalco'),(596,21,'161','Tepanco de López'),(597,21,'162','Tepango de Rodríguez'),(598,21,'163','Tepatlaxco de Hidalgo'),(599,21,'164','Tepeaca'),(600,21,'165','Tepemaxalco'),(601,21,'166','Tepeojuma'),(602,21,'167','Tepetzintla'),(603,21,'168','Tepexco'),(604,21,'169','Tepexi de Rodríguez'),(605,21,'170','Tepeyahualco'),(606,21,'171','Tepeyahualco de Cuauhtémoc'),(607,21,'172','Tetela de Ocampo'),(608,21,'173','Teteles de Avila Castillo'),(609,21,'174','Teziutlán'),(610,21,'175','Tianguismanalco'),(611,21,'176','Tilapa'),(612,21,'177','Tlacotepec de Benito Juárez'),(613,21,'178','Tlacuilotepec'),(614,21,'179','Tlachichuca'),(615,21,'180','Tlahuapan'),(616,21,'181','Tlaltenango'),(617,21,'182','Tlanepantla'),(618,21,'183','Tlaola'),(619,21,'184','Tlapacoya'),(620,21,'185','Tlapanalá'),(621,21,'186','Tlatlauquitepec'),(622,21,'187','Tlaxco'),(623,21,'188','Tochimilco'),(624,21,'189','Tochtepec'),(625,21,'190','Totoltepec de Guerrero'),(626,21,'191','Tulcingo'),(627,21,'192','Tuzamapan de Galeana'),(628,21,'193','Tzicatlacoyan'),(629,21,'194','Venustiano Carranza'),(630,21,'195','Vicente Guerrero'),(631,21,'196','Xayacatlán de Bravo'),(632,21,'197','Xicotepec'),(633,21,'198','Xicotlán'),(634,21,'199','Xiutetelco'),(635,21,'200','Xochiapulco'),(636,21,'201','Xochiltepec'),(637,21,'202','Xochitlán de Vicente Suárez'),(638,21,'203','Xochitlán Todos Santos'),(639,21,'204','Yaonáhuac'),(640,21,'205','Yehualtepec'),(641,21,'206','Zacapala'),(642,21,'207','Zacapoaxtla'),(643,21,'208','Zacatlán'),(644,21,'209','Zapotitlán'),(645,21,'210','Zapotitlán de Méndez'),(646,21,'211','Zaragoza'),(647,21,'212','Zautla'),(648,21,'213','Zihuateutla'),(649,21,'214','Zinacatepec'),(650,21,'215','Zongozotla'),(651,21,'216','Zoquiapan'),(652,21,'217','Zoquitlán'),(653,24,'001','Ahualulco'),(654,24,'002','Alaquines'),(655,24,'003','Aquismón'),(656,24,'004','Armadillo de los Infante'),(657,24,'005','Cárdenas'),(658,24,'006','Catorce'),(659,24,'007','Cedral'),(660,24,'008','Cerritos'),(661,24,'009','Cerro de San Pedro'),(662,24,'010','Ciudad del Maíz'),(663,24,'011','Ciudad Fernández'),(664,24,'012','Tancanhuitz'),(665,24,'013','Ciudad Valles'),(666,24,'014','Coxcatlán'),(667,24,'015','Charcas'),(668,24,'016','Ebano'),(669,24,'017','Guadalcázar'),(670,24,'018','Huehuetlán'),(671,24,'019','Lagunillas'),(672,24,'020','Matehuala'),(673,24,'021','Mexquitic de Carmona'),(674,24,'022','Moctezuma'),(675,24,'023','Rayón'),(676,24,'024','Rioverde'),(677,24,'025','Salinas'),(678,24,'026','San Antonio'),(679,24,'027','San Ciro de Acosta'),(680,24,'028','San Luis Potosí'),(681,24,'029','San Martín Chalchicuautla'),(682,24,'030','San Nicolás Tolentino'),(683,24,'031','Santa Catarina'),(684,24,'032','Santa María del Río'),(685,24,'033','Santo Domingo'),(686,24,'034','San Vicente Tancuayalab'),(687,24,'035','Soledad de Graciano Sánchez'),(688,24,'036','Tamasopo'),(689,24,'037','Tamazunchale'),(690,24,'038','Tampacán'),(691,24,'039','Tampamolón Corona'),(692,24,'040','Tamuín'),(693,24,'041','Tanlajás'),(694,24,'042','Tanquián de Escobedo'),(695,24,'043','Tierra Nueva'),(696,24,'044','Vanegas'),(697,24,'045','Venado'),(698,24,'046','Villa de Arriaga'),(699,24,'047','Villa de Guadalupe'),(700,24,'048','Villa de la Paz'),(701,24,'049','Villa de Ramos'),(702,24,'050','Villa de Reyes'),(703,24,'051','Villa Hidalgo'),(704,24,'052','Villa Juárez'),(705,24,'053','Axtla de Terrazas'),(706,24,'054','Xilitla'),(707,24,'055','Zaragoza'),(708,24,'056','Villa de Arista'),(709,24,'057','Matlapa'),(710,24,'058','El Naranjo'),(711,25,'001','Ahome'),(712,31,'001','Abalá'),(713,31,'002','Acanceh'),(714,31,'003','Akil'),(715,31,'004','Baca'),(716,31,'005','Bokobá'),(717,31,'006','Buctzotz'),(718,31,'007','Cacalchén'),(719,31,'008','Calotmul'),(720,31,'009','Cansahcab'),(721,31,'010','Cantamayec'),(722,31,'011','Celestún'),(723,31,'012','Cenotillo'),(724,31,'013','Conkal'),(725,31,'014','Cuncunul'),(726,31,'015','Cuzamá'),(727,31,'016','Chacsinkín'),(728,31,'017','Chankom'),(729,31,'018','Chapab'),(730,31,'019','Chapab'),(731,31,'020','Chicxulub Pueblo'),(732,31,'021','Chichimilá'),(733,31,'022','Chikindzonot'),(734,31,'023','Chocholá'),(735,31,'024','Chumayel'),(736,31,'025','Dzán'),(737,31,'026','Dzemul'),(738,31,'027','Dzidzantún'),(739,31,'028','Dzilam de Bravo'),(740,31,'029','Dzilam González'),(741,31,'030','Dzitás'),(742,31,'031','Dzoncauich'),(743,31,'032','Espita'),(744,31,'033','Halachó'),(745,31,'034','Hocabá'),(746,31,'035','Hoctún'),(747,31,'036','Homún'),(748,31,'037','Huhí'),(749,31,'038','Hunucmá'),(750,31,'039','Ixil'),(751,31,'040','Izamal'),(752,31,'041','Kanasín'),(753,31,'042','Kantunil'),(754,31,'043','Kaua'),(755,31,'044','Kinchil'),(756,31,'045','Kopomá'),(757,31,'046','Mama'),(758,31,'047','Maní'),(759,31,'048','Maxcanú'),(760,31,'049','Mayapán'),(761,31,'050','Mérida'),(762,31,'051','Mocochá'),(763,31,'052','Motul'),(764,31,'053','Muna'),(765,31,'054','Muxupip'),(766,31,'055','Opichén'),(767,31,'056','Oxkutzcab'),(768,31,'057','Panabá'),(769,31,'058','Peto'),(770,31,'059','Progreso'),(771,31,'060','Quintana Roo'),(772,31,'061','Río Lagartos'),(773,31,'062','Sacalum'),(774,31,'063','Samahil'),(775,31,'064','Sanahcat'),(776,31,'065','San Felipe'),(777,31,'066','Santa Elena'),(778,31,'067','Seyé'),(779,31,'068','Sinanché'),(780,31,'069','Sotuta'),(781,31,'070','Sucilá'),(782,31,'071','Sudzal'),(783,31,'072','Suma'),(784,31,'073','Tahdziú'),(785,31,'074','Tahmek'),(786,31,'075','Teabo'),(787,31,'076','Tecoh'),(788,31,'077','Tekal de Venegas'),(789,31,'078','Tekantó'),(790,31,'079','Tekax'),(791,31,'080','Tekit'),(792,31,'081','Tekom'),(793,31,'082','Telchac Pueblo'),(794,31,'083','Telchac Puerto'),(795,31,'084','Temax'),(796,31,'085','Temozón'),(797,31,'086','Tepakán'),(798,31,'087','Tetiz'),(799,31,'088','Teya'),(800,31,'089','Ticul'),(801,31,'090','Timucuy'),(802,31,'091','Tinum'),(803,31,'092','Tixcacalcupul'),(804,31,'093','Tixkokob'),(805,31,'094','Tixmehuac'),(806,31,'095','Tixpéhual'),(807,31,'096','Tizimín'),(808,31,'097','Tunkás'),(809,31,'098','Tzucacab'),(810,31,'099','Uayma'),(811,31,'100','Ucú'),(812,31,'101','Umán'),(813,31,'102','Valladolid'),(814,31,'103','Xocchel'),(815,31,'104','Yaxcabá'),(816,31,'105','Yaxkukul'),(817,31,'106','Yobaín'),(818,1,'001','Aguascalientes'),(819,1,'002','Asientos'),(820,1,'003','Calvillo'),(821,1,'004','Cosío'),(822,1,'005','Jesús María'),(823,1,'006','Pabellón de Arteaga'),(824,1,'007','Rincón de Romos'),(825,1,'008','San José de Gracia'),(826,1,'009','Tepezalá'),(827,1,'010','El Llano'),(828,1,'011','San Francisco de los Romo'),(829,2,'001','Ensenada '),(830,2,'002','Mexicali '),(831,2,'003','Tecate '),(832,2,'004','Tijuana '),(833,2,'005','Playas de Rosarito '),(834,3,'001','Comondú '),(835,3,'002','Mulegé '),(836,3,'003','La Paz '),(837,3,'008','Los Cabos '),(838,3,'009','Loreto '),(839,4,'001','Calkiní '),(840,4,'002','Campeche '),(841,4,'003','Carmen '),(842,4,'004','Champotón '),(843,4,'005','Hecelchakán '),(844,4,'006','Hopelchén '),(845,4,'007','Palizada '),(846,4,'008','Tenabo '),(847,4,'009','Escárcega '),(848,4,'010','Calakmul '),(849,4,'011','Candelaria '),(850,5,'001','Abasolo '),(851,5,'002','Acuña '),(852,5,'003','Allende '),(853,5,'004','Arteaga '),(854,5,'005','Candela '),(855,5,'006','Castaños '),(856,5,'007','Cuatro Ciénegas '),(857,5,'008','Escobedo '),(858,5,'009','Francisco I. Madero '),(859,5,'010','Frontera '),(860,5,'011','General Cepeda '),(861,5,'012','Guerrero '),(862,5,'013','Hidalgo '),(863,5,'014','Jiménez '),(864,5,'015','Juárez '),(865,5,'016','Lamadrid '),(866,5,'017','Matamoros '),(867,5,'018','Monclova '),(868,5,'019','Morelos '),(869,5,'020','Múzquiz '),(870,5,'021','Nadadores '),(871,5,'022','Nava '),(872,5,'023','Ocampo '),(873,5,'024','Parras '),(874,5,'025','Piedras Negras '),(875,5,'026','Progreso '),(876,5,'027','Ramos Arizpe '),(877,5,'028','Sabinas '),(878,5,'029','Sacramento '),(879,5,'030','Saltillo '),(880,5,'031','San Buenaventura '),(881,5,'032','San Juan de Sabinas '),(882,5,'033','San Pedro '),(883,5,'034','Sierra Mojada '),(884,5,'035','Torreón '),(885,5,'036','Viesca '),(886,5,'037','Villa Unión '),(887,5,'038','Zaragoza '),(888,6,'001','Armería'),(889,6,'002','Colima '),(890,6,'003','Comala '),(891,6,'004','Coquimatlán '),(892,6,'005','Cuauhtémoc '),(893,6,'006','Ixtlahuacán '),(894,6,'007','Manzanillo '),(895,6,'008','Minatitlán '),(896,6,'009','Tecomán '),(897,6,'010','Villa de Álvarez '),(898,7,'001','Acacoyagua '),(899,7,'002','Acala '),(900,7,'003','Acapetahua '),(901,7,'004','Altamirano '),(902,7,'005','Amatán '),(903,7,'006','Amatenango de la Frontera'),(904,7,'007','Amatenango del Valle '),(905,7,'008','Angel Albino Corzo '),(906,7,'009','Arriaga '),(907,7,'010','Bejucal de Ocampo '),(910,7,'011','Bella Vista '),(911,7,'012','Berriozábal '),(912,7,'013','Bochil '),(913,7,'014','El Bosque '),(914,7,'015','Cacahoatán'),(915,7,'016','Catazajá '),(916,7,'017','Cintalapa '),(917,7,'018','Coapilla '),(918,7,'019','Comitán de Domínguez '),(919,7,'020','La Concordia '),(920,7,'021','Copainalá '),(921,7,'022','Chalchihuitán '),(922,7,'023','Chamula '),(923,7,'024','Chanal '),(924,7,'025','Chapultenango'),(925,7,'026','Chenalhó '),(926,7,'027','Chiapa de Corzo '),(927,7,'028','Chiapilla '),(928,7,'029','Chicoasén '),(929,7,'030','Chicomuselo '),(930,7,'031','Chilón '),(931,7,'032','Escuintla '),(932,7,'033','Francisco León '),(933,7,'034','Frontera Comalapa '),(934,7,'035','Frontera Hidalgo '),(935,7,'036','La Grandeza '),(936,7,'037','Huehuetán '),(937,7,'038','Huixtán '),(938,7,'039','Huitiupán '),(939,7,'040','Huixtla '),(940,7,'041','La Independencia '),(941,7,'042','Ixhuatán '),(942,7,'043','Ixtacomitán '),(943,7,'044','Ixtapa '),(944,7,'045','Ixtapangajoya '),(945,7,'046','Jiquipilas '),(946,7,'047','Jitotol '),(947,7,'048','Juárez '),(948,7,'049','Larráinzar '),(949,7,'050','La Libertad '),(950,7,'051','Mapastepec '),(951,7,'052','Las Margaritas'),(952,7,'053','Mazapa de Madero'),(953,7,'054','Mazatán '),(954,7,'055','Metapa '),(955,7,'056','Mitontic '),(956,7,'057','Motozintla '),(957,7,'058','Nicolás Ruíz '),(958,7,'059','Ocosingo '),(959,7,'060','Ocotepec '),(960,7,'061','Ocozocoautla de Espinosa '),(961,7,'062','Ostuacán '),(962,7,'063','Osumacinta '),(963,7,'064','Oxchuc '),(964,7,'065','Palenque '),(965,7,'066','Pantelhó '),(966,7,'067','Pantepec '),(967,7,'068','Pichucalco '),(968,7,'069','Pijijiapan '),(969,7,'070','El Porvenir '),(970,7,'071','Villa Comaltitlán '),(971,7,'072','Pueblo Nuevo Solistahuacán '),(972,7,'073','Rayón '),(973,7,'074','Reforma '),(974,7,'075','Las Rosas '),(975,7,'076','Sabanilla '),(976,7,'077','Salto de Agua '),(977,7,'078','San Cristóbal de las Casas '),(978,7,'079','San Fernando '),(979,7,'080','Siltepec '),(980,7,'081','Simojovel '),(981,7,'082','Sitalá '),(982,7,'083','Socoltenango '),(983,7,'084','Solosuchiapa '),(984,7,'085','Soyaló '),(985,7,'086','Suchiapa '),(986,7,'087','Suchiate '),(987,7,'088','Sunuapa '),(988,7,'089','Tapachula '),(989,7,'090','Tapalapa '),(990,7,'091','Tapilula '),(991,7,'092','Tecpatán '),(992,7,'093','Tenejapa '),(993,7,'094','Teopisca '),(994,7,'096','Tila '),(995,7,'097','Tonalá '),(996,7,'098','Totolapa '),(997,7,'099','La Trinitaria '),(998,7,'100','Tumbalá '),(999,7,'101','Tuxtla Gutiérrez '),(1000,7,'102','Tuxtla Chico '),(1001,7,'103','Tuzantán '),(1002,7,'104','Tzimol '),(1003,7,'105','Unión Juárez '),(1004,7,'106','Venustiano Carranza'),(1005,7,'107','Villa Corzo '),(1006,7,'108','Villaflores '),(1007,7,'109','Yajalón '),(1008,7,'110','San Lucas '),(1009,7,'111','Zinacantán '),(1010,7,'112','San Juan Cancuc '),(1011,7,'113','Aldama '),(1012,7,'114','Benemérito de las Américas '),(1013,7,'115','Maravilla Tenejapa '),(1014,7,'116','Marqués de Comillas '),(1015,7,'117','Montecristo de Guerrero'),(1016,7,'118','San Andrés Duraznal '),(1017,7,'119','Santiago el Pinar '),(1018,8,'001','Ahumada '),(1019,8,'002','Aldama '),(1020,8,'003','Allende '),(1021,8,'004','Aquiles Serdán '),(1022,8,'005','Ascensión '),(1023,8,'006','Bachíniva '),(1024,8,'007','Balleza '),(1025,8,'008','Batopilas '),(1026,8,'009','Bocoyna '),(1027,8,'010','Buenaventura '),(1028,8,'011','Camargo '),(1029,8,'012','Carichí '),(1030,8,'013','Casas Grandes '),(1031,8,'014','Coronado '),(1032,8,'015','Coyame del Sotol '),(1033,8,'016','La Cruz '),(1034,8,'017','Cuauhtémoc '),(1035,8,'018','Cusihuiriachi '),(1036,8,'019','Chihuahua '),(1037,8,'020','Chínipas '),(1038,8,'021','Delicias '),(1039,8,'022','Dr. Belisario Domínguez '),(1040,8,'023','Galeana '),(1041,8,'024','Santa Isabel '),(1042,8,'025','Gómez Farías '),(1043,8,'026','Gran Morelos '),(1044,8,'027','Guachochi '),(1045,8,'028','Guadalupe '),(1046,8,'029','Guadalupe y Calvo '),(1047,8,'030','Guazapares '),(1048,8,'031','Guerrero '),(1049,8,'032','Hidalgo del Parral '),(1050,8,'033','Huejotitán '),(1051,8,'034','Ignacio Zaragoza '),(1052,8,'035','Janos '),(1053,8,'036','Jiménez '),(1054,8,'037','Juárez '),(1055,8,'038','Julimes '),(1056,8,'039','López '),(1057,8,'040','Madera '),(1058,8,'041','Maguarichi '),(1059,8,'042','Manuel Benavides '),(1060,8,'043','Matachí '),(1061,8,'044','Matamoros'),(1062,8,'045','Meoqui '),(1063,8,'046','Morelos '),(1064,8,'047','Moris '),(1065,8,'048','Namiquipa '),(1066,8,'049','Nonoava '),(1067,8,'050','Nuevo Casas Grandes '),(1068,8,'051','Ocampo '),(1069,8,'052','Ojinaga '),(1070,8,'053','Praxedis G. Guerrero'),(1071,8,'054','Riva Palacio '),(1072,8,'055','Rosales '),(1073,8,'056','Rosario '),(1074,8,'057','San Francisco de Borja '),(1075,8,'058','San Francisco de Conchos'),(1076,8,'059','San Francisco del Oro '),(1077,8,'060','Santa Bárbara '),(1078,8,'061','Satevó '),(1079,8,'062','Saucillo '),(1080,8,'063','Temósachic '),(1081,8,'064','El Tule '),(1082,8,'065','Urique '),(1083,8,'066','Uruachi '),(1084,8,'067','Valle de Zaragoza '),(1085,10,'001','Canatlán '),(1086,10,'002','Canelas '),(1087,10,'003','Coneto de Comonfort'),(1088,10,'004','Cuencamé '),(1089,10,'005','Durango '),(1090,10,'006','General Simón Bolívar'),(1091,10,'007','Gómez Palacio '),(1092,10,'008','Guadalupe Victoria '),(1093,10,'009','Guanaceví '),(1094,10,'010','Hidalgo '),(1095,10,'011','Indé '),(1096,10,'012','Lerdo '),(1097,10,'013','Mapimí '),(1098,10,'014','Mezquital '),(1099,10,'015','Nazas '),(1100,10,'016','Nombre de Dios '),(1101,10,'017','Ocampo '),(1102,10,'018','El Oro '),(1103,10,'019','Otáez '),(1104,10,'020','Pánuco de Coronado '),(1105,10,'021','Peñón Blanco '),(1106,10,'022','Poanas '),(1107,10,'023','Pueblo Nuevo '),(1108,10,'024','Rodeo '),(1109,10,'025','San Bernardo '),(1110,10,'026','San Dimas '),(1111,10,'027','San Juan de Guadalupe '),(1112,10,'028','San Juan del Río '),(1113,10,'029','San Luis del Cordero '),(1114,10,'030','San Pedro del Gallo '),(1115,10,'031','Santa Clara '),(1116,10,'032','Santiago Papasquiaro '),(1117,10,'033','Súchil '),(1118,10,'034','Tamazula '),(1119,10,'035','Tepehuanes '),(1120,10,'036','Tlahualilo '),(1121,10,'037','Topia '),(1122,10,'038','Vicente Guerrero '),(1123,10,'039','Nuevo Ideal '),(1124,12,'001','Acapulco de Juárez '),(1125,12,'002','Ahuacuotzingo '),(1126,12,'003','Ajuchitlán del Progreso '),(1127,12,'004','Alcozauca de Guerrero'),(1128,12,'005','Alpoyeca '),(1129,12,'006','Apaxtla '),(1130,12,'007','Arcelia '),(1131,12,'008','Atenango del Río '),(1132,12,'009','Atlamajalcingo del Monte '),(1133,12,'010','Atlixtac '),(1134,12,'011','Atoyac de Álvarez '),(1135,12,'012','Ayutla de los Libres '),(1136,12,'013','Azoyú '),(1137,12,'014','Benito Juárez '),(1138,12,'015','Buenavista de Cuéllar '),(1139,12,'016','Coahuayutla de José María Izazaga '),(1140,12,'017','Cocula '),(1141,12,'018','Copala '),(1142,12,'019','Copalillo '),(1143,12,'020','Copanatoyac '),(1144,12,'021','Coyuca de Benítez '),(1145,12,'022','Coyuca de Catalán '),(1146,12,'023','Cuajinicuilapa '),(1147,12,'024','Cualác '),(1148,12,'025','Cuautepec '),(1149,12,'026','Cuetzala del Progreso '),(1150,12,'027','Cutzamala de Pinzón '),(1151,12,'028','Chilapa de Álvarez '),(1152,12,'029','Chilpancingo de los Bravo '),(1153,12,'030','Florencio Villarreal '),(1154,12,'031','General Canuto A. Neri '),(1155,12,'032','General Heliodoro Castillo '),(1156,12,'033','Huamuxtitlán '),(1157,12,'034','Huitzuco de los Figueroa '),(1158,12,'035','Iguala de la Independencia '),(1159,12,'036','Igualapa '),(1160,12,'037','Ixcateopan de Cuauhtémoc '),(1161,12,'038','Zihuatanejo de Azueta '),(1162,12,'039','Juan R. Escudero '),(1163,12,'040','Leonardo Bravo '),(1164,12,'041','Malinaltepec '),(1165,12,'042','Mártir de Cuilapan '),(1166,12,'043','Metlatónoc '),(1167,12,'044','Mochitlán '),(1168,12,'045','Olinalá '),(1169,12,'046','Ometepec '),(1170,12,'047','Pedro Ascencio Alquisiras '),(1171,12,'048','Petatlán '),(1172,12,'049','Pilcaya '),(1173,12,'050','Pungarabato '),(1174,12,'051','Quechultenango '),(1175,12,'052','San Luis Acatlán '),(1176,12,'053','San Marcos '),(1177,12,'054','San Miguel Totolapan '),(1178,12,'055','Taxco de Alarcón '),(1179,12,'056','Tecoanapa'),(1180,12,'057','Técpan de Galeana '),(1181,12,'058','Teloloapan '),(1182,12,'059','Tepecoacuilco de Trujano '),(1183,12,'060','Tetipac '),(1184,12,'061','Tixtla de Guerrero '),(1185,12,'062','Tlacoachistlahuaca '),(1186,12,'063','Tlacoapa '),(1187,12,'064','Tlalchapa '),(1188,12,'065','Tlalixtaquilla de Maldonado '),(1189,12,'066','Tlapa de Comonfort '),(1190,12,'067','Tlapehuala '),(1191,12,'068','La Unión de Isidoro Montes de Oca'),(1192,12,'069','Xalpatláhuac '),(1193,12,'070','Xochihuehuetlán '),(1194,12,'071','Xochistlahuaca '),(1195,12,'072','Zapotitlán Tablas '),(1196,12,'073','Zirándaro '),(1197,12,'074','Zitlala '),(1198,12,'075','Eduardo Neri '),(1199,12,'076','Acatepec '),(1200,12,'077','Marquelia '),(1201,12,'078','Cochoapa el Grande '),(1202,12,'079','José Joaquin de Herrera '),(1203,12,'080','Juchitán '),(1204,12,'081','Iliatenco ');
/*!40000 ALTER TABLE `Municipio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Opcion`
--

DROP TABLE IF EXISTS `Opcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Opcion` (
  `idOpcion` int(11) NOT NULL AUTO_INCREMENT,
  `idCategoria` int(11) NOT NULL,
  `opcion` text NOT NULL,
  `claveOpcion` text NOT NULL,
  `orden` int(11) NOT NULL,
  PRIMARY KEY (`idOpcion`),
  KEY `fk_Opcion_Categoria1_idx` (`idCategoria`),
  CONSTRAINT `fk_Opcion_Categoria1` FOREIGN KEY (`idCategoria`) REFERENCES `Categoria` (`idCategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Opcion`
--

LOCK TABLES `Opcion` WRITE;
/*!40000 ALTER TABLE `Opcion` DISABLE KEYS */;
/*!40000 ALTER TABLE `Opcion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `OpcionesGrupo`
--

DROP TABLE IF EXISTS `OpcionesGrupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `OpcionesGrupo` (
  `idOpcionesGrupo` int(11) NOT NULL AUTO_INCREMENT,
  `idGrupo` int(11) NOT NULL,
  `opciones` text NOT NULL,
  PRIMARY KEY (`idOpcionesGrupo`,`idGrupo`),
  KEY `fk_OpcionesGrupo_Grupo1_idx` (`idGrupo`),
  CONSTRAINT `fk_OpcionesGrupo_Grupo1` FOREIGN KEY (`idGrupo`) REFERENCES `Grupo` (`idGrupo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `OpcionesGrupo`
--

LOCK TABLES `OpcionesGrupo` WRITE;
/*!40000 ALTER TABLE `OpcionesGrupo` DISABLE KEYS */;
/*!40000 ALTER TABLE `OpcionesGrupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `OpcionesPregunta`
--

DROP TABLE IF EXISTS `OpcionesPregunta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `OpcionesPregunta` (
  `idOpcionesPregunta` int(11) NOT NULL AUTO_INCREMENT,
  `idPregunta` int(11) NOT NULL,
  PRIMARY KEY (`idOpcionesPregunta`),
  KEY `fk_OpcionesPregunta_Pregunta1_idx` (`idPregunta`),
  CONSTRAINT `fk_OpcionesPregunta_Pregunta1` FOREIGN KEY (`idPregunta`) REFERENCES `Pregunta` (`idPregunta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `OpcionesPregunta`
--

LOCK TABLES `OpcionesPregunta` WRITE;
/*!40000 ALTER TABLE `OpcionesPregunta` DISABLE KEYS */;
/*!40000 ALTER TABLE `OpcionesPregunta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Parametro`
--

DROP TABLE IF EXISTS `Parametro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Parametro` (
  `idParametro` int(11) NOT NULL AUTO_INCREMENT,
  `idEmpresas` int(11) NOT NULL,
  `parametro` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  PRIMARY KEY (`idParametro`),
  KEY `fk_Parametro_Empresas1_idx` (`idEmpresas`),
  CONSTRAINT `fk_Parametro_Empresas1` FOREIGN KEY (`idEmpresas`) REFERENCES `Empresas` (`idEmpresas`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Parametro`
--

LOCK TABLES `Parametro` WRITE;
/*!40000 ALTER TABLE `Parametro` DISABLE KEYS */;
/*!40000 ALTER TABLE `Parametro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Poliza`
--

DROP TABLE IF EXISTS `Poliza`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Poliza` (
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
  CONSTRAINT `fk_Poliza_Empresa1` FOREIGN KEY (`idEmpresa`) REFERENCES `Empresa` (`idEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Poliza_Empresas1` FOREIGN KEY (`idEmpresas`) REFERENCES `Empresas` (`idEmpresas`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Poliza`
--

LOCK TABLES `Poliza` WRITE;
/*!40000 ALTER TABLE `Poliza` DISABLE KEYS */;
/*!40000 ALTER TABLE `Poliza` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Pregunta`
--

DROP TABLE IF EXISTS `Pregunta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Pregunta` (
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
-- Dumping data for table `Pregunta`
--

LOCK TABLES `Pregunta` WRITE;
/*!40000 ALTER TABLE `Pregunta` DISABLE KEYS */;
/*!40000 ALTER TABLE `Pregunta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Producto`
--

DROP TABLE IF EXISTS `Producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Producto` (
  `idProducto` int(11) NOT NULL AUTO_INCREMENT,
  `producto` varchar(150) NOT NULL,
  `claveProducto` varchar(60) NOT NULL,
  `codigoBarras` varchar(60) NOT NULL,
  PRIMARY KEY (`idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Producto`
--

LOCK TABLES `Producto` WRITE;
/*!40000 ALTER TABLE `Producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `Producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductoCompuesto`
--

DROP TABLE IF EXISTS `ProductoCompuesto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductoCompuesto` (
  `idProductoCompuesto` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` int(11) NOT NULL,
  `productoEnlazado` varchar(20) DEFAULT NULL,
  `cantidad` float DEFAULT NULL,
  PRIMARY KEY (`idProductoCompuesto`),
  KEY `fk_ProductoCompuesto_Producto1_idx` (`idProducto`),
  CONSTRAINT `fk_ProductoCompuesto_Producto1` FOREIGN KEY (`idProducto`) REFERENCES `Producto` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductoCompuesto`
--

LOCK TABLES `ProductoCompuesto` WRITE;
/*!40000 ALTER TABLE `ProductoCompuesto` DISABLE KEYS */;
/*!40000 ALTER TABLE `ProductoCompuesto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductoImpuesto`
--

DROP TABLE IF EXISTS `ProductoImpuesto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductoImpuesto` (
  `idProductoImpuesto` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` int(11) NOT NULL,
  `idImpuesto` int(11) NOT NULL,
  PRIMARY KEY (`idProductoImpuesto`),
  KEY `fk_ProductoImpuesto_Producto1_idx` (`idProducto`),
  KEY `fk_ProductoImpuesto_Impuesto1_idx` (`idImpuesto`),
  CONSTRAINT `fk_ProductoImpuesto_Impuesto1` FOREIGN KEY (`idImpuesto`) REFERENCES `Impuesto` (`idImpuesto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ProductoImpuesto_Producto1` FOREIGN KEY (`idProducto`) REFERENCES `Producto` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductoImpuesto`
--

LOCK TABLES `ProductoImpuesto` WRITE;
/*!40000 ALTER TABLE `ProductoImpuesto` DISABLE KEYS */;
/*!40000 ALTER TABLE `ProductoImpuesto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Proveedores`
--

DROP TABLE IF EXISTS `Proveedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Proveedores` (
  `idProveedores` int(11) NOT NULL AUTO_INCREMENT,
  `idEmpresa` int(11) NOT NULL,
  `idTipoProveedor` int(11) NOT NULL,
  PRIMARY KEY (`idProveedores`),
  KEY `fk_Proveedores_Empresa1_idx` (`idEmpresa`),
  KEY `fk_Proveedores_TipoProveedor1_idx` (`idTipoProveedor`),
  CONSTRAINT `fk_Proveedores_Empresa1` FOREIGN KEY (`idEmpresa`) REFERENCES `Empresa` (`idEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Proveedores_TipoProveedor1` FOREIGN KEY (`idTipoProveedor`) REFERENCES `TipoProveedor` (`idTipoProveedor`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Proveedores`
--

LOCK TABLES `Proveedores` WRITE;
/*!40000 ALTER TABLE `Proveedores` DISABLE KEYS */;
/*!40000 ALTER TABLE `Proveedores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Proyecto`
--

DROP TABLE IF EXISTS `Proyecto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Proyecto` (
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
-- Dumping data for table `Proyecto`
--

LOCK TABLES `Proyecto` WRITE;
/*!40000 ALTER TABLE `Proyecto` DISABLE KEYS */;
/*!40000 ALTER TABLE `Proyecto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Realizadas`
--

DROP TABLE IF EXISTS `Realizadas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Realizadas` (
  `idRealizadas` int(11) NOT NULL AUTO_INCREMENT,
  `idRegistro` int(11) NOT NULL,
  `idEncuesta` int(11) NOT NULL,
  PRIMARY KEY (`idRealizadas`),
  KEY `fk_Realizadas_Registro1_idx` (`idRegistro`),
  KEY `fk_Realizadas_Encuesta1_idx` (`idEncuesta`),
  CONSTRAINT `fk_Realizadas_Encuesta1` FOREIGN KEY (`idEncuesta`) REFERENCES `Encuesta` (`idEncuesta`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Realizadas_Registro1` FOREIGN KEY (`idRegistro`) REFERENCES `Registro` (`idRegistro`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Realizadas`
--

LOCK TABLES `Realizadas` WRITE;
/*!40000 ALTER TABLE `Realizadas` DISABLE KEYS */;
/*!40000 ALTER TABLE `Realizadas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Registro`
--

DROP TABLE IF EXISTS `Registro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Registro` (
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
-- Dumping data for table `Registro`
--

LOCK TABLES `Registro` WRITE;
/*!40000 ALTER TABLE `Registro` DISABLE KEYS */;
/*!40000 ALTER TABLE `Registro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Respuesta`
--

DROP TABLE IF EXISTS `Respuesta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Respuesta` (
  `idRespuesta` int(11) NOT NULL AUTO_INCREMENT,
  `idPregunta` int(11) NOT NULL,
  `respuesta` text NOT NULL,
  PRIMARY KEY (`idRespuesta`),
  KEY `fk_Respuesta_Pregunta1_idx` (`idPregunta`),
  CONSTRAINT `fk_Respuesta_Pregunta1` FOREIGN KEY (`idPregunta`) REFERENCES `Pregunta` (`idPregunta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Respuesta`
--

LOCK TABLES `Respuesta` WRITE;
/*!40000 ALTER TABLE `Respuesta` DISABLE KEYS */;
/*!40000 ALTER TABLE `Respuesta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Seccion`
--

DROP TABLE IF EXISTS `Seccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Seccion` (
  `idSeccion` int(11) NOT NULL AUTO_INCREMENT,
  `idEncuesta` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `fecha` datetime NOT NULL,
  `claveSeccion` text NOT NULL,
  `orden` int(11) NOT NULL,
  `elementos` int(11) NOT NULL,
  PRIMARY KEY (`idSeccion`),
  KEY `fk_Seccion_Encuesta1_idx` (`idEncuesta`),
  CONSTRAINT `fk_Seccion_Encuesta1` FOREIGN KEY (`idEncuesta`) REFERENCES `Encuesta` (`idEncuesta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Seccion`
--

LOCK TABLES `Seccion` WRITE;
/*!40000 ALTER TABLE `Seccion` DISABLE KEYS */;
/*!40000 ALTER TABLE `Seccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Subparametro`
--

DROP TABLE IF EXISTS `Subparametro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Subparametro` (
  `idSubparametro` int(11) NOT NULL AUTO_INCREMENT,
  `idParametro` int(11) NOT NULL,
  `subparametro` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  PRIMARY KEY (`idSubparametro`),
  KEY `fk_Subparametro_Parametro1_idx` (`idParametro`),
  CONSTRAINT `fk_Subparametro_Parametro1` FOREIGN KEY (`idParametro`) REFERENCES `Parametro` (`idParametro`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Subparametro`
--

LOCK TABLES `Subparametro` WRITE;
/*!40000 ALTER TABLE `Subparametro` DISABLE KEYS */;
/*!40000 ALTER TABLE `Subparametro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Telefono`
--

DROP TABLE IF EXISTS `Telefono`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Telefono` (
  `idTelefono` int(11) NOT NULL AUTO_INCREMENT,
  `lada` varchar(7) DEFAULT NULL,
  `telefono` varchar(16) NOT NULL,
  `extensiones` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idTelefono`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Telefono`
--

LOCK TABLES `Telefono` WRITE;
/*!40000 ALTER TABLE `Telefono` DISABLE KEYS */;
INSERT INTO `Telefono` VALUES (1,'01','50-03-29-90','-'),(2,'01','50-0329-93','-'),(3,'01','50-25-12-07','-'),(4,'01','50-25-15-79','-'),(5,'01','50-03-29-94','-'),(6,'01','0','-'),(7,'01','0','-'),(8,'01','59323113','-'),(9,'01','29260101','-'),(10,'01','477 470 2900','-'),(17,'01','4596-8335','-'),(18,'01','17791007955','-'),(19,'01','58921972','-'),(20,'01','49187227','-'),(23,'-','-','-'),(24,'01','722 279 7700','-'),(25,'01','591 9116291','-'),(26,'-','-','-'),(29,'01','594 956 8360','-'),(30,'-','-','-'),(31,'-','-','-'),(32,'-','-','-'),(33,'045','5560614024','-'),(34,'01','55 6298 9733','-'),(36,'-','-','-'),(37,'-','-','-'),(38,'01',' 5878 01 11','-'),(39,'-','-','-'),(40,'-','-','-'),(44,'01','55 50 93 46 63','-'),(45,'01','55 3300 5700','-');
/*!40000 ALTER TABLE `Telefono` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TipoMovimiento`
--

DROP TABLE IF EXISTS `TipoMovimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TipoMovimiento` (
  `idTipoMovimiento` int(11) NOT NULL AUTO_INCREMENT,
  `tipoMovimiento` varchar(2) NOT NULL,
  `descripcion` text NOT NULL,
  `afectaInventario` varchar(1) NOT NULL,
  `afectaSaldo` varchar(1) NOT NULL,
  PRIMARY KEY (`idTipoMovimiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TipoMovimiento`
--

LOCK TABLES `TipoMovimiento` WRITE;
/*!40000 ALTER TABLE `TipoMovimiento` DISABLE KEYS */;
/*!40000 ALTER TABLE `TipoMovimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TipoProveedor`
--

DROP TABLE IF EXISTS `TipoProveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TipoProveedor` (
  `idTipoProveedor` int(11) NOT NULL AUTO_INCREMENT,
  `clave` varchar(2) NOT NULL,
  `descripcion` text,
  PRIMARY KEY (`idTipoProveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TipoProveedor`
--

LOCK TABLES `TipoProveedor` WRITE;
/*!40000 ALTER TABLE `TipoProveedor` DISABLE KEYS */;
INSERT INTO `TipoProveedor` VALUES (1,'AS','ASIMILADO'),(2,'NO','NOMINA');
/*!40000 ALTER TABLE `TipoProveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Vendedor`
--

DROP TABLE IF EXISTS `Vendedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Vendedor` (
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
  CONSTRAINT `fk_Vendedor_Domicilio1` FOREIGN KEY (`idDomicilio`) REFERENCES `Domicilio` (`idDomicilio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Vendedor_Telefono1` FOREIGN KEY (`idTelefono`) REFERENCES `Telefono` (`idTelefono`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Vendedor`
--

LOCK TABLES `Vendedor` WRITE;
/*!40000 ALTER TABLE `Vendedor` DISABLE KEYS */;
/*!40000 ALTER TABLE `Vendedor` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-16 23:35:32
