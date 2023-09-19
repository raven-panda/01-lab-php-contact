-- MySQL Script generated by MySQL Workbench
-- Wed Sep  6 16:22:47 2023
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- PHP access to the database : User privileges
-- -----------------------------------------------------
REVOKE ALL PRIVILEGES ON contactdb.* FROM 'client'@'%';
GRANT SELECT, INSERT, UPDATE, DELETE ON contactdb.* TO 'client'@'%';
FLUSH PRIVILEGES;

-- -----------------------------------------------------
-- Schema contactdb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `contactdb` DEFAULT CHARACTER SET utf8 ;
USE `contactdb` ;

-- -----------------------------------------------------
-- Table `contactdb`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `contactdb`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `firstname` VARCHAR(100) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `signup_date` DATETIME NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `token_time` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`email`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `contactdb`.`contact`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `contactdb`.`contact` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `firstname` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `user_email` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `contactdb`.`user_contact`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `contactdb`.`user_contact` (
  `user_id` INT NOT NULL,
  `contact_id` INT NOT NULL,
  INDEX `fk_user_contact_user_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_user_contact_contact1_idx` (`contact_id` ASC) VISIBLE,
  CONSTRAINT `fk_user_contact_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `contactdb`.`user` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_user_contact_contact1`
    FOREIGN KEY (`contact_id`)
    REFERENCES `contactdb`.`contact` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
