-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema GeneralSagrado
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `GeneralSagrado` ;

-- -----------------------------------------------------
-- Schema GeneralSagrado
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `GeneralSagrado` DEFAULT CHARACTER SET utf8 ;
USE `GeneralSagrado` ;

-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Estado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Estado` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Estado` (
  `idEstado` INT NOT NULL AUTO_INCREMENT,
  `claveEstado` VARCHAR(20) NULL,
  `estado` VARCHAR(100) NOT NULL,
  `capital` VARCHAR(100) NULL,
  PRIMARY KEY (`idEstado`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Municipio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Municipio` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Municipio` (
  `idMunicipio` INT NOT NULL AUTO_INCREMENT,
  `idEstado` INT NOT NULL,
  `claveMunicipio` VARCHAR(20) NULL,
  `municipio` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idMunicipio`),
  INDEX `fk_Municipio_Estado_idx` (`idEstado` ASC),
  CONSTRAINT `fk_Municipio_Estado`
    FOREIGN KEY (`idEstado`)
    REFERENCES `GeneralSagrado`.`Estado` (`idEstado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Telefono`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Telefono` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Telefono` (
  `idTelefono` INT NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(45) NULL,
  `lada` VARCHAR(7) NULL,
  `telefono` VARCHAR(16) NOT NULL,
  `extensiones` VARCHAR(20) NULL,
  `descripcion` VARCHAR(45) NULL,
  `fecha` DATETIME NULL,
  `hash` VARCHAR(45) NULL,
  PRIMARY KEY (`idTelefono`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Email`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Email` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Email` (
  `idEmail` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(60) NOT NULL,
  `descripcion` VARCHAR(45) NULL,
  `fecha` DATETIME NULL,
  `hash` VARCHAR(45) NULL,
  PRIMARY KEY (`idEmail`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Divisa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Divisa` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Divisa` (
  `idDivisa` INT NOT NULL AUTO_INCREMENT,
  `divisa` VARCHAR(200) NOT NULL,
  `claveDivisa` VARCHAR(10) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `tipoCambio` FLOAT NOT NULL,
  PRIMARY KEY (`idDivisa`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Banco`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Banco` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Banco` (
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
    REFERENCES `GeneralSagrado`.`Divisa` (`idDivisa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Fiscales`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Fiscales` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Fiscales` (
  `idFiscales` INT NOT NULL AUTO_INCREMENT,
  `rfc` VARCHAR(13) NOT NULL,
  `razonSocial` VARCHAR(200) NOT NULL,
  `hash` VARCHAR(45) NULL,
  PRIMARY KEY (`idFiscales`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Domicilio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Domicilio` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Domicilio` (
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
    REFERENCES `GeneralSagrado`.`Municipio` (`idMunicipio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`FiscalesDomicilios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`FiscalesDomicilios` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`FiscalesDomicilios` (
  `idFiscalesDomicilios` INT NOT NULL AUTO_INCREMENT,
  `idDomicilio` INT NOT NULL,
  `idFiscales` INT NOT NULL,
  `esSucursal` VARCHAR(1) NOT NULL,
  PRIMARY KEY (`idFiscalesDomicilios`),
  INDEX `fk_FiscalesDomicilios_Domicilio1_idx` (`idDomicilio` ASC),
  INDEX `fk_FiscalesDomicilios_Fiscales1_idx` (`idFiscales` ASC),
  CONSTRAINT `fk_FiscalesDomicilios_Domicilio1`
    FOREIGN KEY (`idDomicilio`)
    REFERENCES `GeneralSagrado`.`Domicilio` (`idDomicilio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_FiscalesDomicilios_Fiscales1`
    FOREIGN KEY (`idFiscales`)
    REFERENCES `GeneralSagrado`.`Fiscales` (`idFiscales`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`FiscalesTelefonos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`FiscalesTelefonos` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`FiscalesTelefonos` (
  `idFiscalesTelefonos` INT NOT NULL AUTO_INCREMENT,
  `idFiscales` INT NOT NULL,
  `idTelefono` INT NOT NULL,
  PRIMARY KEY (`idFiscalesTelefonos`),
  INDEX `fk_FiscalesTelefonos_Telefono1_idx` (`idTelefono` ASC),
  INDEX `fk_FiscalesTelefonos_Fiscales1_idx` (`idFiscales` ASC),
  CONSTRAINT `fk_FiscalesTelefonos_Telefono1`
    FOREIGN KEY (`idTelefono`)
    REFERENCES `GeneralSagrado`.`Telefono` (`idTelefono`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_FiscalesTelefonos_Fiscales1`
    FOREIGN KEY (`idFiscales`)
    REFERENCES `GeneralSagrado`.`Fiscales` (`idFiscales`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`FiscalesEmail`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`FiscalesEmail` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`FiscalesEmail` (
  `idFiscalesEmail` INT NOT NULL AUTO_INCREMENT,
  `idEmail` INT NOT NULL,
  `idFiscales` INT NOT NULL,
  PRIMARY KEY (`idFiscalesEmail`),
  INDEX `fk_FiscalesEmail_Email1_idx` (`idEmail` ASC),
  INDEX `fk_FiscalesEmail_Fiscales1_idx` (`idFiscales` ASC),
  CONSTRAINT `fk_FiscalesEmail_Email1`
    FOREIGN KEY (`idEmail`)
    REFERENCES `GeneralSagrado`.`Email` (`idEmail`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_FiscalesEmail_Fiscales1`
    FOREIGN KEY (`idFiscales`)
    REFERENCES `GeneralSagrado`.`Fiscales` (`idFiscales`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Empresa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Empresa` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Empresa` (
  `idEmpresa` INT NOT NULL AUTO_INCREMENT,
  `idFiscales` INT NOT NULL,
  `hash` VARCHAR(45) NULL,
  PRIMARY KEY (`idEmpresa`),
  INDEX `fk_Empresa_Fiscales1_idx` (`idFiscales` ASC),
  CONSTRAINT `fk_Empresa_Fiscales1`
    FOREIGN KEY (`idFiscales`)
    REFERENCES `GeneralSagrado`.`Fiscales` (`idFiscales`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Empresas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Empresas` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Empresas` (
  `idEmpresas` INT NOT NULL AUTO_INCREMENT,
  `idEmpresa` INT NOT NULL,
  PRIMARY KEY (`idEmpresas`),
  INDEX `fk_Empresas_Empresa1_idx` (`idEmpresa` ASC),
  CONSTRAINT `fk_Empresas_Empresa1`
    FOREIGN KEY (`idEmpresa`)
    REFERENCES `GeneralSagrado`.`Empresa` (`idEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Parametro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Parametro` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Parametro` (
  `idParametro` INT NOT NULL AUTO_INCREMENT,
  `parametro` VARCHAR(200) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NULL,
  PRIMARY KEY (`idParametro`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Subparametro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Subparametro` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Subparametro` (
  `idSubparametro` INT NOT NULL AUTO_INCREMENT,
  `idParametro` INT NOT NULL,
  `subparametro` VARCHAR(200) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NULL,
  PRIMARY KEY (`idSubparametro`),
  INDEX `fk_Subparametro_Parametro1_idx` (`idParametro` ASC),
  CONSTRAINT `fk_Subparametro_Parametro1`
    FOREIGN KEY (`idParametro`)
    REFERENCES `GeneralSagrado`.`Parametro` (`idParametro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Clientes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Clientes` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Clientes` (
  `idCliente` INT NOT NULL AUTO_INCREMENT,
  `idEmpresa` INT NOT NULL,
  PRIMARY KEY (`idCliente`),
  INDEX `fk_Clientes_Empresa1_idx` (`idEmpresa` ASC),
  CONSTRAINT `fk_Clientes_Empresa1`
    FOREIGN KEY (`idEmpresa`)
    REFERENCES `GeneralSagrado`.`Empresa` (`idEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`TipoProveedor`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`TipoProveedor` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`TipoProveedor` (
  `idTipoProveedor` INT NOT NULL AUTO_INCREMENT,
  `clave` VARCHAR(2) NOT NULL,
  `descripcion` TEXT NULL,
  PRIMARY KEY (`idTipoProveedor`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Proveedores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Proveedores` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Proveedores` (
  `idProveedores` INT NOT NULL AUTO_INCREMENT,
  `idEmpresa` INT NOT NULL,
  `idTipoProveedor` INT NOT NULL,
  PRIMARY KEY (`idProveedores`),
  INDEX `fk_Proveedores_Empresa1_idx` (`idEmpresa` ASC),
  INDEX `fk_Proveedores_TipoProveedor1_idx` (`idTipoProveedor` ASC),
  CONSTRAINT `fk_Proveedores_Empresa1`
    FOREIGN KEY (`idEmpresa`)
    REFERENCES `GeneralSagrado`.`Empresa` (`idEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Proveedores_TipoProveedor1`
    FOREIGN KEY (`idTipoProveedor`)
    REFERENCES `GeneralSagrado`.`TipoProveedor` (`idTipoProveedor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`BancosEmpresa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`BancosEmpresa` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`BancosEmpresa` (
  `idBancosEmpresa` INT NOT NULL AUTO_INCREMENT,
  `idEmpresa` INT NOT NULL,
  `idBanco` INT NOT NULL,
  PRIMARY KEY (`idBancosEmpresa`),
  INDEX `fk_BancosEmpresa_Empresa1_idx` (`idEmpresa` ASC),
  INDEX `fk_BancosEmpresa_Banco1_idx` (`idBanco` ASC),
  CONSTRAINT `fk_BancosEmpresa_Empresa1`
    FOREIGN KEY (`idEmpresa`)
    REFERENCES `GeneralSagrado`.`Empresa` (`idEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_BancosEmpresa_Banco1`
    FOREIGN KEY (`idBanco`)
    REFERENCES `GeneralSagrado`.`Banco` (`idBanco`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Producto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Producto` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Producto` (
  `idProducto` INT NOT NULL AUTO_INCREMENT,
  `producto` VARCHAR(150) NOT NULL,
  `claveProducto` VARCHAR(60) NULL,
  PRIMARY KEY (`idProducto`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Impuesto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Impuesto` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Impuesto` (
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
-- Table `GeneralSagrado`.`Factura`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Factura` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Factura` (
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
    REFERENCES `GeneralSagrado`.`Empresas` (`idEmpresas`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Factura_Empresa1`
    FOREIGN KEY (`idEmpresa`)
    REFERENCES `GeneralSagrado`.`Empresa` (`idEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Multiplos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Multiplos` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Multiplos` (
  `idMultiplos` INT NOT NULL AUTO_INCREMENT,
  `idProducto` INT NOT NULL,
  `cantidad` FLOAT NOT NULL,
  `unidad` VARCHAR(20) NOT NULL,
  `abreviatura` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`idMultiplos`),
  INDEX `fk_Multiplos_Producto1_idx` (`idProducto` ASC),
  CONSTRAINT `fk_Multiplos_Producto1`
    FOREIGN KEY (`idProducto`)
    REFERENCES `GeneralSagrado`.`Producto` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`FacturaDetalle`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`FacturaDetalle` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`FacturaDetalle` (
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
    REFERENCES `GeneralSagrado`.`Factura` (`idFactura`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_FacturaDetalle_Multiplos1`
    FOREIGN KEY (`idMultiplos`)
    REFERENCES `GeneralSagrado`.`Multiplos` (`idMultiplos`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Poliza`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Poliza` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Poliza` (
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
    REFERENCES `GeneralSagrado`.`Empresas` (`idEmpresas`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Poliza_Empresa1`
    FOREIGN KEY (`idEmpresa`)
    REFERENCES `GeneralSagrado`.`Empresa` (`idEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`ProductoImpuesto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`ProductoImpuesto` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`ProductoImpuesto` (
  `idProductoImpuesto` INT NOT NULL AUTO_INCREMENT,
  `idProducto` INT NOT NULL,
  `idImpuesto` INT NOT NULL,
  PRIMARY KEY (`idProductoImpuesto`),
  INDEX `fk_ProductoImpuesto_Producto1_idx` (`idProducto` ASC),
  INDEX `fk_ProductoImpuesto_Impuesto1_idx` (`idImpuesto` ASC),
  CONSTRAINT `fk_ProductoImpuesto_Producto1`
    FOREIGN KEY (`idProducto`)
    REFERENCES `GeneralSagrado`.`Producto` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ProductoImpuesto_Impuesto1`
    FOREIGN KEY (`idImpuesto`)
    REFERENCES `GeneralSagrado`.`Impuesto` (`idImpuesto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Proyecto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Proyecto` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Proyecto` (
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
-- Table `GeneralSagrado`.`TipoMovimiento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`TipoMovimiento` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`TipoMovimiento` (
  `idTipoMovimiento` INT NOT NULL AUTO_INCREMENT,
  `tipoMovimiento` VARCHAR(2) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `afectaInventario` VARCHAR(1) NOT NULL,
  `afectaSaldo` VARCHAR(1) NOT NULL,
  PRIMARY KEY (`idTipoMovimiento`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Cuentasxc`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Cuentasxc` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Cuentasxc` (
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
    REFERENCES `GeneralSagrado`.`Empresa` (`idEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxc_Empresas1`
    FOREIGN KEY (`idEmpresas`)
    REFERENCES `GeneralSagrado`.`Empresas` (`idEmpresas`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxc_Proyecto1`
    FOREIGN KEY (`idProyecto`)
    REFERENCES `GeneralSagrado`.`Proyecto` (`idProyecto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxc_Factura1`
    FOREIGN KEY (`idFactura`)
    REFERENCES `GeneralSagrado`.`Factura` (`idFactura`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxc_TipoMovimiento1`
    FOREIGN KEY (`idTipoMovimiento`)
    REFERENCES `GeneralSagrado`.`TipoMovimiento` (`idTipoMovimiento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Cuentasxp`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Cuentasxp` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Cuentasxp` (
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
    REFERENCES `GeneralSagrado`.`Empresa` (`idEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxp_Empresas1`
    FOREIGN KEY (`idEmpresas`)
    REFERENCES `GeneralSagrado`.`Empresas` (`idEmpresas`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxp_Proyecto1`
    FOREIGN KEY (`idProyecto`)
    REFERENCES `GeneralSagrado`.`Proyecto` (`idProyecto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxp_Factura1`
    FOREIGN KEY (`idFactura`)
    REFERENCES `GeneralSagrado`.`Factura` (`idFactura`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuentasxp_TipoMovimiento1`
    FOREIGN KEY (`idTipoMovimiento`)
    REFERENCES `GeneralSagrado`.`TipoMovimiento` (`idTipoMovimiento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Cardex`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Cardex` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Cardex` (
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
    REFERENCES `GeneralSagrado`.`Producto` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cardex_Factura1`
    FOREIGN KEY (`idFactura`)
    REFERENCES `GeneralSagrado`.`Factura` (`idFactura`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cardex_Divisa1`
    FOREIGN KEY (`idDivisa`)
    REFERENCES `GeneralSagrado`.`Divisa` (`idDivisa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cardex_Poliza1`
    FOREIGN KEY (`idPoliza`)
    REFERENCES `GeneralSagrado`.`Poliza` (`idPoliza`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`ProductoCompuesto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`ProductoCompuesto` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`ProductoCompuesto` (
  `idProductoCompuesto` INT NOT NULL AUTO_INCREMENT,
  `idProducto` INT NOT NULL,
  `productoEnlazado` VARCHAR(20) NULL,
  `cantidad` FLOAT NULL,
  PRIMARY KEY (`idProductoCompuesto`),
  INDEX `fk_ProductoCompuesto_Producto1_idx` (`idProducto` ASC),
  CONSTRAINT `fk_ProductoCompuesto_Producto1`
    FOREIGN KEY (`idProducto`)
    REFERENCES `GeneralSagrado`.`Producto` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Capas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Capas` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Capas` (
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
    REFERENCES `GeneralSagrado`.`Divisa` (`idDivisa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Capas_Producto1`
    FOREIGN KEY (`idProducto`)
    REFERENCES `GeneralSagrado`.`Producto` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Vendedor`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Vendedor` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Vendedor` (
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
    REFERENCES `GeneralSagrado`.`Domicilio` (`idDomicilio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Vendedor_Telefono1`
    FOREIGN KEY (`idTelefono`)
    REFERENCES `GeneralSagrado`.`Telefono` (`idTelefono`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Movimientos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Movimientos` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Movimientos` (
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
    REFERENCES `GeneralSagrado`.`Producto` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Movimientos_TipoMovimiento1`
    FOREIGN KEY (`idTipoMovimiento`)
    REFERENCES `GeneralSagrado`.`TipoMovimiento` (`idTipoMovimiento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Movimientos_Factura1`
    FOREIGN KEY (`idFactura`)
    REFERENCES `GeneralSagrado`.`Factura` (`idFactura`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Movimientos_Proyecto1`
    FOREIGN KEY (`idProyecto`)
    REFERENCES `GeneralSagrado`.`Proyecto` (`idProyecto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Movimientos_Poliza1`
    FOREIGN KEY (`idPoliza`)
    REFERENCES `GeneralSagrado`.`Poliza` (`idPoliza`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Inventario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Inventario` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Inventario` (
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
    REFERENCES `GeneralSagrado`.`Producto` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Inventario_Divisa1`
    FOREIGN KEY (`idDivisa`)
    REFERENCES `GeneralSagrado`.`Divisa` (`idDivisa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Inventario_Empresas1`
    FOREIGN KEY (`idEmpresas`)
    REFERENCES `GeneralSagrado`.`Empresas` (`idEmpresas`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Encuesta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Encuesta` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Encuesta` (
  `idEncuesta` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(200) NOT NULL,
  `nombreClave` VARCHAR(20) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `estatus` VARCHAR(1) NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NULL,
  PRIMARY KEY (`idEncuesta`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Registro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Registro` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Registro` (
  `idRegistro` INT NOT NULL AUTO_INCREMENT,
  `referencia` TEXT NOT NULL,
  `tipo` VARCHAR(5) NOT NULL,
  `nombres` VARCHAR(200) NOT NULL,
  `apellidos` VARCHAR(200) NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NULL,
  PRIMARY KEY (`idRegistro`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Seccion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Seccion` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Seccion` (
  `idSeccion` INT NOT NULL AUTO_INCREMENT,
  `idEncuesta` INT NOT NULL,
  `nombre` VARCHAR(200) NOT NULL,
  `orden` INT NOT NULL,
  `elementos` INT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NULL,
  PRIMARY KEY (`idSeccion`),
  INDEX `fk_Seccion_Encuesta1_idx` (`idEncuesta` ASC),
  CONSTRAINT `fk_Seccion_Encuesta1`
    FOREIGN KEY (`idEncuesta`)
    REFERENCES `GeneralSagrado`.`Encuesta` (`idEncuesta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Grupo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Grupo` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Grupo` (
  `idGrupo` INT NOT NULL AUTO_INCREMENT,
  `idSeccion` INT NOT NULL,
  `nombre` VARCHAR(200) NOT NULL,
  `tipo` VARCHAR(2) NOT NULL,
  `opciones` TEXT NULL,
  `orden` INT NOT NULL,
  `elementos` INT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NULL,
  PRIMARY KEY (`idGrupo`),
  INDEX `fk_Grupo_Seccion1_idx` (`idSeccion` ASC),
  CONSTRAINT `fk_Grupo_Seccion1`
    FOREIGN KEY (`idSeccion`)
    REFERENCES `GeneralSagrado`.`Seccion` (`idSeccion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Pregunta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Pregunta` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Pregunta` (
  `idPregunta` INT NOT NULL AUTO_INCREMENT,
  `idEncuesta` INT NOT NULL,
  `pregunta` TEXT NOT NULL,
  `origen` VARCHAR(1) NOT NULL,
  `idOrigen` VARCHAR(20) NOT NULL,
  `tipo` VARCHAR(2) NOT NULL,
  `opciones` TEXT NULL,
  `orden` INT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NULL,
  PRIMARY KEY (`idPregunta`),
  INDEX `fk_Pregunta_Encuesta1_idx` (`idEncuesta` ASC),
  CONSTRAINT `fk_Pregunta_Encuesta1`
    FOREIGN KEY (`idEncuesta`)
    REFERENCES `GeneralSagrado`.`Encuesta` (`idEncuesta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Categoria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Categoria` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Categoria` (
  `idCategoria` INT NOT NULL AUTO_INCREMENT,
  `categoria` TEXT NOT NULL,
  `descripcion` TEXT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NULL,
  PRIMARY KEY (`idCategoria`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Opcion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Opcion` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Opcion` (
  `idOpcion` INT NOT NULL AUTO_INCREMENT,
  `idCategoria` INT NOT NULL,
  `opcion` TEXT NOT NULL,
  `orden` INT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NULL,
  PRIMARY KEY (`idOpcion`),
  INDEX `fk_Opcion_Categoria1_idx` (`idCategoria` ASC),
  CONSTRAINT `fk_Opcion_Categoria1`
    FOREIGN KEY (`idCategoria`)
    REFERENCES `GeneralSagrado`.`Categoria` (`idCategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Respuesta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Respuesta` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Respuesta` (
  `idRespuesta` INT NOT NULL AUTO_INCREMENT,
  `idEncuesta` INT NOT NULL,
  `idRegistro` INT NOT NULL,
  `idPregunta` INT NOT NULL,
  `respuesta` TEXT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NULL,
  PRIMARY KEY (`idRespuesta`),
  INDEX `fk_Respuesta_Pregunta1_idx` (`idPregunta` ASC),
  INDEX `fk_Respuesta_Encuesta1_idx` (`idEncuesta` ASC),
  INDEX `fk_Respuesta_Registro1_idx` (`idRegistro` ASC),
  CONSTRAINT `fk_Respuesta_Pregunta1`
    FOREIGN KEY (`idPregunta`)
    REFERENCES `GeneralSagrado`.`Pregunta` (`idPregunta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Respuesta_Encuesta1`
    FOREIGN KEY (`idEncuesta`)
    REFERENCES `GeneralSagrado`.`Encuesta` (`idEncuesta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Respuesta_Registro1`
    FOREIGN KEY (`idRegistro`)
    REFERENCES `GeneralSagrado`.`Registro` (`idRegistro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Producto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Producto` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Producto` (
  `idProducto` INT NOT NULL AUTO_INCREMENT,
  `producto` VARCHAR(150) NOT NULL,
  `claveProducto` VARCHAR(60) NULL,
  PRIMARY KEY (`idProducto`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Rol`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Rol` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Rol` (
  `idRol` INT NOT NULL AUTO_INCREMENT,
  `rol` VARCHAR(200) NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NULL,
  PRIMARY KEY (`idRol`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Usuario` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Usuario` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT,
  `idRol` INT NOT NULL,
  `usuario` VARCHAR(100) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `nombres` VARCHAR(150) NOT NULL,
  `apellidos` VARCHAR(150) NOT NULL,
  `fecha` DATETIME NOT NULL,
  `hash` VARCHAR(45) NULL,
  PRIMARY KEY (`idUsuario`),
  INDEX `fk_Usuario_Rol1_idx` (`idRol` ASC),
  CONSTRAINT `fk_Usuario_Rol1`
    FOREIGN KEY (`idRol`)
    REFERENCES `GeneralSagrado`.`Rol` (`idRol`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Computadora`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Computadora` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Computadora` (
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
    REFERENCES `GeneralSagrado`.`Producto` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Computadora_Usuario1`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `GeneralSagrado`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`Mantenimiento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`Mantenimiento` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`Mantenimiento` (
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
    REFERENCES `GeneralSagrado`.`Computadora` (`idComputadora`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`PreferenciaSimple`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`PreferenciaSimple` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`PreferenciaSimple` (
  `idPregunta` INT NOT NULL,
  `idOpcion` INT NOT NULL,
  `preferencia` INT NULL,
  PRIMARY KEY (`idPregunta`, `idOpcion`),
  INDEX `fk_PreferenciaSimple_Opcion1_idx` (`idOpcion` ASC),
  CONSTRAINT `fk_PreferenciaSimple_Pregunta1`
    FOREIGN KEY (`idPregunta`)
    REFERENCES `GeneralSagrado`.`Pregunta` (`idPregunta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_PreferenciaSimple_Opcion1`
    FOREIGN KEY (`idOpcion`)
    REFERENCES `GeneralSagrado`.`Opcion` (`idOpcion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`MantenimientoAntivirus`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`MantenimientoAntivirus` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`MantenimientoAntivirus` (
  `idMantenimientoAntivirus` INT NOT NULL AUTO_INCREMENT,
  `fecha` DATETIME NOT NULL,
  `idComputadora` INT NOT NULL,
  PRIMARY KEY (`idMantenimientoAntivirus`),
  INDEX `fk_MantenimientoAntivirus_Computadora1_idx` (`idComputadora` ASC),
  CONSTRAINT `fk_MantenimientoAntivirus_Computadora1`
    FOREIGN KEY (`idComputadora`)
    REFERENCES `GeneralSagrado`.`Computadora` (`idComputadora`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`NivelE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`NivelE` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`NivelE` (
  `idNivel` INT NOT NULL AUTO_INCREMENT,
  `nivel` VARCHAR(60) NOT NULL,
  `descripcion` VARCHAR(200) NULL,
  `hash` VARCHAR(45) NULL,
  PRIMARY KEY (`idNivel`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`GradoE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`GradoE` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`GradoE` (
  `idGrado` INT NOT NULL AUTO_INCREMENT,
  `idNivel` INT NOT NULL,
  `grado` VARCHAR(60) NOT NULL,
  `abreviatura` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(150) NULL,
  `hash` VARCHAR(45) NULL,
  PRIMARY KEY (`idGrado`),
  INDEX `fk_GradoE_NivelE1_idx` (`idNivel` ASC),
  CONSTRAINT `fk_GradoE_NivelE1`
    FOREIGN KEY (`idNivel`)
    REFERENCES `GeneralSagrado`.`NivelE` (`idNivel`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`CicloE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`CicloE` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`CicloE` (
  `idCiclo` INT NOT NULL AUTO_INCREMENT,
  `ciclo` VARCHAR(5) NOT NULL,
  `actual` VARCHAR(1) NOT NULL,
  `inicio` DATETIME NOT NULL,
  `termino` DATETIME NOT NULL,
  `descripcion` TEXT NULL,
  `hash` VARCHAR(45) NULL,
  PRIMARY KEY (`idCiclo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`GrupoE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`GrupoE` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`GrupoE` (
  `idGrupo` INT NOT NULL AUTO_INCREMENT,
  `idGrado` INT NOT NULL,
  `idCiclo` INT NOT NULL,
  `grupo` VARCHAR(40) NOT NULL,
  `hash` VARCHAR(45) NULL,
  PRIMARY KEY (`idGrupo`),
  INDEX `fk_GrupoC_GradoE1_idx` (`idGrado` ASC),
  INDEX `fk_GrupoE_CicloE1_idx` (`idCiclo` ASC),
  CONSTRAINT `fk_GrupoC_GradoE1`
    FOREIGN KEY (`idGrado`)
    REFERENCES `GeneralSagrado`.`GradoE` (`idGrado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_GrupoE_CicloE1`
    FOREIGN KEY (`idCiclo`)
    REFERENCES `GeneralSagrado`.`CicloE` (`idCiclo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`MateriaE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`MateriaE` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`MateriaE` (
  `idMateria` INT NOT NULL AUTO_INCREMENT,
  `idCiclo` INT NOT NULL,
  `idGrado` INT NOT NULL,
  `materia` VARCHAR(100) NOT NULL,
  `creditos` FLOAT NULL,
  `hash` VARCHAR(45) NULL,
  PRIMARY KEY (`idMateria`),
  INDEX `fk_MateriaE_GradoE1_idx` (`idGrado` ASC),
  INDEX `fk_MateriaE_CicloE1_idx` (`idCiclo` ASC),
  CONSTRAINT `fk_MateriaE_GradoE1`
    FOREIGN KEY (`idGrado`)
    REFERENCES `GeneralSagrado`.`GradoE` (`idGrado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_MateriaE_CicloE1`
    FOREIGN KEY (`idCiclo`)
    REFERENCES `GeneralSagrado`.`CicloE` (`idCiclo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`ProfesoresGrupo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`ProfesoresGrupo` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`ProfesoresGrupo` (
  `idGrupo` INT NOT NULL,
  `idRegistro` INT NOT NULL,
  `idMateria` INT NOT NULL,
  PRIMARY KEY (`idGrupo`, `idRegistro`, `idMateria`),
  INDEX `fk_meGruposProfesor_meGrupoC1_idx` (`idGrupo` ASC),
  INDEX `fk_GruposProfesor_MateriaE1_idx` (`idMateria` ASC),
  INDEX `fk_GruposProfesor_Registro1_idx` (`idRegistro` ASC),
  CONSTRAINT `fk_meGruposProfesor_meGrupoC1`
    FOREIGN KEY (`idGrupo`)
    REFERENCES `GeneralSagrado`.`GrupoE` (`idGrupo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_GruposProfesor_MateriaE1`
    FOREIGN KEY (`idMateria`)
    REFERENCES `GeneralSagrado`.`MateriaE` (`idMateria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_GruposProfesor_Registro1`
    FOREIGN KEY (`idRegistro`)
    REFERENCES `GeneralSagrado`.`Registro` (`idRegistro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GeneralSagrado`.`EncuestaGrupo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `GeneralSagrado`.`EncuestaGrupo` ;

CREATE TABLE IF NOT EXISTS `GeneralSagrado`.`EncuestaGrupo` (
  `idGrupo` INT NOT NULL,
  `idEncuesta` INT NOT NULL,
  PRIMARY KEY (`idGrupo`, `idEncuesta`),
  INDEX `fk_EncuestaGrupo_Encuesta1_idx` (`idEncuesta` ASC),
  CONSTRAINT `fk_EncuestaGrupo_GrupoE1`
    FOREIGN KEY (`idGrupo`)
    REFERENCES `GeneralSagrado`.`GrupoE` (`idGrupo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_EncuestaGrupo_Encuesta1`
    FOREIGN KEY (`idEncuesta`)
    REFERENCES `GeneralSagrado`.`Encuesta` (`idEncuesta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
