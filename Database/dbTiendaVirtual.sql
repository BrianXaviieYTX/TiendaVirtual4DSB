-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema dbtiendavirtual4to
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `dbtiendavirtual4to` DEFAULT CHARACTER SET utf8 ;
USE `dbtiendavirtual4to` ;

-- -----------------------------------------------------
-- Table `dbtiendavirtual4to`.`compania`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtiendavirtual4to`.`compania` (
  `idcompania` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre_compania` VARCHAR(45) NOT NULL,
  `direccion_compania` TEXT NOT NULL,
  `telefono_compania` VARCHAR(10) NOT NULL,
  `email_compania` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`idcompania`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbtiendavirtual4to`.`categorias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtiendavirtual4to`.`categorias` (
  `idcategorias` INT(11) NOT NULL AUTO_INCREMENT,
  `codigo_categoria` VARCHAR(10) NOT NULL,
  `nombre_categorias` VARCHAR(45) NOT NULL,
  `detalle_categoria` TEXT NOT NULL,
  `fk_idcompania` INT(11) NOT NULL,
  PRIMARY KEY (`idcategorias`, `fk_idcompania`),
  INDEX `fk_categorias_compania_provedor1_idx` (`fk_idcompania` ASC) ,
  CONSTRAINT `fk_categorias_compania_provedor1`
    FOREIGN KEY (`fk_idcompania`)
    REFERENCES `dbtiendavirtual4to`.`compania` (`idcompania`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbtiendavirtual4to`.`productos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtiendavirtual4to`.`productos` (
  `idproductos` INT(11) NOT NULL AUTO_INCREMENT,
  `codigo_producto` VARCHAR(10) NOT NULL,
  `nombre_producto` VARCHAR(45) NOT NULL,
  `descripcion_producto` TEXT NOT NULL,
  `Stock` INT(11) NOT NULL,
  `precio_compra` DOUBLE NOT NULL,
  `precio_venta` DOUBLE NOT NULL,
  `imagen_producto` VARCHAR(200) NOT NULL,
  `dateregister` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `categorias_idcategorias` INT(11) NOT NULL,
  PRIMARY KEY (`idproductos`, `categorias_idcategorias`),
  INDEX `fk_productos_categorias1_idx` (`categorias_idcategorias` ASC) ,
  CONSTRAINT `fk_productos_categorias1`
    FOREIGN KEY (`categorias_idcategorias`)
    REFERENCES `dbtiendavirtual4to`.`categorias` (`idcategorias`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbtiendavirtual4to`.`rol`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtiendavirtual4to`.`rol` (
  `idrol` INT(11) NOT NULL AUTO_INCREMENT,
  `nombrerol` VARCHAR(45) NULL DEFAULT NULL,
  `descripcion` TEXT NULL DEFAULT NULL,
  `status` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`idrol`))
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbtiendavirtual4to`.`persona`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtiendavirtual4to`.`persona` (
  `idpersona` INT(11) NOT NULL AUTO_INCREMENT,
  `nroidentificacion` VARCHAR(10) NOT NULL,
  `nombres` VARCHAR(45) NOT NULL,
  `apellidos` VARCHAR(45) NOT NULL,
  `telefono` VARCHAR(10) NOT NULL,
  `email_user` VARCHAR(100) NOT NULL,
  `password` VARCHAR(75) NOT NULL,
  `direccionfiscal` VARCHAR(100) NOT NULL,
  `estatus` INT(11) NOT NULL,
  `datecreated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fk_idrol` INT(11) NOT NULL,
  PRIMARY KEY (`idpersona`, `fk_idrol`),
  INDEX `fk_persona_rol_idx` (`fk_idrol` ASC) ,
  CONSTRAINT `fk_persona_rol`
    FOREIGN KEY (`fk_idrol`)
    REFERENCES `dbtiendavirtual4to`.`rol` (`idrol`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbtiendavirtual4to`.`carrito`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtiendavirtual4to`.`carrito` (
  `idcarrito` INT(11) NOT NULL AUTO_INCREMENT,
  `productos_idproductos` INT(11) NOT NULL,
  `cantidad` DOUBLE NOT NULL,
  `persona_idpersona` INT(11) NOT NULL,
  PRIMARY KEY (`idcarrito`, `productos_idproductos`, `persona_idpersona`),
  INDEX `fk_dbtiendavirtual4to_productos1_idx` (`productos_idproductos` ASC) ,
  INDEX `fk_dbtiendavirtual4to_persona1_idx` (`persona_idpersona` ASC) ,
  CONSTRAINT `fk_dbtiendavirtual4to_productos1`
    FOREIGN KEY (`productos_idproductos`)
    REFERENCES `dbtiendavirtual4to`.`productos` (`idproductos`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_dbtiendavirtual4to_persona1`
    FOREIGN KEY (`persona_idpersona`)
    REFERENCES `dbtiendavirtual4to`.`persona` (`idpersona`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `dbtiendavirtual4to`.`ventas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtiendavirtual4to`.`ventas` (
  `idventas` INT(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` INT(11) NOT NULL,
  `total` DOUBLE NOT NULL,
  `fechaventa` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `persona_idpersona` INT(11) NOT NULL,
  `persona_rol_idrol` INT(11) NOT NULL,
  PRIMARY KEY (`idventas`, `persona_idpersona`, `persona_rol_idrol`),
  INDEX `fk_ventas_persona_idx` (`persona_idpersona` ASC, `persona_rol_idrol` ASC) ,
  CONSTRAINT `fk_ventas_persona`
    FOREIGN KEY (`persona_idpersona` , `persona_rol_idrol`)
    REFERENCES `dbtiendavirtual4to`.`persona` (`idpersona` , `fk_idrol`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `dbtiendavirtual4to`.`productos_venta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtiendavirtual4to`.`productos_venta` (
  `idproductos_ventas` INT(11) NOT NULL AUTO_INCREMENT,
  `cantidad` DOUBLE NOT NULL,
  `precio` DOUBLE NOT NULL,
  `subtotal` DOUBLE NOT NULL,
  `productos_idproductos` INT(11) NOT NULL,
  `fk_idcategorias` INT(11) NOT NULL,
  `fk_idventas` INT(11) NOT NULL,
  `fk_ventaidpersona` INT(11) NOT NULL,
  `fk_personaidrol` INT(11) NOT NULL,
  PRIMARY KEY (`idproductos_ventas`, `productos_idproductos`, `fk_idcategorias`, `fk_idventas`, `fk_ventaidpersona`, `fk_personaidrol`),
  INDEX `fk_productos_venta_productos1_idx` (`productos_idproductos` ASC, `fk_idcategorias` ASC) ,
  INDEX `fk_productos_venta_ventas1_idx` (`fk_idventas` ASC, `fk_ventaidpersona` ASC, `fk_personaidrol` ASC) ,
  CONSTRAINT `fk_productos_venta_productos1`
    FOREIGN KEY (`productos_idproductos` , `fk_idcategorias`)
    REFERENCES `dbtiendavirtual4to`.`productos` (`idproductos` , `categorias_idcategorias`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_productos_venta_ventas1`
    FOREIGN KEY (`fk_idventas` , `fk_ventaidpersona` , `fk_personaidrol`)
    REFERENCES `dbtiendavirtual4to`.`ventas` (`idventas` , `persona_idpersona` , `persona_rol_idrol`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

USE `dbtiendavirtual4to` ;
INSERT INTO `rol` (`idrol`, `nombrerol`, `descripcion`, `status`) VALUES ('1', 'Administador', 'Administrador', '1'),
('2', 'Inspector', 'Inspector', '1'), ('3', 'Bodega', 'Bodega', '1'), ('4', 'Ventas', 'Ventas', '1'), ('5', 'Clientes', 'Solo Clientes', '0');

 
 INSERT INTO `compania` (`idcompania`, `nombre_compania`, `direccion_compania`, `telefono_compania`, `email_compania`) 
 VALUES ('1', 'Nestle', 'Cayambe', '0236598745', 'nestle@info.com'), ('2', 'Coca Cola', 'Cayambe', '0225416985', 'coca_cola@info.com'),
 ('3', 'TerraFertil', 'Tabacundo', '0225369854', 'terrafertil@info.com');

INSERT INTO `categorias` (`idcategorias`, `codigo_categoria`, `nombre_categorias`, `detalle_categoria`, `fk_idcompania`) 
VALUES ('1', 'CT001', 'Bebidas', '123456', '2'),('2', 'CT002', 'Productos Organicos', '1425', '3'), 
('3', 'CT003', 'Productos Nestle', '145255', '1'),('4', 'CT004', 'Viveres', '123366', '1');

INSERT INTO `dbtiendavirtual4to`.`productos` (`idproductos`, `codigo_producto`, `nombre_producto`, `descripcion_producto`, `Stock`, 
`precio_compra`, `precio_venta`, `imagen_producto`, `categorias_idcategorias`) VALUES ('1', 'PR001', 'Coca Cola',
 'Juntos sabe mejor es la descripción perfecta de comer en compañía de los que más quieres. Los sabores se disfrutan más porque los momentos juntos son el mejor ingrediente.', 
 '150', '2.50', '3.00', 'ajask.png', '1'),('2', 'PR002', 'Granos secos', '100% de grano entero. Libre de gluten por naturaleza. Quinotto Mediterranean Mix 250 gr. Buena fuente de proteína, fibra y hierro.', 
 '120', '0.30', '0.50', '1245.png', '2'),('3', 'PR003', 'Chocolate Galack', 'El chocolate es rico en un tipo de antioxidante que ayuda a disminuir el riesgo de sufrir enfermedades del corazón. Disfrutar de un delicioso chocolate caliente en leche es una buena forma de relajarse después de un día muy activo. '
 , '85', '1.85', '2.25', 'ajssl.png', '3');

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
