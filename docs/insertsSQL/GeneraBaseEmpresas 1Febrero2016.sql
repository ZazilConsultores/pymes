-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema GeneralEmpresas
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `GeneralEmpresas` ;

-- -----------------------------------------------------
-- Schema GeneralEmpresas
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `GeneralEmpresas` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `GeneralEmpresas` ;

-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Estado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Estado` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Estado` (
  `idEstado` INT NOT NULL AUTO_INCREMENT,
  `estado` VARCHAR(100) NOT NULL,
  `capital` VARCHAR(100) NULL,
  PRIMARY KEY (`idEstado`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Municipio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Municipio` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Municipio` (
  `idMunicipio` INT NOT NULL AUTO_INCREMENT,
  `idEstado` INT NOT NULL,
  `municipio` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idMunicipio`),
  INDEX `fk_Municipio_Estado_idx` (`idEstado` ASC),
  CONSTRAINT `fk_Municipio_Estado`
    FOREIGN KEY (`idEstado`)
    REFERENCES `GeneralEmpresas`.`Estado` (`idEstado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Telefono`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Telefono` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Telefono` (
  `idTelefono` INT NOT NULL AUTO_INCREMENT,
  `lada` VARCHAR(7) NULL,
  `tipo` VARCHAR(2) NOT NULL,
  `telefono` VARCHAR(16) NOT NULL,
  `extensiones` VARCHAR(30) NULL,
  `descripcion` TEXT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idTelefono`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Email`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Email` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Email` (
  `idEmail` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(60) NOT NULL,
  `descripcion` VARCHAR(45) NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idEmail`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Divisa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Divisa` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Divisa` (
  `idDivisa` INT NOT NULL AUTO_INCREMENT,
  `divisa` VARCHAR(200) NOT NULL,
  `claveDivisa` VARCHAR(10) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `tipoCambio` FLOAT NOT NULL,
  PRIMARY KEY (`idDivisa`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Banco`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Banco` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Banco` (
  `idBanco` INT NOT NULL AUTO_INCREMENT,
  `idDivisa` INT NOT NULL,
  `banco` VARCHAR(200) NOT NULL,
  `cuenta` VARCHAR(60) NOT NULL,
  `tipo` VARCHAR(20) NOT NULL,
  `fecha` DATETIME NOT NULL,
  `saldo` DECIMAL NOT NULL,
  PRIMARY KEY (`idBanco`),
  INDEX `fk_Banco_Divisa1_idx` (`idDivisa` ASC),
  CONSTRAINT `fk_Banco_Divisa1`
    FOREIGN KEY (`idDivisa`)
    REFERENCES `GeneralEmpresas`.`Divisa` (`idDivisa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Fiscales`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Fiscales` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Fiscales` (
  `idFiscales` INT NOT NULL AUTO_INCREMENT,
  `rfc` VARCHAR(13) NOT NULL,
  `razonSocial` VARCHAR(200) NOT NULL,
  `idDomicilio` INT NULL,
  `idsTelefonos` TEXT NULL,
  `idsEmails` TEXT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idFiscales`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Domicilio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Domicilio` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Domicilio` (
  `idDomicilio` INT NOT NULL AUTO_INCREMENT,
  `idMunicipio` INT NOT NULL,
  `calle` VARCHAR(60) NOT NULL,
  `colonia` VARCHAR(60) NOT NULL,
  `codigoPostal` VARCHAR(5) NOT NULL,
  `numeroInterior` VARCHAR(60) NOT NULL,
  `numeroExterior` VARCHAR(60) NOT NULL,
  `hash` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idDomicilio`),
  INDEX `fk_Domicilio_Municipio1_idx` (`idMunicipio` ASC),
  CONSTRAINT `fk_Domicilio_Municipio1`
    FOREIGN KEY (`idMunicipio`)
    REFERENCES `GeneralEmpresas`.`Municipio` (`idMunicipio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Empresa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Empresa` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Empresa` (
  `idEmpresa` INT NOT NULL AUTO_INCREMENT,
  `idFiscales` INT NOT NULL,
  `esEmpresa` VARCHAR(1) NULL DEFAULT 'N',
  `esCliente` VARCHAR(1) NULL DEFAULT 'N',
  `esProveedor` VARCHAR(1) NULL DEFAULT 'N',
  `idsBancos` TEXT NULL,
  `hash` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idEmpresa`),
  INDEX `fk_Empresa_Fiscales1_idx` (`idFiscales` ASC),
  CONSTRAINT `fk_Empresa_Fiscales1`
    FOREIGN KEY (`idFiscales`)
    REFERENCES `GeneralEmpresas`.`Fiscales` (`idFiscales`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Parametro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Parametro` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Parametro` (
  `idParametro` INT NOT NULL AUTO_INCREMENT,
  `parametro` VARCHAR(200) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idParametro`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Subparametro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Subparametro` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Subparametro` (
  `idSubparametro` INT NOT NULL AUTO_INCREMENT,
  `idParametro` INT NOT NULL,
  `subparametro` VARCHAR(200) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idSubparametro`),
  INDEX `fk_Subparametro_Parametro1_idx` (`idParametro` ASC),
  CONSTRAINT `fk_Subparametro_Parametro1`
    FOREIGN KEY (`idParametro`)
    REFERENCES `GeneralEmpresas`.`Parametro` (`idParametro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Producto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Producto` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Producto` (
  `idProducto` INT NOT NULL AUTO_INCREMENT,
  `producto` VARCHAR(150) NOT NULL,
  `claveProducto` VARCHAR(60) NULL,
  PRIMARY KEY (`idProducto`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Impuesto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Impuesto` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Impuesto` (
  `idImpuesto` INT NOT NULL AUTO_INCREMENT,
  `impuesto` VARCHAR(60) NOT NULL,
  `abreviatura` VARCHAR(15) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `porcentaje` FLOAT NOT NULL,
  `estatus` VARCHAR(1) NOT NULL,
  `fechaPublicacion` DATETIME NOT NULL,
  PRIMARY KEY (`idImpuesto`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Factura`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Factura` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Factura` (
  `idFactura` INT NOT NULL AUTO_INCREMENT,
  `factura` VARCHAR(150) NOT NULL,
  `idEmpresa` INT NOT NULL,
  `idCliente` INT NULL,
  `idProveedor` INT NULL,
  `fecha` DATETIME NOT NULL,
  `subtotal` DECIMAL NOT NULL,
  `total` DECIMAL NOT NULL,
  `hash` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idFactura`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Multiplos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Multiplos` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Multiplos` (
  `idMultiplos` INT NOT NULL AUTO_INCREMENT,
  `idProducto` INT NOT NULL,
  `cantidad` FLOAT NOT NULL,
  `unidad` VARCHAR(20) NOT NULL,
  `abreviatura` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`idMultiplos`),
  INDEX `fk_Multiplos_Producto1_idx` (`idProducto` ASC),
  CONSTRAINT `fk_Multiplos_Producto1`
    FOREIGN KEY (`idProducto`)
    REFERENCES `GeneralEmpresas`.`Producto` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`FacturaDetalle`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`FacturaDetalle` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`FacturaDetalle` (
  `idFactura` INT NOT NULL,
  `idMultiplos` INT NOT NULL,
  `secuencial` INT NOT NULL,
  `cantidad` FLOAT NOT NULL,
  `descripcion` TEXT NOT NULL,
  `precioUnitario` DECIMAL NOT NULL,
  `importe` DECIMAL NOT NULL,
  PRIMARY KEY (`idFactura`),
  INDEX `fk_FacturaDetalle_Factura1_idx` (`idFactura` ASC),
  INDEX `fk_FacturaDetalle_Multiplos1_idx` (`idMultiplos` ASC),
  CONSTRAINT `fk_FacturaDetalle_Factura1`
    FOREIGN KEY (`idFactura`)
    REFERENCES `GeneralEmpresas`.`Factura` (`idFactura`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_FacturaDetalle_Multiplos1`
    FOREIGN KEY (`idMultiplos`)
    REFERENCES `GeneralEmpresas`.`Multiplos` (`idMultiplos`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Poliza`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Poliza` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Poliza` (
  `idPoliza` INT NOT NULL AUTO_INCREMENT,
  `idEmpresa` INT NOT NULL,
  `idCliente` INT NULL,
  `idProveedor` VARCHAR(45) NULL,
  `tipo` VARCHAR(2) NOT NULL,
  `poliza` VARCHAR(100) NOT NULL,
  `fecha` DATETIME NOT NULL,
  `tipoPoliza` VARCHAR(2) NOT NULL,
  `origen` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idPoliza`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Proyecto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Proyecto` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Proyecto` (
  `idProyecto` INT NOT NULL AUTO_INCREMENT,
  `proyecto` VARCHAR(60) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `costo` DECIMAL NOT NULL,
  `ganancia` DECIMAL NOT NULL,
  `fechaApertura` DATETIME NOT NULL,
  `fechaCierre` DATETIME NOT NULL,
  PRIMARY KEY (`idProyecto`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`TipoMovimiento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`TipoMovimiento` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`TipoMovimiento` (
  `idTipoMovimiento` INT NOT NULL AUTO_INCREMENT,
  `tipoMovimiento` VARCHAR(2) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `afectaInventario` VARCHAR(1) NOT NULL,
  `afectaSaldo` VARCHAR(1) NOT NULL,
  PRIMARY KEY (`idTipoMovimiento`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Cuentasxc`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Cuentasxc` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Cuentasxc` (
  `idCuentasxc` INT NOT NULL AUTO_INCREMENT,
  `idEmpresa` INT NOT NULL,
  `idCliente` INT NOT NULL,
  `idFactura` INT NOT NULL,
  `idTipoMovimiento` INT NOT NULL,
  `idProyecto` INT NOT NULL,
  `secuencial` INT NOT NULL,
  `numeroReferencia` VARCHAR(100) NOT NULL,
  `descripcion` TEXT NULL,
  `estatus` VARCHAR(2) NULL,
  `conceptoPago` VARCHAR(10) NULL,
  `formaLiquidar` VARCHAR(15) NULL,
  `fecha` DATETIME NULL,
  `fechaCaptura` DATETIME NULL,
  `subtotal` DECIMAL NULL,
  `total` DECIMAL NULL,
  PRIMARY KEY (`idCuentasxc`),
  INDEX `fk_Cuentasxc_Proyecto1_idx` (`idProyecto` ASC),
  INDEX `fk_Cuentasxc_Factura1_idx` (`idFactura` ASC),
  INDEX `fk_Cuentasxc_TipoMovimiento1_idx` (`idTipoMovimiento` ASC),
  CONSTRAINT `fk_Cuentasxc_Proyecto1`
    FOREIGN KEY (`idProyecto`)
    REFERENCES `GeneralEmpresas`.`Proyecto` (`idProyecto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxc_Factura1`
    FOREIGN KEY (`idFactura`)
    REFERENCES `GeneralEmpresas`.`Factura` (`idFactura`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxc_TipoMovimiento1`
    FOREIGN KEY (`idTipoMovimiento`)
    REFERENCES `GeneralEmpresas`.`TipoMovimiento` (`idTipoMovimiento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Cuentasxp`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Cuentasxp` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Cuentasxp` (
  `idCuentasxp` INT NOT NULL AUTO_INCREMENT,
  `idEmpresa` INT NOT NULL,
  `idProveedor` INT NOT NULL,
  `idFactura` INT NOT NULL,
  `idTipoMovimiento` INT NOT NULL,
  `idProyecto` INT NOT NULL,
  `fechaCaptura` DATETIME NULL,
  `secuencial` INT NULL,
  `descripcion` TEXT NULL,
  `estatus` VARCHAR(1) NULL,
  `conceptoPago` VARCHAR(2) NULL,
  `formaLiquidar` VARCHAR(15) NULL,
  `fecha` DATETIME NULL,
  `subtotal` DECIMAL NULL,
  `total` DECIMAL NULL,
  PRIMARY KEY (`idCuentasxp`),
  INDEX `fk_Cuentasxp_Proyecto1_idx` (`idProyecto` ASC),
  INDEX `fk_Cuentasxp_Factura1_idx` (`idFactura` ASC),
  INDEX `fk_Cuentasxp_TipoMovimiento1_idx` (`idTipoMovimiento` ASC),
  CONSTRAINT `fk_Cuentasxp_Proyecto1`
    FOREIGN KEY (`idProyecto`)
    REFERENCES `GeneralEmpresas`.`Proyecto` (`idProyecto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxp_Factura1`
    FOREIGN KEY (`idFactura`)
    REFERENCES `GeneralEmpresas`.`Factura` (`idFactura`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxp_TipoMovimiento1`
    FOREIGN KEY (`idTipoMovimiento`)
    REFERENCES `GeneralEmpresas`.`TipoMovimiento` (`idTipoMovimiento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Cardex`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Cardex` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Cardex` (
  `idCardex` INT NOT NULL AUTO_INCREMENT,
  `secuencialEntrada` INT NOT NULL,
  `fechaEntrada` DATETIME NOT NULL,
  `idProducto` INT NOT NULL,
  `secuencialSalida` INT NULL,
  `fechaSalida` DATETIME NULL,
  `cantidad` FLOAT NULL,
  `costo` DECIMAL NULL,
  `costoSalida` DECIMAL NULL,
  `idFactura` INT NOT NULL,
  `utilidad` DECIMAL NULL,
  `idDivisa` INT NOT NULL,
  `idPoliza` INT NOT NULL,
  `estatus` VARCHAR(1) NULL,
  PRIMARY KEY (`idCardex`),
  INDEX `fk_Cardex_Producto1_idx` (`idProducto` ASC),
  INDEX `fk_Cardex_Factura1_idx` (`idFactura` ASC),
  INDEX `fk_Cardex_Divisa1_idx` (`idDivisa` ASC),
  INDEX `fk_Cardex_Poliza1_idx` (`idPoliza` ASC),
  CONSTRAINT `fk_Cardex_Producto1`
    FOREIGN KEY (`idProducto`)
    REFERENCES `GeneralEmpresas`.`Producto` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cardex_Factura1`
    FOREIGN KEY (`idFactura`)
    REFERENCES `GeneralEmpresas`.`Factura` (`idFactura`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cardex_Divisa1`
    FOREIGN KEY (`idDivisa`)
    REFERENCES `GeneralEmpresas`.`Divisa` (`idDivisa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cardex_Poliza1`
    FOREIGN KEY (`idPoliza`)
    REFERENCES `GeneralEmpresas`.`Poliza` (`idPoliza`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`ProductoCompuesto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`ProductoCompuesto` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`ProductoCompuesto` (
  `idProductoCompuesto` INT NOT NULL AUTO_INCREMENT,
  `idProducto` INT NOT NULL,
  `productoEnlazado` VARCHAR(20) NULL,
  `cantidad` FLOAT NULL,
  PRIMARY KEY (`idProductoCompuesto`),
  INDEX `fk_ProductoCompuesto_Producto1_idx` (`idProducto` ASC),
  CONSTRAINT `fk_ProductoCompuesto_Producto1`
    FOREIGN KEY (`idProducto`)
    REFERENCES `GeneralEmpresas`.`Producto` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Capas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Capas` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Capas` (
  `idCapas` INT NOT NULL AUTO_INCREMENT,
  `idProducto` INT NOT NULL,
  `secuencial` INT NULL,
  `entrada` DOUBLE NULL,
  `fechaEntrada` DATETIME NULL,
  `costoUnitario` DECIMAL NULL,
  `costoTotal` DECIMAL NULL,
  `idDivisa` INT NOT NULL,
  PRIMARY KEY (`idCapas`),
  INDEX `fk_Capas_Divisa1_idx` (`idDivisa` ASC),
  INDEX `fk_Capas_Producto1_idx` (`idProducto` ASC),
  CONSTRAINT `fk_Capas_Divisa1`
    FOREIGN KEY (`idDivisa`)
    REFERENCES `GeneralEmpresas`.`Divisa` (`idDivisa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Capas_Producto1`
    FOREIGN KEY (`idProducto`)
    REFERENCES `GeneralEmpresas`.`Producto` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`TipoProveedor`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`TipoProveedor` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`TipoProveedor` (
  `idTipoProveedor` INT NOT NULL AUTO_INCREMENT,
  `clave` VARCHAR(2) NOT NULL,
  `descripcion` TEXT NULL,
  PRIMARY KEY (`idTipoProveedor`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Vendedor`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Vendedor` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Vendedor` (
  `idVendedor` INT NOT NULL AUTO_INCREMENT,
  `claveVendedor` VARCHAR(20) NOT NULL,
  `nombre` VARCHAR(60) NOT NULL,
  `idDomicilio` INT NOT NULL,
  `estatus` VARCHAR(1) NOT NULL,
  `fechaAlta` DATETIME NOT NULL,
  `comision` DECIMAL NOT NULL,
  PRIMARY KEY (`idVendedor`),
  INDEX `fk_Vendedor_Domicilio1_idx` (`idDomicilio` ASC),
  CONSTRAINT `fk_Vendedor_Domicilio1`
    FOREIGN KEY (`idDomicilio`)
    REFERENCES `GeneralEmpresas`.`Domicilio` (`idDomicilio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Movimientos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Movimientos` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Movimientos` (
  `idMovimientos` INT NOT NULL AUTO_INCREMENT,
  `idProducto` INT NOT NULL,
  `idTipoMovimiento` INT NOT NULL,
  `idFactura` INT NOT NULL,
  `idProyecto` INT NOT NULL,
  `idPoliza` INT NOT NULL,
  `cantidad` DECIMAL NOT NULL,
  `fecha` DATETIME NOT NULL,
  `secuencial` INT NOT NULL,
  `estatus` VARCHAR(1) NOT NULL,
  `costoUnitario` DECIMAL NOT NULL,
  `esOrigen` VARCHAR(1) NOT NULL,
  PRIMARY KEY (`idMovimientos`),
  INDEX `fk_Movimientos_Producto1_idx` (`idProducto` ASC),
  INDEX `fk_Movimientos_TipoMovimiento1_idx` (`idTipoMovimiento` ASC),
  INDEX `fk_Movimientos_Factura1_idx` (`idFactura` ASC),
  INDEX `fk_Movimientos_Proyecto1_idx` (`idProyecto` ASC),
  INDEX `fk_Movimientos_Poliza1_idx` (`idPoliza` ASC),
  CONSTRAINT `fk_Movimientos_Producto1`
    FOREIGN KEY (`idProducto`)
    REFERENCES `GeneralEmpresas`.`Producto` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Movimientos_TipoMovimiento1`
    FOREIGN KEY (`idTipoMovimiento`)
    REFERENCES `GeneralEmpresas`.`TipoMovimiento` (`idTipoMovimiento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Movimientos_Factura1`
    FOREIGN KEY (`idFactura`)
    REFERENCES `GeneralEmpresas`.`Factura` (`idFactura`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Movimientos_Proyecto1`
    FOREIGN KEY (`idProyecto`)
    REFERENCES `GeneralEmpresas`.`Proyecto` (`idProyecto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Movimientos_Poliza1`
    FOREIGN KEY (`idPoliza`)
    REFERENCES `GeneralEmpresas`.`Poliza` (`idPoliza`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Inventario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Inventario` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Inventario` (
  `idInventario` INT NOT NULL AUTO_INCREMENT,
  `idEmpresa` INT NOT NULL,
  `idProducto` INT NOT NULL,
  `idDivisa` INT NOT NULL,
  `existencia` DECIMAL NOT NULL,
  `apartado` DECIMAL NOT NULL,
  `existenciaReal` DECIMAL NOT NULL,
  `maximo` DECIMAL NOT NULL,
  `minimo` DECIMAL NOT NULL,
  `fecha` DATETIME NOT NULL,
  `costoUnitario` DECIMAL NOT NULL,
  `porcentajeGanancia` DECIMAL NOT NULL,
  `cantidadGanancia` DECIMAL NOT NULL,
  `costoCliente` DECIMAL NOT NULL,
  PRIMARY KEY (`idInventario`),
  INDEX `fk_Inventario_Producto1_idx` (`idProducto` ASC),
  INDEX `fk_Inventario_Divisa1_idx` (`idDivisa` ASC),
  CONSTRAINT `fk_Inventario_Producto1`
    FOREIGN KEY (`idProducto`)
    REFERENCES `GeneralEmpresas`.`Producto` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Inventario_Divisa1`
    FOREIGN KEY (`idDivisa`)
    REFERENCES `GeneralEmpresas`.`Divisa` (`idDivisa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Encuesta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Encuesta` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Encuesta` (
  `idEncuesta` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(200) NOT NULL,
  `nombreClave` VARCHAR(30) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `estatus` VARCHAR(1) NOT NULL,
  `fecha` DATETIME NOT NULL,
  `fechaInicio` DATETIME NOT NULL,
  `fechaFin` DATETIME NOT NULL,
  `hash` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idEncuesta`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Registro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Registro` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Registro` (
  `idRegistro` INT NOT NULL AUTO_INCREMENT,
  `referencia` TEXT NOT NULL,
  `tipo` VARCHAR(5) NOT NULL,
  `nombres` VARCHAR(200) NOT NULL,
  `apellidos` VARCHAR(200) NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idRegistro`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Seccion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Seccion` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Seccion` (
  `idSeccion` INT NOT NULL AUTO_INCREMENT,
  `idEncuesta` INT NOT NULL,
  `nombre` VARCHAR(200) NOT NULL,
  `orden` INT NOT NULL,
  `elementos` INT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idSeccion`),
  INDEX `fk_Seccion_Encuesta1_idx` (`idEncuesta` ASC),
  CONSTRAINT `fk_Seccion_Encuesta1`
    FOREIGN KEY (`idEncuesta`)
    REFERENCES `GeneralEmpresas`.`Encuesta` (`idEncuesta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Grupo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Grupo` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Grupo` (
  `idGrupo` INT NOT NULL AUTO_INCREMENT,
  `idSeccion` INT NOT NULL,
  `nombre` VARCHAR(200) NOT NULL,
  `tipo` VARCHAR(2) NOT NULL,
  `opciones` TEXT NULL,
  `orden` INT NOT NULL,
  `elementos` INT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idGrupo`),
  INDEX `fk_Grupo_Seccion1_idx` (`idSeccion` ASC),
  CONSTRAINT `fk_Grupo_Seccion1`
    FOREIGN KEY (`idSeccion`)
    REFERENCES `GeneralEmpresas`.`Seccion` (`idSeccion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Pregunta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Pregunta` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Pregunta` (
  `idPregunta` INT NOT NULL AUTO_INCREMENT,
  `idEncuesta` INT NOT NULL,
  `pregunta` TEXT NOT NULL,
  `origen` VARCHAR(1) NOT NULL,
  `idOrigen` VARCHAR(20) NOT NULL,
  `tipo` VARCHAR(2) NOT NULL,
  `opciones` TEXT NULL,
  `orden` INT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idPregunta`),
  INDEX `fk_Pregunta_Encuesta1_idx` (`idEncuesta` ASC),
  CONSTRAINT `fk_Pregunta_Encuesta1`
    FOREIGN KEY (`idEncuesta`)
    REFERENCES `GeneralEmpresas`.`Encuesta` (`idEncuesta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Categoria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Categoria` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Categoria` (
  `idCategoria` INT NOT NULL AUTO_INCREMENT,
  `categoria` TEXT NOT NULL,
  `descripcion` TEXT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idCategoria`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Opcion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Opcion` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Opcion` (
  `idOpcion` INT NOT NULL AUTO_INCREMENT,
  `idCategoria` INT NOT NULL,
  `opcion` TEXT NOT NULL,
  `orden` INT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idOpcion`),
  INDEX `fk_Opcion_Categoria1_idx` (`idCategoria` ASC),
  CONSTRAINT `fk_Opcion_Categoria1`
    FOREIGN KEY (`idCategoria`)
    REFERENCES `GeneralEmpresas`.`Categoria` (`idCategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Respuesta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Respuesta` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Respuesta` (
  `idEncuesta` INT NOT NULL,
  `idRegistro` INT NOT NULL,
  `idPregunta` INT NOT NULL,
  `respuesta` TEXT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NOT NULL,
  INDEX `fk_Respuesta_Pregunta1_idx` (`idPregunta` ASC),
  INDEX `fk_Respuesta_Registro1_idx` (`idRegistro` ASC),
  INDEX `fk_Respuesta_Encuesta1_idx` (`idEncuesta` ASC),
  PRIMARY KEY (`idEncuesta`, `idRegistro`, `idPregunta`),
  CONSTRAINT `fk_Respuesta_Pregunta1`
    FOREIGN KEY (`idPregunta`)
    REFERENCES `GeneralEmpresas`.`Pregunta` (`idPregunta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Respuesta_Registro1`
    FOREIGN KEY (`idRegistro`)
    REFERENCES `GeneralEmpresas`.`Registro` (`idRegistro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Respuesta_Encuesta1`
    FOREIGN KEY (`idEncuesta`)
    REFERENCES `GeneralEmpresas`.`Encuesta` (`idEncuesta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Producto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Producto` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Producto` (
  `idProducto` INT NOT NULL AUTO_INCREMENT,
  `producto` VARCHAR(150) NOT NULL,
  `claveProducto` VARCHAR(60) NULL,
  PRIMARY KEY (`idProducto`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Rol`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Rol` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Rol` (
  `idRol` INT NOT NULL AUTO_INCREMENT,
  `rol` VARCHAR(200) NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idRol`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Usuario` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Usuario` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT,
  `idRol` INT NOT NULL,
  `usuario` VARCHAR(100) NOT NULL,
  `nombres` VARCHAR(150) NOT NULL,
  `apellidos` VARCHAR(150) NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idUsuario`),
  INDEX `fk_Usuario_Rol1_idx` (`idRol` ASC),
  CONSTRAINT `fk_Usuario_Rol1`
    FOREIGN KEY (`idRol`)
    REFERENCES `GeneralEmpresas`.`Rol` (`idRol`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Computadora`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Computadora` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Computadora` (
  `idComputadora` INT NOT NULL,
  `idProducto` INT NOT NULL,
  `idUsuario` INT NOT NULL,
  `numeroSerie` VARCHAR(45) NULL,
  `nodoPuerto` VARCHAR(30) NULL,
  `sistemaOperativo` VARCHAR(45) NULL,
  `procesador` VARCHAR(45) NULL,
  `discoDuro` VARCHAR(30) NULL,
  `monitor` VARCHAR(30) NULL,
  `teclado` VARCHAR(30) NULL,
  `mouse` VARCHAR(30) NULL,
  `bocina` VARCHAR(30) NULL,
  `direccionIP` VARCHAR(30) NULL,
  `direccionMAC` VARCHAR(45) NULL,
  `ubicacion` VARCHAR(150) NULL,
  `fechaCompra` DATETIME NULL,
  `garantia` VARCHAR(1) NULL,
  `fechaGarantia` DATETIME NULL,
  `fechaAsignacion` DATETIME NULL,
  PRIMARY KEY (`idComputadora`),
  INDEX `fk_Computadora_Producto1_idx` (`idProducto` ASC),
  INDEX `fk_Computadora_Usuario1_idx` (`idUsuario` ASC),
  CONSTRAINT `fk_Computadora_Producto1`
    FOREIGN KEY (`idProducto`)
    REFERENCES `GeneralEmpresas`.`Producto` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Computadora_Usuario1`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `GeneralEmpresas`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Mantenimiento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Mantenimiento` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Mantenimiento` (
  `idMantenimiento` INT NOT NULL AUTO_INCREMENT,
  `idComputadora` INT NOT NULL,
  `tipo` VARCHAR(2) NULL,
  `fecha` DATETIME NULL,
  `nombre` VARCHAR(150) NULL,
  `descripcion` TEXT NULL,
  `archivo` TEXT NULL,
  PRIMARY KEY (`idMantenimiento`),
  INDEX `fk_Mantenimiento_Computadora1_idx` (`idComputadora` ASC),
  CONSTRAINT `fk_Mantenimiento_Computadora1`
    FOREIGN KEY (`idComputadora`)
    REFERENCES `GeneralEmpresas`.`Computadora` (`idComputadora`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`PreferenciaSimple`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`PreferenciaSimple` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`PreferenciaSimple` (
  `idPregunta` INT NOT NULL,
  `idOpcion` INT NOT NULL,
  `preferencia` INT NOT NULL,
  INDEX `fk_PreferenciaSimple_Pregunta1_idx` (`idPregunta` ASC),
  INDEX `fk_PreferenciaSimple_Opcion1_idx` (`idOpcion` ASC),
  PRIMARY KEY (`idPregunta`, `idOpcion`),
  CONSTRAINT `fk_PreferenciaSimple_Pregunta1`
    FOREIGN KEY (`idPregunta`)
    REFERENCES `GeneralEmpresas`.`Pregunta` (`idPregunta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_PreferenciaSimple_Opcion1`
    FOREIGN KEY (`idOpcion`)
    REFERENCES `GeneralEmpresas`.`Opcion` (`idOpcion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralEmpresas`.`Sucursal`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralEmpresas`.`Sucursal` ;

CREATE TABLE IF NOT EXISTS `GeneralEmpresas`.`Sucursal` (
  `idSucursal` INT NOT NULL AUTO_INCREMENT,
  `idEmpresa` INT NOT NULL,
  `idDomicilio` INT NOT NULL,
  `idsTelefonos` TEXT NULL,
  `idsEmails` TEXT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NOT NULL,
  INDEX `fk_Sucursal_Empresa1_idx` (`idEmpresa` ASC),
  INDEX `fk_Sucursal_Domicilio1_idx` (`idDomicilio` ASC),
  PRIMARY KEY (`idSucursal`),
  CONSTRAINT `fk_Sucursal_Empresa1`
    FOREIGN KEY (`idEmpresa`)
    REFERENCES `GeneralEmpresas`.`Empresa` (`idEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Sucursal_Domicilio1`
    FOREIGN KEY (`idDomicilio`)
    REFERENCES `GeneralEmpresas`.`Domicilio` (`idDomicilio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
