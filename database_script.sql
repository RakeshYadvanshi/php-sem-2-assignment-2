CREATE DATABASE kumar50;

USE kumar50;

CREATE TABLE `product` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `productTitle` VARCHAR(45) NULL,
  `productDesc` VARCHAR(500) NULL,
  `quantity` INT NULL,
  `price` DECIMAL NULL,
  `createdBy` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));