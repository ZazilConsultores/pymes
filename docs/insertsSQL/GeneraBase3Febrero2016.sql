-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema GeneralDos
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `GeneralDos` ;

-- -----------------------------------------------------
-- Schema GeneralDos
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `GeneralDos` DEFAULT CHARACTER SET utf8 ;
USE `GeneralDos` ;

-- -----------------------------------------------------
-- Table `GeneralDos`.`Estado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Estado` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Estado` (
  `idEstado` INT NOT NULL AUTO_INCREMENT,
  `estado` VARCHAR(100) NOT NULL,
  `capital` VARCHAR(100) NULL,
  PRIMARY KEY (`idEstado`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Municipio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Municipio` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Municipio` (
  `idMunicipio` INT NOT NULL AUTO_INCREMENT,
  `idEstado` INT NOT NULL,
  `municipio` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idMunicipio`),
  INDEX `fk_Municipio_Estado_idx` (`idEstado` ASC),
  CONSTRAINT `fk_Municipio_Estado`
    FOREIGN KEY (`idEstado`)
    REFERENCES `GeneralDos`.`Estado` (`idEstado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Telefono`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Telefono` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Telefono` (
  `idTelefono` INT NOT NULL AUTO_INCREMENT,
  `lada` VARCHAR(7) NULL,
  `telefono` VARCHAR(16) NOT NULL,
  `extensiones` VARCHAR(20) NULL,
  `hash` VARCHAR(45) NULL,
  PRIMARY KEY (`idTelefono`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Email`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Email` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Email` (
  `idEmail` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(60) NOT NULL,
  `descripcion` VARCHAR(45) NULL,
  `hash` VARCHAR(45) NULL,
  PRIMARY KEY (`idEmail`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Divisa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Divisa` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Divisa` (
  `idDivisa` INT NOT NULL AUTO_INCREMENT,
  `divisa` VARCHAR(200) NOT NULL,
  `claveDivisa` VARCHAR(10) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `tipoCambio` FLOAT NOT NULL,
  PRIMARY KEY (`idDivisa`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Banco`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Banco` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Banco` (
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
    REFERENCES `GeneralDos`.`Divisa` (`idDivisa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Fiscales`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Fiscales` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Fiscales` (
  `idFiscales` INT NOT NULL,
  `rfc` VARCHAR(13) NOT NULL,
  `razonSocial` VARCHAR(200) NOT NULL,
  `hash` VARCHAR(45) NULL,
  PRIMARY KEY (`idFiscales`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Domicilio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Domicilio` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Domicilio` (
  `idDomicilio` INT NOT NULL AUTO_INCREMENT,
  `idMunicipio` INT NOT NULL,
  `calle` VARCHAR(60) NOT NULL,
  `colonia` VARCHAR(60) NOT NULL,
  `codigoPostal` VARCHAR(5) NOT NULL,
  `numeroInterior` VARCHAR(60) NOT NULL,
  `numeroExterior` VARCHAR(60) NOT NULL,
  `hash` VARCHAR(45) NULL,
  PRIMARY KEY (`idDomicilio`),
  INDEX `fk_Domicilio_Municipio1_idx` (`idMunicipio` ASC),
  CONSTRAINT `fk_Domicilio_Municipio1`
    FOREIGN KEY (`idMunicipio`)
    REFERENCES `GeneralDos`.`Municipio` (`idMunicipio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`FiscalesDomicilios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`FiscalesDomicilios` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`FiscalesDomicilios` (
  `idFiscalesDomicilios` INT NOT NULL AUTO_INCREMENT,
  `idDomicilio` INT NOT NULL,
  `idFiscales` INT NOT NULL,
  `esSucursal` VARCHAR(1) NOT NULL,
  PRIMARY KEY (`idFiscalesDomicilios`),
  INDEX `fk_FiscalesDomicilios_Domicilio1_idx` (`idDomicilio` ASC),
  INDEX `fk_FiscalesDomicilios_Fiscales1_idx` (`idFiscales` ASC),
  CONSTRAINT `fk_FiscalesDomicilios_Domicilio1`
    FOREIGN KEY (`idDomicilio`)
    REFERENCES `GeneralDos`.`Domicilio` (`idDomicilio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_FiscalesDomicilios_Fiscales1`
    FOREIGN KEY (`idFiscales`)
    REFERENCES `GeneralDos`.`Fiscales` (`idFiscales`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`FiscalesTelefonos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`FiscalesTelefonos` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`FiscalesTelefonos` (
  `idFiscalesTelefonos` INT NOT NULL,
  `idFiscales` INT NOT NULL,
  `idTelefono` INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idFiscalesTelefonos`),
  INDEX `fk_FiscalesTelefonos_Telefono1_idx` (`idTelefono` ASC),
  INDEX `fk_FiscalesTelefonos_Fiscales1_idx` (`idFiscales` ASC),
  CONSTRAINT `fk_FiscalesTelefonos_Telefono1`
    FOREIGN KEY (`idTelefono`)
    REFERENCES `GeneralDos`.`Telefono` (`idTelefono`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_FiscalesTelefonos_Fiscales1`
    FOREIGN KEY (`idFiscales`)
    REFERENCES `GeneralDos`.`Fiscales` (`idFiscales`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`FiscalesEmail`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`FiscalesEmail` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`FiscalesEmail` (
  `idFiscalesEmail` INT NOT NULL AUTO_INCREMENT,
  `idEmail` INT NOT NULL,
  `idFiscales` INT NOT NULL,
  PRIMARY KEY (`idFiscalesEmail`),
  INDEX `fk_FiscalesEmail_Email1_idx` (`idEmail` ASC),
  INDEX `fk_FiscalesEmail_Fiscales1_idx` (`idFiscales` ASC),
  CONSTRAINT `fk_FiscalesEmail_Email1`
    FOREIGN KEY (`idEmail`)
    REFERENCES `GeneralDos`.`Email` (`idEmail`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_FiscalesEmail_Fiscales1`
    FOREIGN KEY (`idFiscales`)
    REFERENCES `GeneralDos`.`Fiscales` (`idFiscales`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Empresa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Empresa` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Empresa` (
  `idEmpresa` INT NOT NULL AUTO_INCREMENT,
  `idFiscales` INT NOT NULL,
  `hash` VARCHAR(45) NULL,
  PRIMARY KEY (`idEmpresa`),
  INDEX `fk_Empresa_Fiscales1_idx` (`idFiscales` ASC),
  CONSTRAINT `fk_Empresa_Fiscales1`
    FOREIGN KEY (`idFiscales`)
    REFERENCES `GeneralDos`.`Fiscales` (`idFiscales`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Empresas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Empresas` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Empresas` (
  `idEmpresas` INT NOT NULL AUTO_INCREMENT,
  `idEmpresa` INT NOT NULL,
  PRIMARY KEY (`idEmpresas`),
  INDEX `fk_Empresas_Empresa1_idx` (`idEmpresa` ASC),
  CONSTRAINT `fk_Empresas_Empresa1`
    FOREIGN KEY (`idEmpresa`)
    REFERENCES `GeneralDos`.`Empresa` (`idEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Parametro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Parametro` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Parametro` (
  `idParametro` INT NOT NULL AUTO_INCREMENT,
  `parametro` VARCHAR(200) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idParametro`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Subparametro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Subparametro` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Subparametro` (
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
    REFERENCES `GeneralDos`.`Parametro` (`idParametro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Clientes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Clientes` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Clientes` (
  `idCliente` INT NOT NULL AUTO_INCREMENT,
  `idEmpresa` INT NOT NULL,
  PRIMARY KEY (`idCliente`),
  INDEX `fk_Clientes_Empresa1_idx` (`idEmpresa` ASC),
  CONSTRAINT `fk_Clientes_Empresa1`
    FOREIGN KEY (`idEmpresa`)
    REFERENCES `GeneralDos`.`Empresa` (`idEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`TipoProveedor`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`TipoProveedor` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`TipoProveedor` (
  `idTipoProveedor` INT NOT NULL AUTO_INCREMENT,
  `clave` VARCHAR(2) NOT NULL,
  `descripcion` TEXT NULL,
  PRIMARY KEY (`idTipoProveedor`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Proveedores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Proveedores` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Proveedores` (
  `idProveedores` INT NOT NULL AUTO_INCREMENT,
  `idEmpresa` INT NOT NULL,
  `idTipoProveedor` INT NOT NULL,
  PRIMARY KEY (`idProveedores`),
  INDEX `fk_Proveedores_Empresa1_idx` (`idEmpresa` ASC),
  INDEX `fk_Proveedores_TipoProveedor1_idx` (`idTipoProveedor` ASC),
  CONSTRAINT `fk_Proveedores_Empresa1`
    FOREIGN KEY (`idEmpresa`)
    REFERENCES `GeneralDos`.`Empresa` (`idEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Proveedores_TipoProveedor1`
    FOREIGN KEY (`idTipoProveedor`)
    REFERENCES `GeneralDos`.`TipoProveedor` (`idTipoProveedor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`BancosEmpresa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`BancosEmpresa` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`BancosEmpresa` (
  `idBancosEmpresa` INT NOT NULL AUTO_INCREMENT,
  `idEmpresa` INT NOT NULL,
  `idBanco` INT NOT NULL,
  PRIMARY KEY (`idBancosEmpresa`),
  INDEX `fk_BancosEmpresa_Empresa1_idx` (`idEmpresa` ASC),
  INDEX `fk_BancosEmpresa_Banco1_idx` (`idBanco` ASC),
  CONSTRAINT `fk_BancosEmpresa_Empresa1`
    FOREIGN KEY (`idEmpresa`)
    REFERENCES `GeneralDos`.`Empresa` (`idEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_BancosEmpresa_Banco1`
    FOREIGN KEY (`idBanco`)
    REFERENCES `GeneralDos`.`Banco` (`idBanco`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Producto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Producto` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Producto` (
  `idProducto` INT NOT NULL AUTO_INCREMENT,
  `producto` VARCHAR(150) NOT NULL,
  `claveProducto` VARCHAR(60) NULL,
  PRIMARY KEY (`idProducto`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Impuesto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Impuesto` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Impuesto` (
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
-- Table `GeneralDos`.`Factura`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Factura` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Factura` (
  `idFactura` INT NOT NULL AUTO_INCREMENT,
  `idEmpresa` INT NOT NULL,
  `idEmpresas` INT NOT NULL,
  `tipo` VARCHAR(2) NOT NULL,
  `factura` VARCHAR(60) NOT NULL,
  `fecha` DATETIME NOT NULL,
  `subtotal` DECIMAL NOT NULL,
  `total` DECIMAL NOT NULL,
  PRIMARY KEY (`idFactura`),
  INDEX `fk_Factura_Empresas1_idx` (`idEmpresas` ASC),
  INDEX `fk_Factura_Empresa1_idx` (`idEmpresa` ASC),
  CONSTRAINT `fk_Factura_Empresas1`
    FOREIGN KEY (`idEmpresas`)
    REFERENCES `GeneralDos`.`Empresas` (`idEmpresas`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Factura_Empresa1`
    FOREIGN KEY (`idEmpresa`)
    REFERENCES `GeneralDos`.`Empresa` (`idEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Multiplos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Multiplos` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Multiplos` (
  `idMultiplos` INT NOT NULL AUTO_INCREMENT,
  `idProducto` INT NOT NULL,
  `cantidad` FLOAT NOT NULL,
  `unidad` VARCHAR(20) NOT NULL,
  `abreviatura` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`idMultiplos`),
  INDEX `fk_Multiplos_Producto1_idx` (`idProducto` ASC),
  CONSTRAINT `fk_Multiplos_Producto1`
    FOREIGN KEY (`idProducto`)
    REFERENCES `GeneralDos`.`Producto` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`FacturaDetalle`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`FacturaDetalle` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`FacturaDetalle` (
  `idFacturaDetalle` INT NOT NULL AUTO_INCREMENT,
  `idFactura` INT NOT NULL,
  `idMultiplos` INT NOT NULL,
  `secuencial` INT NOT NULL,
  `cantidad` FLOAT NOT NULL,
  `descripcion` TEXT NOT NULL,
  `precioUnitario` DECIMAL NOT NULL,
  `importe` DECIMAL NOT NULL,
  PRIMARY KEY (`idFacturaDetalle`),
  INDEX `fk_FacturaDetalle_Factura1_idx` (`idFactura` ASC),
  INDEX `fk_FacturaDetalle_Multiplos1_idx` (`idMultiplos` ASC),
  CONSTRAINT `fk_FacturaDetalle_Factura1`
    FOREIGN KEY (`idFactura`)
    REFERENCES `GeneralDos`.`Factura` (`idFactura`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_FacturaDetalle_Multiplos1`
    FOREIGN KEY (`idMultiplos`)
    REFERENCES `GeneralDos`.`Multiplos` (`idMultiplos`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Poliza`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Poliza` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Poliza` (
  `idPoliza` INT NOT NULL AUTO_INCREMENT,
  `idEmpresas` INT NOT NULL,
  `tipo` VARCHAR(2) NOT NULL,
  `idEmpresa` INT NOT NULL,
  `poliza` VARCHAR(100) NOT NULL,
  `fecha` DATETIME NOT NULL,
  `tipoPoliza` VARCHAR(2) NOT NULL,
  `origen` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idPoliza`),
  INDEX `fk_Poliza_Empresas1_idx` (`idEmpresas` ASC),
  INDEX `fk_Poliza_Empresa1_idx` (`idEmpresa` ASC),
  CONSTRAINT `fk_Poliza_Empresas1`
    FOREIGN KEY (`idEmpresas`)
    REFERENCES `GeneralDos`.`Empresas` (`idEmpresas`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Poliza_Empresa1`
    FOREIGN KEY (`idEmpresa`)
    REFERENCES `GeneralDos`.`Empresa` (`idEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`ProductoImpuesto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`ProductoImpuesto` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`ProductoImpuesto` (
  `idProductoImpuesto` INT NOT NULL AUTO_INCREMENT,
  `idProducto` INT NOT NULL,
  `idImpuesto` INT NOT NULL,
  PRIMARY KEY (`idProductoImpuesto`),
  INDEX `fk_ProductoImpuesto_Producto1_idx` (`idProducto` ASC),
  INDEX `fk_ProductoImpuesto_Impuesto1_idx` (`idImpuesto` ASC),
  CONSTRAINT `fk_ProductoImpuesto_Producto1`
    FOREIGN KEY (`idProducto`)
    REFERENCES `GeneralDos`.`Producto` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ProductoImpuesto_Impuesto1`
    FOREIGN KEY (`idImpuesto`)
    REFERENCES `GeneralDos`.`Impuesto` (`idImpuesto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Proyecto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Proyecto` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Proyecto` (
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
-- Table `GeneralDos`.`TipoMovimiento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`TipoMovimiento` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`TipoMovimiento` (
  `idTipoMovimiento` INT NOT NULL AUTO_INCREMENT,
  `tipoMovimiento` VARCHAR(2) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `afectaInventario` VARCHAR(1) NOT NULL,
  `afectaSaldo` VARCHAR(1) NOT NULL,
  PRIMARY KEY (`idTipoMovimiento`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Cuentasxc`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Cuentasxc` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Cuentasxc` (
  `idCuentasxc` INT NOT NULL AUTO_INCREMENT,
  `idEmpresas` INT NOT NULL,
  `idEmpresa` INT NOT NULL,
  `idProyecto` INT NOT NULL,
  `idFactura` INT NOT NULL,
  `idTipoMovimiento` INT NOT NULL,
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
  INDEX `fk_Cuentasxc_Empresa1_idx` (`idEmpresa` ASC),
  INDEX `fk_Cuentasxc_Empresas1_idx` (`idEmpresas` ASC),
  INDEX `fk_Cuentasxc_Proyecto1_idx` (`idProyecto` ASC),
  INDEX `fk_Cuentasxc_Factura1_idx` (`idFactura` ASC),
  INDEX `fk_Cuentasxc_TipoMovimiento1_idx` (`idTipoMovimiento` ASC),
  CONSTRAINT `fk_Cuentasxc_Empresa1`
    FOREIGN KEY (`idEmpresa`)
    REFERENCES `GeneralDos`.`Empresa` (`idEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxc_Empresas1`
    FOREIGN KEY (`idEmpresas`)
    REFERENCES `GeneralDos`.`Empresas` (`idEmpresas`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxc_Proyecto1`
    FOREIGN KEY (`idProyecto`)
    REFERENCES `GeneralDos`.`Proyecto` (`idProyecto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxc_Factura1`
    FOREIGN KEY (`idFactura`)
    REFERENCES `GeneralDos`.`Factura` (`idFactura`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxc_TipoMovimiento1`
    FOREIGN KEY (`idTipoMovimiento`)
    REFERENCES `GeneralDos`.`TipoMovimiento` (`idTipoMovimiento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Cuentasxp`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Cuentasxp` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Cuentasxp` (
  `idCuentasxp` INT NOT NULL AUTO_INCREMENT,
  `idEmpresas` INT NOT NULL,
  `idEmpresa` INT NOT NULL,
  `idProyecto` INT NOT NULL,
  `idFactura` INT NOT NULL,
  `idTipoMovimiento` INT NOT NULL,
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
  INDEX `fk_Cuentasxp_Empresa1_idx` (`idEmpresa` ASC),
  INDEX `fk_Cuentasxp_Empresas1_idx` (`idEmpresas` ASC),
  INDEX `fk_Cuentasxp_Proyecto1_idx` (`idProyecto` ASC),
  INDEX `fk_Cuentasxp_Factura1_idx` (`idFactura` ASC),
  INDEX `fk_Cuentasxp_TipoMovimiento1_idx` (`idTipoMovimiento` ASC),
  CONSTRAINT `fk_Cuentasxp_Empresa1`
    FOREIGN KEY (`idEmpresa`)
    REFERENCES `GeneralDos`.`Empresa` (`idEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxp_Empresas1`
    FOREIGN KEY (`idEmpresas`)
    REFERENCES `GeneralDos`.`Empresas` (`idEmpresas`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxp_Proyecto1`
    FOREIGN KEY (`idProyecto`)
    REFERENCES `GeneralDos`.`Proyecto` (`idProyecto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxp_Factura1`
    FOREIGN KEY (`idFactura`)
    REFERENCES `GeneralDos`.`Factura` (`idFactura`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxp_TipoMovimiento1`
    FOREIGN KEY (`idTipoMovimiento`)
    REFERENCES `GeneralDos`.`TipoMovimiento` (`idTipoMovimiento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Cardex`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Cardex` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Cardex` (
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
    REFERENCES `GeneralDos`.`Producto` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cardex_Factura1`
    FOREIGN KEY (`idFactura`)
    REFERENCES `GeneralDos`.`Factura` (`idFactura`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cardex_Divisa1`
    FOREIGN KEY (`idDivisa`)
    REFERENCES `GeneralDos`.`Divisa` (`idDivisa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cardex_Poliza1`
    FOREIGN KEY (`idPoliza`)
    REFERENCES `GeneralDos`.`Poliza` (`idPoliza`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`ProductoCompuesto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`ProductoCompuesto` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`ProductoCompuesto` (
  `idProductoCompuesto` INT NOT NULL AUTO_INCREMENT,
  `idProducto` INT NOT NULL,
  `productoEnlazado` VARCHAR(20) NULL,
  `cantidad` FLOAT NULL,
  PRIMARY KEY (`idProductoCompuesto`),
  INDEX `fk_ProductoCompuesto_Producto1_idx` (`idProducto` ASC),
  CONSTRAINT `fk_ProductoCompuesto_Producto1`
    FOREIGN KEY (`idProducto`)
    REFERENCES `GeneralDos`.`Producto` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Capas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Capas` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Capas` (
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
    REFERENCES `GeneralDos`.`Divisa` (`idDivisa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Capas_Producto1`
    FOREIGN KEY (`idProducto`)
    REFERENCES `GeneralDos`.`Producto` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Vendedor`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Vendedor` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Vendedor` (
  `idVendedor` INT NOT NULL AUTO_INCREMENT,
  `claveVendedor` VARCHAR(20) NOT NULL,
  `nombre` VARCHAR(60) NOT NULL,
  `idTelefono` INT NOT NULL,
  `idDomicilio` INT NOT NULL,
  `estatus` VARCHAR(1) NOT NULL,
  `fechaAlta` DATETIME NOT NULL,
  `comision` DECIMAL NOT NULL,
  PRIMARY KEY (`idVendedor`),
  INDEX `fk_Vendedor_Domicilio1_idx` (`idDomicilio` ASC),
  INDEX `fk_Vendedor_Telefono1_idx` (`idTelefono` ASC),
  CONSTRAINT `fk_Vendedor_Domicilio1`
    FOREIGN KEY (`idDomicilio`)
    REFERENCES `GeneralDos`.`Domicilio` (`idDomicilio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Vendedor_Telefono1`
    FOREIGN KEY (`idTelefono`)
    REFERENCES `GeneralDos`.`Telefono` (`idTelefono`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Movimientos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Movimientos` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Movimientos` (
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
    REFERENCES `GeneralDos`.`Producto` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Movimientos_TipoMovimiento1`
    FOREIGN KEY (`idTipoMovimiento`)
    REFERENCES `GeneralDos`.`TipoMovimiento` (`idTipoMovimiento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Movimientos_Factura1`
    FOREIGN KEY (`idFactura`)
    REFERENCES `GeneralDos`.`Factura` (`idFactura`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Movimientos_Proyecto1`
    FOREIGN KEY (`idProyecto`)
    REFERENCES `GeneralDos`.`Proyecto` (`idProyecto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Movimientos_Poliza1`
    FOREIGN KEY (`idPoliza`)
    REFERENCES `GeneralDos`.`Poliza` (`idPoliza`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Inventario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Inventario` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Inventario` (
  `idInventario` INT NOT NULL AUTO_INCREMENT,
  `idProducto` INT NOT NULL,
  `idDivisa` INT NOT NULL,
  `idEmpresas` INT NOT NULL,
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
  INDEX `fk_Inventario_Empresas1_idx` (`idEmpresas` ASC),
  CONSTRAINT `fk_Inventario_Producto1`
    FOREIGN KEY (`idProducto`)
    REFERENCES `GeneralDos`.`Producto` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Inventario_Divisa1`
    FOREIGN KEY (`idDivisa`)
    REFERENCES `GeneralDos`.`Divisa` (`idDivisa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Inventario_Empresas1`
    FOREIGN KEY (`idEmpresas`)
    REFERENCES `GeneralDos`.`Empresas` (`idEmpresas`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Encuesta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Encuesta` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Encuesta` (
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
-- Table `GeneralDos`.`Registro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Registro` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Registro` (
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
-- Table `GeneralDos`.`Seccion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Seccion` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Seccion` (
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
    REFERENCES `GeneralDos`.`Encuesta` (`idEncuesta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Grupo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Grupo` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Grupo` (
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
    REFERENCES `GeneralDos`.`Seccion` (`idSeccion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Pregunta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Pregunta` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Pregunta` (
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
    REFERENCES `GeneralDos`.`Encuesta` (`idEncuesta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Categoria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Categoria` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Categoria` (
  `idCategoria` INT NOT NULL AUTO_INCREMENT,
  `categoria` TEXT NOT NULL,
  `descripcion` TEXT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idCategoria`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Opcion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Opcion` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Opcion` (
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
    REFERENCES `GeneralDos`.`Categoria` (`idCategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Respuesta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Respuesta` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Respuesta` (
  `idRespuesta` INT NOT NULL AUTO_INCREMENT,
  `idEncuesta` INT NOT NULL,
  `idRegistro` INT NOT NULL,
  `idPregunta` INT NOT NULL,
  `respuesta` TEXT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idRespuesta`),
  INDEX `fk_Respuesta_Pregunta1_idx` (`idPregunta` ASC),
  INDEX `fk_Respuesta_Registro1_idx` (`idRegistro` ASC),
  INDEX `fk_Respuesta_Encuesta1_idx` (`idEncuesta` ASC),
  CONSTRAINT `fk_Respuesta_Pregunta1`
    FOREIGN KEY (`idPregunta`)
    REFERENCES `GeneralDos`.`Pregunta` (`idPregunta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Respuesta_Registro1`
    FOREIGN KEY (`idRegistro`)
    REFERENCES `GeneralDos`.`Registro` (`idRegistro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Respuesta_Encuesta1`
    FOREIGN KEY (`idEncuesta`)
    REFERENCES `GeneralDos`.`Encuesta` (`idEncuesta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Producto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Producto` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Producto` (
  `idProducto` INT NOT NULL AUTO_INCREMENT,
  `producto` VARCHAR(150) NOT NULL,
  `claveProducto` VARCHAR(60) NULL,
  PRIMARY KEY (`idProducto`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Rol`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Rol` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Rol` (
  `idRol` INT NOT NULL AUTO_INCREMENT,
  `rol` VARCHAR(200) NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idRol`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Usuario` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Usuario` (
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
    REFERENCES `GeneralDos`.`Rol` (`idRol`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Computadora`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Computadora` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Computadora` (
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
    REFERENCES `GeneralDos`.`Producto` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Computadora_Usuario1`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `GeneralDos`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`Mantenimiento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`Mantenimiento` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`Mantenimiento` (
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
    REFERENCES `GeneralDos`.`Computadora` (`idComputadora`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`PreferenciaSimple`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`PreferenciaSimple` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`PreferenciaSimple` (
  `idPregunta` INT NOT NULL,
  `idOpcion` INT NOT NULL,
  `preferencia` INT NULL,
  PRIMARY KEY (`idPregunta`, `idOpcion`),
  INDEX `fk_PreferenciaSimple_Opcion1_idx` (`idOpcion` ASC),
  CONSTRAINT `fk_PreferenciaSimple_Pregunta1`
    FOREIGN KEY (`idPregunta`)
    REFERENCES `GeneralDos`.`Pregunta` (`idPregunta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_PreferenciaSimple_Opcion1`
    FOREIGN KEY (`idOpcion`)
    REFERENCES `GeneralDos`.`Opcion` (`idOpcion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralDos`.`MantenimientoAntivirus`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralDos`.`MantenimientoAntivirus` ;

CREATE TABLE IF NOT EXISTS `GeneralDos`.`MantenimientoAntivirus` (
  `idMantenimientoAntivirus` INT NOT NULL AUTO_INCREMENT,
  `fecha` DATETIME NOT NULL,
  `idComputadora` INT NOT NULL,
  PRIMARY KEY (`idMantenimientoAntivirus`),
  INDEX `fk_MantenimientoAntivirus_Computadora1_idx` (`idComputadora` ASC),
  CONSTRAINT `fk_MantenimientoAntivirus_Computadora1`
    FOREIGN KEY (`idComputadora`)
    REFERENCES `GeneralDos`.`Computadora` (`idComputadora`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
