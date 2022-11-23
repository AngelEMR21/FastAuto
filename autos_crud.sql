-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema autos_crud
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema autos_crud
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `autos_crud` DEFAULT CHARACTER SET utf8mb3 ;
USE `autos_crud` ;

-- -----------------------------------------------------
-- Table `autos_crud`.`vendedores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `autos_crud`.`vendedores` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  `apellido` VARCHAR(45) NULL DEFAULT NULL,
  `telefono` VARCHAR(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `autos_crud`.`autos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `autos_crud`.`autos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(45) NULL DEFAULT NULL,
  `precio` DECIMAL(10,2) NULL DEFAULT NULL,
  `imagen` VARCHAR(200) NULL DEFAULT NULL,
  `descripcion` LONGTEXT NULL DEFAULT NULL,
  `puertas` INT NULL DEFAULT NULL,
  `marca` VARCHAR(45) NULL DEFAULT NULL,
  `modelo` VARCHAR(45) NULL DEFAULT NULL,
  `creado` DATE NULL DEFAULT NULL,
  `vendedores_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_autos_vendedores_idx` (`vendedores_id` ASC) VISIBLE,
  CONSTRAINT `fk_autos_vendedores`
    FOREIGN KEY (`vendedores_id`)
    REFERENCES `autos_crud`.`vendedores` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `autos_crud`.`solicitudes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `autos_crud`.`solicitudes` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(255) NULL DEFAULT NULL,
  `email` VARCHAR(255) NULL DEFAULT NULL,
  `telefono` VARCHAR(255) NULL DEFAULT NULL,
  `mensaje` VARCHAR(255) NULL DEFAULT NULL,
  `autos_id` INT NULL DEFAULT NULL,
  `status` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `autos_id` (`autos_id` ASC) VISIBLE,
  CONSTRAINT `solicitudes_ibfk_1`
    FOREIGN KEY (`autos_id`)
    REFERENCES `autos_crud`.`autos` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `autos_crud`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `autos_crud`.`usuarios` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(255) NOT NULL,
  `apellidos` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `telefono` VARCHAR(255) NOT NULL,
  `password` CHAR(60) NOT NULL,
  `rol` INT NULL DEFAULT NULL,
  UNIQUE INDEX `id` (`id` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8mb3;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
